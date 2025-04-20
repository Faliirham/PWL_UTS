<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_performance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('m_employees')->onDelete('cascade');
            $table->foreignId('evaluator_id')->constrained('m_user')->onDelete('cascade');
            $table->unsignedTinyInteger('score');
            $table->text('notes')->nullable();
            $table->date('evaluation_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_performance');
    }
};
