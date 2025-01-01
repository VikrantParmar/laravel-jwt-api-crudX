<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps(); // This will create 'created_at' and 'updated_at' columns
            $table->softDeletes(); // Soft delete column for 'deleted_at'
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
