<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

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

        // delete redis bloom filter
        $res = Redis::executeRaw(['DEL', 'user_emails']);
        if (! $res) {
            $this->error('Error deleting bloom filter');
            return;
        }

        // reserve redis bloom filter
        $res = Redis::executeRaw(['BF.RESERVE', 'user_emails', 0.001, 1000000]);
        if (! $res) {
            $this->error('Error reserving bloom filter');
            return;
        }

        // seed database
        $this->call('db:seed');

        $this->info('Benchmark data prepared.');
    }
}
