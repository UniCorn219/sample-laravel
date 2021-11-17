<?php

namespace App\Helpers;

use Auth;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;

/**
 * Class Common.
 *
 * @package App\Helpers
 */
class Common
{
    public static function randomString($type = 'alnum', $len = 8)
    {
        switch ($type)
        {
            case 'basic':
                return mt_rand();
            case 'alnum':
            case 'numeric':
            case 'nozero':
            case 'alpha':
                switch ($type)
                {
                    case 'alpha':
                        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'alnum':
                        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'numeric':
                        $pool = '0123456789';
                        break;
                    case 'nozero':
                        $pool = '123456789';
                        break;
                }
                return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
            case 'unique': // todo: remove in 3.1+
            case 'md5':
                return md5(uniqid(mt_rand()));
            case 'encrypt': // todo: remove in 3.1+
            case 'sha1':
                return sha1(uniqid(mt_rand(), TRUE));
        }
    }

    public static function currentUser()
    {
        return Auth::guard('api')->user();
    }

    /**
     * @return bool|int|null
     */
    public static function isIosDevice()
    {
        $agent = new Agent();

        return $agent->is('iOS');
    }

    public static function replaceHideString($string, $lengthStartHide = 2)
    {
        if (strlen($string) == 3) {
            return self::mb_substr_replace($string, "*", 1, 1);
        }

        $lengthString = strlen($string);
        $lengthReplaceStart = (int) $lengthStartHide;
        $lengthReplace = ($lengthString - $lengthStartHide);

        if ($lengthReplace > 10) {
            $lengthReplace = 10;
        }

        return self::mb_substr_replace($string, str_repeat("*", $lengthReplace), $lengthReplaceStart, $lengthString);
    }

    public static function mb_substr_replace($original, $replacement, $position, $length)
    {
        $startString = mb_substr($original, 0, $position, "UTF-8");
        $endString = mb_substr($original, $position + $length, mb_strlen($original), "UTF-8");

        $out = $startString . $replacement . $endString;

        return $out;
    }

    public static function replaceHideUserName($string)
    {
        if (strlen($string) <= 10) {
            return self::mb_substr_replace($string, "*", 1, 1);
        }

        return self::replaceHideString($string, 1);
    }

    public static function generateThreadKey(array $params, int|null $productId): string
    {
        sort($params);

        if ($productId) {
            array_push($params, $productId);
        }

        return join("_", $params);
    }

    public static function convertTimeKoreaToUtc($dateTimeKorea): ?string
    {
        if (empty($dateTimeKorea)) {
            return null;
        }

        $date = Carbon::createFromFormat('Y-m-d H:i:s', $dateTimeKorea, 'Asia/Seoul');
        $date->setTimezone('UTC');
        return $date->format('Y-m-d H:i:s');
    }
}
