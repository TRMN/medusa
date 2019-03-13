<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameViewSfs extends Migration
{
    use \App\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     * @throws \Exception
     */
    public function up()
    {
        // Change the name and description
        $record = App\Permission::where('name', 'VIEW_SFS')->first();

        $record->name = 'VIEW_SFC';
        $record->description = 'View SFC members';

        try {
            $record->save();
            $this->writeAuditTrail(
                'system user',
                'update',
                'permissions',
                null,
                $record->toJson(),
                'rename_view_sfs'
            );
        } catch (Exception $e) {
            throw new Exception();
        }

        // Find all users with the old permission and update them

        foreach (App\User::where('permissions', 'VIEW_SFS')->get() as $user) {
            // First, remove the old permission from their list
            $perms = Arr::where($user->permissions, function ($value, $key) {
                return $value != 'VIEW_SFS';
            });

            // Add the new permission name
            $perms[] = 'VIEW_SFC';

            $user->permissions = $perms;

            try {
                $user->save();
                $this->writeAuditTrail(
                    'system user',
                    'update',
                    'users',
                    null,
                    $user->toJson(),
                    'rename_view_sfs'
                );
            } catch (Exception $e) {
                throw new Exception();
            }
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
