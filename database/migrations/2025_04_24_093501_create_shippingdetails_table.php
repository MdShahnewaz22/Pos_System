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
    
        Schema::create('shippingdetails', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('address'); // Better for longer addresses
            $table->enum('payment_status', [
                'cash_on_delivery',
                'credit_card',
                'bank_transfer',
                'paypal',
                'mobile_payment'
            ]);
            $table->decimal('subtotal', 10, 2); // Accurate for prices and currency
            $table->enum('status', ['Active', 'Inactive', 'Deleted'])->default('Active');
            $table->timestamps();
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
        Schema::dropIfExists('shippingdetails');
    }
};
