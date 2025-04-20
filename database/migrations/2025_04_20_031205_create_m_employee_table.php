<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('m_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('m_branches')->onDelete('cascade');
            $table->foreignId('position_id')->nullable()->constrained('m_positions')->onDelete('set null');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->date('hire_date');
            $table->enum('status', ['active', 'resigned'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};