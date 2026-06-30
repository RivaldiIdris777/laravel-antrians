@extends('layouts.admin.master')
@section('title', 'User Management | Admin Panel')
@push('styles')
<style>
       /* Animasi untuk modal */
    #editModal {
        transition: opacity 0.3s ease;
    }
    
    #editModal:not(.hidden) {
        display: block;
    }
    
    /* Smooth transition untuk modal panel */
    #editModal .transform {
        transition: all 0.3s ease;
    }

      /* Animasi untuk modal hapus */
    #deleteModal {
        transition: opacity 0.3s ease;
    }
    
    #deleteModal:not(.hidden) {
        display: block;
    }
    
    /* Smooth transition untuk modal panel */
    #editModal .transform, #deleteModal .transform {
        transition: all 0.3s ease;
    }
</style>
@endpush
@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center gap-1.5 text-[12px] text-gray-400 mb-3" aria-label="Breadcrumb">
    <a href="#" class="hover:text-brand transition-colors">Admin</a>
    <i class="ti ti-chevron-right text-[10px]"></i>
    <span class="text-gray-600 font-medium">User Management</span>
</nav>

<!-- Judul halaman -->
<div class="flex items-center justify-between mb-5">
    <h1 class="text-[22px] font-bold text-gray-800">User Management</h1>
</div>

<!-- Card konten utama -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md m-6">
        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
            <thead
                class="bg-gray-50 text-xs uppercase font-medium text-gray-700 tracking-wider border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-4">Username</th>
                    <th scope="col" class="px-6 py-4">Email</th>
                    <th scope="col" class="px-6 py-4">Role</th>
                    <th scope="col" class="px-6 py-4">Verified</th>
                    <th scope="col" class="px-6 py-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">   
                @forelse ($users as $user)             
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-1 text-xs font-semibold text-blue-600">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600">
                                {{ $user->email_verified_at !== null ? 'Ya' : 'Tidak' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                <button type="button"
                                    class="inline-flex items-center gap-1 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 cursor-pointer"
                                    onclick="openEditModal({{ $user }})">
                                    Edit
                                </button>
                                @if ($user->id !== auth()->id())
                                <button type="button"
                                    class="inline-flex items-center gap-1 rounded-md bg-red-600 px-3 py-1.5 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 cursor-pointer"
                                    onclick="openDeleteModal({{ $user->id }}, '{{ $user->name }}')">
                                    Hapus
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>                
                @empty
                 <!-- Kondisi Jika Tidak Ada Data -->
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400 italic">
                            Belum ada data user yang terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- Modal Edit User -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeEditModal()"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                Edit User
                            </h3>
                            
                            <!-- Hidden input untuk user ID -->
                            <input type="hidden" id="user_id" name="user_id">
                            
                            <!-- Input Name -->
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            
                            <!-- Input Email -->
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            
                            <!-- Input Role -->
                            <div class="mb-4">
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                <select id="role" 
                                        name="role" 
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Pilih Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                    <option value="operator">Operator</option>
                                </select>
                            </div>
                            
                            <!-- Input Password -->
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password <span class="text-xs text-gray-500">(Kosongkan jika tidak ingin mengubah)</span>
                                </label>
                                <input type="password" 
                                       id="password" 
                                       name="password"
                                       placeholder="Masukkan password baru jika ingin mengubah"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Simpan
                    </button>
                    <button type="button"
                            onclick="closeEditModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeDeleteModal()"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Konfirmasi Hapus
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" id="deleteMessage">
                                Apakah anda yakin ingin menghapus akun ini?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button"
                        id="confirmDeleteBtn"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Iya
                </button>
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Tidak
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const editForm = document.getElementById('editForm');
    const editModal = document.getElementById('editModal');
    const deleteModal = document.getElementById('deleteModal');
    const pageBody = document.body;
    const csrfToken = document.querySelector('input[name="_token"]').value;

    // Variabel untuk menyimpan ID user yang akan dihapus
    let deleteUserId = null;

    function openEditModal(user) {
        editForm.user_id.value = user.id;
        editForm.name.value = user.name;
        editForm.email.value = user.email;
        editForm.role.value = user.role;
        editForm.password.value = '';
        editForm.action = `/admin/users/${user.id}`;

        editModal.classList.remove('hidden');
        pageBody.style.overflow = 'hidden';
    }

    function closeEditModal() {
        editModal.classList.add('hidden');
        pageBody.style.overflow = 'auto';
        editForm.reset();
    }

    function openDeleteModal(userId, userName) {
        deleteUserId = userId;
        const deleteMessage = document.getElementById('deleteMessage');
        deleteMessage.textContent = `Apakah anda yakin ingin menghapus akun "${userName}"?`;
        deleteModal.classList.remove('hidden');
        pageBody.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        pageBody.style.overflow = 'auto';
        deleteUserId = null;
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !editModal.classList.contains('hidden')) {
            closeEditModal();
        }
    });

    function showValidationErrors(errors) {
        const messages = Object.entries(errors)
            .map(([field, list]) => `- ${field}: ${list.join(', ')}`)
            .join('\n');

        alert(`Validasi gagal:\n${messages}`);
    }

    async function saveUser(event) {
        event.preventDefault();

        const userId = editForm.user_id.value;
        const response = await fetch(`/admin/users/${userId}`, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new FormData(editForm)
        });

        const text = await response.text();
        let data = {};

        try {
            data = text ? JSON.parse(text) : {};
        } catch (err) {
            throw new Error('Server tidak mengembalikan JSON.');
        }

        if (!response.ok) {
            if (data.errors) {
                showValidationErrors(data.errors);
                return;
            }
            throw new Error(data.message || `HTTP ${response.status}`);
        }

        if (data.success) {
            alert('User berhasil diupdate');
            location.reload();
            return;
        }

        alert('Gagal mengupdate user');
    }

    editForm.addEventListener('submit', saveUser);

     async function deleteUser() {
        if (!deleteUserId) return;

        try {
            const response = await fetch(`/admin/users/${deleteUserId}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Tampilkan alert berhasil
                alert('Berhasil menghapus data user!');
                // Reload halaman untuk memperbarui tabel
                location.reload();
            } else {
                alert(data.message || 'Gagal menghapus user');
                closeDeleteModal();
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus user');
            closeDeleteModal();
        }
    }

    // Fungsi dan proses untuk membuka modal konfirmasi hapus

    document.getElementById('confirmDeleteBtn').addEventListener('click', deleteUser);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            if (!editModal.classList.contains('hidden')) {
                closeEditModal();
            }
            if (!deleteModal.classList.contains('hidden')) {
                closeDeleteModal();
            }
        }
    });

    function showValidationErrors(errors) {
        const messages = Object.entries(errors)
            .map(([field, list]) => `- ${field}: ${list.join(', ')}`)
            .join('\n');

        alert(`Validasi gagal:\n${messages}`);
    }

    async function saveUser(event) {
        event.preventDefault();

        const userId = editForm.user_id.value;
        const response = await fetch(`/admin/users/${userId}`, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new FormData(editForm)
        });

        const text = await response.text();
        let data = {};

        try {
            data = text ? JSON.parse(text) : {};
        } catch (err) {
            throw new Error('Server tidak mengembalikan JSON.');
        }

        if (!response.ok) {
            if (data.errors) {
                showValidationErrors(data.errors);
                return;
            }
            throw new Error(data.message || `HTTP ${response.status}`);
        }

        if (data.success) {
            alert('User berhasil diupdate');
            location.reload();
            return;
        }

        alert('Gagal mengupdate user');
    }

    editForm.addEventListener('submit', saveUser);
</script>
@endpush
@endsection
