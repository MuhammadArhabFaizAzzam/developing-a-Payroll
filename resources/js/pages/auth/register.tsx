import { Head, useForm } from '@inertiajs/react';
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
import registerAction from '@/routes/register';

export default function Register({
    status = null,
}: {
    status?: string | null;
}) {
    const { data, setData, post, processing, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        terms: false,
    });

    useEffect(() => {
        if (status) {
            reset('password', 'password_confirmation');
        }
    }, [status, reset]);

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post(registerAction.store.url(), {
            preserveScroll: true,
            onError: (errors) => {
                if (Object.keys(errors).length) {
                    reset('password', 'password_confirmation');
                }
            },
        });
    };

    return (
        <div className="flex min-h-screen items-center justify-center bg-linear-to-br from-emerald-50 via-green-50 to-blue-50 px-4 py-12 sm:px-6 lg:px-8">
            <Head title="Daftar - Penerima Gaji" />

            <Card className="w-full max-w-md border-0 bg-white/80 shadow-2xl backdrop-blur-sm">
                <CardHeader className="space-y-1 text-center">
                    <div className="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-linear-to-r from-emerald-500 to-green-600">
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
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"
                            />
                        </svg>
                    </div>
                    <CardTitle className="text-2xl font-bold text-gray-900">
                        Buat Akun Baru
                    </CardTitle>
                    <CardDescription className="text-gray-600">
                        Bergabunglah dengan sistem penggajian
                    </CardDescription>
                </CardHeader>

                <CardContent className="space-y-4">
                    {status && (
                        <div className="flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 p-3">
                            <svg
                                className="h-4 w-4 text-emerald-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                            <p className="text-sm text-emerald-700">{status}</p>
                        </div>
                    )}

                    <form onSubmit={submit} className="space-y-4">
                        <div className="space-y-2">
                            <Label
                                htmlFor="name"
                                className="text-sm font-medium text-gray-700"
                            >
                                Nama Lengkap
                            </Label>
                            <Input
                                id="name"
                                type="text"
                                className="h-12 rounded-xl border-gray-200 focus:border-transparent focus:ring-2 focus:ring-emerald-500"
                                value={data.name}
                                onChange={(e) =>
                                    setData('name', e.target.value)
                                }
                                placeholder="Masukkan nama lengkap"
                                required
                                autoFocus
                            />
                        </div>

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
                                className="h-12 rounded-xl border-gray-200 focus:border-transparent focus:ring-2 focus:ring-emerald-500"
                                value={data.email}
                                onChange={(e) =>
                                    setData('email', e.target.value)
                                }
                                placeholder="example@company.com"
                                required
                            />
                        </div>

                        <div className="grid grid-cols-2 gap-4">
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
                                    className="h-12 rounded-xl border-gray-200 focus:border-transparent focus:ring-2 focus:ring-emerald-500"
                                    value={data.password}
                                    onChange={(e) =>
                                        setData('password', e.target.value)
                                    }
                                    placeholder="Minimal 8 karakter"
                                    required
                                />
                            </div>
                            <div className="space-y-2">
                                <Label
                                    htmlFor="password_confirmation"
                                    className="text-sm font-medium text-gray-700"
                                >
                                    Konfirmasi
                                </Label>
                                <Input
                                    id="password_confirmation"
                                    type="password"
                                    className="h-12 rounded-xl border-gray-200 focus:border-transparent focus:ring-2 focus:ring-emerald-500"
                                    value={data.password_confirmation}
                                    onChange={(e) =>
                                        setData(
                                            'password_confirmation',
                                            e.target.value,
                                        )
                                    }
                                    placeholder="Ulangi kata sandi"
                                    required
                                />
                            </div>
                        </div>

                        <Button
                            type="submit"
                            className="h-12 w-full rounded-xl bg-linear-to-r from-emerald-500 to-green-600 font-semibold text-white shadow-lg transition-all duration-200 hover:from-emerald-600 hover:to-green-700 hover:shadow-xl"
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
                                    Membuat Akun...
                                </>
                            ) : (
                                'Daftar Sekarang'
                            )}
                        </Button>
                    </form>

                    <div className="border-t border-gray-200 pt-6 text-center">
                        <p className="text-sm text-gray-600">
                            Sudah punya akun?{' '}
                            <TextLink
                                href={loginPage()}
                                className="font-semibold text-emerald-600 hover:text-emerald-700"
                            >
                                Masuk sekarang
                            </TextLink>
                        </p>
                    </div>
                </CardContent>
            </Card>
        </div>
    );
}

Register.layout = (page: React.ReactNode) => (
    <>
        <Head title="Daftar - Penerima Gaji" />
        <div className="min-h-screen bg-linear-to-br from-emerald-50 via-green-50 to-blue-50">
            {page}
        </div>
    </>
);
