<?php

namespace App\Commands;

use App\Client\Cloudflare;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Verify extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'verify';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Verify API token';

    /**
     * Execute the console command.
     *
     * @param Cloudflare $cloudflare
     *
     * @return mixed
     */
    public function handle( Cloudflare $cloudflare)
    {
        print_r( $cloudflare->verify() );
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
