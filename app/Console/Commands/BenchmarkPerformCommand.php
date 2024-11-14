<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Http;
use League\CommonMark\Node\Inline\Newline;

class BenchmarkPerformCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'benchmark:perform';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Benchmark common email addresses and domains';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Benchmarking common email addresses and domains...');

        $userData = User::factory()->raw([
            'name' => 'test user',
            'email' => 'test@example.com'
        ]);

        $benchmark_results = [];

        $bar = $this->output->createProgressBar(200);

        $bar->start();

        $benchmark_results =  Benchmark::measure([
            'common' => function () use ($userData, $bar) {
                $response = Http::post(
                    'http://localhost/api/users',
                    $userData,
                );
                $bar->advance();
                return $response;
            },
            'unique' => function () use ($bar) {
                $response = Http::post(
                    'http://localhost/api/users',
                    User::factory()->raw(),
                );
                $bar->advance();
                return $response;
            }
        ], 100);
        $this->newLine();

        $this->table(
            ['Test Type', 'Time (ms)'],
            [
                ['common', $benchmark_results['common']],
                ['unique', $benchmark_results['unique']]
            ]
        );
    }
}
