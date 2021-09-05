<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('smg_manager_id')->constrained('users')->onDeleted('cascade');
            $table->foreignId('category_id')->constrained()->onDeleted('cascade')->onUpdated('cascade');
            $table->foreignId('unit_id')->constrained('units')->onDeleted('cascade');
            $table->string('name');
            $table->string('sku');
            $table->text('sizes')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('status')->default(0);
            // $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('products');
    }
}
