<?php

class SeedFeatureCodes extends Seeder
{
    public function run() {
        DB::table('feature_codes')->delete();
        DB::table('feature_codes')->insert(
            array(
                array('code'=>'billing', 'subcode'=>'','defaultStatus'=>'on','title'=>'Billing / Invoicing','description'=>'Send monthly invoices to parents, track payments and revenue cycle tools.'),
                array('code'=>'schedule', 'subcode'=>'menu','defaultStatus'=>'off','title'=>'Menu & Menu Selection','description'=>'Create daily menus and allow parents/students to choose from menu'),
                array('code'=>'communication','subcode'=>'','defaultStatus'=>'on','title'=>'Communication Tools','description'=>'Various communication tools allow things such as parent to teacher, student to teacher, and/or student to student messaging'),
                array('code'=>'social','subcode'=>'','defaultStatus'=>'off','title'=>'Social Features','description'=>'')
            )
        );




    }

}


