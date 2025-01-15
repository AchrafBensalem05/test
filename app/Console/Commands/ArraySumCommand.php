<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ArraySumCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:array_sum {array*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sum of nested array';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $input = $this->argument('array');
        $parsedArray = $this->parseArray($input);
        $sum = $this->calculateSum($parsedArray);
        $this->info("output: $sum");

        return Command::SUCCESS;
    }


    private function parseArray(array $input): array
    {
        return json_decode($input[0], true);
    }

    private function calculateSum(array $array): int
    {
        $sum = 0;
        array_walk_recursive($array, function ($value) use (&$sum) {
            if (is_numeric($value)) {
                $sum += $value;
            }
        });
        return $sum;
    }
}
