<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device',
        'browser',
        'browser_v',
        'platform',
        'platform_v',
        'isrobot',
        'isdesktop',
        'istablet',
        'isphone',
    ];

    /**
     * Get agent mode .
     */
    public static function getMode()
    {
        $return = 0;
        $settings = Setting::where('param', 'LIKE', 'agent_mode')->get();
        if ($settings !== null) {
            foreach ($settings as $key => $setting) {
                $return = $setting->value;
            }
        }

        return $return;
    }

    /**
     * Get agent tracker .
     */
    public static function getTracker()
    {
        $return = 0;
        $settings = Setting::where('param', 'LIKE', 'agent_track')->get();
        if ($settings !== null) {
            foreach ($settings as $key => $setting) {
                $return = $setting->value;
            }
        }

        return $return;
    }
}
