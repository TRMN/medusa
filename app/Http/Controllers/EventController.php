<?php

namespace App\Http\Controllers;

use App\User;
use App\Country;
use App\MedusaEvents;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /event.
     *
     * @return Response
     */
    public function index()
    {
        if (($redirect = $this->loginValid()) !== true) {
            return $redirect;
        }

        return view(
            'events.index',
            ['events' => MedusaEvents::where('requestor', '=', Auth::user()->id)->orderBy('start_date')->get()]
        );
    }

    /**
     * Show the form for creating a new resource.
     * GET /event/create.
     *
     * @return Response
     */
    public function create()
    {
        if (($redirect = $this->loginValid()) !== true) {
            return $redirect;
        }

        return view(
            'events.event',
            [
                'action'    => 'add',
                'event'     => new MedusaEvents(),
                'countries' => Country::getCountries(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     * POST /event.
     *
     * @return Response
     */
    public function store()
    {
        if (($redirect = $this->loginValid()) !== true) {
            return $redirect;
        }

        $data = Request::all();
        $data['requestor'] = Auth::user()->_id;

        if (empty($data['end_date']) === true) {
            $data['end_date'] = $data['start_date'];
        }

        if (empty($data['registrars']) === true) {
            $data['registrars'] = [];
        }

        try {
            $event = MedusaEvents::create($data);

            $this->writeAuditTrail(
                (string) Auth::user()->_id,
                'create',
                'events',
                $event->id,
                $event->toJson(),
                'EventController@store'
            );

            $this->_updateUsers($event);

            $msg = 'Your event "'.$event->event_name.'" has been scheduled';
        } catch (\Exception $e) {
            $msg =
              'There was a problem scheduling "'.$data['event_name'].'"';
            Log::error($e->getTraceAsString());
        }

        return Redirect::route('events.show', [$event->id])->with(
            'message',
            $msg
        );
    }

    private function _updateUsers(MedusaEvents $event)
    {
        Log::debug('Updating requestor and registrars of '.$event->event_name);

        try {
            // Flag the record of the requestor and any registrars so the mobile app
            // knows to ask for the list of events

            if ($this->_setEventFlag($event->requestor) === true) {
                foreach ($event->registrars as $registrar) {
                    if ($this->_setEventFlag($registrar) === false) {
                        throw new \Exception('Unable to update registrar');
                    }
                }
            } else {
                throw new \Exception('Unable to update requestor');
            }
        } catch (\Exception $e) {
            Log::error($e->getTraceAsString());

            throw new \Exception('Unable to update requestor or registrars');
        }
    }

    private function _setEventFlag($id)
    {
        try {
            $user = User::find($id);
            $user->lastUpdated = time();
            $user->hasEvents = true;
            $user->save();

            $this->writeAuditTrail(
                (string) Auth::user()->_id,
                'update',
                'users',
                $user->id,
                $user->toJson(),
                'EventController@store'
            );

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Display the specified resource.
     * GET /event/{id}.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(MedusaEvents $event)
    {
        if (($redirect = $this->loginValid()) !== true || $event->requestor != Auth::user()->id) {
            return $redirect;
        }

        return view(
            'events.show',
            [
            'event'     => $event,
            'countries' => Country::getCountries(),
            ]
        );
    }

    public function export(MedusaEvents $event)
    {
        if (($redirect = $this->loginValid()) !== true || $event->requestor != Auth::user()->id) {
            return $redirect;
        }

        $event->exportCheckIns();
    }

    /**
     * Show the form for editing the specified resource.
     * GET /event/{id}/edit.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit(MedusaEvents $event)
    {
        if (($redirect = $this->loginValid()) !== true) {
            return $redirect;
        }

        return view(
            'events.event',
            [
            'action'    => 'edit',
            'event'     => $event,
            'countries' => Country::getCountries(),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     * PUT /event/{id}.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(MedusaEvents $event)
    {
        if (($redirect = $this->loginValid()) !== true) {
            return $redirect;
        }

        try {
            if (empty($event->registrars) === true) {
                $event->registrars = [];
            }

            $event->update(Request::all());

            $this->writeAuditTrail(
                (string) Auth::user()->_id,
                'update',
                'events',
                $event->id,
                json_encode(Request::all()),
                'EventController@update'
            );

            $msg = 'Your event "'.$event->event_name.'" has been updated';

            $this->_updateUsers($event);
        } catch (\Exception $e) {
            $msg =
              'There was a problem saving the update to "'.$event->event_name.'"';
            Log::error($e->getTraceAsString());
        }

        return Redirect::route('events.index')->with('message', $msg);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /event/{id}.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
