<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Events extends Eloquent
{
    protected $fillable = [
      'event_name',
      'address1',
      'address2',
      'city',
      'state_province',
      'postal_code',
      'country',
      'start_date',
      'end_date',
      'requestor',
      'registrars',
      'checkins',
    ];

    public static $rules = [
      'event_name'     => 'required',
      'address1'       => 'required',
      'city'           => 'required',
      'state_province' => 'required',
      'postal_code'    => 'required',
      'country'        => 'required',
      'start_date'     => 'required'
    ];

    public static $updateRules = [
    ];

    protected $table = 'events';

    public function exportCheckIns()
    {
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
        $csv->setNewline("\r\n");

        $headers =
            [
                'RMN Number',
                'Name',
                'City',
                'State/Province',
                'Country',
                'Rank',
                'Branch',
                'Assignment',
                'Check-in Timestamp',
            ];

        $csv->insertOne($headers);

        foreach ($this->checkins as $checkin) {
            if (is_array($checkin)) {
                $member = User::find($checkin['_id']);
            } else {
                $member = User::find($checkin);
            }

            $csv->insertOne(
                [
                    $member->member_id,
                    $member->getFullName(),
                    $member->city,
                    $member->state_province,
                    $member->country,
                    $member->getGreeting(),
                    $member->branch,
                    $member->getAssignmentName('primary'),
                    empty($checkin['timestamp'])?'':$checkin['timestamp'],
                ]
            );
        }

        $csv->output(date('Y-m-d') . '_' . str_replace(' ', '_', $this->event_name) . '_roster.csv');
    }
}
