<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;
use App\Models\Agent as AgentModel;

class BrowserAgent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $mode = AgentModel::getMode();
        
        if($mode == 'yes') {
            
            $tracker = AgentModel::getTracker();
            $allowTrack = false;

			if($tracker == 'admin' && $request->segment(1) == Config::get('app.backend_path')) {
				$allowTrack = true;
			}
			elseif($tracker == 'website' && $request->segment(1) != Config::get('app.backend_path')) {
				$allowTrack = true;
			}
			elseif($tracker == 'both') {
				$allowTrack = true;
			}
            
            if($allowTrack === true) {
                $device = Agent::device();   
                $browser = Agent::browser();
                $browser_v = Agent::version($browser);
                $platform = Agent::platform();
                $platform_v = Agent::version($platform);
                $isrobot = Agent::isRobot();
                $isdesktop = Agent::isDesktop();
                $istablet = Agent::isTablet();
                $isphone = Agent::isPhone();
        
                AgentModel::create([
                    'device' => $device,
                    'browser' => $browser,
                    'browser_v' => $browser_v,
                    'platform' => $platform,
                    'platform_v' => $platform_v,
                    'isrobot' => $isrobot,
                    'isdesktop' => $isdesktop,
                    'istablet' => $istablet,
                    'isphone' => $isphone,
                ]);
            }
        }

        return $next($request);
    }
}
