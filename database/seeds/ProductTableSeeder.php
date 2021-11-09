<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Product::class, 10)->create();      //vai chamar o model e criar 10 produtos, chamando o metodo create;
    }
}
