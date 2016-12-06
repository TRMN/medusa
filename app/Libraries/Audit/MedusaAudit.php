<?php

namespace Medusa\Audit;

use App\Audit;

trait MedusaAudit
{

    /**
     * @param $memberId RMN number of the person making the change
     * @param $action What Action did they take (Update, Create, etc)
     * @param $collection What collection was this against
     * @param $docId MongoID of the document in the collection being changed.  Will be blank for create
     * @param $values JSON data being inserted or updated
     * @param $from_where What part of the app did the change
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
