<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Cache;

//MODELS
use App\Models\GeneralSetting;

class SettingHelper {

    public static function removeGeneral() {
        Cache::forget('GeneralSetting');
    }

    public static function getIcon() {
        $general_setting = Cache::rememberForever('GeneralSetting', function() {
          return GeneralSetting::find(1)->toArray();
        });
        return $general_setting['icon_name'];
    }

    public static function getAppName() {
        $general_setting = Cache::rememberForever('GeneralSetting', function() {
          return GeneralSetting::find(1)->toArray();
        });
        return $general_setting['app_name'];
    }

    public static function getSkin() {
        $general_setting = Cache::rememberForever('GeneralSetting', function() {
          return GeneralSetting::find(1)->toArray();
        });
        return $general_setting['skin'];
    }

    public static function getOwner() {
        $general_setting = Cache::rememberForever('GeneralSetting', function() {
          return GeneralSetting::find(1)->toArray();
        });
        return $general_setting['owner'];
    }

    public static function getVersion() {
        $general_setting = Cache::rememberForever('GeneralSetting', function() {
          return GeneralSetting::find(1)->toArray();
        });
        return $general_setting['version'];
    }

    public static function getPerPage() {
        $general_setting = Cache::rememberForever('GeneralSetting', function() {
          return GeneralSetting::find(1)->toArray();
        });
        return $general_setting['per_page'];
    }

    public static function getPerPageApi() {
        $general_setting = Cache::rememberForever('GeneralSetting', function() {
          return GeneralSetting::find(1)->toArray();
        });
        return $general_setting['per_page_api'];
    }

    public static function getDatetimeFormat() {
        $general_setting = Cache::rememberForever('GeneralSetting', function() {
          return GeneralSetting::find(1)->toArray();
        });
        return $general_setting['datetime_format'];
    }

}
