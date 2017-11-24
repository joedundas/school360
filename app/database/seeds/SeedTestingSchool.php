<?php

class SeedTestingSchool extends Seeder
{
    public function run() {
        DB::table('schools')->delete();
        DB::table('staff')->delete();
        DB::table('users')->delete();
        DB::table('user_school_mapper')->delete();
        DB::table('student_to_parent_mapper')->delete();
        DB::table('student_to_teacher_mapper')->delete();
        $schoolId_1 = DB::table('schools')->insertGetId(
            array('name'=>'Testing School','address'=>'123 Banana Lane','city'=>'Phoenix','state'=>'AZ','zip'=>'850234567')
        );
        $schoolId_2 = DB::table('schools')->insertGetId(
            array('name'=>'Paradise Valley Christian Prep','address'=>'567 Fog Lane','city'=>'Phoenix','state'=>'AZ','zip'=>'850238967')
        );


        $this->seed_staff($schoolId_1,$schoolId_2);
        list($teacherId_1,$teacherId_2) = $this->seed_teacher($schoolId_1);

        $parentId = $this->seed_parent($schoolId_1);
        $this->seed_student($schoolId_1,$parentId,$teacherId_1,$teacherId_2);



    }

    public function seed_teacher($schoolId_1) {
        // Teacher 2
        $teacherId = DB::table('teachers')->insertGetId(

            array('firstName'=>'Gloria','lastName'=>'Rug','email'=>'teacher@someschool.edu')

        );

        $userId = DB::table('users')->insertGetId(

            array('teacherId'=>$teacherId,'password'=>Hash::make('7383jmd2'),'email'=>'teacher@someschool.edu','canLogin'=>'Y')

        );
        DB::table('user_school_mapper')->insert(

            array('userId'=>$userId,'schoolId'=>$schoolId_1,'default_school'=>'Y')

        );
        $teacherId_1 = $teacherId;

        // Teacher 2
        $teacherId = DB::table('teachers')->insertGetId(

            array('firstName'=>'Bill','lastName'=>'McHiggins','email'=>'bill@someschool.edu')

        );

        $userId = DB::table('users')->insertGetId(

            array('teacherId'=>$teacherId,'password'=>Hash::make('7383jmd2'),'email'=>'bill@someschool.edu','canLogin'=>'Y')

        );
        DB::table('user_school_mapper')->insert(

            array('userId'=>$userId,'schoolId'=>$schoolId_1,'default_school'=>'Y')

        );
        $teacherId_2 = $teacherId;

        return array($teacherId_1,$teacherId_2);
    }
    public function seed_parent($schoolId_1) {
        $parentId = DB::table('parents')->insertGetId(

            array('firstName'=>'Cynthia','lastName'=>'Dundas','email'=>'cdundas3@gmail.com')

        );

        $userId = DB::table('users')->insertGetId(

            array('parentId'=>$parentId,'password'=>Hash::make('7383jmd2'),'email'=>'cdundas3@gmail.com','canLogin'=>'Y')

        );
        DB::table('user_school_mapper')->insert(

            array('userId'=>$userId,'schoolId'=>$schoolId_1,'default_school'=>'Y')

        );
        return $parentId;
    }

    public function seed_student($schoolId_1,$parentId,$teacherId_1,$teacherId_2) {

        // Student 1
        $studentId = DB::table('students')->insertGetId(

            array('firstName'=>'Joshua','lastName'=>'Dundas','email'=>'joshua.dundas@icloud.com','currentGradeLevel'=>2)

        );

        $userId = DB::table('users')->insertGetId(

            array('studentId'=>$studentId,'password'=>Hash::make('7383jmd2'),'email'=>'joshua.dundas@icloud.com','canLogin'=>'Y')

        );
        DB::table('user_school_mapper')->insert(

            array('userId'=>$userId,'schoolId'=>$schoolId_1,'default_school'=>'Y')

        );

        DB::table('student_to_parent_mapper')->insert(
            array('student_userId'=>$studentId, 'parent_userId'=>$parentId)
        );

        DB::table('student_to_teacher_mapper')->insert(
            array('student_userId'=>$studentId,'teacher_userId'=>$teacherId_1,'gradeLevel'=>2)
        );

        // Student 2
        $studentId = DB::table('students')->insertGetId(

            array('firstName'=>'James','lastName'=>'Dundas','email'=>'james.dundas@icloud.com','currentGradeLevel'=>8)

        );

        $userId = DB::table('users')->insertGetId(

            array('studentId'=>$studentId,'password'=>Hash::make('7383jmd2'),'email'=>'james.dundas@icloud.com','canLogin'=>'Y')

        );
        DB::table('user_school_mapper')->insert(

            array('userId'=>$userId,'schoolId'=>$schoolId_1,'default_school'=>'Y')

        );
        DB::table('student_to_parent_mapper')->insert(
            array('student_userId'=>$studentId, 'parent_userId'=>$parentId)
        );
        DB::table('student_to_teacher_mapper')->insert(
            array('student_userId'=>$studentId,'teacher_userId'=>$teacherId_2,'gradeLevel'=>8)
        );

    }

    public function seed_staff($schoolId_1,$schoolId_2) {
        $staffId = DB::table('staff')->insertGetId(

                array('firstName'=>'Joe','lastName'=>'Dundas','email'=>'jdunda1@gmail.com')

        );

        $userId = DB::table('users')->insertGetId(

                array('staffId'=>$staffId,'password'=>Hash::make('7383jmd2'),'email'=>'jdunda1@gmail.com','canLogin'=>'Y')

        );
        DB::table('user_school_mapper')->insert(

                array('userId'=>$userId,'schoolId'=>$schoolId_1,'default_school'=>'N')

        );
        DB::table('user_school_mapper')->insert(

            array('userId'=>$userId,'schoolId'=>$schoolId_2,'default_school'=>'Y')

        );
    }
}


