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
    { {
            Schema::create('productdetails', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('product_id');
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->unsignedBigInteger('unit_id');
                $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');   
                $table->string('unit_value',255);      
                $table->unsignedBigInteger('color_id')->nullable();
                $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');                
                $table->unsignedBigInteger('size_id')->nullable();
                $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');                
                $table->string('purchase_price', 255);  
                $table->decimal('selling_price', 10, 2);            
                $table->decimal('tax',  10, 2)->default(0);              
                $table->decimal('discount', 10, 2)->default(0);  
                $table->decimal('total_price', 10, 2);  
                $table->string('image', 255)->nullable();            
                $table->enum('status', ['Active', 'Inactive', 'Deleted'])->default('Active');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productdetails');
    }
};
