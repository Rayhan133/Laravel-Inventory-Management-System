<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTotalRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('total_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDeleted('cascade');
            $table->foreignId('unit_id')->constrained('units')->onDeleted('cascade');
            $table->string('variant');
            $table->string('required_qty');
            $table->string('supplied_qty')->default(0);
            $table->decimal('total_price')->default(0);
            $table->string('image')->nullable();
            $table->longText('note')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('total_requirements');
    }
}
