<?php

namespace App\Commands;

use App\Cloudflare\Client;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class ZonesSettingsDevelopmentMode extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'zones:settings:development_mode {zone : zone name} {value : can be on, off, y, n, yes, no}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Turn development more on/off';

    /**
     * Execute the console command.
     *
     * @param Client $client
     *
     * @return mixed
     */
    public function handle( Client $client)
    {

        $zone = $this->argument( 'zone');
        $onoff = $this->argument( 'value');

        $allowed = ['on'=>'on', 'yes'=>'on', 'true'=>'on', 'y' => 'on', true => 'on',
                    'off'=>'off', 'no'=>'off', 'false'=>'off', 'n' => 'off', false => 'off'];

        if (!isset($allowed[$onoff]))
            throw new Exception('Allowed: ' . implode( ', ', array_keys( $allowed )));

        $response = $client->request('patch', "/zones/$zone/settings/development_mode", ['
            value'=>$allowed[$onoff],
        ]);
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
