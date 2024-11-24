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
        Schema::create('order_ticket_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_info_id');
            $table->foreign('ticket_info_id')->references('id')->on('ticket_infos')->onDelete('cascade');
            $table->unsignedBigInteger('order_ticket_id');
            $table->foreign('order_ticket_id')->references('id')->on('order_tickets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_ticket_infos');
    }
};
