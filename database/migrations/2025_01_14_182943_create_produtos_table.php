<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50); 
            $table->string('description', 200);
            $table->double('price')->unsigned(); 
            $table->date('expiration_date');
            $table->string('image');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade'); // Relacionamento com categorias
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
        Schema::dropIfExists('produtos');
    }
};
