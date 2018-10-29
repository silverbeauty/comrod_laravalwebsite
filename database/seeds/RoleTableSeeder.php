<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	if (!Role::where('name', 'user_autoapprove')->exists()) {
    		Role::create([
    			'name' => 'user_autoapprove',
    			'label' => 'User Autoapprove'
    		]);
    	}
    }
}
