<?php

namespace App\Traits;

use App\Models\Message;

trait MedusaLog
{
    /**
     * Log a message to both the permanent and transitory logs.
     *
     * @param array $msgDetails
     *
     * @throws \Exception
     */
    protected function logMsg(array $msgDetails)
    {
        try {
            Message::create($msgDetails);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    protected function clearLog(string $source)
    {
        // Delete any records in the messages collection, this is a fresh run
        Message::where('source', $source)->delete();
    }
}
