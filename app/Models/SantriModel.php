<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class SantriModel extends Model
{
    use HasFactory;

    protected $table = 'santri';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'nama_wali',
        'no_hp_wali',
    ];

    // public function program()
    // {
    //     return $this->belongsToMany(ProgramModel::class, 'program_tahap', 'tahap_id', 'program_id');
    // }
    // public function kategori()
    // {
    //     return $this->belongsToMany(KategoriModel::class, 'contents_categories', 'content_id', 'category_id');
    // }
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
    // public function blog()
    // {
    //     return $this->belongsTo(BlogModel::class, 'blog_id');
    // }
    // public function komentar()
    // {
    //     return $this->hasMany(KomentarModel::class, 'content_id');
    // }

    
}
