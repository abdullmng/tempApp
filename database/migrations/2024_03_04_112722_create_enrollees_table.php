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
        Schema::create('enrollees', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('sector_id')->nullable();
            $table->unsignedBigInteger('organisation_id');
            $table->unsignedBigInteger('hcp_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('pf_number')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender', ['male', 'female', 'others']);
            $table->date('date_of_birth');
            $table->string('email')->nullable();
            $table->string('phone_number');
            //$table->boolean('is_bhcpf')->default(false);
            //$table->string('ref');
            $table->string('address')->nullable();
            $table->string('nin')->nullable();
            $table->integer('id_printout_count')->nullable();
            $table->string("marital_status")->nullable();
            $table->string("picture")->nullable();
            //$table->bigInteger('primary_hcp')->nullable();
            $table->bigInteger('blood_group')->nullable();
            $table->string('illness')->nullable();
            $table->string('organization')->nullable();
            $table->date('date_of_first_appointment')->nullable();
            $table->string('occupation')->nullable();
            $table->string('designation')->nullable();
            $table->string('station')->nullable();
            $table->bigInteger('hmo')->nullable();
            $table->bigInteger('enrolled_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollees');
    }
};
