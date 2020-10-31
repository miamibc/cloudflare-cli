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
        $result = [];

        foreach ($parser->find('section.modunit div') as $header)
        {
            if (!$title = $header->first('h3.mod-title')) continue;

            $url = "";
            if ($pre = $header->first('pre'))
            {
                $url  = $pre->text();
            }

            // $method = "";
            // if ($span = $title->first('span.label') )
            // {
            //                $method = $span->text();
            // }
            $plans  = array_map( function ($plan){
                return substr( $plan->text(), 0, 1);
            }, $title->find('li.plan'));


            foreach ( $title->findInDocument('ul, span') as $element) $element->remove();

            $text   = $title->text();

            if ($text && $url && $plans)
            {
                $result[] = [
                    'plans'=> '<comment>' . implode("",$plans) . '</comment>',
                    'url'=> "<info>$url</info>" . PHP_EOL . trim( $text ) . PHP_EOL,
                    // 'description'=>$text,
                ];
                // $this->line("<info>$text</info> $url <comment>" . implode(", ",$plans) . "</comment>");
            }
        }

        $this->table(['plans', 'url', 'description'], $result);
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
