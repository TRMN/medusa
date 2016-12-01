<?php

class AnnouncementController extends Controller
{

    public function index()
    {
        $announcements = Announcement::orderBy('publish_date')->get();

        $viewData = [
            'announcements' => $announcements,
        ];

        return Response::view('announcement.index', $viewData);
    }

    public function show($id)
    {

        $announcement = Announcement::with('user')->find($id);

        if (empty($announcement)) {
            return Redirect::route('announcement.index');
        }

        $viewData = [
            'announcement' => $announcement,
        ];

        return Response::view('announcement.show', $viewData);
    }

    public function create()
    {

        $announcement = new Announcement;

        $viewData = [
            'announcement' => $announcement,
        ];

        return Response::view('announcement.create', $viewData);
    }

    public function edit($id)
    {

        $announcement = Announcement::with('user')->find($id);

        // @todo: ACL will probably do more checking
        if (Auth::id() != $announcement->user->id) {
            return redirect('announcement/' . $id);
        }

        $viewData = [
            'announcement' => $announcement,
        ];

        return Response::view('announcement.edit', $viewData);
    }

    public function update($id)
    {

        $data = Input::all();

        $announcement = Announcement::with('user')->find($id);

        $announcementUserId = $announcement->user->id;

        // @todo: ACL will probably do more checking
        if (Auth::id() != $announcementUserId) {
            return redirect('announcement/' . $id);
        }

        $announcement->update($data);

        return Redirect::route('announcement.show', $id);
    }

    public function store()
    {

        $data = Input::all();

        $announcement = Announcement::create($data);

        $announcement->is_published = false;

        // @todo: ACL will probably do more checking
        $currentUser = Auth::getUser();

        $currentUser->announcements()->save($announcement);

        return Redirect::route('announcement.show', $announcement->id);
    }

    public function destroy($id)
    {

        // @todo: ACL will probably do more checking
        Announcement::destroy($id);

        return Redirect::route('announcement.index');
    }
}
