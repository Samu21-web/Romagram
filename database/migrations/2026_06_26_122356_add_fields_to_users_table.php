<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->unique()->after('email');
            $table->enum('gender', ['male', 'female'])->nullable()->after('phone');
            $table->enum('interested_in', ['male', 'female'])->nullable()->after('gender');
            $table->integer('age')->nullable()->after('interested_in');
            $table->boolean('profile_complete')->default(false)->after('age');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'gender', 'interested_in', 'age', 'profile_complete']);
        });
    }
};