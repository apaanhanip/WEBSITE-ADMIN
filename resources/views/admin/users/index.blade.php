@extends('layouts.app')

@section('title', 'สมาชิก')
@section('page-title', 'สมาชิก')
@section('page-subtitle', 'จัดการบัญชีลูกค้า')

@section('content')
    <form method="GET" class="mb-4 flex gap-2">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="ค้นหาชื่อ/อีเมล..." class="form-input sm:w-64">
        <button class="btn-secondary">ค้นหา</button>
    </form>

    <div class="card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead><tr><th>ชื่อ</th><th>อีเมล</th><th>เบอร์</th><th class="text-right">ยอดเงิน</th><th class="text-center">ออเดอร์</th><th>สมัครเมื่อ</th><th class="text-right"></th></tr></thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="font-semibold text-coffee-900">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td class="text-right font-semibold text-coffee-700">฿{{ number_format($user->balance, 2) }}</td>
                            <td class="text-center">{{ $user->purchases_count }}</td>
                            <td class="text-xs text-coffee-500">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="text-right"><a href="{{ route('admin.users.show', $user) }}" class="text-sm font-semibold text-coffee-600 hover:text-coffee-800">ดู</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7"><x-empty-state title="ยังไม่มีสมาชิก" /></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
@endsection
