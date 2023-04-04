<?php

namespace App\Rules;

use Closure;
use App\Models\Setting;
use App\Models\PasswordHistory;
use Illuminate\Contracts\Validation\ValidationRule;

class Password implements ValidationRule
{
    protected $email = '';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($email = '')
    {
        $this->email = $email;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $settings = Setting::where('param', 'LIKE', 'password_%')->get();
        if ($settings !== null) {
            $error = false;
            foreach ($settings as $key => $setting) {
                if ($setting->param == 'password_number' && $setting->value == 'yes' && preg_match('/[0-9]/', $value) === 0) {
                    $fail('The :attribute should contain at least 1 number');
                    $error = true;
                }
                if ($setting->param == 'password_character' && $setting->value == 'yes' && preg_match('/[a-zA-Z]/', $value) === 0) {
                    $fail('The :attribute should contain at least 1 character');
                    $error = true;
                }
                if ($setting->param == 'password_uppercase' && $setting->value == 'yes' && preg_match('/[A-Z]/', $value) === 0) {
                    $fail('The :attribute should contain at least 1 uppercase character');
                    $error = true;
                }
                if ($setting->param == 'password_specialcharacter' && $setting->value == 'yes' && preg_match('/[^a-zA-Z\d]/', $value) === 0) {
                    $fail('The :attribute should contain at least 1 special character');
                    $error = true;
                }
                if ($setting->param == 'password_min' && (strlen($value) < $setting->value)) {
                    $fail('The :attribute must be at least '.$setting->value.' characters');
                    $error = true;
                }
                if ($setting->param == 'password_max' && (strlen($value) > $setting->value)) {
                    $fail('The :attribute may not be greater than '.$setting->value.' characters');
                    $error = true;
                }
            }

            if($error === false) {
                
                if (PasswordHistory::isExist($value, $this->email) === true) {
                    $fail('Please insert different password');
                }
    
                $result = PasswordHistory::coldDown($this->email);
                if ($result !== false) {
                    $fail('Password cold down period applied. You can try again after '.$result);
                }
            }
        }
    }
}
