<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
   /**
     * Display form edit GA
     */
    public function editGA()
    {
        $settings = Setting::where('param', 'LIKE', 'ga_%')->get();
        return view('setting.ga', ['settings' => $settings]);
    }

    /**
     * Process update GA
     */
    public function updateGA(Request $request)
    {
        $customAttr = [
            'ga_mode' => 'Mode',
            'ga_code' => 'Code',
            'ga_track' => 'Track',
        ];

        $validated = $request->validate([
            'ga_mode' => 'required',
            'ga_code' => Rule::requiredIf(function () use ($request) {
                return $request->ga_mode == 'yes';
            }),
            'ga_track' => 'required',
        ], [], $customAttr);

        foreach ($customAttr as $field => $rule) {
            $setting = Setting::where('param', $field)->first();
            $setting->value = $request->{$field};
            $setting->save();
        }

        return redirect()->route('setting.ga.edit')->with('success', 'Updated successfully!');
    }

    /**
     * Display form edit announcement
     */
    public function editAnnounce()
    {
        $settings = Setting::where('param', 'LIKE', 'announce_%')->get();
        return view('setting.announce', ['settings' => $settings]);
    }

    /**
     * Process update announcement
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAnnounce(Request $request)
    {
        $customAttr = [
            'announce_mode' => 'Announcement Mode',
            'announce_msg'  => 'Announcement Message',
            'announce_start' => 'Announcement Start Date',
            'announce_end' => 'Announcement End Date',
            'announce_mood' => 'Announcement Mood',
        ];

        $validated = $request->validate([
            'announce_mode' => 'required',
            'announce_msg'  => Rule::requiredIf(function () use ($request) {
                return $request->announce_mode == 'yes';
            }),
            'announce_start' => Rule::requiredIf(function () use ($request) {
                return $request->announce_mode == 'yes';
            }),
            'announce_end' => Rule::requiredIf(function () use ($request) {
                return $request->announce_mode == 'yes';
            }),
            'announce_mood' => 'required',
        ], [], $customAttr);


        foreach ($customAttr as $field => $rule) {
            $setting = Setting::where('param', $field)->first();
            $setting->value = $request->{$field};
            $setting->save();
        }

        return redirect()->route('setting.announce.edit')->with('success', 'Updated successfully!');
    }

    /**
     * Display form edit maintenance.
     */
    public function editMaintenance()
    {
        $settings = Setting::where('param', 'LIKE', 'maintenance_%')->get();
        return view('setting.maintenance', ['settings' => $settings]);
    }

    /**
     * Process update maintenance
     */
    public function updateMaintenance(Request $request)
    {
        $customAttr = [
            'maintenance_msg'   => 'Maintenance Message',
            'maintenance_retry' => 'Maintenance Retry',
            'maintenance_refresh' => 'Maintenance Refresh',
            'maintenance_mode'  => 'Maintenance Mode',
        ];

        $validated = $request->validate([
            'maintenance_msg'   => 'required|max:255',
            'maintenance_retry' => 'required|integer',
            'maintenance_refresh' => 'required',
            'maintenance_mode'  => 'required',
        ], [], $customAttr);

        foreach ($customAttr as $field => $rule) {
            $setting = Setting::where('param', $field)->first();
            $setting->value = $request->{$field};
            $setting->save();
        }

        return redirect()->route('setting.maintenance.edit')->with('success', 'Updated successfully!');
    }

    /**
     * Display form edit password
     */
    public function editPassword()
    {
        $settings = Setting::where('param', 'LIKE', 'password_%')->get();
        return view('setting.password', ['settings' => $settings]);
    }

    /**
     * Process update password
     */
    public function updatePassword(Request $request)
    {
        $fields = [];
        $settings = Setting::where('param', 'LIKE', 'password_%')->get();
        if ($settings !== null) {
            foreach ($settings as $key => $setting) {
                $fields[$setting->param] = 'required';
            }
        }

        $validated = $request->validate($fields, []);

        foreach ($fields as $field => $rule) {
            $setting = Setting::where('param', $field)->first();
            $setting->value = $request->{$field};
            $setting->save();
        }

        return redirect()->route('setting.password.edit')->with('success', 'Updated successfully!');
    }

    /**
     * Display form edit header
     */
    public function editHeader()
    {
        $settings = Setting::where('param', 'LIKE', 'header_%')->get();
        return view('setting.header', ['settings' => $settings]);
    }

    /**
     * Process update header
     */
    public function updateHeader(Request $request)
    {
        $fields = [];
        $settings = Setting::where('param', 'LIKE', 'header_%')->get();
        if ($settings !== null) {
            foreach ($settings as $key => $setting) {
                $fields[$setting->param] = 'required';
            }
        }

        $validated = $request->validate($fields, []);

        foreach ($fields as $field => $rule) {
            $setting = Setting::where('param', $field)->first();

            if($field == 'header_image') {
                $picture = $request->file($field);
                $filename = 'logo.' . $picture->getClientOriginalExtension();
                $path = storage_path().('/app/public/img/logo/'.$filename);
                Image::make($picture)->resize(80, 80)->save($path);

                $setting->value = $filename;
            }
            else {
                $setting->value = $request->{$field};
            }
            
            $setting->save();
        }

        return redirect()->route('setting.header.edit')->with('success', 'Updated successfully!');
    }

    /**
     * Display form edit agent
     */
    public function editAgent()
    {
        $settings = Setting::where('param', 'LIKE', 'agent_%')->get();
        return view('setting.agent', ['settings' => $settings]);
    }

    /**
     * Process update agent
     */
    public function updateAgent(Request $request)
    {
        $fields = [];
        $settings = Setting::where('param', 'LIKE', 'agent_%')->get();
        if ($settings !== null) {
            foreach ($settings as $key => $setting) {
                $fields[$setting->param] = 'required';
            }
        }

        $validated = $request->validate($fields, []);

        foreach ($fields as $field => $rule) {
            $setting = Setting::where('param', $field)->first();
            $setting->value = $request->{$field};
            $setting->save();
        }

        return redirect()->route('setting.agent.edit')->with('success', 'Updated successfully!');
    }
}
