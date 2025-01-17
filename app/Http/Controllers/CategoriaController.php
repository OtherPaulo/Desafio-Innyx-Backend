<?php

public function up(): void
{
    Schema::create('categorias', function (Blueprint $table) {
        $table->id();
        $table->string('name', 100);
        $table->timestamps();
    });
}
