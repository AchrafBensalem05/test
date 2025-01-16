<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use InvalidArgumentException;

class StringReplace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:string_replace {template} {arguments*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replace string with arguments';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $template = $this->argument('template');
        $arguments = $this->argument('arguments');

        if (!preg_match_all('/\{(\d+)\}/', $template, $matches)) {
            $this->error('Invalid template format. Placeholders should be like this {0}, {1}, etc.');
            return Command::FAILURE;
        }

        $placeholderCount = count($matches[0]);
        if ($placeholderCount > count($arguments)) {
            $this->error('The number of arguments does not match.');
            return Command::FAILURE;
        }

        $result = $this->replacePlaceholders($template, $arguments);
        $this->info($result);

        return Command::SUCCESS;
    }


    private function replacePlaceholders(string $template, array $arguments): string
    {
        return preg_replace_callback('/\{(\d+)\}/', function ($matches) use ($arguments) {
            $index = (int) $matches[1];
            if (!array_key_exists($index, $arguments)) {
                $this->warn("Placeholder {$matches[0]} has no argument.");
                return $matches[0]; 
            }
            return $arguments[$index];
        }, $template);
    }
}
