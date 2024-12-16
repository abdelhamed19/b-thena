<?php

use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('address');
            $table->foreignId('deleted_by')->nullable()->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
        CustomerAddress::create([
            'customer_id' => 1,
            'address' => 'القاهرة',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};
