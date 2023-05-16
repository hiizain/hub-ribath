<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ProgramModel extends Model
{
    use HasFactory;

    protected $table = 'program';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_program',
        'deskripsi',
        'tahun',
    ];

    public function tahap()
    {
        return $this->belongsToMany(TahapModel::class, 'program_tahap', 'program_id', 'tahap_id');
    }
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
