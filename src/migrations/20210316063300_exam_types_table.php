<?php

declare(strict_types=1);

use \Clinicare\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class ExamTypesTable extends Migration
{
    public function up(): void
    {

        $this->schema->create('exam_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $this->schema->dropIfExists('exam_types');
    }
}
