<?php

use App\Enums\SaleStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('total_amount')->nullable();
            $table->decimal('total_cost')->nullable();
            $table->decimal('total_profit')->nullable();
            $table->enum('status', SaleStatusEnum::values())->default(SaleStatusEnum::PENDING);
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
