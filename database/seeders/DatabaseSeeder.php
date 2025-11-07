<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $user1 = User::firstOrCreate(
            ['email' => 'teste01@exemplo.com'], 
            [
                'name' => 'Usuário 01',
                'password' => Hash::make('123456789'),
            ]
        );

        if ($user1->contacts()->count() === 0) {
            Contact::factory()->count(10)->create([
                'user_id' => $user1->id,
            ]);
        }

        $user2 = User::firstOrCreate(
            ['email' => 'teste02@exemplo.com'],
            [
                'name' => 'Usuário 02',
                'password' => Hash::make('123456789'),
            ]
        );

        if ($user2->contacts()->count() === 0) {
            Contact::factory()->count(5)->create([
                'user_id' => $user2->id,
            ]);
        }


    }
}
