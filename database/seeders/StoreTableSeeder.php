<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stores = \App\Store::all();
        
        foreach ($stores as $store)
        {
        	Log::debug('Store: ' . $store->name);
        	$store->products()->save(factory(\App\Product::class)->make());
        }


    }
}
