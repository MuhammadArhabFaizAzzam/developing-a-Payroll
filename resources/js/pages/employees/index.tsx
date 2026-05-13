import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Badge } from '@/components/ui/badge';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { MoreVertical, Plus, Edit, Trash2, Eye } from 'lucide-react';
import * as employees from '@/routes/employees';
import type { PageProps } from '@inertiajs/core';

interface Employee {
    id: number;
    nip: string;
    nama: string;
    departemen: string;
    jabatan: string;
    status: 'aktif' | 'tidak_aktif';
    gaji_dasar: number;
    latest_payroll: {
        id: number;
        bulan: number;
        tahun: number;
        status: 'pending' | 'dibayar';
        taken_at: string | null;
    } | null;
}

interface Props extends PageProps {
    employees: {
        data: Employee[];
        links: any;
        meta: any;
    };
    search: string;
    status: string;
}

export default function EmployeeIndex({ employees: paginatedEmployees, search, status }: Props) {
    const formatTakenAt = (takenAt: string) =>
        new Intl.DateTimeFormat('id-ID', {
            dateStyle: 'medium',
            timeStyle: 'short',
        }).format(new Date(takenAt));

    const formatSalary = (salary: number) => {
        if (!salary || salary === 0) {
            return <span className="text-muted-foreground text-sm italic">Belum diisi</span>;
        }
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(salary);
    };

    const payrollPickupBadge = (employee: Employee) => {
        const payroll = employee.latest_payroll;

        if (!payroll) {
            return <span className="text-muted-foreground text-sm">Belum ada gaji</span>;
        }

        if (payroll.status !== 'dibayar') {
            return <Badge variant="secondary">Menunggu Bayar</Badge>;
        }

        if (!payroll.taken_at) {
            return (
                <Badge variant="outline" className="border-sky-500 text-sky-600">
                    Belum Diambil
                </Badge>
            );
        }

        return (
            <div className="flex flex-col gap-1">
                <Badge className="bg-emerald-600 text-white hover:bg-emerald-600">
                    Sudah Diambil
                </Badge>
                <span className="text-muted-foreground text-xs">{formatTakenAt(payroll.taken_at)}</span>
            </div>
        );
    };

    const handleSearch = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        const formData = new FormData(e.currentTarget);
        const status = formData.get('status') as string;
        router.get(employees.index.url(), {
            search: formData.get('search') || '',
            status: status === 'all' ? '' : status,
        });
    };

    const handleDelete = (id: number) => {
        if (confirm('Yakin ingin menghapus karyawan ini?')) {
            router.delete(employees.show.url({ id }));
        }
    };

    return (
        <>
            <Head title="Daftar Karyawan" />
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-start justify-between">
                    <div>
                        <h1 className="text-3xl font-bold tracking-tight">Daftar Karyawan</h1>
                        <p className="text-muted-foreground mt-1">
                            Kelola data karyawan penerima gaji
                        </p>
                    </div>
                    <Link href={employees.create.url()}>
                        <Button>
                            <Plus className="mr-2 h-4 w-4" />
                            Tambah Karyawan
                        </Button>
                    </Link>
                </div>

                {/* Filter */}
                <form onSubmit={handleSearch} className="space-y-4 rounded-lg border p-4">
                    <div className="grid gap-4 md:grid-cols-4">
                        <div>
                            <label className="mb-2 block text-sm font-medium">Cari</label>
                            <Input
                                name="search"
                                placeholder="Nama, NIP, atau Departemen"
                                defaultValue={search}
                            />
                        </div>
                        <div>
                            <label className="mb-2 block text-sm font-medium">Status</label>
                            <Select name="status" defaultValue={status ? status : 'all'}>
                                <SelectTrigger>
                                    <SelectValue placeholder="Semua" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="all">Semua</SelectItem>
                                    <SelectItem value="aktif">Aktif</SelectItem>
                                    <SelectItem value="tidak_aktif">Tidak Aktif</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                        <div className="flex items-end">
                            <Button type="submit" className="w-full">
                                Cari
                            </Button>
                        </div>
                    </div>
                </form>

                {/* Table */}
                <div className="overflow-hidden rounded-lg border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>NIP</TableHead>
                                <TableHead>Nama</TableHead>
                                <TableHead>Departemen</TableHead>
                                <TableHead>Jabatan</TableHead>
                                <TableHead>Gaji Dasar</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead>Pengambilan Gaji</TableHead>
                                <TableHead className="text-right">Aksi</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {paginatedEmployees.data.length === 0 ? (
                                <TableRow>
                                    <TableCell colSpan={8} className="text-center py-8 text-muted-foreground">
                                        Tidak ada data karyawan
                                    </TableCell>
                                </TableRow>
                            ) : (
                                paginatedEmployees.data.map((employee) => (
                                    <TableRow 
                                        key={employee.id}
                                        className={employee.status === 'tidak_aktif' ? 'opacity-60' : ''}
                                    >
                                        <TableCell className="font-mono text-sm">{employee.nip}</TableCell>
                                        <TableCell className="font-medium">{employee.nama}</TableCell>
                                        <TableCell>{employee.departemen}</TableCell>
                                        <TableCell>{employee.jabatan}</TableCell>
                                        <TableCell>
                                            {formatSalary(employee.gaji_dasar)}
                                        </TableCell>
                                        <TableCell>
                                            <Badge
                                                variant={
                                                    employee.status === 'aktif' ? 'default' : 'secondary'
                                                }
                                            >
                                                {employee.status === 'aktif' ? 'Aktif' : 'Tidak Aktif'}
                                            </Badge>
                                        </TableCell>
                                        <TableCell>{payrollPickupBadge(employee)}</TableCell>
                                        <TableCell className="text-right">
                                            <DropdownMenu>
                                                <DropdownMenuTrigger asChild>
                                                    <Button 
                                                        variant="ghost" 
                                                        size="sm"
                                                        disabled={employee.status === 'tidak_aktif'}
                                                    >
                                                        <MoreVertical className="h-4 w-4" />
                                                    </Button>
                                                </DropdownMenuTrigger>
                                                <DropdownMenuContent align="end">
                                                    <DropdownMenuItem asChild>
                                                        <Link href={employees.show.url({ id: employee.id })}>
                                                            <Eye className="mr-2 h-4 w-4" />
                                                            Lihat
                                                        </Link>
                                                    </DropdownMenuItem>
                                                    {employee.status === 'aktif' && (
                                                        <>
                                                            <DropdownMenuItem asChild>
                                                                <Link href={employees.edit.url({ id: employee.id })}>
                                                                    <Edit className="mr-2 h-4 w-4" />
                                                                    Edit
                                                                </Link>
                                                            </DropdownMenuItem>
                                                            <DropdownMenuItem
                                                                onClick={() => handleDelete(employee.id)}
                                                                className="text-red-600"
                                                            >
                                                                <Trash2 className="mr-2 h-4 w-4" />
                                                                Hapus
                                                            </DropdownMenuItem>
                                                        </>
                                                    )}
                                                </DropdownMenuContent>
                                            </DropdownMenu>
                                        </TableCell>
                                    </TableRow>
                                ))
                            )}
                        </TableBody>
                    </Table>
                </div>

                {/* Pagination */}
                {paginatedEmployees.links.length > 0 && (
                    <div className="flex justify-center gap-2">
                        {paginatedEmployees.links.map((link: any, index: number) => (
                            <Link
                                key={index}
                                href={link.url || '#'}
                                className={`px-3 py-1 rounded ${
                                    link.active
                                        ? 'bg-primary text-primary-foreground'
                                        : 'border hover:bg-muted'
                                }`}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            />
                        ))}
                    </div>
                )}
            </div>
        </>
    );
}

EmployeeIndex.layout = {
    breadcrumbs: [
        {
            title: 'Karyawan',
            href: employees.index.url(),
        },
    ],
};
