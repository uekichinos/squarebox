<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    /**
     * Get header info
     */
    public static function getHeader()
    {
        $title = config('app.name', 'Laravel');
        $image = url('img/logo.svg');

        $settings = Setting::where('param', 'LIKE', 'header_%')->get();
        if($settings) {
            foreach($settings as $key => $setting) {
                if($setting->param == 'header_title' && !empty($setting->value)) {
                    $title = $setting->value;
                }
                else if($setting->param == 'header_image' && !empty($setting->value)) {
                    $image = Storage::url('img/logo/'.$setting->value);
                }
            }
        }

        return ['title' => $title, 'image' => $image];
    }
}
