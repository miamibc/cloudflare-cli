<?php

namespace App\Commands;

use App\Cloudflare\Client;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Zones extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'zones {--N|name=}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'List zones available';

    /**
     * Execute the console command.
     *
     * @param Client $client
     *
     * @return mixed
     */
    public function handle( Client $client)
    {
        $options = [];
        if ($this->option('name'))
        {
            $options['match'] = 'all';
            $options['name'] = $this->option('name');
        }

        $response = $client->request('get', '/zones', $options );
        if ( $response->errors() )
        {
            $this->error( $response->errorsJson() );
            return 1;
        }

        $this->table(['id', 'name', 'owner'], array_map( function($item){
            return [
                'id' => "<info>{$item['id']}</info>",
                'name' => $item['name'],
                'owner' => "{$item['owner']['type']} {$item['owner']['email']}"
                ];
        }, $response->result()));

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
