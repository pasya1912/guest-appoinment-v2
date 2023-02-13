    <?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilityDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('snack_kering');
            $table->integer('snack_basah');
            $table->integer('makan_siang');
            $table->integer('permen');
            $table->integer('kopi');
            $table->integer('teh');
            $table->integer('soft_drink');
            $table->integer('air_mineral');
            $table->integer('helm');
            $table->integer('handuk');
            $table->integer('speaker');
            $table->integer('speker_wireless');
            $table->integer('mobil');
            $table->integer('motor');
            $table->integer('mini_bus');
            $table->integer('bus');
            $table->bigInteger('appointment_id')->unsigned();
            $table->foreign('appointment_id')->references('id')->on('appointments');
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
        Schema::dropIfExists('facility_details');
    }
}