<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id(); // Blog ID
            $table->string('title');
            $table->string('slug')->unique(); // SEO-friendly slug
            $table->text('content');
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Foreign key for category
            $table->string('image')->nullable(); // Image for the blog
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
