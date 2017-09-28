<?php
namespace lexsurkov\helper\helpers;

use Yii;
use yii\web\IdentityInterface;

class Shortcut {

    public static function APP(){
        return Yii::$app;
    }

    public static function USER(){
        return self::APP()->user;
    }

    /**
     * @return null|IdentityInterface
     */
    public static function IDENTITY(){
        return self::USER()->identity;
    }

    public static function REQUEST(){
        return self::APP()->request;
    }

    public static function DB(){
        return self::APP()->db;
    }

    public static function RESPONSE(){
        return self::APP()->response;
    }

    public static function GET($value = null, $default = null){
        if (empty($value))
            return self::REQUEST()->get();
        else
            return self::REQUEST()->get($value, $default);
    }

    public static function POST($value = null, $default = null){
        if (empty($value))
            return self::REQUEST()->post();
        else
            return self::REQUEST()->post($value, $default);
    }

    public static function PARAMS($param){
        return isset(self::APP()->params[$param]) ? self::APP()->params[$param] : null;
    }

    public static function URL($route = [], $absolute = false){
        return !$absolute ? self::APP()->urlManager->createUrl($route) : self::APP()->urlManager->createAbsoluteUrl($route);
    }

    public static function SITE(){
        if (defined("WEB_URL"))
            return WEB_URL;
        else
            return self::REQUEST()->hostInfo;
    }

    public static function HOST(){
        return preg_replace('#^https?://#', "", self::SITE());
    }
}