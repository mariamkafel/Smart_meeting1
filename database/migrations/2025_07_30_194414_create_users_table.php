<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('FirstName', 100);
            $table->string('LastName', 100);
            $table->string('Email', 255)->unique();
            $table->string('PasswordHash', 255);
            $table->string('Role', 50);
            $table->string('Department', 100);
            $table->boolean('IsActive');
            $table->string('ProfileImageUrl', 500)->nullable();
            $table->dateTime('LastSeenDate')->nullable();
            $table->dateTime('CreatedDate')->default(DB::raw('GETDATE()'));
            $table->dateTime('UpdatedDate')->default(DB::raw('GETDATE()'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
