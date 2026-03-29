<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run raw SQL from database/migrations/sql (SQLite + MySQL).
     */
    public function up(): void
    {
        $driver = DB::getDriverName();
        $file = match ($driver) {
            'mysql' => 'create_clients_table_mysql.sql',
            'sqlite' => 'create_clients_table_sqlite.sql',
            default => 'create_clients_table_sqlite.sql',
        };

        $path = database_path('migrations/sql/'.$file);
        DB::unprepared(file_get_contents($path));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS clients');
    }
};
