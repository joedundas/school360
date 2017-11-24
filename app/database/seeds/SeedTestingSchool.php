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
        $this->seed_staff();
        $this->seed_teacher();
        $this->seed_parent();
        $this->seed_student();



    }

    public function seed_teacher() {
        $teacherId = DB::table('teachers')->insertGetId(

            array('firstName'=>'Gloria','lastName'=>'Rug','email'=>'teacher@someschool.edu')

        );

        $userId = DB::table('users')->insertGetId(

            array('teacherId'=>$teacherId,'password'=>Hash::make('7383jmd2'),'email'=>'teacher@someschool.edu','canLogin'=>'Y')

        );
        DB::table('user_school_mapper')->insert(

            array('userId'=>$userId,'schoolId'=>1)

        );
    }
    public function seed_parent() {
        $parentId = DB::table('parents')->insertGetId(

            array('firstName'=>'Cynthia','lastName'=>'Dundas','email'=>'cdundas3@gmail.com')

        );

        $userId = DB::table('users')->insertGetId(

            array('parentId'=>$parentId,'password'=>Hash::make('7383jmd2'),'email'=>'cdundas3@gmail.com','canLogin'=>'Y')

        );
        DB::table('user_school_mapper')->insert(

            array('userId'=>$userId,'schoolId'=>1)

        );
    }

    public function seed_student() {
        $studentId = DB::table('students')->insertGetId(

            array('firstName'=>'Joshua','lastName'=>'Dundas','email'=>'joshua.dundas@icloud.com','currentGradeLevel'=>2)

        );

        $userId = DB::table('users')->insertGetId(

            array('studentId'=>$studentId,'password'=>Hash::make('7383jmd2'),'email'=>'joshua.dundas@icloud.com','canLogin'=>'Y')

        );
        DB::table('user_school_mapper')->insert(

            array('userId'=>$userId,'schoolId'=>1)

        );
    }

    public function seed_staff() {
        $staffId = DB::table('staff')->insertGetId(

                array('firstName'=>'Joe','lastName'=>'Dundas','email'=>'jdunda1@gmail.com')

        );

        $userId = DB::table('users')->insertGetId(

                array('staffId'=>$staffId,'password'=>Hash::make('7383jmd2'),'email'=>'jdunda1@gmail.com','canLogin'=>'Y')

        );
        DB::table('user_school_mapper')->insert(

                array('userId'=>$userId,'schoolId'=>1)

        );
    }
}


