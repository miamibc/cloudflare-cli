<?php

namespace App\Commands;

use App\Cloudflare\Client;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class UserTokensVerify extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'user:tokens:verify';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Verify API token';

    /**
     * Execute the console command.
     *
     * @param Client $client
     *
     * @return mixed
     */
    public function handle( Client $client)
    {
        $response = $client->request('get', '/user/tokens/verify');
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
