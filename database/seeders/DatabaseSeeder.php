<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => 'password',
        ]);

        $member = Member::create([
            'name' => 'Anggota Demo',
            'email' => 'member@example.com',
            'phone' => '08123456789',
            'address' => 'Jalan Contoh No.1',
        ]);

        User::factory()->create([
            'name' => 'Anggota Demo',
            'email' => 'member@example.com',
            'role' => 'member',
            'member_id' => $member->id,
            'password' => 'password',
        ]);

        // seed default loan policy
        $this->call(LoanPolicySeeder::class);
    }
}
