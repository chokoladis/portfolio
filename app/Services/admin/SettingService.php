<?php

namespace App\Services\admin\Setting;

use Illuminate\Support\Facades\Cache;
class SettingService {

    public function unsetAllCache()
    {
        Cache::flush();
    }
}
