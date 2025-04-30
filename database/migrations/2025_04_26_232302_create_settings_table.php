<?php

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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title')->nullable()->comment('such as Dr. Mr. Mrs Etc.');
            $table->string('image')->nullable();
            $table->string('religion')->nullable();
            $table->text('address_1')->nullable();
            $table->enum('Gender', ['M', 'F', 'none'])->default('none');
            $table->date('DateOfBirth')->nullable();
            $table->integer('age')->default(0);
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
