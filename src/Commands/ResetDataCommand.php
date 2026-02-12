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

    protected $description = 'Clear all data from tables except the users table. Optionally re-seed.';

    /**
     * Tables that should NOT be truncated.
     */
    protected array $protected = [
        'users',
        'migrations',
        'settings',
        'personal_access_tokens',
    ];

    public function handle(): int
    {
        if (! $this->option('force') && ! $this->confirm('This will delete all data (except users & settings). Continue?')) {
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
        $this->info('All data cleared (users & settings preserved).');

        if ($this->option('seed')) {
            $this->call('db:seed', [
                '--class' => \Cachet\Database\Seeders\UcSetupSeeder::class,
            ]);
        }

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
