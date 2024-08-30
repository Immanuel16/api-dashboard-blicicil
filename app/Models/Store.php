<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;


class Store extends Model
{
    public $timestamps = false;
    protected $primaryKey = '_id';
    protected $table = 'tbl_m_store';

    protected $fillable = [
        'store_id',
        'latitude',
        'longitude',
        'telepon',
        'merchant_id',
        'city_id',
        'created_by',
        'created_at',
        'created_by',
        'store_name',
        'address',
    ];
    // use HasFactory;
}
