<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id', 10);
            $table->unsignedBigInteger('sales_executive_id');
            $table->unsignedBigInteger('zone_id');
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('store_address')->nullable();
            $table->string('nid_image')->nullable();
            $table->tinyInteger('account_status')->default(0);
            $table->string('account_type')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
