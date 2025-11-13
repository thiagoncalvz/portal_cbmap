<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable()->after('id');
            }

            if (!Schema::hasColumn('users', 'cpf')) {
                $table->string('cpf')->unique()->after('name');
            } else {
                // garante índice único no cpf
                $table->unique('cpf');
            }

            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->nullable()->after('cpf');
            } else {
                // deixa nullable caso exista e esteja NOT NULL
                $table->string('email')->nullable()->change();
            }

            if (!Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken();
            }

            if (!Schema::hasColumn('users', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        // opcional: reverter só o que você quiser
        Schema::table('users', function (Blueprint $table) {
            // $table->dropColumn(['name','cpf','email','remember_token','created_at','updated_at']);
        });
    }
};
