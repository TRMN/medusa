<?php

namespace App\Common;

use App\Grade;

trait UpdatePaygrades
{
    use \App\Audit\MedusaAudit;

    /**
     * @param string $branch
     * @param array $paygrades
     * @return void
     */
    public function update_paygrades(string $branch, array $paygrades)
    {
        foreach ($paygrades as $paygrade => $title) {
            $record = Grade::where('grade', $paygrade)->first();
            $ranks = $record->rank;
            if (is_null($title)) {
                unset($ranks[$branch]);
            } else {
                $ranks[$branch] = $title;
            }

            $record->rank = $ranks;

            $this->writeAuditTrail(
                'system user',
                'update',
                'grades',
                $record->id,
                $record->toJson(),
                'update_rank_titles'
            );

            $record->save();
        }
    }
}