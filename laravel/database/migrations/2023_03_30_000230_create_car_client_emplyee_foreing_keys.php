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
       Schema::table('clients', function (Blueprint $table){
           $table->foreign("employee_id")
                 ->references("id")
                 ->on("employees")
                 ->onDelete('cascade');
       });

        Schema::table('cars', function (Blueprint $table){
            $table->foreign("client_id")
                ->references("id")
                ->on("clients")
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_client_emplyee_foreing_keys');
    }
};
