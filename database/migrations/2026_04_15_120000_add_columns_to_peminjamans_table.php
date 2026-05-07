<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus data lama yang kosong (jika ada)
        DB::table('peminjamans')->delete();

        Schema::table('peminjamans', function (Blueprint $table) {
            if (!Schema::hasColumn('peminjamans', 'siswa_id')) {
                $table->unsignedBigInteger('siswa_id')->after('id');
            }
            if (!Schema::hasColumn('peminjamans', 'buku_id')) {
                $table->unsignedBigInteger('buku_id')->after('siswa_id');
            }
            if (!Schema::hasColumn('peminjamans', 'tanggal_pinjam')) {
                $table->date('tanggal_pinjam')->after('buku_id');
            }
            if (!Schema::hasColumn('peminjamans', 'batas_kembali')) {
                $table->date('batas_kembali')->after('tanggal_pinjam');
            }
            if (!Schema::hasColumn('peminjamans', 'tanggal_kembali')) {
                $table->date('tanggal_kembali')->nullable()->after('batas_kembali');
            }
            if (!Schema::hasColumn('peminjamans', 'status')) {
                $table->enum('status', ['Dipinjam', 'Dikembalikan'])->default('Dipinjam')->after('tanggal_kembali');
            }
            if (!Schema::hasColumn('peminjamans', 'denda')) {
                $table->integer('denda')->default(0)->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $columns = ['siswa_id', 'buku_id', 'tanggal_pinjam', 'batas_kembali', 'tanggal_kembali', 'status', 'denda'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('peminjamans', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
