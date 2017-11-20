<?php

class SeedStatesUS extends Seeder
{
    public function run() {
        DB::table('state_list')->delete();
        DB::table('state_list')->insert(
            array(
                array('name' => 'Alabama', 'code2' => 'AL'),
                array('name' => 'Alaska', 'code2' => 'AK'),
                array('name' => 'Arizona', 'code2' => 'AZ'),
                array('name' => 'Arkansas', 'code2' => 'AR'),
                array('name' => 'California', 'code2' => 'CA'),
                array('name' => 'Colorado', 'code2' => 'CO'),
                array('name' => 'Connecticut', 'code2' => 'CT'),
                array('name' => 'Delaware', 'code2' => 'DE'),
                array('name' => 'District of Columbia', 'code2' => 'DC'),
                array('name' => 'Florida', 'code2' => 'FL'),
                array('name' => 'Georgia', 'code2' => 'GA'),
                array('name' => 'Hawaii', 'code2' => 'HI'),
                array('name' => 'Idaho', 'code2' => 'ID'),
                array('name' => 'Illinois', 'code2' => 'IL'),
                array('name' => 'Indiana', 'code2' => 'IN'),
                array('name' => 'Iowa', 'code2' => 'IA'),
                array('name' => 'Kansas', 'code2' => 'KS'),
                array('name' => 'Kentucky', 'code2' => 'KY'),
                array('name' => 'Louisiana', 'code2' => 'LA'),
                array('name' => 'Maine', 'code2' => 'ME'),
                array('name' => 'Maryland', 'code2' => 'MD'),
                array('name' => 'Massachusetts', 'code2' => 'MA'),
                array('name' => 'Michigan', 'code2' => 'MI'),
                array('name' => 'Minnesota', 'code2' => 'MN'),
                array('name' => 'Mississippi', 'code2' => 'MS'),
                array('name' => 'Missouri', 'code2' => 'MO'),
                array('name' => 'Montana', 'code2' => 'MT'),
                array('name' => 'Nebraska', 'code2' => 'NE'),
                array('name' => 'Nevada', 'code2' => 'NV'),
                array('name' => 'New Hampshire', 'code2' => 'NH'),
                array('name' => 'New Jersey', 'code2' => 'NJ'),
                array('name' => 'New Mexico', 'code2' => 'NM'),
                array('name' => 'New York', 'code2' => 'NY'),
                array('name' => 'North Carolina', 'code2' => 'NC'),
                array('name' => 'North Dakota', 'code2' => 'ND'),
                array('name' => 'Ohio', 'code2' => 'OH'),
                array('name' => 'Oklahoma', 'code2' => 'OK'),
                array('name' => 'Oregon', 'code2' => 'OR'),
                array('name' => 'Pennsylvania', 'code2' => 'PA'),
                array('name' => 'Rhode Island', 'code2' => 'RI'),
                array('name' => 'South Carolina', 'code2' => 'SC'),
                array('name' => 'South Dakota', 'code2' => 'SD'),
                array('name' => 'Tennessee', 'code2' => 'TN'),
                array('name' => 'Texas', 'code2' => 'TX'),
                array('name' => 'Utah', 'code2' => 'UT'),
                array('name' => 'Vermont', 'code2' => 'VT'),
                array('name' => 'Virginia', 'code2' => 'VA'),
                array('name' => 'Washington', 'code2' => 'WA'),
                array('name' => 'West Virginia', 'code2' => 'WV'),
                array('name' => 'Wisconsin', 'code2' => 'WI'),
                array('name' => 'Wyoming', 'code2' => 'WY')
            ));
    }
}