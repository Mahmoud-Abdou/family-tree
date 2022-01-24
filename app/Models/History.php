<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// User History
class History extends Model
{
    protected $table = "histories";

    protected $fillable = [
        'user_id',
        'last_login',
        'ip',
        'os',
        'browser',
    ];

    protected $appends = ['os_image', 'browser_image'];

    private $imagePath = '/assets/images/';

    public function getOsImageAttribute()
    {
        switch ($this->os) {
            case 'Windows 8.1':
            case 'Windows 8':
            case 'Windows 7':
            case 'Windows 10':
                return asset($this->imagePath . '/os/windows.png');
            case 'Mac OS X':
                return asset($this->imagePath . '/os/os-x.png');
            case 'Linux':
            case 'Ubuntu':
                return asset($this->imagePath . '/os/linux.png');
            case 'Chrome OS':
                return asset($this->imagePath . '/os/chromium-os.png');
            case 'iPhone':
            case 'iPod':
                return asset($this->imagePath . '/os/ios.png');
            case 'Android':
                return asset($this->imagePath . '/os/android.png');
            default:
                return asset($this->imagePath . '/os/default-os.png');
        }
    }

    public function getBrowserImageAttribute()
    {
        switch ($this->browser) {
            case 'Chrome':
                return asset($this->imagePath . '/os/chrome.png');
            case 'Safari':
                return asset($this->imagePath . '/os/safari.png');
            case 'Firefox':
                return asset($this->imagePath . '/os/firefox.png');
            case 'Edg':
                return asset($this->imagePath . '/os/edge.png');
            default:
                return asset($this->imagePath . '/os/default.png');
        }
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

}
