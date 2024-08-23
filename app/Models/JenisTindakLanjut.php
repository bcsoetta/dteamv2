<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class JenisTindakLanjut extends Model implements FilamentUser
{
    use HasFactory, HasPanelShield, HasRoles;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $guard_name = 'web';

    protected $fillable = [
        'nama_tindak_lanjut',
    ];

    public function tindakLanjut(): HasMany
    {
        return $this->hasMany(TindakLanjutSkep::class);
    }
}
