<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('UserTableSeeder');
        //$this->call('AchievementTypesTableSeeder');
        //$this->call('GroupTableSeeder');

    }

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        $password = Hash::make('123456');

        \App\User::create(
            array(
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => $password,
                'is_admin' => 'true',
                'is_trainer' => '0',
                'group_id' => '0',
                'is_active' => '1',
                'remember_token' => null,

            )
        );
    }

}

class AchievementTypesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('achievement_types')->delete();

        \App\AchievementTypes::create(
            array(
                'type' => 'Winner'
            )
        );
    }
}

class GroupTableSeeder extends Seeder {

    public function run()
    {
        DB::table('groups')->delete();

        $user = DB::table('users')->where('email', 'trener@nieco.com')->first();
        //$this->command->info($user->name);

        \App\Group::create(
            array(
                'name' => 'Prva skupina',
                'trainer_id' => $user->id,
            )
        );
    }
}
