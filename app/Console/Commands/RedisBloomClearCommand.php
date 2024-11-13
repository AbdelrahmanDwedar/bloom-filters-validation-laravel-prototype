<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisBloomClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:bloom:clear {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears the specified Redis Bloom filter';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $key = $this->argument('key');

        // Clear the Bloom filter
        $res=Redis::executeRaw(['DEL', $key]);

        if (!$res) {
            $this->error("Failed to clear Bloom filter with key '{$key}'.");
            return;
        }

        // Check if the Bloom filter exists
        $res = Redis::executeRaw(['BF.RESERVE', $key, 0.001, 100000000]);

        if (!$res) {
            $this->error("Failed to reserve Bloom filter with key '{$key}'.");
            return;
        }

        $this->info("Bloom filter with key '{$key}' has been cleared.");

    }
}
