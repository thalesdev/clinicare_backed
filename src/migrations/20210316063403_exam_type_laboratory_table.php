<?php

declare(strict_types=1);

use \Clinicare\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class ExamTypeLaboratoryTable extends Migration
{
    public function up(): void
    {

        $this->schema->create('exam_type_laboratory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laboratory_id')->constrained();
            $table->foreignId('exam_type_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $this->schema->dropIfExists('exam_type_laboratory');
    }
}
