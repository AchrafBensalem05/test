<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        $result = $this->replacePlaceholders($template, $arguments);
        $this->info($result);

        return Command::SUCCESS;
    }


    private function replacePlaceholders(string $template, array $arguments): string
    {
        return preg_replace_callback('/\{(\d+)\}/', function ($matches) use ($arguments) {
            $index = (int) $matches[1];
            return $arguments[$index] ?? $matches[0];
        }, $template);
    }
}
