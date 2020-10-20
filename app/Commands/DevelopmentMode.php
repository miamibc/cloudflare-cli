<?php

namespace App\Commands;

use App\Client\Cloudflare;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class DevelopmentMode extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'development_mode {zone : zone name} {value : can be on, off, y, n, yes, no}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Turn development more on/off';

    /**
     * Execute the console command.
     *
     * @param Cloudflare $cloudflare
     *
     * @return mixed
     */
    public function handle( Cloudflare $cloudflare)
    {
        print_r( $cloudflare->development_mode( $this->argument('zone'), $this->argument( 'value') ) );
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
