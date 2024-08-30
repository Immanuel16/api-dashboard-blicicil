<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Member extends Model
{
	// protected $connection = 'atlas';
    public $timestamps = false;
    protected $primaryKey = '_id';
    protected $table = 'tbl_m_member';

    protected $fillable = [
        'name',
        'email',
        'mobile_phone',
        'password',
        'fcm_token',
        'api_token',
        'verify_otp',
        'forgot_otp',
        'limit',
        'limit_used',
        'is_login',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by',
    ];
}