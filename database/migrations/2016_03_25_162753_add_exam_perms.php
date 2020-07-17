<?php

use Illuminate\Database\Migrations\Migration;

class AddExamPerms extends Migration
{
    use \App\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $newPerms = [
            'ADD_GRADE' => 'Add an exam grade or edit a grade they entered',
            'EDIT_GRADE' => 'Edit any exam grade',
        ];

        foreach ($newPerms as $perm => $desc) {
            $this->writeAuditTrail(
                'system user',
                'create',
                'permissions',
                null,
                json_encode(['name' => $perm, 'description' => $desc]),
                'add_exam_perms'
            );
            App\Permission::create(['name' => $perm, 'description' => $desc]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
