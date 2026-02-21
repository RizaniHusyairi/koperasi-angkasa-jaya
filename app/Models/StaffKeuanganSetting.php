<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffKeuanganSetting extends Model
{
    protected $fillable = [
        'company_name',
        'company_address',
        'company_email',
        'company_phone',
        'bank_name',
        'bank_account',
        'company_logo',
    ];
}
