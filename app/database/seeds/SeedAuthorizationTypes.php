<?php

class SeedAuthorizationTypes extends Seeder
{
    public function run() {
        DB::table('authorization_types')->delete();
        DB::table('authorization_types')->insert(
            array(
                array(
                    'permissionCategory'=>'Billing',
                    'permissionSubCategory'=>'',
                    'entryOrder'=>0,
                    'requires'=>json_encode(array('view_billing'=>'Y')),
                    'permissionCode'=>'perform_billing',
                    'default_staff'=>'Y',
                    'default_parent'=>'N',
                    'default_teacher'=>'N',
                    'default_student'=>'N',
                    'title'=>'Perform Billing',
                    'description'=>'Can view and perform billing and invoicing functions'
                ),
                array(
                    'permissionCategory'=>'Billing',
                    'permissionSubCategory'=>'',
                    'entryOrder'=>1,
                    'requires'=>null,
                    'title'=>'View Billing',
                    'permissionCode'=>'view_billing',
                    'default_staff'=>'Y',
                    'default_parent'=>'N',
                    'default_teacher'=>'N',
                    'default_student'=>'N',

                    'description'=>'Can view (only) billing and invoicing functions'
                ),

                array(
                    'permissionCategory'=>'Teachers & Staff',
                    'permissionSubCategory'=>'Staff',
                    'entryOrder'=>0,
                    'requires'=>null,
                    'permissionCode'=>'add_staff',
                    'default_staff'=>'N',
                    'default_parent'=>'N',
                    'default_teacher'=>'N',
                    'default_student'=>'N',
                    'title'=>'Add New Staff Members',
                    'description'=>'Can add new staff'
                ),

                array(
                    'permissionCategory'=>'Teachers & Staff',
                    'permissionSubCategory'=>'Staff',
                    'entryOrder'=>1,
                    'requires'=>null,
                    'permissionCode'=>'edit_staff',
                    'default_staff'=>'N',
                    'default_parent'=>'N',
                    'default_teacher'=>'N',
                    'default_student'=>'N',
                    'title'=>'Edit Current Staff Members',
                    'description'=>'Can edit staff'
                ),

            )
        );




    }

}

