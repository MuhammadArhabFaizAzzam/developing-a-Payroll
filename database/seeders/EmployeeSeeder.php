<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            [
                'nip' => 'EMP001',
                'nama' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@example.com',
                'departemen' => 'Keuangan',
                'jabatan' => 'Staff Keuangan',
                'tanggal_masuk' => '2023-01-15',
                'gaji_dasar' => 5000000,
                'no_rekening' => '1234567890',
                'nama_bank' => 'Bank BRI',
                'npwp' => '12.345.678.9-123.456',
                'status' => 'aktif',
                'alamat' => 'Jakarta Selatan',
                'no_hp' => '081234567890',
            ],
            [
                'nip' => 'EMP002',
                'nama' => 'Siti Rahayu',
                'email' => 'siti.rahayu@example.com',
                'departemen' => 'HRD',
                'jabatan' => 'HR Manager',
                'tanggal_masuk' => '2022-06-01',
                'gaji_dasar' => 7500000,
                'no_rekening' => '2345678901',
                'nama_bank' => 'Bank Mandiri',
                'npwp' => '23.456.789.1-234.567',
                'status' => 'aktif',
                'alamat' => 'Jakarta Barat',
                'no_hp' => '081234567891',
            ],
            [
                'nip' => 'EMP003',
                'nama' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'departemen' => 'IT',
                'jabatan' => 'Programmer',
                'tanggal_masuk' => '2023-03-20',
                'gaji_dasar' => 6000000,
                'no_rekening' => '3456789012',
                'nama_bank' => 'Bank BCA',
                'npwp' => '34.567.890.1-345.678',
                'status' => 'aktif',
                'alamat' => 'Jakarta Timur',
                'no_hp' => '081234567892',
            ],
            [
                'nip' => 'EMP004',
                'nama' => 'Dewi Lestari',
                'email' => 'dewi.lestari@example.com',
                'departemen' => 'Marketing',
                'jabatan' => 'Marketing Staff',
                'tanggal_masuk' => '2023-08-10',
                'gaji_dasar' => 4500000,
                'no_rekening' => '4567890123',
                'nama_bank' => 'Bank BNI',
                'npwp' => '45.678.901.2-456.789',
                'status' => 'aktif',
                'alamat' => 'Jakarta Utara',
                'no_hp' => '081234567893',
            ],
            [
                'nip' => 'EMP005',
                'nama' => 'Rudi Hermawan',
                'email' => 'rudi.hermawan@example.com',
                'departemen' => 'Operasional',
                'jabatan' => 'Supervisor',
                'tanggal_masuk' => '2022-01-05',
                'gaji_dasar' => 6500000,
                'no_rekening' => '5678901234',
                'nama_bank' => 'Bank BTN',
                'npwp' => '56.789.012.3-567.890',
                'status' => 'aktif',
                'alamat' => 'Depok',
                'no_hp' => '081234567894',
            ],
            [
                'nip' => 'EMP006',
                'nama' => 'Wati Opti',
                'email' => 'wati.oks@example.com',
                'departemen' => 'Produksi',
                'jabatan' => 'Operator',
                'tanggal_masuk' => '2023-11-01',
                'gaji_dasar' => 3500000,
                'no_rekening' => '6789012345',
                'nama_bank' => 'Bank BRI',
                'npwp' => '67.890.123.4-678.901',
                'status' => 'aktif',
                'alamat' => 'Bekasi',
                'no_hp' => '081234567895',
            ],
            [
                'nip' => 'EMP007',
                'nama' => 'Joko Pramono',
                'email' => 'joko.pramono@example.com',
                'departemen' => 'IT',
                'jabatan' => 'System Admin',
                'tanggal_masuk' => '2022-09-15',
                'gaji_dasar' => 7000000,
                'no_rekening' => '7890123456',
                'nama_bank' => 'Bank Mandiri',
                'npwp' => '78.901.234.5-789.012',
                'status' => 'aktif',
                'alamat' => 'Tangerang',
                'no_hp' => '081234567896',
            ],
            [
                'nip' => 'EMP008',
                'nama' => 'Lisa Permata',
                'email' => 'lisa.permata@example.com',
                'departemen' => 'Keuangan',
                'jabatan' => 'Akuntan',
                'tanggal_masuk' => '2023-05-20',
                'gaji_dasar' => 5500000,
                'no_rekening' => '8901234567',
                'nama_bank' => 'Bank BCA',
                'npwp' => '89.012.345.6-890.123',
                'status' => 'aktif',
                'alamat' => 'Serang',
                'no_hp' => '081234567897',
            ],
        ];

        foreach ($employees as $employee) {
            Employee::updateOrCreate(
                ['nip' => $employee['nip']],
                $employee,
            );
        }
    }
}
