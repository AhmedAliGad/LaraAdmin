<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->text('close_notes')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('status_id')->default(1);
            $table->unsignedBigInteger('priority_id')->nullable();
            $table->unsignedBigInteger('ticket_category_id')->nullable();
            $table->unsignedBigInteger('close_reason_id')->nullable();
            $table->unsignedBigInteger('close_request_by')->nullable();
            $table->json('assigned_users')->nullable();
            $table->enum('device_os', ['android', 'ios', 'web'])->default('web');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('priority_id')->references('id')->on('priorities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
