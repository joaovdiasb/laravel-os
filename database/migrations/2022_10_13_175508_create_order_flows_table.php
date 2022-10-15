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
        Schema::create('order_flows', function (Blueprint $table) {
            $table->id();
            $table->text('message')->nullable();
            $table->json('attachments')->default(new \Illuminate\Database\Query\Expression('(JSON_ARRAY())'));
            $table->foreignId('order_flow_type_id')->nullable()->constrained('order_flow_types');
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('user_id')->constrained('users');
            $table->softDeletes();
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
        Schema::dropIfExists('order_flows');
    }
};
