<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class TindakLanjutSkep extends Model implements FilamentUser
{
    use HasFactory, HasPanelShield, HasRoles;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $guard_name = 'web';

    protected $fillable = [
        'skep_id',
        'tindak_lanjut_id',
        'nomor_surat_tindak_lanjut',
        'tanggal_surat_tindak_lanjut',
        'tanggal_jatuh_tempo',
        'nilai_tindak_lanjut_rupiah',
        'file_tindak_lanjut',
        'user_id',
        'keterangan',
    ];

    public function skep(): BelongsTo
    {
        return $this->belongsTo(SuratKeputusan::class);
    }

    public function tindakLanjut(): BelongsTo
    {
        return $this->belongsTo(JenisTindakLanjut::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
