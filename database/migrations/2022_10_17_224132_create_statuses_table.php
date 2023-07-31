<?php

use App\Models\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });
        Status::create(['name_en' => 'Open', 'name_ar' => 'مفتوح', 'color' => '#cf2bce']);
        Status::create(['name_en' => 'In Progress', 'name_ar' => 'جاري العمل', 'color' => '#E8C013']);
        Status::create(['name_en' => 'Close Request', 'name_ar' => 'طلب اغلاق', 'color' => '#e98259']);
        Status::create(['name_en' => 'Closed', 'name_ar' => 'مغلق', 'color' => '#e98259']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
