<?php

declare(strict_types=1);

use \Clinicare\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class OccupationAreasTable extends Migration
{

    public function up(): void
    {

        $this->schema->create('occupation_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        $this->schema->table('users', function (Blueprint $table) {
            $table->foreign('occupation_area_id')->references('id')
                ->on('occupation_areas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        $this->schema->table('users', function (Blueprint $table) {
            $table->dropForeign(['occupation_area_id']);
        });
        $this->schema->dropIfExists('occupation_areas');
    }
}
