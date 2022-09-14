<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id(); //id otomatis auto increment
            $table->string('npm',12)->nullable(); //type data varchar
            $table->string('nama',100)->nullable(); //type data varchar
            $table->string('jenis_kelamin',10)->nullable(); //type data varchar
            $table->text('alamat')->nullable(); //type data text
            $table->timestamps(); //otomatis dibuatkan kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table');
    }
}
