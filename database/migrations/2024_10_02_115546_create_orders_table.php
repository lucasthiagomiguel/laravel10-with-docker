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
        // Criação da tabela orders
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('code')->unique();
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraint
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });

        // Criação da tabela order_product (tabela de relacionamento)

        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity')->default(1);
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // Evitar duplicatas
            $table->unique(['order_id', 'product_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product'); // Excluir primeiro a tabela de relacionamento
        Schema::dropIfExists('orders'); // Depois a tabela de pedidos
    }
};
