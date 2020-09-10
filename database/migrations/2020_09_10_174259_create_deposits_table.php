<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained();
            $table->foreignId('wallet_id')
                ->constrained();
            $table->decimal('invested_amount')->default(0);
            $table->decimal('percentage')->default(0);
            $table->tinyInteger('status');
            $table->smallInteger('duration');
            $table->smallInteger('accrue_times')->default(0);
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
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['wallet_id']);
        });
        Schema::dropIfExists('deposits');
    }
}
