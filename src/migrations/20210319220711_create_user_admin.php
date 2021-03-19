<?php

declare(strict_types=1);

use \Clinicare\Database\Migration\Migration;
use Clinicare\Models\User;

final class CreateUserAdmin extends Migration
{

    public function up(): void
    {

        User::create([
            "name" => "Ademir",
            "email" => "admin@test.com",
            "password" => md5("admin"),
            "phone" => "11111111111",
            "type" => 5
        ]);
    }

    public function down(): void
    {
        User::where('email', "admin@test.com")->first()->delete();
    }
}
