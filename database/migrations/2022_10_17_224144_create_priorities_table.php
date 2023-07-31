<?php

use App\Models\Priority;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrioritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('priorities', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });
        Priority::create(['name_en' => 'Low',  'name_ar' => 'منخفض', 'color' => '#b4aef6']);
        Priority::create(['name_en' => 'Medium',  'name_ar' => 'متوسط', 'color' => '#5e8f5a']);
        Priority::create(['name_en' => 'High',  'name_ar' => 'مرتفع', 'color' => '#7b2e4c']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('priorities');
    }
}
