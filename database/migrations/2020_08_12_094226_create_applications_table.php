<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->char('application_id', 50)->unique();
            $table->char('last_name', 60);
            $table->char('first_name', 60);
            $table->char('middle_name', 60)->nullable();
            $table->char('sex', 1);
            $table->char('email', 150)->index();
            $table->char('mobile', 10)->index();
            $table->char('qualification_id', 25)->index();
            $table->tinyInteger('coc_count')->default(0);
            // $table->json('competencies')->nullable();
            // $table->char('competency_id', 25)->index()->nullable();
            // $table->char('slug', 50)->unique();
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
        Schema::dropIfExists('applicants');
    }
}
