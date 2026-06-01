import { Head, useForm } from '@inertiajs/react';
import { Shield } from 'lucide-react';
import { useEffect } from 'react';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { login as loginPage } from '@/routes';

export default function AdminLogin({
    status = null,
}: {
    status?: string | null;
}) {
    const { data, setData, post, processing, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    useEffect(() => {
        if (status) {
            reset('email');
        }
    }, [status, reset]);

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/login/admin', {
            preserveScroll: true,
            onError: (errors) => {
                if (errors.email) {
                    reset('password');
                }
            },
        });
    };

    return (
        <div className="relative flex min-h-screen items-center justify-center overflow-hidden bg-linear-to-br from-slate-900 via-purple-900 to-slate-900 px-4 py-12">
            <Head title="Admin Login - Penerima Gaji" />

            {/* Background Pattern */}
            <div className="absolute inset-0 opacity-20">
                <div className="animate-blob absolute top-1/4 left-1/4 h-72 w-72 rounded-full bg-purple-500 mix-blend-multiply blur-xl filter"></div>
                <div className="animate-blob animation-delay-2000 absolute top-1/2 right-1/4 h-72 w-72 rounded-full bg-yellow-400 mix-blend-multiply blur-xl filter"></div>
                <div className="animate-blob animation-delay-4000 absolute bottom-1/4 left-1/2 h-72 w-72 rounded-full bg-pink-400 mix-blend-multiply blur-xl filter"></div>
            </div>

            <Card className="relative w-full max-w-md border-0 bg-white/20 shadow-2xl backdrop-blur-xl">
                <CardHeader className="relative z-10 space-y-1 text-center">
                    <div className="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-2xl bg-linear-to-r from-purple-500 to-indigo-600 shadow-2xl">
                        <Shield className="h-10 w-10 text-white" />
                    </div>
                    <CardTitle className="bg-linear-to-r from-gray-900 to-gray-700 bg-clip-text text-3xl font-bold text-transparent">
                        Admin Panel
                    </CardTitle>
                    <CardDescription className="text-gray-300">
                        Masuk ke sistem administrasi penggajian
                    </CardDescription>
                </CardHeader>

                <CardContent className="relative z-10 space-y-4">
                    {status && (
                        <div className="flex items-center gap-2 rounded-2xl border border-red-500/20 bg-red-500/10 p-3 backdrop-blur-sm">
                            <Shield className="h-4 w-4 text-red-400" />
                            <p className="text-sm text-red-200">{status}</p>
                        </div>
                    )}

                    <form onSubmit={submit} className="space-y-4">
                        <div className="space-y-2">
                            <Label
                                htmlFor="email"
                                className="text-sm font-semibold text-gray-200"
                            >
                                Email Admin
                            </Label>
                            <Input
                                id="email"
                                type="email"
                                className="h-14 rounded-2xl border-2 border-white/30 bg-white/70 text-gray-900 placeholder-gray-500 backdrop-blur-sm focus:border-purple-400 focus:ring-4 focus:ring-purple-500/20"
                                value={data.email}
                                onChange={(e) =>
                                    setData('email', e.target.value)
                                }
                                placeholder="admin@perusahaan.com"
                                required
                                autoFocus
                            />
                        </div>

                        <div className="space-y-2">
                            <Label
                                htmlFor="password"
                                className="text-sm font-semibold text-gray-200"
                            >
                                Kata Sandi Admin
                            </Label>
                            <Input
                                id="password"
                                type="password"
                                className="h-14 rounded-2xl border-2 border-white/30 bg-white/70 text-gray-900 placeholder-gray-500 backdrop-blur-sm focus:border-purple-400 focus:ring-4 focus:ring-purple-500/20"
                                value={data.password}
                                onChange={(e) =>
                                    setData('password', e.target.value)
                                }
                                placeholder="••••••••••••"
                                required
                                autoComplete="current-password"
                            />
                        </div>

                        <div className="flex items-center justify-between pt-2">
                            <label className="flex items-center space-x-2 text-sm">
                                <input
                                    type="checkbox"
                                    className="rounded-lg border-2 border-gray-300 bg-white text-purple-600 shadow-sm focus:ring-2 focus:ring-purple-500"
                                    name="remember"
                                    checked={data.remember}
                                    onChange={(e) =>
                                        setData('remember', e.target.checked)
                                    }
                                />
                                <span className="font-medium text-gray-200">
                                    Ingat Saya
                                </span>
                            </label>
                            <TextLink
                                href={loginPage()}
                                className="text-xs font-semibold text-purple-300 transition-colors hover:text-purple-200"
                            >
                                Login User Biasa →
                            </TextLink>
                        </div>

                        <Button
                            type="submit"
                            className="hover:shadow-3xl h-14 w-full rounded-2xl border-2 border-purple-400/50 bg-linear-to-r from-purple-500 via-indigo-500 to-purple-600 font-bold text-white shadow-2xl backdrop-blur-sm transition-all duration-300 hover:-translate-y-0.5 hover:from-purple-600 hover:via-indigo-600 hover:to-purple-700"
                            disabled={processing}
                        >
                            {processing ? (
                                <>
                                    <svg
                                        className="mr-3 -ml-1 h-5 w-5 animate-spin"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle
                                            className="opacity-25"
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            strokeWidth="4"
                                        />
                                        <path
                                            className="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                        />
                                    </svg>
                                    Memverifikasi...
                                </>
                            ) : (
                                <>
                                    <Shield className="mr-2 inline h-5 w-5" />
                                    Masuk Admin Panel
                                </>
                            )}
                        </Button>
                    </form>

                    <div className="border-t border-white/20 py-6 text-center">
                        <p className="text-xs text-gray-400">
                            © 2025 Penerima Gaji Admin. Sistem Keamanan Tinggi.
                        </p>
                    </div>
                </CardContent>
            </Card>

            <style>{`
                @keyframes blob {
                    0% { transform: translate(0px, 0px) scale(1); }
                    33% { transform: translate(30px, -50px) scale(1.1); }
                    66% { transform: translate(-20px, 20px) scale(0.9); }
                    100% { transform: translate(0px, 0px) scale(1); }
                }
                .animate-blob {
                    animation: blob 7s infinite;
                }
                .animation-delay-2000 { animation-delay: 2s; }
                .animation-delay-4000 { animation-delay: 4s; }
            `}</style>
        </div>
    );
}

AdminLogin.layout = (page: React.ReactNode) => (
    <>
        <Head title="Admin Login - Penerima Gaji" />
        <div className="relative min-h-screen overflow-hidden bg-linear-to-br from-slate-900 via-purple-900 to-slate-900">
            {page}
        </div>
    </>
);
