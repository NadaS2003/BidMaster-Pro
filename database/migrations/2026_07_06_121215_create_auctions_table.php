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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // البائع
            $table->string('title');
            $table->text('description');
            $table->string('image_path')->nullable(); // مسار صورة المنتج
            $table->decimal('starting_price', 10, 2);
            $table->decimal('current_price', 10, 2)->nullable();
            $table->string('status')->default('active'); // سيرتبط بالـ Enum
            $table->timestamp('end_time'); // وقت انتهاء المزاد (مهم للـ Queue)
            $table->text('ai_evaluation')->nullable(); // حقل الذكاء الاصطناعي
            $table->softDeletes(); // تفعيل الحذف المؤقت (Soft Delete)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
