<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Candidate;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = [
            'username' => 'testmanager',
            'password' => bcrypt('123456789'),
            'is_active' => true,
            'role' => 'manager',
        ];

        $user = User::create($manager);

        $agent = [
            'username' => 'testagent1',
            'password' => bcrypt('123456789'),
            'is_active' => true,
            'role' => 'agent',
        ];

        $user = User::create($agent);

        $agent = [
            'username' => 'testagent2',
            'password' => bcrypt('123456789'),
            'is_active' => true,
            'role' => 'agent',
        ];

        $user = User::create($agent);

        Candidate::factory()->count(20)->create();
    }
}
