<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class TahapProgramModel extends Model
{
    use HasFactory;

    protected $table = 'program_tahap';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'program_id',
        'tahap_id',
        'mulai',
        'selesai',
        'is_actived',
    ];

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
    // public function tahap()
    // {
    //     return $this->hasMany(TahapModel::class, 'id', 'tahap_id');
    // }
    public function tahap()
    {
        return $this->belongsTo(TahapModel::class, 'tahap_id', 'id');
    }
    public function program()
    {
        return $this->belongsTo(ProgramModel::class, 'program_id', 'id');
    }

    
}
