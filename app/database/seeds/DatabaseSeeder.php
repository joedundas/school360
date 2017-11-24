<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		//$this->call(SeedStatesUS::class);
        //$this->call(SeedTimezones::class);

        $this->call(SeedGradeLevels::class);
        $this->call(SeedCourses::class);
        $this->call(SeedAuthorizationTypes::class);
        $this->call(SeedTestingSchool::class);
	}

}
