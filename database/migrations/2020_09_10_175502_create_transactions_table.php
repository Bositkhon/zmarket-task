<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type');
            $table->foreignId('user_id')
                ->constrained();
            $table->foreignId('wallet_id')
                ->constrained();
            $table->foreignId('deposit_id')
                ->nullable()
                ->constrained();
            $table->decimal('amount')->default(0);
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
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['wallet_id']);
            $table->dropForeign(['deposit_id']);
        });
        Schema::dropIfExists('transactions');
    }
}
