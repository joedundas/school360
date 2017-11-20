<?php

class SeedTestingSchool extends Seeder
{
    public function run() {
        DB::table('schools')->delete();
        DB::table('staff')->delete();
        DB::table('users')->delete();
        DB::table('user_school_mapper')->delete();
        DB::table('schools')->insert(
            array(
                array('name'=>'Testing School','address'=>'123 Banana Lane','city'=>'Phoenix','state'=>'AZ','zip'=>'850234567')
            )
        );

        DB::table('staff')->insert(
            array(
                array('firstName'=>'Joe','lastName'=>'Dundas','email'=>'jdunda1@gmail.com')
            )
        );
        DB::table('users')->insert(
            array(
                array('staffId'=>1,'password'=>Hash::make('7383jmd2'),'email'=>'jdunda1@gmail.com')
            )
        );
        DB::table('user_school_mapper')->insert(
            array(
                array('userId'=>1,'schoolId'=>1)
            )
        );
    }
}


