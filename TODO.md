# TODO - Rapikan UI/Blade (Gaji-uy)

## ✅ Completed
- [x] Analisis struktur Blade & controller/view terkait

## 🔄 Next Steps
1. Buat folder `resources/views/partials/` untuk komponen reusable (page-header, status-badge, empty-state)
2. Pindahkan CSS inline dari `resources/views/layouts/app.blade.php` ke `resources/css/app.css`
3. Rapikan `resources/views/layouts/app.blade.php` (hapus `<style>`, rapikan struktur, tetap jaga tampilan)
4. Refactor halaman:
   - `resources/views/employees/index.blade.php`
   - `resources/views/employees/create.blade.php`
   - `resources/views/employees/edit.blade.php`
   - `resources/views/employees/show.blade.php`
   - `resources/views/payrolls/index.blade.php`
   - `resources/views/payrolls/create.blade.php`
   - `resources/views/payrolls/slip-gaji.blade.php`
5. Jalankan tes cepat: pastikan halaman admin dashboard, employees, payrolls tampil tanpa error

## Notes
- Target: semua rapi dan **tampilan/fungsi tidak berubah**.

