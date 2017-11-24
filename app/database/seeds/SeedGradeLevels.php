<?php

class SeedGradeLevels extends Seeder
{
    public function run() {
        DB::table('grade_levels')->delete();
        DB::table('grade_levels')->insert(
            array(
                array('gradeOrder'=>0, 'gradeLevel'=>'Pre-K'),
                array('gradeOrder'=>1,'gradeLevel'=>'Kindergarten'),
                array('gradeOrder'=>2,'gradeLevel'=>'1'),
                array('gradeOrder'=>3,'gradeLevel'=>'2'),
                array('gradeOrder'=>4,'gradeLevel'=>'3'),
                array('gradeOrder'=>5,'gradeLevel'=>'4'),
                array('gradeOrder'=>6,'gradeLevel'=>'5'),
                array('gradeOrder'=>7,'gradeLevel'=>'6'),
                array('gradeOrder'=>8,'gradeLevel'=>'7'),
                array('gradeOrder'=>9,'gradeLevel'=>'8'),
                array('gradeOrder'=>10,'gradeOrder'=>0,'gradeLevel'=>'9'),
                array('gradeOrder'=>11,'gradeLevel'=>'10'),
                array('gradeOrder'=>12,'gradeLevel'=>'11'),
                array('gradeOrder'=>13,'gradeLevel'=>'12'),
            )
        );




    }

}


