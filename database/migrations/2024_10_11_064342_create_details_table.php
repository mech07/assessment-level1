<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto_increment
            $table->string('key', 255); // varchar(255) NOT NULL
            $table->text('value')->nullable(); // text NULL
            $table->string('icon', 255)->nullable(); // varchar(255) NULL
            $table->string('status', 255)->default('1'); // varchar(255) NOT NULL DEFAULT '1'
            $table->string('type', 255)->default('detail')->nullable(); // varchar(255) NULL DEFAULT 'detail'
            $table->unsignedBigInteger('user_id')->nullable(); // bigint unsigned NULL, foreign key
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('details');
    }
}
