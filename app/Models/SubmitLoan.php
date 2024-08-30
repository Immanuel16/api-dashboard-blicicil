<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

use Jenssegers\Mongodb\Eloquent\Model;

class SubmitLoan extends Model
{
	// protected $connection = 'atlas';
    public $timestamps = false;
    protected $primaryKey = '_id';
    protected $table = 'tbl_m_submit_loan';

    protected $fillable = [
        'nama_pemohon',
        'status_pernikahan',
        'nama_ibu_kandung',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kota',
        'kodepos',
        'location_id',
        'status_rumah',
        'pekerjaan',
        'pekerjaan_id',
        'tipe_pekerjaan',
        'tipe_pekerjaan_id',
        'jabatan',
        'penghasilan',
        'nama_perusahaan',
        'alamat_perusahaan',
        'telepon_perusahaan',
        'ktp_pasangan',
        'nama_pasangan',
        'hp_pasangan',
        'nama_darurat',
        'hp_darurat',
        'hubungan',
        'data',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function member() {
        return $this->belongsTo('App\Models\Member', 'member_id');
    }
}