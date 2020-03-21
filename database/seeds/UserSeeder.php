<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create(
    		[
    			'name' => 'Vicente Chirinos',
		        'email' => 'josechirinos_88@hotmail.com',
		        'email_verified_at' => now(),
		        'password' => bcrypt(123456654),
		        'remember_token' => Str::random(10),
    		]
    	);

    	factory(App\User::class,20)->create();
    }
}
