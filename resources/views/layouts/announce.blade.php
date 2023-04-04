@php

$settings = \App\Models\Setting::where('param', 'LIKE', 'announce_%')->get();
if(count($settings) > 0) {
	$config = [];
	foreach($settings as $key => $setting) {
		$config[$setting->param] = $setting->value;
	}

	if(count($config) > 0) {
		$start_dt = date('YmdHis', strtotime($config['announce_start']));
		$end_dt = date('YmdHis', strtotime($config['announce_end']));
		$current_dt = date('YmdHis', strtotime('+8 hour'));
		
		if($config['announce_mode'] == 'yes' && !empty($config['announce_msg']) && ($start_dt <= $current_dt && $end_dt >= $current_dt)) {

			if($config['announce_mood'] == 'message') {
				$color = 'green';
			}
			else if($config['announce_mood'] == 'warning') {
				$color = 'yellow';
			}
			else {
				$color = 'red';
			}

			echo '<nav class="border-b border-gray-100 text-center p-3 bg-'.$color.'-300">';
			echo $config['announce_msg'];
			echo '</nav>';
		}
	}
}

@endphp