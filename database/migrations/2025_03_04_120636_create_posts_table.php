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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->foreignId('user_id')->index()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('postable_id')->nullable();
            $table->string('postable_type')->nullable();
            $table->longText('body')->nullable();
            $table->boolean('isDisabled')->default(false);
            $table->foreignId('deleted_by')->index()->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->index(['postable_type', 'postable_id'], 'postable_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
