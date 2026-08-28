<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->dateTime('tanggal_kunjungan')->nullable()->after('user_id');
        });

        DB::table('kunjungans')->whereNull('tanggal_kunjungan')->update([
            'tanggal_kunjungan' => DB::raw('created_at'),
        ]);

        Schema::table('kunjungans', function (Blueprint $table) {
            $table->dateTime('tanggal_kunjungan')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->dropColumn('tanggal_kunjungan');
        });
    }
};
