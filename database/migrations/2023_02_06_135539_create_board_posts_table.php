<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board')->constrained('boards')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('extinguisher_type')->constrained('extinguisher_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('site')->constrained('sites')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->string('innerid');
            $table->string('fa_no');
            $table->timestamp('fa_date');
            $table->string('comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_posts');
    }
};
