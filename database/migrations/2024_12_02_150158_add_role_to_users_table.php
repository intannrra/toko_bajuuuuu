<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->default('user')->after('password'); // Tambahkan kolom 'role' setelah kolom 'password'
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'role_id')) {
            $table->bigInteger('role_id')->unsigned()->notNull();
        }
    });    
}
};