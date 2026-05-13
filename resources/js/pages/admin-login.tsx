import { Head, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Shield } from 'lucide-react';
import TextLink from '@/components/text-link';
import { request as passwordRequest } from '@/routes/password';
import { login as loginPage } from '@/routes';
import { useEffect } from 'react';

export default function AdminLogin({ status = null }: { status?: string | null }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    useEffect(() => {
        if (status) {
            reset('email');
        }
    }, [status]);

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
        <div className="min-h-screen flex items-center justify-center bg-linear-to-br from-slate-900 via-purple-900 to-slate-900 py-12 px-4 relative overflow-hidden">
            <Head title="Admin Login - Penerima Gaji" />
            
            {/* Background Pattern */}
            <div className="absolute inset-0 opacity-20">
                <div className="absolute top-1/4 left-1/4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
                <div className="absolute top-1/2 right-1/4 w-72 h-72 bg-yellow-400 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
                <div className="absolute bottom-1/4 left-1/2 w-72 h-72 bg-pink-400 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
            </div>

            <Card className="w-full max-w-md relative bg-white/20 backdrop-blur-xl border-0 shadow-2xl">
                <CardHeader className="space-y-1 text-center relative z-10">
                    <div className="mx-auto h-20 w-20 bg-linear-to-r from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-4 shadow-2xl">
                        <Shield className="w-10 h-10 text-white" />
                    </div>
                    <CardTitle className="text-3xl font-bold bg-linear-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                        Admin Panel
                    </CardTitle>
                    <CardDescription className="text-gray-300">
                        Masuk ke sistem administrasi penggajian
                    </CardDescription>
                </CardHeader>

                <CardContent className="space-y-4 relative z-10">
                    {status && (
                        <div className="flex items-center gap-2 p-3 bg-red-500/10 border border-red-500/20 rounded-2xl backdrop-blur-sm">
                            <Shield className="h-4 w-4 text-red-400" />
                            <p className="text-sm text-red-200">{status}</p>
                        </div>
                    )}

                    <form onSubmit={submit} className="space-y-4">
                        <div className="space-y-2">
                            <Label htmlFor="email" className="text-sm font-semibold text-gray-200">
                                Email Admin
                            </Label>
                            <Input
                                id="email"
                                type="email"
                                className="h-14 rounded-2xl bg-white/70 backdrop-blur-sm border-2 border-white/30 focus:border-purple-400 focus:ring-4 focus:ring-purple-500/20 text-gray-900 placeholder-gray-500"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                placeholder="admin@perusahaan.com"
                                required
                                autoFocus
                            />
                        </div>

                        <div className="space-y-2">
                            <Label htmlFor="password" className="text-sm font-semibold text-gray-200">
                                Kata Sandi Admin
                            </Label>
                            <Input
                                id="password"
                                type="password"
                                className="h-14 rounded-2xl bg-white/70 backdrop-blur-sm border-2 border-white/30 focus:border-purple-400 focus:ring-4 focus:ring-purple-500/20 text-gray-900 placeholder-gray-500"
                                value={data.password}
                                onChange={(e) => setData('password', e.target.value)}
                                placeholder="••••••••••••"
                                required
                                autoComplete="current-password"
                            />
                        </div>

                        <div className="flex items-center justify-between pt-2">
                            <label className="flex items-center space-x-2 text-sm">
                                <input
                                    type="checkbox"
                                    className="rounded-lg border-2 border-gray-300 bg-white text-purple-600 shadow-sm focus:ring-purple-500 focus:ring-2"
                                    name="remember"
                                    checked={data.remember}
                                    onChange={(e) => setData('remember', e.target.checked)}
                                />
                                <span className="text-gray-200 font-medium">Ingat Saya</span>
                            </label>
                            <TextLink href={loginPage()} className="text-xs text-purple-300 hover:text-purple-200 font-semibold transition-colors">
                                Login User Biasa →
                            </TextLink>
                        </div>

                        <Button
                            type="submit"
                            className="w-full h-14 bg-linear-to-r from-purple-500 via-indigo-500 to-purple-600 hover:from-purple-600 hover:via-indigo-600 hover:to-purple-700 text-white font-bold rounded-2xl shadow-2xl hover:shadow-3xl hover:-translate-y-0.5 transition-all duration-300 border-2 border-purple-400/50 backdrop-blur-sm"
                            disabled={processing}
                        >
                            {processing ? (
                                <>
                                    <svg className="animate-spin -ml-1 mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24">
                                        <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                                        <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                    </svg>
                                    Memverifikasi...
                                </>
                            ) : (
                                <>
                                    <Shield className="w-5 h-5 mr-2 inline" />
                                    Masuk Admin Panel
                                </>
                            )}
                        </Button>
                    </form>

                    <div className="text-center py-6 border-t border-white/20">
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
        <div className="min-h-screen bg-linear-to-br from-slate-900 via-purple-900 to-slate-900 relative overflow-hidden">
            {page}
        </div>
    </>
);

