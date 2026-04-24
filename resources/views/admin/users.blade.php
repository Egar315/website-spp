@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .page-title {
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    
    .btn-add {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: white;
        border-radius: 12px;
        font-weight: 600;
        padding: 10px 20px;
        border: none;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
    }
    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        color: white;
    }

    .main-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .search-wrapper {
        position: relative;
        margin-bottom: 24px;
    }
    .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }
    .search-input {
        border-radius: 50rem;
        padding-left: 44px;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
    }
    .search-input:focus {
        border-color: #cbd5e1;
        box-shadow: none;
        background-color: white;
    }

    .table-custom {
        width: 100%;
        margin: 0;
    }
    .table-custom th {
        color: #64748b;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        border-top: none;
    }
    .table-custom td {
        padding: 16px;
        vertical-align: middle;
        color: #334155;
        font-weight: 500;
        font-size: 0.95rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .name-badge {
        background-color: #3b82f6;
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .email-text {
        color: #64748b;
        font-weight: 400;
        font-size: 0.9rem;
    }

    .role-text {
        color: #64748b;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .status-active {
        background-color: #dcfce7;
        color: #16a34a;
    }
    .status-inactive {
        background-color: #f1f5f9;
        color: #64748b;
    }

    .action-btn {
        background: none;
        border: none;
        padding: 6px 12px;
        border-radius: 8px;
        margin-right: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-edit { background-color: #eff6ff; color: #2563eb; }
    .btn-edit:hover { background-color: #2563eb; color: white; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2); }
    
    .btn-delete { background-color: #fef2f2; color: #dc2626; }
    .btn-delete:hover { background-color: #dc2626; color: white; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(220, 38, 38, 0.2); }
    
    .modal-content {
        border-radius: 20px !important;
        border: none !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
    }
    .modal-header {
        border-bottom: 1px solid #f1f5f9 !important;
        padding: 24px 24px 16px 24px !important;
    }
    .modal-body {
        padding: 24px !important;
    }
    .modal-footer {
        border-top: 1px solid #f1f5f9 !important;
        padding: 16px 24px 24px 24px !important;
    }
    .form-control, .form-select {
        border-radius: 10px;
        padding: 10px 16px;
        border: 1px solid #e2e8f0;
        font-size: 0.95rem;
        background-color: #f8fafc;
        transition: all 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        background-color: #ffffff;
    }

    .animate-hidden {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1), transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .animate-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .table-custom tbody tr {
        transition: all 0.3s ease;
    }
    
    .table-custom tbody tr:hover {
        background-color: #f8fafc;
        transform: translateX(4px);
        box-shadow: -4px 0 0 #3b82f6, 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

</style>

<div>
    <div class="page-header">
        <h2 class="page-title">Manajemen Pengguna</h2>
        <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addStaffModal">
            <i class="bi bi-plus-lg me-1"></i> Tambah Pengguna
        </button>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="main-card h-100" style="background: #f0f9ff; border-color: #bae6fd; padding: 20px;">
                <h6 class="fw-bold mb-2 text-primary"><i class="bi bi-shield-lock-fill me-2"></i>Administrator</h6>
                <p class="mb-0 text-muted" style="font-size: 0.85rem;">Akses penuh ke semua fitur, pengaturan SPP, manajemen pengguna, dan laporan keuangan.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="main-card h-100" style="background: #f0fdf4; border-color: #bbf7d0; padding: 20px;">
                <h6 class="fw-bold mb-2 text-success"><i class="bi bi-person-badge-fill me-2"></i>Petugas</h6>
                <p class="mb-0 text-muted" style="font-size: 0.85rem;">Verifikasi pembayaran online dan mencatat pembayaran tunai langsung di sekolah.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="main-card h-100" style="background: #fdf2f8; border-color: #fbcfe8; padding: 20px;">
                <h6 class="fw-bold mb-2 text-danger"><i class="bi bi-mortarboard-fill me-2"></i>Siswa</h6>
                <p class="mb-0 text-muted" style="font-size: 0.85rem;">Melihat tagihan, riwayat pembayaran, mengirim bukti transfer, dan mencetak kwitansi.</p>
            </div>
        </div>
    </div>



    <div class="main-card">
        <form action="{{ route('admin.users') }}" method="GET" class="search-wrapper">
            <i class="bi bi-search search-icon"></i>
            <input type="text" name="search" class="form-control py-2 search-input" placeholder="Cari pengguna berdasarkan nama atau email..." value="{{ request('search') }}">
        </form>

        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th><span class="name-badge">NAMA</span></th>
                        <th>EMAIL</th>
                        <th>JABATAN</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td class="email-text">{{ $user->email }}</td>
                        <td class="role-text">
                            @if($user->role === 'admin') <span class="badge bg-primary text-white">Admin</span>
                            @elseif($user->role === 'petugas') <span class="badge bg-info text-white">Petugas</span>
                            @else <span class="badge bg-secondary text-white">Siswa</span>
                            @endif
                        </td>
                        <td>
                            @if($user->status === 'active')
                                <span class="status-badge status-active">Aktif</span>
                            @else
                                <span class="status-badge status-inactive">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="action-btn btn-edit" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editStaffModal"
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-username="{{ $user->username }}"
                                data-email="{{ $user->email }}"
                                data-role="{{ $user->role }}"
                                data-status="{{ $user->status }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                            
                            <button type="button" class="action-btn btn-delete" title="Hapus Pengguna"
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteStaffModal"
                                data-action="{{ route('admin.users.delete', $user->id) }}"
                                data-name="{{ $user->name }}">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="d-flex justify-content-end mt-3">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

@section('modals')
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
      <div class="modal-header border-0 pb-0 pt-4 px-4">
        <h5 class="modal-title fw-bold" id="addStaffModalLabel">Tambah Pengguna Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.users') }}" method="POST">
          @csrf
          <div class="modal-body px-4">
            <div class="mb-3">
                <label class="form-label text-muted" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">NAMA LENGKAP</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="cth. Budi Santoso">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label text-muted" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">USERNAME</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required placeholder="cth. budisantoso">
                @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label text-muted" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">ALAMAT EMAIL</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="cth. budi@sekolah.sch.id">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label text-muted" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">KATA SANDI</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Minimal 6 karakter">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label text-muted" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">PERAN (ROLE)</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="" disabled selected>Pilih peran pengguna</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                </select>
                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label text-muted" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">STATUS</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>
          <div class="modal-footer border-0 pt-0 pb-4 px-4">
            <button type="button" class="btn btn-light" style="border-radius: 8px; font-weight: 600;" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary" style="background-color: #1e3a8a; border-radius: 8px; font-weight: 600; border: none;">Simpan Pengguna</button>
          </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
      <div class="modal-header border-0 pb-0 pt-4 px-4">
        <h5 class="modal-title fw-bold" id="editStaffModalLabel">Edit Pengguna</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editStaffForm" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body px-4">
            <div class="mb-3">
                <label class="form-label text-muted" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">NAMA LENGKAP</label>
                <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label text-muted" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">USERNAME</label>
                <input type="text" name="username" id="edit_username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">ALAMAT EMAIL</label>
                <input type="email" name="email" id="edit_email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">KATA SANDI BARU (Opsional)</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah sandi">
            </div>

            <div class="mb-3">
                <label class="form-label text-muted" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">PERAN (ROLE)</label>
                <select name="role" id="edit_role" class="form-select" required>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                    <option value="siswa">Siswa</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label text-muted" style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">STATUS</label>
                <select name="status" id="edit_status" class="form-select" required>
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
          </div>
          <div class="modal-footer border-0 pt-0 pb-4 px-4">
            <button type="button" class="btn btn-light" style="border-radius: 8px; font-weight: 600;" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary" style="background-color: #1e3a8a; border-radius: 8px; font-weight: 600; border: none;">Simpan Perubahan</button>
          </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteStaffModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content text-center p-2" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
      <div class="modal-body pt-4 pb-4">
        <div class="mb-3">
            <i class="bi bi-exclamation-circle text-danger" style="font-size: 3.5rem;"></i>
        </div>
        <h5 class="fw-bold mb-2">Hapus Pengguna?</h5>
        <p class="text-muted mb-4" style="font-size: 0.95rem;">Apakah Anda yakin ingin menghapus <strong id="delete_user_name" class="text-dark"></strong> secara permanen?</p>
        <form id="deleteStaffForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="d-flex gap-2 justify-content-center">
                <button type="button" class="btn btn-light w-50" style="border-radius: 10px; font-weight: 600;" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger w-50" style="border-radius: 10px; font-weight: 600;">Ya, Hapus</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@if($errors->any() && !old('_method'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var myModal = new bootstrap.Modal(document.getElementById('addStaffModal'), {
            keyboard: false
        });
        myModal.show();
    });
</script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editStaffModal = document.getElementById('editStaffModal');
        if (editStaffModal) {
            editStaffModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                
                document.getElementById('edit_name').value = button.getAttribute('data-name');
                document.getElementById('edit_username').value = button.getAttribute('data-username');
                document.getElementById('edit_email').value = button.getAttribute('data-email');
                document.getElementById('edit_role').value = button.getAttribute('data-role');
                document.getElementById('edit_status').value = button.getAttribute('data-status');
                
                var form = document.getElementById('editStaffForm');
                form.action = '/admin/users/' + id;
            });
        }
        
        var deleteStaffModal = document.getElementById('deleteStaffModal');
        if (deleteStaffModal) {
            deleteStaffModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var action = button.getAttribute('data-action');
                var name = button.getAttribute('data-name');
                
                document.getElementById('delete_user_name').textContent = name;
                document.getElementById('deleteStaffForm').action = action;
            });
        }

        const animatedElements = document.querySelectorAll('.page-header, .search-wrapper, .table-custom thead, .table-custom tbody tr, .pagination');
        
        animatedElements.forEach(el => {
            if(el) {
                el.classList.add('animate-hidden');
            }
        });

        setTimeout(() => {
            animatedElements.forEach((el, index) => {
                if(el) {
                    setTimeout(() => {
                        el.classList.add('animate-visible');
                    }, 80 * index);
                }
            });
        }, 100);
    });
</script>
@endsection
