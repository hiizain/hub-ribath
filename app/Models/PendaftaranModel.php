<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PendaftaranModel extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'program_id',
        'santri_id',
        'is_setuju',
    ];

    public function santri()
    {
        return $this->belongsTo(SantriModel::class, 'santri_id', 'id');
    }
    public function program()
    {
        return $this->belongsTo(ProgramModel::class, 'program_id', 'id');
    }

    
}
