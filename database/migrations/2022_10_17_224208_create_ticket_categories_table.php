<?php

use App\Models\TicketCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });
        TicketCategory::create(['name_en' => 'Problem', 'name_ar' => 'مشكلة',  'color' => '#cf2bce']);
        TicketCategory::create(['name_en' => 'Change Request', 'name_ar' => 'طلب تغيير',  'color' => '#e98259']);
        TicketCategory::create(['name_en' => 'Help Request', 'name_ar' => 'مساعدة',  'color' => '#e98259']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_categories');
    }
}
