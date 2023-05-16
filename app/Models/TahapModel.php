<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class TahapModel extends Model
{
    use HasFactory;

    protected $table = 'ref_tahap';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_tahap',
    ];

    public function program()
    {
        return $this->belongsToMany(ProgramModel::class, 'program_tahap', 'tahap_id', 'program_id');
    }
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
