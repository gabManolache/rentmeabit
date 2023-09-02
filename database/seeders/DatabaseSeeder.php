<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'name' => 'Gabriel Manolache',
            'email' => 'm.gabriel@calm-coders.com',
            'password' => Hash::make('Salmonela1!'),  // Sostituisci con la password che desideri
            'email_verified_at' => now(),
            // 'current_team_id' => null,  // Puoi impostarlo se necessario
            // 'profile_photo_path' => null,  // Puoi impostarlo se necessario
            'created_at' => now(),
            'updated_at' => now(),
            // Altri campi qui, se necessario
        ]);


         // Creo 10 utenti con i loro prodotti, proprietà, foto e feedback
        \App\Models\User::factory(10)
        ->has(
            \App\Models\Product::factory(5)
                ->has(\App\Models\ProductProp::factory(2), 'properties')
                ->has(\App\Models\ProductPhoto::factory(3), 'photos')
                ->has(\App\Models\ProductFeedback::factory(2), 'feedbacks'),
            'products'
        )
        ->create();

    // Creo 20 ordini con i dettagli dei prodotti ordinati
    \App\Models\Order::factory(20)
        ->has(\App\Models\OrderProduct::factory(3), 'orderProducts')
        ->create();


    \App\Models\User::factory(10)->create();

        $this->call([
            ProductSeeder::class,
            ProductPropSeeder::class,
            ProductPhotoSeeder::class,
            ProductFeedbackSeeder::class,
            OrderSeeder::class,
            OrderProductSeeder::class,
        ]);
    }


}
