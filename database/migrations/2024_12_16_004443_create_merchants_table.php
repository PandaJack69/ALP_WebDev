<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->bigInteger('revenue')->default(0);
            $table->timestamp('joined_at');
            $table->timestamps(); // Ini akan menambahkan created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('merchants');
    }
}