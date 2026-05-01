<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'email',
        'departemen',
        'jabatan',
        'tanggal_masuk',
        'gaji_dasar',
        'no_rekening',
        'nama_bank',
        'npwp',
        'status',
        'alamat',
        'no_hp',
    ];

    protected $casts = [
        'gaji_dasar' => 'decimal:2',
        'tanggal_masuk' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }

    public function getGajiTerbaruAttribute()
    {
        return $this->payrolls()
            ->where('status', 'dibayar')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->first();
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeCari($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('nip', 'like', "%{$search}%")
                ->orWhere('departemen', 'like', "%{$search}%");
        });
    }
}
