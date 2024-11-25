<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        
    }
    private function setValidationRule() {
        
        Validator::extend('handle_xss', function ($attribute, $value, $parameters, $validator) {

            $value = html_entity_decode($value);

            $value = str_replace("&#60", "&lt;", $value);
            $value = str_replace("&#62", "&gt;", $value);
            $value = str_replace("&#38", "&amp;", $value);
            $value = str_replace("&#160", "&nbsp;", $value);
            $value = str_replace("&#162", "&cent;", $value);
            $value = str_replace("&#163", "&pound;", $value);
            $value = str_replace("&#165", "&yen;", $value);
            $value = str_replace("&#8364", "&euro;", $value);
            $value = str_replace("&#169", "&copy;", $value);
            $value = str_replace("&#174", "&reg;", $value);

            if (preg_match('/((\%3C)|<)((\%2F)|\/)*[a-z0-9\%]+((\%3E)|>)/ix', $value)) {
                return false;
            } else if (preg_match('/<img|script[^>]+src/i', $value)) {
                return false;
            } else if (preg_match('/((\%3C)|<)(|\s|\S)+((\%3E)|>)/i', $value)) {
                return false;
            } else if (strstr($value, '<') != '' || strstr($value, '>') != '' || strstr($value, '&#60') != '' || strstr($value, '&#62') != '' || strstr($value, '&#x3C') != '' || strstr($value, '&#x3E') != '') {
                return false;
            } else {
                return true;
            }

        });

        Validator::replacer('handle_xss', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':field', '', $message);
        });

        Validator::extend('valid_input', function ($attribute, $value, $parameters, $validator) {
            $regex = '/^[\x20-\x7E\n]+$/';
            if (!preg_match($regex, $value)) {
                return false;
            } else {
                return true;
            }
        });

        Validator::replacer('valid_input', function ($message, $attribute, $rule, $parameters) {
            return 'Please enter valid input.';
        });

        Validator::extend('no_url', function ($attribute, $value, $parameters, $validator) {
            $str = $value;
            preg_match_all('/\b(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$]/i', $str, $result, PREG_PATTERN_ORDER);
            
            if (isset($result[0][0]) && count($result[0]) > 0) 
            {
                return false;
            } else {
                return true;
            }
        });
        
        Validator::replacer('no_url', function ($message, $attribute, $rule, $parameters) {
            return 'URL is not allowed.';
        });

        Validator::extend('bad_words', function ($attribute, $value, $parameters, $validator) {
            $badWords = array("nude","naked","sex","porn","porno","sperm");
            $str = $value;
            $result = array();
            preg_match("/\b(" . implode($badWords,"|") . ")\b/i", $str, $result);
            
            if (isset($result[0]) && count($result[0]) > 0) 
            {
                return false;
            } else {
                return true;
            }
        });
        
        Validator::replacer('bad_words', function ($message, $attribute, $rule, $parameters) {
            return 'Please remove bad word/inappropriate language.';
        });

        return true;
    }
}
