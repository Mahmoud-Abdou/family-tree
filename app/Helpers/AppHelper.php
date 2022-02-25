<?php

namespace App\Helpers;

use App\Models\Activity;
use App\Models\History;
use Carbon\Carbon;

class AppHelper {

    static function generateRandomString($length = 8)
    {
        $characters = '0123456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    static function generateOtpCode($length = 6)
    {
        $code = "0123456789";
        $final_code = '';
        for ($i = 0; $i < $length; $i++) {
            $final_code .= $code[rand(0, strlen($code) - 1)];
        }
        return $final_code;
    }

    function generateToken()
    {
        return $this::generateRandomString(60);
    }

    static function GeneralSettings($var)
    {
        $Setting = cache('setting');
        return $Setting->$var;
//        $Setting = \App\Models\Setting::first();
//        return $Setting->$var;
    }

    static function AddUserHistory()
    {
        $log = [];
        $log['user_id'] = auth()->check() ? auth()->id() : null;
        $log['last_login'] = now();
        $log['ip'] = request()->ip();
        $log['os'] = AppHelper::getOS();
        $log['browser'] = AppHelper::getBrowser();
        History::create($log);
    }

    static function AddLog($subject, $action = null, $action_id = null)
    {
//        $baseClass = class_basename($model);
        $log = [];
        $log['subject'] = $subject;
        $log['user_id'] = auth()->check() ? auth()->id() : null;
        $log['action'] = $action;
        $log['action_id'] = $action_id;
        $log['uri'] = request()->path(); //request()->fullUrl();
        $log['method'] = request()->method();
        $log['ip_address'] = request()->ip();
        $log['agent'] = request()->header('user-agent');
        Activity::create($log);
    }

    // Menu array List
    static function MenuList($GroupId)
    {
        return Menu::where('father_id', $GroupId)->where('status', 1)->orderby('row_no', 'asc')->get();
    }

    // detect browser
    static function getBrowser()
    {
        // check if IE 8 - 11+
        preg_match('/Trident\/(.*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
        if ($matches) {
            $version = intval($matches[1]) + 4;     // Trident 4 for IE8, 5 for IE9, etc
            return 'Internet Explorer ' . ($version < 11 ? $version : $version);
        }
        preg_match('/MSIE (.*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
        if ($matches) {
            return 'Internet Explorer ' . intval($matches[1]);
        }

        // check if Firefox, Opera, Chrome, Safari
        foreach (array('Firefox', 'OPR', 'Edg', 'Chrome', 'Safari') as $browser) {
            preg_match('/' . $browser . '/', $_SERVER['HTTP_USER_AGENT'], $matches);
            if ($matches) {
                return str_replace('OPR', 'Opera', $browser);   // we don't care about the version, because this is a modern browser that updates itself unlike IE
            }
        }
        return 'unknown';
    }

    // detect OS
    static function getOS()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform = "unknown";
        $os_array = array(
            '/windows nt 11/i' => 'Windows 11',
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/macintosh|intel mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile',
            '/mozilla/i' => 'FireFox',
            '/chrome/i' => 'Chrome OS',
//            '/chrome os/i' => 'Chrome OS',
        );

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
                break;
            }

        }

        return $os_platform;
    }

    // Videos Check Functions
    static function GetYoutubeVideo($url)
    {
        if (preg_match('/youtu\.be/i', $url) || preg_match('/youtube\.com\/watch/i', $url)) {
            $pattern = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
            preg_match($pattern, $url, $matches);
            if (count($matches) && strlen($matches[7]) == 11) {
                return $matches[7];
            }
        }

        return '';
    }

    // Social Share links
    static function SocialShare($social, $title)
    {
        $shareLink = "";
        $URL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        switch ($social) {
            case "facebook":
                $shareLink = "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($URL);
                break;
            case "twitter":
                $shareLink = "https://twitter.com/intent/tweet?text=$title&url=" . urlencode($URL);
                break;
            case "google":
                $shareLink = "https://plus.google.com/share?url=" . urlencode($URL);
                break;
            case "linkedin":
                $shareLink = "http://www.linkedin.com/shareArticle?mini=true&url=" . urlencode($URL) . "&title=$title";
                break;
            case "tumblr":
                $shareLink = "http://www.tumblr.com/share/link?url=" . urlencode($URL);
                break;
        }

        return $shareLink;
    }

    static function dateForDB($date = "", $withTime = 0)
    {
        if ($date != "") {
            try {
                $format = env("DATE_FORMAT", "Y-m-d");
                if ($withTime) {
                    return \Illuminate\Support\Carbon::createFromFormat($format . " h:i A", $date)->format('Y-m-d H:i:s');
                } else {
                    return Carbon::createFromFormat($format, $date)->format('Y-m-d');
                }
            } catch (\Exception $e) {
                return null;
            }
        }
        return "";
    }

    static function formatDate($date = "")
    {
        if ($date != "") {
            $format = env("DATE_FORMAT", "Y-m-d");
            return date($format, strtotime($date));
        }
        return "";
    }

    static function jsDateFormat()
    {
        $format = env("DATE_FORMAT", "Y-m-d");
        $format = str_replace("Y", "YYYY", $format);
        $format = str_replace("m", "MM", $format);
        $format = str_replace("d", "DD", $format);
        return $format;
    }

    static function theme_asset($path)
    {
//        return secure_asset('assets/theme/' . Setting::first()->style_theme . '/' . $path);
        return secure_asset('assets/theme/' . cache('setting')->style_theme . '/' . $path);
    }

    static function convertLocalToUTC($time)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $time, 'Europe/Paris')->setTimezone('UTC');
    }

    static function convertUTCToLocal($time)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $time, 'UTC')->setTimezone('Europe/Paris');
    }

}
