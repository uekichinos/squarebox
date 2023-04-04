<?php

namespace App\Models;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PasswordHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'password_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['userid', 'password'];

    /**
     * Get password history limit/value.
     */
    public static function getLimit()
    {
        $return = 0;
        $settings = Setting::where('param', 'LIKE', 'password_history')->get();
        if ($settings !== null) {
            foreach ($settings as $key => $setting) {
                $return = $setting->value;
            }
        }

        return $return;
    }

    /**
     * Insert new password.
     */
    public static function capturePassword($password)
    {
        $limit = self::getLimit();
        if ($limit > 0) {
            $id = Auth::user()->id;
            $history = new PasswordHistory();
            $history->userid = $id;
            $history->password = Crypt::encryptString($password);
            $history->save();
        }
    }

    /**
     * Check if password already available in password history.
     */
    public static function isExist($password, $email = '')
    {
        $limit = self::getLimit();
        if ($limit > 0) {

            if($email != '') {
                $id = User::where('email', $email)->first()->id;
            }
            else {
                $id = Auth::user()->id;
            }
            
            $histories = PasswordHistory::where('userid', $id)->orderBy('id', 'desc')->limit($limit)->get();
            if ($histories !== null) {
                foreach ($histories as $key => $history) {
                    $history_password = Crypt::decryptString($history->password);
                    if ($history_password == $password) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Check when the last time user update password.
     */
    public static function coldDown($email = '')
    {
        $period = 0;
        $settings = Setting::where('param', 'LIKE', 'password_colddown')->get();
        if ($settings !== null) {
            foreach ($settings as $key => $setting) {
                $period = $setting->value;
            }
        }

        if ($period != 0) {

            if($email != '') {
                $id = User::where('email', $email)->first()->id;
            }
            else {
                $id = Auth::user()->id;
            }
            
            $histories = PasswordHistory::where('userid', $id)->orderBy('id', 'desc')->limit(1)->get();
            if ($histories !== null) {
                foreach ($histories as $key => $history) {
                    $targetdate = date('Y-m-d H:i:s', strtotime($history->created_at.' + '.$period.' hours'));
                    if ($targetdate > date('Y-m-d H:i:s')) {
                        return date('d M Y, h:ia', strtotime($targetdate));
                    }
                }
            }
        }

        return false;
    }
}
