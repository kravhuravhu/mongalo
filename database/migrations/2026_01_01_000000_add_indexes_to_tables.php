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
        // ─── ORDERS TABLE ───
        Schema::table('orders', function (Blueprint $table) {
            $table->index('payment_status');
            $table->index('created_at');
            $table->index('order_number');
            $table->index(['book_id', 'payment_status']);
        });

        // ─── EVENT REGISTRATIONS TABLE ───
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->index('event_id');
            $table->index('email');
            $table->index('payment_status');
            $table->index(['event_id', 'payment_status']);
            $table->index('created_at');
        });

        // ─── BAPTISM REQUESTS TABLE ───
        Schema::table('baptism_requests', function (Blueprint $table) {
            $table->index('status');
            $table->index('created_at');
            $table->index('email');
        });

        // ─── CONTACT MESSAGES TABLE ───
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->index('status');
            $table->index('created_at');
            $table->index('email');
        });

        // ─── BOOKS TABLE ───
        Schema::table('books', function (Blueprint $table) {
            $table->index('is_free');
            $table->index('is_featured');
            $table->index('sort_order');
            $table->index('slug');
        });

        // ─── EVENTS TABLE ───
        Schema::table('events', function (Blueprint $table) {
            $table->index('is_past');
            $table->index('date');
            $table->index(['date', 'is_past']);
            $table->index('slug');
        });

        // ─── INVITE REQUESTS TABLE ───
        Schema::table('invite_requests', function (Blueprint $table) {
            $table->index('status');
            $table->index('created_at');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['payment_status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['order_number']);
            $table->dropIndex(['book_id', 'payment_status']);
        });

        Schema::table('event_registrations', function (Blueprint $table) {
            $table->dropIndex(['event_id']);
            $table->dropIndex(['email']);
            $table->dropIndex(['payment_status']);
            $table->dropIndex(['event_id', 'payment_status']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('baptism_requests', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['email']);
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['email']);
        });

        Schema::table('books', function (Blueprint $table) {
            $table->dropIndex(['is_free']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['sort_order']);
            $table->dropIndex(['slug']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['is_past']);
            $table->dropIndex(['date']);
            $table->dropIndex(['date', 'is_past']);
            $table->dropIndex(['slug']);
        });

        Schema::table('invite_requests', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['email']);
        });
    }
};