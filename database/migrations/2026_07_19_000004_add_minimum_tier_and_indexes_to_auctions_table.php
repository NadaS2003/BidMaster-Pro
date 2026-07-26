<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            // Tier-gating: which minimum account tier can access this auction
            $table->string('minimum_tier')->default('standard')->after('status');

            // Performance indexes on the most queried columns
            $table->index('status', 'idx_auctions_status');
            $table->index('end_time', 'idx_auctions_end_time');
            $table->index(['status', 'end_time'], 'idx_auctions_status_end_time');
        });

        Schema::table('bids', function (Blueprint $table) {
            // Composite index for fastest "highest bid on an auction" lookups
            $table->index(['auction_id', 'amount'], 'idx_bids_auction_amount');
            $table->index('user_id', 'idx_bids_user_id');
        });
    }

    public function down(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropIndex('idx_auctions_status');
            $table->dropIndex('idx_auctions_end_time');
            $table->dropIndex('idx_auctions_status_end_time');
            $table->dropColumn('minimum_tier');
        });

        Schema::table('bids', function (Blueprint $table) {
            $table->dropIndex('idx_bids_auction_amount');
            $table->dropIndex('idx_bids_user_id');
        });
    }
};
