<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('count');
            $table->decimal('price', 8, 2);
            $table->string('image')->nullable();
            $table->boolean('featured')->default(false);
            $table->unsignedBigInteger('category_id');
            $table->float('sale')->nullable();
            $table->decimal('old_price', 8, 2)->nullable();
            $table->text('how_to_take_it')->nullable();
            $table->string('ingredients_image')->nullable();
            $table->text('ingredients_text')->nullable();
            $table->text('product_description');
            $table->text('product_article')->nullable();
            $table->json('product_icons')->nullable();
            $table->float('sale_on_3')->nullable();
            $table->float('sale_on_6')->nullable();
            $table->float('sale_on_9')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
