<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title');
            $table->string('excerpt')->nullable()->after('content');
            $table->string('category')->nullable()->after('excerpt');
            $table->string('thumbnail')->nullable()->after('category');
            $table->unsignedInteger('views')->default(0)->after('thumbnail');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['slug', 'excerpt', 'category', 'thumbnail', 'views']);
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
