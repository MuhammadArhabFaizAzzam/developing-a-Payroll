<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page()
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_visit_the_dashboard()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('dashboard'));
        $response->assertOk();
    }

    public function test_accepted_users_are_redirected_from_home_to_their_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'user',
            'desired_job_status' => 'diterima',
        ]);

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertRedirect(route('dashboard'));
    }

    public function test_admin_users_see_the_admin_dashboard()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response
            ->assertOk()
            ->assertSee('Total Karyawan');
    }

    public function test_regular_users_see_the_user_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response
            ->assertOk()
            ->assertSee('Dashboard Saya');
    }

    public function test_regular_users_cannot_access_admin_payroll_routes()
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get(route('employees.index'));

        $response->assertForbidden();
    }

    public function test_regular_users_can_choose_a_job_for_admin_review()
    {
        Employee::create([
            'nip' => 'EMP999',
            'nama' => 'Test Employee',
            'email' => 'employee@example.com',
            'departemen' => 'IT',
            'jabatan' => 'Programmer',
            'tanggal_masuk' => '2026-01-01',
            'gaji_dasar' => 5000000,
            'status' => 'aktif',
        ]);

        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->post(route('user.job-choice.update'), [
            'desired_department' => 'IT',
            'desired_job' => 'Programmer',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'desired_department' => 'IT',
            'desired_job' => 'Programmer',
            'desired_job_status' => 'menunggu_review',
        ]);
    }

    public function test_admin_users_can_see_user_job_choices()
    {
        User::factory()->create([
            'role' => 'user',
            'desired_department' => 'IT',
            'desired_job' => 'Programmer',
            'desired_job_status' => 'menunggu_review',
        ]);

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response
            ->assertOk()
            ->assertSee('Pilihan Pekerjaan User')
            ->assertSee('IT')
            ->assertSee('Programmer');
    }

    public function test_admin_users_can_approve_user_job_choices()
    {
        $user = User::factory()->create([
            'role' => 'user',
            'desired_department' => 'IT',
            'desired_job' => 'Programmer',
            'desired_job_status' => 'menunggu_review',
        ]);

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.job-choices.approve', $user));

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'desired_job_status' => 'diterima',
        ]);
        $this->assertDatabaseHas('employees', [
            'user_id' => $user->id,
            'nama' => $user->name,
            'email' => $user->email,
            'departemen' => 'IT',
            'jabatan' => 'Programmer',
            'status' => 'aktif',
        ]);
    }

    public function test_approved_users_see_their_matching_user_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'user',
            'desired_department' => 'IT',
            'desired_job' => 'Programmer',
            'desired_job_status' => 'diterima',
        ]);

        Employee::create([
            'user_id' => $user->id,
            'nip' => 'USR00001',
            'nama' => $user->name,
            'email' => $user->email,
            'departemen' => 'IT',
            'jabatan' => 'Programmer',
            'tanggal_masuk' => '2026-01-01',
            'gaji_dasar' => 0,
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response
            ->assertOk()
            ->assertSee('Dashboard Saya')
            ->assertSee('Diterima')
            ->assertSee('IT')
            ->assertSee('Programmer');
    }

    public function test_users_can_take_paid_salary_from_their_dashboard()
    {
        $user = User::factory()->create(['role' => 'user']);
        $employee = Employee::create([
            'user_id' => $user->id,
            'nip' => 'USR00002',
            'nama' => $user->name,
            'email' => $user->email,
            'departemen' => 'IT',
            'jabatan' => 'Programmer',
            'tanggal_masuk' => '2026-01-01',
            'gaji_dasar' => 5000000,
            'status' => 'aktif',
        ]);
        $payroll = Payroll::create([
            'employee_id' => $employee->id,
            'bulan' => 5,
            'tahun' => 2026,
            'gaji_dasar' => 5000000,
            'gaji_bersih' => 5000000,
            'status' => 'dibayar',
            'tanggal_bayar' => '2026-05-08',
        ]);

        $response = $this->actingAs($user)->post(route('user.payrolls.take', $payroll));

        $response->assertRedirect();
        $this->assertNotNull($payroll->refresh()->taken_at);
    }

    public function test_users_cannot_take_unpaid_salary()
    {
        $user = User::factory()->create(['role' => 'user']);
        $employee = Employee::create([
            'user_id' => $user->id,
            'nip' => 'USR00003',
            'nama' => $user->name,
            'email' => $user->email,
            'departemen' => 'IT',
            'jabatan' => 'Programmer',
            'tanggal_masuk' => '2026-01-01',
            'gaji_dasar' => 5000000,
            'status' => 'aktif',
        ]);
        $payroll = Payroll::create([
            'employee_id' => $employee->id,
            'bulan' => 5,
            'tahun' => 2026,
            'gaji_dasar' => 5000000,
            'gaji_bersih' => 5000000,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->post(route('user.payrolls.take', $payroll));

        $response->assertRedirect();
        $this->assertNull($payroll->refresh()->taken_at);
    }

    public function test_users_can_view_their_paid_salary_slip()
    {
        $user = User::factory()->create(['role' => 'user']);
        $employee = Employee::create([
            'user_id' => $user->id,
            'nip' => 'USR00004',
            'nama' => $user->name,
            'email' => $user->email,
            'departemen' => 'IT',
            'jabatan' => 'Programmer',
            'tanggal_masuk' => '2026-01-01',
            'gaji_dasar' => 5000000,
            'status' => 'aktif',
        ]);
        $payroll = Payroll::create([
            'employee_id' => $employee->id,
            'bulan' => 5,
            'tahun' => 2026,
            'gaji_dasar' => 5000000,
            'gaji_bersih' => 5000000,
            'status' => 'dibayar',
            'tanggal_bayar' => '2026-05-08',
        ]);

        $response = $this->actingAs($user)->get(route('user.payrolls.slip-gaji', $payroll));

        $response
            ->assertOk()
            ->assertSee($user->name)
            ->assertSee('Programmer');
    }
}
