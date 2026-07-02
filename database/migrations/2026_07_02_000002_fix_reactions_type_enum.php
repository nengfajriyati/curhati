<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('reactions', 'type')) {
            Schema::table('reactions', function (Blueprint $table) {
                $table->string('type', 20)->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('reactions', 'type')) {
            Schema::table('reactions', function (Blueprint $table) {
                $table->enum('type', ['like', 'love', 'sad'])->nullable()->change();
            });
        }
    }
};
