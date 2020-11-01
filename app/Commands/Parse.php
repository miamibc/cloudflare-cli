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

        foreach ($parser->find('section.modunit') as $header)
        {
            if (!$link = $header->first('a[id]')) continue;
            $link = $link->attr('id');

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
                return ucfirst( substr( $plan->text(), 0, 1) );
            }, $title->find('li.plan'));

            foreach ( $title->findInDocument('ul, span') as $element) $element->remove();

            $text   = trim( $title->text() );

            $params = array_map( function ($item){
                return $item->text();
            }, $header->find('.object-definition-table .param-name strong'));

            if (1)
            {
                $result[] = [
                    // 'ref'=>  "<comment>$link</comment>",
                    'url'=>  "<info>$url</info>",
                    'params'=> '<comment>' . implode(" ",$params) . '</comment>',
                    'description'=>$text,
                    //'plans'=> '<comment>' . implode("",$plans) . '</comment>',
                ];
                $this->line("<info>$url</info> <comment>" . implode(" ",$params) . "</comment> $text");
            }
        }

        // $this->table(["url', 'description'], $result);
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
