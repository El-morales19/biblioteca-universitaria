<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('books', 'active')) {
            Schema::table('books', function (Blueprint $table) {
                $table->boolean('active')->default(true)->after('available');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('books', 'active')) {
            Schema::table('books', function (Blueprint $table) {
                $table->dropColumn('active');
            });
        }
    }
};