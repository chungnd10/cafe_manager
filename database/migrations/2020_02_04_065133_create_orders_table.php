<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_name')->nullable();

            $table->unsignedInteger('table_id');
            $table->foreign('table_id')
                ->references('id')
                ->on('tables')
                ->onDelete('CASCADE');

            $table->unsignedInteger('created_by');
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->unsignedInteger('order_status_id');
            $table->foreign('order_status_id')
                ->references('id')
                ->on('orders')
                ->onDelete('CASCADE');

            $table->unsignedInteger('bartender_id')->nullable();
            $table->foreign('bartender_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
