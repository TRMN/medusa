<?php

use Jenssegers\Mongodb\Model as Eloquent;

class Report extends Eloquent {

	protected $fillable = ['promotion_actions','award_actions','courses','activities','problems','questions','report_sent','command_crew','new_crew','chapter_id','chapter_info', 'report_date'];

    public function getDraftReport()
    {

    }
}
