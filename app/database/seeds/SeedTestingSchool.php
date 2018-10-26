<?php

class SeedTestingSchool extends Seeder
{
    public function run() {
        DB::table('schools')->delete();
        DB::table('contact_info')->delete();
        DB::table('demographics')->delete();
        DB::table('users')->delete();
        DB::table('user_school_mapper')->delete();
        DB::table('user_relationship_map')->delete();
        DB::table('user_authorizations')->delete();
        DB::table('user_roles')->delete();
        $schoolId_1 = DB::table('schools')->insertGetId(
            array('name'=>'Testing School','address'=>'123 Banana Lane','city'=>'Phoenix','state'=>'AZ','zip'=>'850234567')
        );



        $schoolId_2 = DB::table('schools')->insertGetId(
            array('name'=>'Paradise Valley Christian Prep','address'=>'567 Fog Lane','city'=>'Phoenix','state'=>'AZ','zip'=>'850238967')
        );

        DB::table('feature_flips')->insert(
            array(
                array('schoolId'=>$schoolId_2,'code'=>'schedule','subcode'=>'menu','status'=>'on')
            )
        );

        list($teacherId_1,$teacherId_2) = $this->seed_teacher($schoolId_1);
        $parentId = $this->seed_parent($schoolId_1);
        $this->seed_student($schoolId_1,$parentId,$teacherId_1,$teacherId_2);
        $this->seed_staff($schoolId_1,$schoolId_2);
    }

    public function seed_teacher($schoolId_1) {
        // Teacher 1
        $userId = DB::table('users')->insertGetId(
            array('firstName'=>'Gloria','lastName'=>'Rug','email'=>'teacher@someschool.edu','password'=>Hash::make('7383jmd2'),'canLogin'=>'Y')
        );
        $roleId = DB::table('user_roles')->insertGetId(
            array('role'=>'teacher','userId'=>$userId,'schoolId'=>$schoolId_1,'default_role'=>'Y')
        );
        DB::table('user_school_mapper')->insert(
            array('userId'=>$userId,'roleId'=>$roleId,'schoolId'=>$schoolId_1)
        );
        $teacherId_1 = $roleId;

        // Teacher 2
        $userId = DB::table('users')->insertGetId(
            array('firstName'=>'Bill','lastName'=>'McHiggins','email'=>'bill@someschool.edu','password'=>Hash::make('7383jmd2'),'canLogin'=>'Y')
        );
        $roleId = DB::table('user_roles')->insertGetId(
            array('role'=>'teacher','userId'=>$userId,'schoolId'=>$schoolId_1,'default_role'=>'Y')
        );
        DB::table('user_school_mapper')->insert(
            array('userId'=>$userId,'roleId'=>$roleId,'schoolId'=>$schoolId_1)
        );
        $teacherId_2 = $roleId;

        return array($teacherId_1,$teacherId_2);
    }


    public function seed_parent($schoolId_1) {
        $userId = DB::table('users')->insertGetId(
            array('firstName'=>'Cynthia','lastName'=>'Dundas','email'=>'cdundas3@gmail.com','password'=>Hash::make('7383jmd2'),'canLogin'=>'Y')
        );
        $roleId = DB::table('user_roles')->insertGetId(
            array('role'=>'parent','userId'=>$userId,'schoolId'=>$schoolId_1,'default_role'=>'Y')
        );
        DB::table('user_school_mapper')->insert(
            array('userId'=>$userId,'roleId'=>$roleId,'schoolId'=>$schoolId_1)
        );
        return $roleId;
    }

    public function seed_student($schoolId_1,$parentId,$teacherId_1,$teacherId_2) {

        // Student 1
        $userId = DB::table('users')->insertGetId(
            array('firstName'=>'Joshua','lastName'=>'Dundas','email'=>'joshua.dundas@icloud.com','password'=>Hash::make('7383jmd2'),'canLogin'=>'Y')
        );
        $roleId = DB::table('user_roles')->insertGetId(
            array('role'=>'student','userId'=>$userId,'schoolId'=>$schoolId_1,'default_role'=>'Y')
        );
        DB::table('user_school_mapper')->insert(
            array('userId'=>$userId,'roleId'=>$roleId,'schoolId'=>$schoolId_1)
        );
        DB::table('user_relationship_map')->insert(
            array('roleId'=>$roleId,'relatedTo_roleId'=>$parentId,'relatedToIs'=>'parent')
        );
        DB::table('user_relationship_map')->insert(
            array('roleId'=>$roleId,'relatedTo_roleId'=>$teacherId_1,'relatedToIs'=>'teacher')
        );


        // Student 2
        $userId = DB::table('users')->insertGetId(
            array('firstName'=>'James','lastName'=>'Dundas','email'=>'james.dundas@icloud.com','password'=>Hash::make('7383jmd2'),'canLogin'=>'Y')
        );
        $roleId = DB::table('user_roles')->insertGetId(
            array('role'=>'student','userId'=>$userId,'schoolId'=>$schoolId_1,'default_role'=>'Y')
        );
        DB::table('user_school_mapper')->insert(
            array('userId'=>$userId,'roleId'=>$roleId,'schoolId'=>$schoolId_1)
        );
        DB::table('user_relationship_map')->insert(
            array('roleId'=>$roleId,'relatedTo_roleId'=>$parentId,'relatedToIs'=>'parent')
        );
        DB::table('user_relationship_map')->insert(
            array('roleId'=>$roleId,'relatedTo_roleId'=>$teacherId_2,'relatedToIs'=>'teacher')
        );



    }

    public function seed_staff($schoolId_1,$schoolId_2) {

        $userId = DB::table('users')->insertGetId(
                array('firstName'=>'Joe','lastName'=>'Dundas','email'=>'jdunda1@gmail.com','password'=>Hash::make('7383jmd2'),'canLogin'=>'Y')
        );

        // Role 1 at School 1
        $roleId = DB::table('user_roles')->insertGetId(
            array('role'=>'staff','userId'=>$userId,'schoolId'=>$schoolId_1,'default_role'=>'Y')
        );
        DB::table('user_school_mapper')->insert(
                array('userId'=>$userId,'roleId'=>$roleId,'schoolId'=>$schoolId_1)
        );

        DB::table('contact_info')->insert(
            array(
                array(
                    'userId'=>$userId,
                    'roleId'=>$roleId,
                    'isDefault'=>'Y',
                    'contactType'=>'email',
                    'entryType'=>'Home',
                    'contactInfo'=>base64_encode(json_encode(array('email'=>'testextra@gmail.com')))
                ),
                array(
                    'userId'=>$userId,
                    'roleId'=>$roleId,
                    'isDefault'=>'Y',
                    'contactType'=>'address',
                    'entryType'=>'Home',
                    'contactInfo'=>base64_encode(json_encode(array('address1'=>'123 Boingo','address2'=>'','city'=>'Phoenix','state'=>'AZ','zip'=>'85023')))
                ),
            )
        );

        DB::table('demographics')->insert(
            array(
                'userId'=>$userId,
                'roleId'=>$roleId,
                'dem-birthdate'=>'',
                'dem-about'=>'This is a little blurb about me.  I hope you like it.  It can be changed in your profile.'
            )
        );

        // Role 2 at School 2
        $roleId = DB::table('user_roles')->insertGetId(
            array('role'=>'staff','userId'=>$userId,'schoolId'=>$schoolId_2,'default_role'=>'Y')
        );
        DB::table('user_school_mapper')->insert(
            array('userId'=>$userId,'roleId'=>$roleId,'schoolId'=>$schoolId_2)
        );
        DB::table('user_authorizations')->insert(
            array(
                array('roleId'=>$roleId,'schoolId'=>$schoolId_2,'permissionCode'=>'add_courses','permissionValue'=>'Y'),
                array('roleId'=>$roleId,'schoolId'=>$schoolId_2,'permissionCode'=>'add_staff','permissionValue'=>'Y')
            )
        );


    }
}



