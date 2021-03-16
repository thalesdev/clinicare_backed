<?php

declare(strict_types=1);


use \Clinicare\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class LaboratoriesTable extends Migration
{
    public function up(): void
    {

        $this->schema->create('laboratories', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj');
            $table->string('cnes');
            $table->string('iss');
            $table->string('employees');
            $table->foreignId('user_id')->references('id')
                ->on('users')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $this->schema->table('laboratories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        $this->schema->dropIfExists('laboratories');
    }
}
