<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class AnnounceOff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:announceoff';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable announcement mode after exceed end date based on announcement module setting';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $settings = Setting::where('param', 'LIKE', 'announce_%')->get();
        if (count($settings) > 0) {
            $config = [];
            foreach ($settings as $key => $setting) {
                $config[$setting->param] = $setting->value;
            }

            if (count($config) > 0) {
                $mode = $config['announce_mode'];
                $end_datetime = date('YmdHi', strtotime($config['announce_end']));
                $current_datetime = date('YmdHi', strtotime('+8 hour'));

                if ($mode == 'yes' && $current_datetime >= $end_datetime) {
                    Setting::where('param', 'announce_mode')->update(['value' => 'no']);
                }
            }
        }
    }
}
