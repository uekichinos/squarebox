@php

$settings = \App\Models\Setting::where('param', 'LIKE', 'ga_%')->get();
if(count($settings) > 0) {
	$config = [];
	foreach($settings as $key => $setting) {
		$config[$setting->param] = $setting->value;
	}

	if(count($config) > 0) {
		if($config['ga_mode'] == 'yes' && !empty($config['ga_code'])) {
			if($config['ga_track'] == 'admin' && Request::segment(1) == Config::get('app.backend_path')) {
				echo $config['ga_code'];
			}
			elseif($config['ga_track'] == 'website' && Request::segment(1) != Config::get('app.backend_path')) {
				echo $config['ga_code'];
			}
			elseif($config['ga_track'] == 'both') {
				echo $config['ga_code'];
			}
		}
	}
}

@endphp