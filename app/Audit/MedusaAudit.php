<?php

namespace App\Audit;

use App\Audit;

trait MedusaAudit
{

    /**
     * @param $memberId string RMN number of the person making the change
     * @param $action string What Action did they take (Update, Create, etc)
     * @param $collection string What collection was this against
     * @param $docId string MongoID of the document in the collection being changed.  Will be blank for create
     * @param $values string JSON data being inserted or updated
     * @param $from_where string What part of the app did the change
     *
     * @return bool
     */

    protected function writeAuditTrail($memberId, $action, $collection, $docId, $values, $from_where)
    {
        $auditRecord = [
          'member_id' => $memberId,
          'action' => $action,
          'collection_name' => $collection,
          'document_id' => $docId,
          'document_values' => $values,
          'from_where' => $from_where,
        ];

        Audit::create($auditRecord);

        return true;
    }
}
