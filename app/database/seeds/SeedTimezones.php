<?php

class SeedTimezones extends Seeder
{
    public function run() {
        DB::table('timezones')->delete();
        DB::table('timezones')->insert(
            array(
                array('conventionalName'=>'Pacific/Honolulu', 'shortCode'=>'','offset'=>'-10','longCode'=>'Hawaii Time'),
                array('conventionalName'=>'America/Anchorage', 'shortCode'=>'','offset'=>'-8','longCode'=>'Alaska Time'),
                array('conventionalName'=>'America/Los_Angeles', 'shortCode'=>'','offset'=>'-7','longCode'=>'Pacific Time'),
                array('conventionalName'=>'America/Denver', 'shortCode'=>'','offset'=>'-6','longCode'=>'Mountain Time'),
                array('conventionalName'=>'America/Phoenix', 'shortCode'=>'','offset'=>'-7','longCode'=>'Mountain Time - Arizona'),
                array('conventionalName'=>'America/Chicago', 'shortCode'=>'','offset'=>'-5','longCode'=>'Central Time'),
                array('conventionalName'=>'America/New_York', 'shortCode'=>'','offset'=>'-4','longCode'=>'Eastern Time'),

            ));
    }
}