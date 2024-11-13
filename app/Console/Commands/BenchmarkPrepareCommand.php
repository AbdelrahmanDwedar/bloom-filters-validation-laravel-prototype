<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BenchmarkPrepareCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'benchmark:prepare';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // migrate database
        $this->call('migrate:fresh');

        // seed database
        $this->call('db:seed');

        $this->info('Benchmark data prepared.');
    }
}
