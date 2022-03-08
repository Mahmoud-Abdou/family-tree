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
                return secure_asset($this->imagePath . 'os/windows.png');
            case 'Mac OS X':
                return secure_asset($this->imagePath . 'os/os-x.png');
            case 'Linux':
            case 'Ubuntu':
                return secure_asset($this->imagePath . 'os/linux.png');
            case 'Chrome OS':
                return secure_asset($this->imagePath . 'os/chromium-os.png');
            case 'iPhone':
            case 'iPod':
                return secure_asset($this->imagePath . 'os/ios.png');
            case 'Android':
                return secure_asset($this->imagePath . 'os/android.png');
            default:
                return secure_asset($this->imagePath . 'os/default-os.png');
        }
    }

    public function getBrowserImageAttribute()
    {
        switch ($this->browser) {
            case 'Chrome':
                return secure_asset($this->imagePath . 'browser/chrome.png');
            case 'Safari':
                return secure_asset($this->imagePath . 'browser/safari.png');
            case 'Firefox':
                return secure_asset($this->imagePath . 'browser/firefox.png');
            case 'Edg':
                return secure_asset($this->imagePath . 'browser/edge.png');
            default:
                return secure_asset($this->imagePath . 'browser/default.png');
        }
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

}
