<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class SuratKeputusan extends Model implements FilamentUser
{
    use HasFactory, HasPanelShield, HasRoles;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $guard_name = 'web';

    protected $fillable = [
        'fasilitas_id',
        'nomor_skep',
        'tanggal_skep',
        'jatuh_tempo',
        'perusahaan_id',
        'file_skep',
        'waktu_mulai',
        'waktu_selesai',
        'user_id',
        'keterangan',
    ];

    public function tindakLanjutSkep(): HasMany
    {
        return $this->hasMany(TindakLanjutSkep::class, 'skep_id');
    }

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function fasilitas(): BelongsTo
    {
        return $this->belongsTo(JenisFasilitas::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
