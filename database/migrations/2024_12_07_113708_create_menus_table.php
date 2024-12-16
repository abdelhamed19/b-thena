<?php

use App\Models\Menu;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('item_description');
            $table->string('item_price');
            $table->boolean('is_active')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
