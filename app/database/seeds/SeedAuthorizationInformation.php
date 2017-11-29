<?php

class SeedAuthorizationInformation extends Seeder
{
    public function run() {
        DB::table('authorization_types')->delete();
        DB::table('authorization_views')->delete();
        DB::table('authorization_role_defaults')->delete();

        $this->seedCodes();
        $this->seedDefaults();
        $this->seedAuthorizationViews();
    }

    public function seedAuthorizationViews() {
        DB::table('authorization_views')->insert(
            array(
                array(
                    'item'=>'administration_link',
                    'authorizationsRequired'=>json_encode(array(),true),
                    'rolesRequired'=>json_encode(array('staff'),true),
                    'rolesRestricted'=>json_encode(array('student','parent'),true)
                ),
                array(
                    'item'=>'add_staff',
                    'authorizationsRequired'=>json_encode(array('add_staff'),true),
                    'rolesRequired'=>null,
                    'rolesRestricted'=>json_encode(array('student','parent'),true)
                ),
                array(
                    'item'=>'edit_staff',
                    'authorizationsRequired'=>json_encode(array('edit_staff'),true),
                    'rolesRequired'=>null,
                    'rolesRestricted'=>json_encode(array('student','parent'),true)
                ),
            )
        );
    }


    public function seedDefaults() {
        DB::table('authorization_role_defaults')->insert(
            array(
                array(
                    'role'=>'staff',
                    'permissionCode'=>'perform_billing',
                    'defaultValue'=>'Y'
                ),
                array(
                    'role'=>'staff',
                    'permissionCode'=>'view_billing',
                    'defaultValue'=>'Y'
                ),
            )
        );
    }
    public function seedCodes() {
        DB::table('authorization_types')->insert(
            array(
                array(
                    'permissionCategory'=>'Billing',
                    'permissionSubCategory'=>'',
                    'entryOrder'=>0,
                    'requires'=>json_encode(array('view_billing'=>'Y')),
                    'defaultValue'=>'N',
                    'title'=>'Perform Billing',
                    'permissionCode'=>'perform_billing',
                    'description'=>'Can view and perform billing and invoicing functions'
                ),
                array(
                    'permissionCategory'=>'Billing',
                    'permissionSubCategory'=>'',
                    'entryOrder'=>1,
                    'requires'=>null,
                    'defaultValue'=>'N',
                    'title'=>'View Billing',
                    'permissionCode'=>'view_billing',
                    'description'=>'Can view (only) billing and invoicing functions'
                ),

                array(
                    'permissionCategory'=>'Teachers & Staff',
                    'permissionSubCategory'=>'Staff',
                    'entryOrder'=>0,
                    'requires'=>null,
                    'defaultValue'=>'N',
                    'title'=>'Add New Staff Members',
                    'permissionCode'=>'add_staff',
                    'description'=>'Can add new staff'
                ),

                array(
                    'permissionCategory'=>'Teachers & Staff',
                    'permissionSubCategory'=>'Staff',
                    'entryOrder'=>1,
                    'requires'=>null,
                    'defaultValue'=>'N',
                    'title'=>'Edit Current Staff Members',
                    'permissionCode'=>'edit_staff',
                    'description'=>'Can edit staff'
                ),

            )
        );
    }

}

