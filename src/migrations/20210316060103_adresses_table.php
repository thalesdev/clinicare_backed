<?php

declare(strict_types=1);

use \Clinicare\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class AdressesTable extends Migration
{

    public function up(): void
    {

        $this->schema->create('adresses', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('number');
            $table->string('complement');
            $table->string('address');
            $table->string('state');
            $table->string('district');
            $table->string('city');
            $table->integer('zipcode');
            $table->timestamps();
        });
        $this->schema->table('users', function (Blueprint $table) {
            $table->foreign('address_id')->references('id')
                ->on('adresses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        $this->schema->table('users', function (Blueprint $table) {
            $table->dropForeign(['address_id']);
        });
        $this->schema->dropIfExists('adresses');
    }
}
