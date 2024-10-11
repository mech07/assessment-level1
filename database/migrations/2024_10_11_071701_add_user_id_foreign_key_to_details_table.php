<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('details', function (Blueprint $table) {
            // Ensure the user_id column exists and is of the correct type
            $table->unsignedBigInteger('user_id')->change();

            // Add foreign key constraint
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::table('details', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
