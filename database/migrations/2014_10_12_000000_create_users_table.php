<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('role',['owner','cashier','manager'])->default('cashier');
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        User::create([
            'name' => 'amr',
            'email' => 'amr@owner.com',
            'password' => Hash::make('123456789'),
            'role' => 'owner',
            'address' => 'Alshiekh Zayed',
            'phone' => '01060669978',
        ]);
        User::create([
            'name' => 'manager',
            'email' => 'manager@manager.com',
            'password' => Hash::make('123456789'),
            'role' => 'manager',
            'address' => 'Alshiekh Zayed',
            'phone' => '01234567890',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
