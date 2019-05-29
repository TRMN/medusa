<?php

use Illuminate\Database\Migrations\Migration;

class AddUploadExams extends Migration
{
    use \App\Models\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->writeAuditTrail(
            'system user',
            'create',
            'permissions',
            null,
            json_encode(['name' => 'UPLOAD_EXAMS', 'description' => 'Upload Academy Exam Grades']),
            'add_flag_lt'
        );
        App\Models\Permission::create(['name' => 'UPLOAD_EXAMS', 'description' => 'Upload Academy Exam Grades']);
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
