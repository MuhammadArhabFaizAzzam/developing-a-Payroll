import { Head, Link, usePage } from '@inertiajs/react';
import {
    Banknote,
    BarChart3,
    CheckCircle2,
    FileText,
    ShieldCheck,
    Users,
} from 'lucide-react';

import { dashboard, login, register } from '@/routes';

export default function Welcome() {
    const { auth } = usePage().props;

    return (
        <>
            <Head title="Payroll Website" />

            <main className="min-h-screen bg-slate-50 text-slate-950">
                <section className="border-b border-slate-200 bg-white">
                    <div className="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                        <div className="flex items-center gap-3">
                            <div className="flex h-10 w-10 items-center justify-center rounded-md bg-emerald-600 text-white">
                                <Banknote className="h-5 w-5" />
                            </div>
                            <div>
                                <p className="text-base font-semibold">
                                    Payroll Website
                                </p>
                                <p className="text-xs text-slate-500">
                                    Laravel MVC Assignment
                                </p>
                            </div>
                        </div>

                        <nav className="flex items-center gap-3">
                            {auth.user ? (
                                <Link
                                    href={dashboard()}
                                    className="rounded-md bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={login()}
                                        className="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100"
                                    >
                                        Login
                                    </Link>
                                    <Link
                                        href={register()}
                                        className="rounded-md bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700"
                                    >
                                        Register
                                    </Link>
                                </>
                            )}
                        </nav>
                    </div>
                </section>

                <section className="mx-auto grid min-h-[calc(100vh-73px)] max-w-7xl items-center gap-10 px-6 py-12 lg:grid-cols-[1.05fr_0.95fr]">
                    <div>
                        <p className="mb-4 inline-flex items-center gap-2 rounded-md border border-emerald-200 bg-emerald-50 px-3 py-1 text-sm font-medium text-emerald-800">
                            <CheckCircle2 className="h-4 w-4" />
                            Employee payroll management system
                        </p>

                        <h1 className="max-w-3xl text-4xl leading-tight font-semibold tracking-normal text-slate-950 md:text-6xl">
                            Sistem Penggajian Karyawan Berbasis Laravel
                        </h1>

                        <p className="mt-5 max-w-2xl text-base leading-7 text-slate-600 md:text-lg">
                            Website full stack untuk mengelola data karyawan,
                            menghitung gaji bulanan, memproses status
                            pembayaran, dan membuat slip gaji melalui struktur
                            MVC Laravel.
                        </p>

                        <div className="mt-8 flex flex-col gap-3 sm:flex-row">
                            {auth.user && (
                                <Link
                                    href={dashboard()}
                                    className="inline-flex items-center justify-center rounded-md bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700"
                                >
                                    Masuk Dashboard
                                </Link>
                            )}
                            <a
                                href="#features"
                                className="inline-flex items-center justify-center rounded-md bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700"
                            >
                                Lihat Fitur
                            </a>
                        </div>

                        <div className="mt-8 grid max-w-2xl grid-cols-3 gap-4">
                            <div>
                                <p className="text-2xl font-semibold">CRUD</p>
                                <p className="text-sm text-slate-500">
                                    Karyawan
                                </p>
                            </div>
                            <div>
                                <p className="text-2xl font-semibold">MVC</p>
                                <p className="text-sm text-slate-500">
                                    Laravel
                                </p>
                            </div>
                            <div>
                                <p className="text-2xl font-semibold">PDF</p>
                                <p className="text-sm text-slate-500">
                                    Slip gaji
                                </p>
                            </div>
                        </div>
                    </div>

                    <div className="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                        <div className="mb-5 flex items-center justify-between border-b border-slate-200 pb-4">
                            <div>
                                <p className="text-sm text-slate-500">
                                    Ringkasan Bulan Ini
                                </p>
                                <p className="text-xl font-semibold">
                                    Payroll Dashboard
                                </p>
                            </div>
                            <BarChart3 className="h-6 w-6 text-emerald-600" />
                        </div>

                        <div className="grid gap-3 sm:grid-cols-2">
                            <SummaryItem
                                icon={Users}
                                label="Data karyawan"
                                value="Aktif dan tidak aktif"
                            />
                            <SummaryItem
                                icon={Banknote}
                                label="Penggajian"
                                value="Pending dan dibayar"
                            />
                            <SummaryItem
                                icon={FileText}
                                label="Slip gaji"
                                value="Siap cetak"
                            />
                            <SummaryItem
                                icon={ShieldCheck}
                                label="Keamanan"
                                value="Akses internal"
                            />
                        </div>

                        <div
                            id="features"
                            className="mt-6 rounded-md bg-slate-100 p-4"
                        >
                            <p className="mb-3 text-sm font-semibold text-slate-700">
                                Modul yang tersedia
                            </p>
                            <ul className="space-y-2 text-sm text-slate-600">
                                <li>
                                    Manajemen data karyawan dan status kerja
                                </li>
                                <li>
                                    Perhitungan gaji dasar, tunjangan, dan
                                    potongan
                                </li>
                                <li>
                                    Proses pelunasan payroll per karyawan atau
                                    batch
                                </li>
                                <li>
                                    Dashboard rekap gaji dan riwayat penggajian
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
            </main>
        </>
    );
}

function SummaryItem({
    icon: Icon,
    label,
    value,
}: {
    icon: React.ComponentType<{ className?: string }>;
    label: string;
    value: string;
}) {
    return (
        <div className="rounded-md border border-slate-200 p-4">
            <Icon className="mb-3 h-5 w-5 text-emerald-600" />
            <p className="font-medium">{label}</p>
            <p className="mt-1 text-sm text-slate-500">{value}</p>
        </div>
    );
}
