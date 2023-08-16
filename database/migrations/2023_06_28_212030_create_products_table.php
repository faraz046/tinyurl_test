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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->boolean('top')->default(false);
            $table->timestamps();
            $table->softDeletes();

            //index
            $table->index(['name']);
            $table->index(['price']);
            $table->index(['created_at']);
            $table->index(['deleted_at']);
            $table->index(['top', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
