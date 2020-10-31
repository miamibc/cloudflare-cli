<?php

namespace App\Commands;

use App\Cloudflare\Client;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class ZonesDetails extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'zones:details {zone : zone id}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get zone details';

    /**
     * Execute the console command.
     *
     * @param Client $client
     *
     * @return mixed
     */
    public function handle( Client $client)
    {
        $zone =  $this->argument('zone');

        $response = $client->request('get', "/zones/$zone");
        $response->success()
            ? $this->line( $response->resultJson() )
            : $this->error( $response->errorsJson() );
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
