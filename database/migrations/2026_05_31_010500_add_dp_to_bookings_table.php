<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // MySQL raw query to alter enum column
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'paid', 'cancelled', 'dp') NOT NULL DEFAULT 'pending'");
        
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('dp_amount', 10, 2)->nullable()->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('dp_amount');
        });
        
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'paid', 'cancelled') NOT NULL DEFAULT 'pending'");
    }
};
