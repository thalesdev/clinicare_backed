<?php

declare(strict_types=1);

use \Clinicare\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

final class AppointmentsTable extends Migration
{
    public function up(): void
    {

        $this->schema->create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id');
            $table->foreignId('doctor_id');
            $table->date('schedule')->default('now()');
            $table->string('prescription')->nullable();
            $table->string('observation')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('users');
            $table->foreign('doctor_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        $this->schema->dropIfExists('appointments');
    }
}
