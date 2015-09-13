<?php

class PermissionSeeder extends Seeder
{

    public function run()
    {
        DB::collection('permissions')->delete();

        $perms = [
            'LOGOUT' => 'Logout',
            'CHANGE_PWD' => 'Change their password',
            'EDIT_SELF' => 'Edit personal information',
            'ROSTER' => 'See members of their chapter',
            'TRANSFER' => 'Request a branch or chapter transfer',
            'DUTY_ROSTER' => 'See members of the chapter and subordinate chapters with extended data',
            'EXPORT_ROSTER' => 'Export duty roster',
            'EDIT_WEBSITE' => 'Edit link to chapter website',
            'ASSIGN_NONCOMMAND_BILLET' => 'Request a non-command billet for a member of their chapter',
            'PROMOTE_E6O1' => 'Promote a member of their chapter to E-6 or O-1',
            'REQUEST_PROMOTION' => 'Request promotion of member of their chapter',
            'CHAPTER_REPORT' => 'Submit a chapter report',
            'ADD_MEMBER' => 'Manually add a member',
            'DEL_MEMBER' => 'Delete a member',
            'EDIT_MEMBER' => 'Edit a member',
            'VIEW_MEMBERS' => 'View complete membership list',
            'PROC_APPLICATIONS' => 'Process membership applications',
            'PROC_XFERS' => 'Process a transfer request',
            'ADD_BILLET' => 'Add a new billet to the master list',
            'DEL_BILLET' => 'Delete a billet from the master list',
            'EDIT_BILLET' => 'Edit a billet in the master list',
            'COMMISSION_SHIP' => 'Commission a new ship',
            'DECOMMISSION_SHIP' => 'Decommission a ship',
            'EDIT_SHIP' => 'Edit a ship',
            'VIEW_DSHIPS' => 'View decomissioned ships',
            'CREATE_ECHELON' => 'Create an echelon',
            'EDIT_ECHELON' => 'Edit an echelon',
            'DEL_ECHELON' => 'Delete an echelon',
            'ASSIGN_SHIP' => 'Assign a ship to an echelon',
            'CHANGE_ASSIGNMENT' => 'Change what echelon a ship is assigned to',
            'VIEW_CHAPTER_REPORTS' => 'View Chapter Reports',
            'ASSIGN_PERMS' => 'Assign user permissions',
            'ALL_PERMS' => 'Grant all user permissions',
            'VIEW_SU' => 'View Separation Units',
        ];

        foreach ($perms as $perm => $desc) {
            $this->command->comment('Adding ' . $perm);
            Permission::create(["name" => $perm, 'description' => $desc]);
        }
    }

}