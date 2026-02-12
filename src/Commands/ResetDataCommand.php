<?php

namespace Cachet\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetDataCommand extends Command
{
    protected $signature = 'cachet:reset-data
                            {--seed : Re-seed after clearing data}
                            {--force : Skip confirmation prompt}';

    protected $description = 'Clear all data from all tables  Optionally re-seed and create a new user.';

    /**
     * Tables that should NOT be truncated.
     */
    protected array $protected = [
        // 'users',
        'migrations',
        'settings',
    ];

    public function handle(): int
    {
        if (! $this->option('force') && ! $this->confirm('This will delete ALL data including users (settings preserved). Continue?')) {
            $this->info('Cancelled.');

            return self::SUCCESS;
        }

        $tables = $this->getTablesToTruncate();

        $driver = DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } elseif ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        foreach ($tables as $table) {
            DB::table($table)->truncate();
            $this->line("  Truncated <info>{$table}</info>");
        }

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } elseif ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $this->newLine();
        $this->info('All data cleared (settings preserved).');

        if ($this->option('seed')) {
            $this->call('db:seed', [
                '--class' => \Cachet\Database\Seeders\UcSetupSeeder::class,
            ]);
        }

        $this->newLine();
        $this->warn('All users have been removed. Create a new admin user by running:');
        $this->line('  <info>php vendor/bin/testbench cachet:make:user</info>');

        return self::SUCCESS;
    }

    protected function getTablesToTruncate(): array
    {
        $allTables = Schema::getTableListing();

        return array_values(array_filter($allTables, function (string $table) {
            return ! in_array($table, $this->protected, true);
        }));
    }
}
