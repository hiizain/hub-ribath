<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class SafariModel extends Model
{
    use HasFactory;

    protected $table = 'safari_maulid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'paket_media_id',
        'majlis_id',
        'no_hp',
        'tanggal',
        'lokasi',
        'detail_lokasi',
        'is_accepted',
    ];

    public function paket()
    {
        return $this->belongsTo(PaketMediaModel::class, 'paket_media_id', 'id');
    }
}
