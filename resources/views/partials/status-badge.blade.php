@php
    $label = match($status) {
        'aktif' => 'Aktif',
        'tidak_aktif' => 'Tidak Aktif',
        'pending' => 'Pending',
        'dibayar' => 'Lunas',
        default => ucfirst((string) $status),
    };
@endphp

<span class="badge-status {{ $status }}">{{ $label }}</span>

