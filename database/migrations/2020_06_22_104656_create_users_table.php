<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('unique_id', 15)->nullable();
            $table->string('verification_code', 10)->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email', 191)->unique()->nullable();
            $table->string('password')->nullable();
            $table->text('profile_image')->nullable();
            $table->string('phone_number')->nullable();
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null'); // Foreign key constraint on 'roles' table
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->enum('status', [1, 2])->nullable(); // Better to use meaningful enum values like 'active' and 'inactive'
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
