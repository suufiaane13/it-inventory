<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change cost from decimal(10,2) to integer
        // Using DB::statement to avoid requiring doctrine/dbal
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE maintenances MODIFY cost INT NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE maintenances ALTER COLUMN cost TYPE INTEGER USING cost::integer');
        } elseif ($driver === 'sqlite') {
            // SQLite doesn't support ALTER COLUMN, need to recreate table
            DB::statement('
                CREATE TABLE maintenances_new (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    equipment_id INTEGER NOT NULL,
                    reported_by INTEGER NOT NULL,
                    description TEXT NOT NULL,
                    status VARCHAR(255) NOT NULL DEFAULT \'open\',
                    cost INTEGER NULL,
                    reported_at TIMESTAMP NOT NULL,
                    resolved_at TIMESTAMP NULL,
                    created_at TIMESTAMP NULL,
                    updated_at TIMESTAMP NULL,
                    FOREIGN KEY (equipment_id) REFERENCES equipments(id) ON DELETE CASCADE,
                    FOREIGN KEY (reported_by) REFERENCES users(id) ON DELETE RESTRICT
                )
            ');
            DB::statement('INSERT INTO maintenances_new SELECT id, equipment_id, reported_by, description, status, CAST(cost AS INTEGER) as cost, reported_at, resolved_at, created_at, updated_at FROM maintenances');
            DB::statement('DROP TABLE maintenances');
            DB::statement('ALTER TABLE maintenances_new RENAME TO maintenances');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE maintenances MODIFY cost DECIMAL(10,2) NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE maintenances ALTER COLUMN cost TYPE DECIMAL(10,2)');
        } elseif ($driver === 'sqlite') {
            // SQLite doesn't support ALTER COLUMN, need to recreate table
            DB::statement('
                CREATE TABLE maintenances_old (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    equipment_id INTEGER NOT NULL,
                    reported_by INTEGER NOT NULL,
                    description TEXT NOT NULL,
                    status VARCHAR(255) NOT NULL DEFAULT \'open\',
                    cost DECIMAL(10,2) NULL,
                    reported_at TIMESTAMP NOT NULL,
                    resolved_at TIMESTAMP NULL,
                    created_at TIMESTAMP NULL,
                    updated_at TIMESTAMP NULL,
                    FOREIGN KEY (equipment_id) REFERENCES equipments(id) ON DELETE CASCADE,
                    FOREIGN KEY (reported_by) REFERENCES users(id) ON DELETE RESTRICT
                )
            ');
            DB::statement('INSERT INTO maintenances_old SELECT id, equipment_id, reported_by, description, status, CAST(cost AS REAL) as cost, reported_at, resolved_at, created_at, updated_at FROM maintenances');
            DB::statement('DROP TABLE maintenances');
            DB::statement('ALTER TABLE maintenances_old RENAME TO maintenances');
        }
    }
};
