<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductFeedback;
use App\Models\ProductPhoto;
use App\Models\ProductProp;
use App\Models\ProductRelated;
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


        // Crea utenti con prodotti, proprietà, foto, feedback
        User::factory(10)
        ->has(
            Product::factory(5)
                ->has(ProductProp::factory(2), 'properties')
                ->has(
                    ProductFeedback::factory(rand(0, 100)), // Numero casuale di feedback
                    'feedbacks'
                )
                ->has(ProductPhoto::factory()->count(4)->state(['main' => false]), 'photos')
                ->has(ProductPhoto::factory()->state(['main' => true]), 'photos')
                ->afterCreating(function($product) {
                    ProductRelated::factory(rand(2, 7))->create([
                        'product_id' => $product->id,
                        'related_id' => Product::all()->random()->id,
                    ]);
                }),
            'products'
        )
        ->create();

        // Crea ordini con i dettagli dei prodotti ordinati
        Order::factory(20)
            ->has(OrderProduct::factory(3), 'orderProducts')
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
