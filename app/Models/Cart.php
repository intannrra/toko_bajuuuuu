<?php

// database/migrations/xxxx_xx_xx_create_carts_table.php
Schema::create('carts', function (Blueprint $table) {
    $table->string('product');
    $table->integer('quantity');
    $table->decimal('price', 10, 2);
    $table->decimal('total', 10, 2);
    $table->text('address');
    $table->string('shipping_method');
    $table->string('payment_method');
    $table->timestamps();
});
