<?php

namespace App\Commands;

use App\Cloudflare\Client;
use App\Cloudflare\Documentation;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Parse extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'parse';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Parse cloudflare documentation';

    /**
     * Execute the console command.
     *
     * @param Client $client
     *
     * @return mixed
     */
    public function handle(Documentation $documentation)
    {
        $parser = $documentation->download()->parse();

        foreach ($parser->find('section.modunit div') as $header)
        {
            if (!$title = $header->first('h3.mod-title')) continue;

            $url = "";
            if ($pre = $header->first('pre'))
            {
                $url  = $pre->text();
            }

            $method = "";
            if ($span = $title->first('span.label') )
            {
                $method = $span->text();
            }
            $plans  = array_map( function ($plan){
                return $plan->text();
            }, $title->find('li.plan'));


            foreach ( $title->findInDocument('ul, span') as $element) $element->remove();

            $text   = $title->text();

            if ($method && $text && $url && $plans)
            {
                $this->line("<info>$text</info> $method $url (" . implode("Plans: ",$plans) . ")");
            }
        }

    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule)
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
