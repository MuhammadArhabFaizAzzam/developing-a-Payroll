<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'bulan',
        'tahun',
        'gaji_dasar',
        'tunjangan_transport',
        'tunjangan_makanan',
        'tunjangan_kesehatan',
        'tunjangan_tahun',
        'total_tunjangan',
        'potongan_bpjs',
        'potongan_pph',
        'potongan_alpha',
        'potongan_lain',
        'total_potongan',
        'gaji_bersih',
        'status',
        'tanggal_bayar',
        'taken_at',
        'keterangan',
    ];

    protected $casts = [
        'gaji_dasar' => 'decimal:2',
        'tunjangan_transport' => 'decimal:2',
        'tunjangan_makanan' => 'decimal:2',
        'tunjangan_kesehatan' => 'decimal:2',
        'tunjangan_tahun' => 'decimal:2',
        'total_tunjangan' => 'decimal:2',
        'potongan_bpjs' => 'decimal:2',
        'potongan_pph' => 'decimal:2',
        'potongan_alpha' => 'decimal:2',
        'potongan_lain' => 'decimal:2',
        'total_potongan' => 'decimal:2',
        'gaji_bersih' => 'decimal:2',
        'tanggal_bayar' => 'date',
        'taken_at' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function scopeBulanIni($query)
    {
        $bulan = date('n');
        $tahun = date('Y');

        return $query->where('bulan', $bulan)->where('tahun', $tahun);
    }

    public function scopeLunas($query)
    {
        return $query->where('status', 'dibayar');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public static function hitungGaji($employee, $bulan, $tahun)
    {
        $gajiDasar = $employee->gaji_dasar;

        // Tunjangan
        $tunjanganTransport = 500000;
        $tunjanganMakanan = 300000;
        $tunjanganKesehatan = 200000;
        $tunjanganTahun = $gajiDasar * 0.05; // 5% tunjangan tahunan

        $totalTunjangan = $tunjanganTransport + $tunjanganMakanan + $tunjanganKesehatan + $tunjanganTahun;

        // Potongan
        $potonganBpjs = $gajiDasar * 0.02; // 2% BPJS
        $potonganPph = ($gajiDasar + $totalTunjangan) * 0.05; // 5% PPH
        $potonganAlpha = 0;
        $potonganLain = 0;

        $totalPotongan = $potonganBpjs + $potonganPph + $potonganAlpha + $potonganLain;

        // Gaji Bersih
        $gajiBersih = ($gajiDasar + $totalTunjangan) - $totalPotongan;

        return [
            'gaji_dasar' => $gajiDasar,
            'tunjangan_transport' => $tunjanganTransport,
            'tunjangan_makanan' => $tunjanganMakanan,
            'tunjangan_kesehatan' => $tunjanganKesehatan,
            'tunjangan_tahun' => $tunjanganTahun,
            'total_tunjangan' => $totalTunjangan,
            'potongan_bpjs' => $potonganBpjs,
            'potongan_pph' => $potonganPph,
            'potongan_alpha' => $potonganAlpha,
            'potongan_lain' => $potonganLain,
            'total_potongan' => $totalPotongan,
            'gaji_bersih' => $gajiBersih,
        ];
    }

    public function getNamaBulanAttribute()
    {
        $bulanNama = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return $bulanNama[$this->bulan].' '.$this->tahun;
    }
}
