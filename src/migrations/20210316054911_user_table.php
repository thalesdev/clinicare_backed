<?php

declare(strict_types=1);

use \Clinicare\Database\Migration\Migration;

final class UserTable extends Migration
{

    public function up(): void
    {

        $this->schema->create('users', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->string('specialty')->nullable();
            $table->string('crm')->unique()->nullable();
            $table->integer('type')->default(0);
            $table->integer('gender')->default(0);
            $table->date('birth')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('nationality')->nullable();
            $table->string('naturalness')->nullable();
            $table->double('salary')->nullable();
            $table->string('cpf')->unique()->nullable();
            $table->string('rg')->unique()->nullable();


            $table->foreignId('occupation_area_id')->nullable();
            $table->foreignId('address_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        $this->schema->dropIfExists('users');
    }
}
