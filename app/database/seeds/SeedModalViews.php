<?php

class SeedModalViews extends Seeder
{
    public function run() {
        DB::table('modal_views')->delete();
        DB::table('modal_views')->insert(
            array(
                array('key'=>'roles-list', 'width'=>'md', 'view'=>'secure.modals.roleList','title'=>'Your Accounts and Roles'),
            )
        );
    }

}


