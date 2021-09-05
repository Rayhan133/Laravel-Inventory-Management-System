<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_team_id');
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('area')->nullable()->nullable();
            $table->string('city')->nullable();
            $table->string('image')->nullable();
            $table->string('nid_image')->nullable();
            $table->string('account_balance')->default(0);
            $table->string('account_due')->default(0);
            $table->string('account_type')->default(0);
            $table->tinyInteger('account_status')->default(0);
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
        Schema::dropIfExists('suuppliers');
    }
}
