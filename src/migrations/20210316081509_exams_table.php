<?php

declare(strict_types=1);

use \Clinicare\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class ExamsTable extends Migration
{
    public function up(): void
    {

        $this->schema->create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('laboratory_id')->constrained();
            $table->date('schedule')->default('now()');
            $table->string('result')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $this->schema->dropIfExists('exams');
    }
}
