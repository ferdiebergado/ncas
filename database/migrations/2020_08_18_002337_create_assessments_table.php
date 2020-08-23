<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->char('assessment_id', 50)->unique();
            $table->char('application_id', 50)->index();
            $table->char('assessmentable_id')->index()->nullable();
            $table->char('assessmentable_type')->nullable();
            // $table->char('application_id', 25)->index();
            // $table->char('qualification_id', 25)->index();
            $table->json('answers')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessments');
    }
}
