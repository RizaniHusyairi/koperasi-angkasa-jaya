<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiniMarketSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_address',
        'company_email',
        'company_phone',
        'company_logo',
    ];

    protected $appends = ['logo_url'];

    public function getLogoUrlAttribute()
    {
        if ($this->company_logo) {
            return asset('storage/' . $this->company_logo);
        }
        return asset('assets/logo/logo_koperasi.png');
    }
}
