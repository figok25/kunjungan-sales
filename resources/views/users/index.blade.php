<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-800 px-4 py-3 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-4">
                <form method="GET" class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-sm text-gray-600">Cari Nama</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Role</label>
                        <select name="role" class="border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Semua</option>
                            <option value="owner" @selected(request('role') == 'owner')>Owner</option>
                            <option value="admin" @selected(request('role') == 'admin')>Admin</option>
                            <option value="sales" @selected(request('role') == 'sales')>Sales</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Filter</button>
                    <a href="{{ route('users.create') }}" class="ml-auto bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">+ Tambah User</a>
                </form>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Nama</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Email</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Role</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-4 py-3">{{ $user->name }}</td>
                                <td class="px-4 py-3">{{ $user->email }}</td>
                                <td class="px-4 py-3 capitalize">{{ $user->role }}</td>
                                <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                                    @if (! $user->isOwner() || auth()->user()->isOwner())
                                        <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:underline">Edit</a>
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4 py-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
