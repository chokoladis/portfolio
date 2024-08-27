
<?php

namespace App\Services;

// use App\Models\User;
// use Exception;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Str;

class CleanerService
{
    const TEMP_DIRS = [
        '/storage/works/temp/',
        '/storage/workers/temp/'
    ];

    public static function cleanDir(string $path, bool $remove = false) {

    }

    static function cleanTempDirs(bool $remove = false) {
        
    }
}
