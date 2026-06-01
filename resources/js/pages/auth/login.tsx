import { Head, useForm } from '@inertiajs/react';
import { AlertCircle } from 'lucide-react';
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
import { register as registerPage } from '@/routes';
import loginAction from '@/routes/login';
import { request as passwordRequest } from '@/routes/password';

export default function Login({ status = null }: { status?: string | null }) {
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
        post(loginAction.store.url(), {
            preserveScroll: true,
            onError: (errors) => {
                if (errors.email) {
                    reset('password');
                }
            },
        });
    };

    return (
        <div className="flex min-h-screen items-center justify-center bg-linear-to-br from-blue-50 to-indigo-100 px-4 py-12 sm:px-6 lg:px-8">
            <Head title="Masuk - Penerima Gaji" />

            <Card className="w-full max-w-md border-0 bg-white/80 shadow-2xl backdrop-blur-sm">
                <CardHeader className="space-y-1 text-center">
                    <div className="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-linear-to-r from-blue-500 to-indigo-600">
                        <svg
                            className="h-8 w-8 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                            />
                        </svg>
                    </div>
                    <CardTitle className="text-2xl font-bold text-gray-900">
                        Selamat Datang Kembali
                    </CardTitle>
                    <CardDescription className="text-gray-600">
                        Masuk ke akun Penerima Gaji Anda
                    </CardDescription>
                </CardHeader>

                <CardContent className="space-y-4">
                    {status && (
                        <div className="flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 p-3">
                            <AlertCircle className="h-4 w-4 text-red-500" />
                            <p className="text-sm text-red-700">{status}</p>
                        </div>
                    )}

                    <form onSubmit={submit} className="space-y-4">
                        <div className="space-y-2">
                            <Label
                                htmlFor="email"
                                className="text-sm font-medium text-gray-700"
                            >
                                Email
                            </Label>
                            <Input
                                id="email"
                                type="email"
                                className="h-12 rounded-xl border-gray-200 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                                value={data.email}
                                onChange={(e) =>
                                    setData('email', e.target.value)
                                }
                                placeholder="admin@example.com"
                                required
                                autoFocus
                            />
                        </div>

                        <div className="space-y-2">
                            <Label
                                htmlFor="password"
                                className="text-sm font-medium text-gray-700"
                            >
                                Kata Sandi
                            </Label>
                            <Input
                                id="password"
                                type="password"
                                className="h-12 rounded-xl border-gray-200 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                                value={data.password}
                                onChange={(e) =>
                                    setData('password', e.target.value)
                                }
                                placeholder="••••••••"
                                required
                                autoComplete="current-password"
                            />
                        </div>

                        <div className="flex items-center justify-between">
                            <label className="flex items-center space-x-2 text-sm">
                                <input
                                    type="checkbox"
                                    className="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                    name="remember"
                                    checked={data.remember}
                                    onChange={(e) =>
                                        setData('remember', e.target.checked)
                                    }
                                />
                                <span className="text-gray-700">
                                    Ingat saya
                                </span>
                            </label>
                            <TextLink
                                href={passwordRequest()}
                                className="text-sm font-medium text-blue-600 hover:text-blue-700"
                            >
                                Lupa Password?
                            </TextLink>
                        </div>

                        <Button
                            type="submit"
                            className="h-12 w-full rounded-xl bg-linear-to-r from-blue-500 to-indigo-600 font-semibold text-white shadow-lg transition-all duration-200 hover:from-blue-600 hover:to-indigo-700 hover:shadow-xl"
                            disabled={processing}
                        >
                            {processing ? (
                                <>
                                    <svg
                                        className="mr-3 -ml-1 h-5 w-5 animate-spin text-white"
                                        xmlns="http://www.w3.org/2000/svg"
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
                                        ></circle>
                                        <path
                                            className="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                        ></path>
                                    </svg>
                                    Memproses...
                                </>
                            ) : (
                                'Masuk ke Akun'
                            )}
                        </Button>
                    </form>

                    <div className="border-t border-gray-200 py-4 text-center">
                        <p className="mb-3 text-sm text-gray-600">
                            Belum punya akun?{' '}
                            <TextLink
                                href={registerPage()}
                                className="font-semibold text-blue-600 hover:text-blue-700"
                            >
                                Daftar sekarang
                            </TextLink>
                        </p>
                        <p className="text-xs text-gray-500">
                            © 2025 Penerima Gaji. Semua hak dilindungi.
                        </p>
                    </div>
                </CardContent>
            </Card>
        </div>
    );
}

Login.layout = (page: React.ReactNode) => (
    <>
        <Head title="Masuk - Penerima Gaji" />
        <div className="min-h-screen bg-linear-to-br from-blue-50 to-indigo-100">
            {page}
        </div>
    </>
);
