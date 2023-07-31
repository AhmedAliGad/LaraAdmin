<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar')->nullable();
            $table->text('description_en');
            $table->text('description_ar')->nullable();
            $table->longText('terms_en');
            $table->longText('terms_ar')->nullable();
            $table->longText('privacy_en');
            $table->longText('privacy_ar')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('whatsapp');
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('address_en')->nullable();
            $table->string('address_ar')->nullable();
            $table->string('latitude')->nullable()->default('24.774265');
            $table->string('longitude')->nullable()->default('46.738586');
            $table->timestamps();
        });
        Setting::create(['name_en' => 'FNDEV Support', 'description_en' => 'FNDEV Tickets System',
            'email' => 'info@fndevcs.com', 'phone' => '01020304050', 'whatsapp' => '+201020304050',
            'privacy_en' => 'App privacy', 'terms_en' => 'App terms']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
