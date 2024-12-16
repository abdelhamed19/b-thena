<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      //  Menu::factory(10)->create();
      Menu::create([
        'item_name' => 'كفته على الفحم',
        'item_description' => 'كفته على الفحم',
        'item_price' => 50.00,
        'is_active' => 1,

      ]);
      Menu::create([
        'item_name' => 'سجق على الفحم',
        'item_description' => 'سجق على الفحم',
        'item_price' => 40.00,
        'is_active' => 1,

      ]);
      Menu::create([
        'item_name' => 'حواوشي على الفحم',
        'item_description' => 'حواوشي على الفحم',
        'item_price' => 60.00,
        'is_active' => 1,
      ]);
      Menu::create([
        'item_name' => 'طرب على الفحم',
        'item_description' => 'طرب على الفحم',
        'item_price' => 65.00,
        'is_active' => 1,
      ]);

        Customer::factory(10)->create();
        CustomerAddress::create([
            'customer_id' => 1,
            'address' => 'المنصورة',
        ]);
       // Order::factory(10)->create();
    }
}
