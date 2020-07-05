<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_event', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('people_id');
            $table->foreign('people_id')
                ->references('id')
                ->on('people')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer('registration_order');
            $table->string('ticket_hash');
            $table->string('ticket_type');
            $table->decimal('ticket_value');
            $table->timestamp('purchase_date');
            $table->string('order_hash');
            $table->enum('payment_status', ['Aprovado', 'Não pago', 'Cancelado']);
            $table->boolean('check_in')->default(false);
            $table->timestamp('check_in_date')->nullable(true);
            $table->string('discount_code')->nullable(true);
            $table->enum('payment_method', ['gratis', 'cartão de crédito', 'boleto bancário', 'adicionado manualmente', 'débito online']);

            $table->unsignedBigInteger('import_id')->nullable(true);
            $table->foreign('import_id')
                ->references('id')
                ->on('imports')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('people_event');
    }
}
