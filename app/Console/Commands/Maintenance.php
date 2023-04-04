<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Str;
use App\Mail\UnderMaintenance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

class Maintenance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:maintenance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable and disable maintenance based on maintenance module setting';

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
        $settings = Setting::where('param', 'LIKE', 'maintenance_%')->get();
        if (count($settings) > 0) {

            $config = [];
            foreach ($settings as $key => $setting) {
                $config[$setting->param] = $setting->value;
            }

            if (count($config) > 0) {
                $mode = $config['maintenance_mode'];
                $retry = $config['maintenance_retry'];
                $refresh = $config['maintenance_refresh'];
                $msg = $config['maintenance_msg'];
                $secret = Str::random(40);
                $down_file = storage_path().'/framework/down';

                if ($mode == 'yes' && !file_exists($down_file)) {
                    
                    /* send access code to all admin */
                    $users = User::role('admin')->get();
                    if(count($users) > 0) {
                        foreach($users as $user) {
                            Mail::to($user->email)->send(new UnderMaintenance($secret));
                        }
                    }

                    Artisan::queue('down --retry='.$retry.' --refresh='.$refresh.' --secret='.$secret.' --render="errors::maintenance"');
                } 
                elseif ($mode == 'no' && file_exists($down_file)) {
                    Artisan::queue('up');
                }
            }
        }
    }
}
