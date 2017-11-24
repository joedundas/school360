<?php

class SeedCourses extends Seeder
{
    public function run() {
        DB::table('courses')->delete();
        DB::table('courses')->insert(
            array(
                array('courseName'=>'History', 'courseDescription'=>'',"gradeLevelBegin"=>5),
            )
        );




    }

}


