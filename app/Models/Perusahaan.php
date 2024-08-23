<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class Perusahaan extends Model implements FilamentUser
{
    use HasFactory, HasRoles, HasPanelShield;
    /**
     * The table associated with the model.
     *
     * @var string
     */

     protected $guard_name = "web";

     protected $fillable = [
         'npwp_perusahaan',
         'nama_perusahaan'
     ];

    public function suratKeputusan(): HasMany
    {
        return $this->hasMany(SuratKeputusan::class);
    }
}
