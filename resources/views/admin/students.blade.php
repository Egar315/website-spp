@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
<style>
    .page-title {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1.5rem;
    }
    
    .main-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    
    .filters-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        gap: 16px;
    }

    .search-input-group {
        position: relative;
        flex-grow: 1;
        max-width: 500px;
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
        background-color: #fff;
    }
    .search-input:focus {
        border-color: #cbd5e1;
        box-shadow: none;
    }

    .filter-selects {
        display: flex;
        gap: 12px;
    }
    .form-select-custom {
        border-radius: 50rem;
        border: 1px solid #e2e8f0;
        padding-left: 16px;
        padding-right: 36px;
        color: #475569;
        background-color: #fff;
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
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
        border-top: none;
        background-color: #f8fafc;
    }
    .table-custom td {
        padding: 16px;
        vertical-align: middle;
        color: #334155;
        font-weight: 600;
        font-size: 0.9rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .val-text {
        font-weight: 400;
        color: #64748b;
    }

    
    .status-pill {
        padding: 4px 16px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
    }
    .pill-paid {
        background-color: #dcfce7;
        color: #16a34a;
    }
    .pill-unpaid {
        background-color: #fee2e2;
        color: #ef4444;
    }

    
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 24px;
    }
    .showing-text {
        color: #64748b;
        font-size: 0.85rem;
    }
    .pagination-custom {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .page-btn {
        background: white;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 6px 14px;
        border-radius: 50rem;
        text-decoration: none;
        transition: all 0.2s;
    }
    .page-btn:hover {
        background-color: #f8fafc;
        color: #0f172a;
    }
    .page-num {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #475569;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s;
    }
    .page-num.active {
        background-color: #1e3a8a;
        color: white;
    }
    
    .pagination-custom .pagination {
        margin: 0;
        gap: 8px;
    }
    .pagination-custom .page-item .page-link {
        border-radius: 50rem;
        color: #475569;
        font-weight: 600;
        border: 1px solid #e2e8f0;
        padding: 6px 14px;
        transition: all 0.2s;
    }
    .pagination-custom .page-item.active .page-link {
        background-color: #1e3a8a;
        border-color: #1e3a8a;
        color: white;
    }
    .pagination-custom .page-item:not(.active) .page-link:hover {
        background-color: #f8fafc;
        color: #0f172a;
    }

    .action-btn {
        background: none;
        border: none;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-edit { background-color: #eff6ff; color: #2563eb; }
    .btn-edit:hover { background-color: #2563eb; color: white; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2); }

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
</style>

<div>
    <h2 class="page-title">Data Induk Siswa</h2>

    <div class="main-card">
        
        <form action="{{ route('admin.students') }}" method="GET" class="filters-wrapper">
            <div class="search-input-group">
                <i class="bi bi-search search-icon"></i>
                <input type="text" name="search" class="form-control py-2 search-input" placeholder="Cari berdasarkan NISN atau nama..." value="{{ request('search') }}">
            </div>
            
            <div class="filter-selects">
                    <select name="class" class="form-select py-2 form-select-custom" style="width: auto;" onchange="this.form.submit()">
                        <option value="all" {{ request('class') == 'all' ? 'selected' : '' }}>Semua Kelas</option>
                        <option value="X" {{ request('class') == 'X' ? 'selected' : '' }}>Kelas X</option>
                        <option value="XI" {{ request('class') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                        <option value="XII" {{ request('class') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                    </select>
                    
                    <select name="year" class="form-select py-2 form-select-custom" style="width: auto;" onchange="this.form.submit()">
                        <option value="all" {{ request('year') == 'all' ? 'selected' : '' }}>Semua Tahun</option>
                        <option value="2026" {{ request('year') == '2026' ? 'selected' : '' }}>2026</option>
                        <option value="2025" {{ request('year') == '2025' ? 'selected' : '' }}>2025</option>
                        <option value="2024" {{ request('year') == '2024' ? 'selected' : '' }}>2024</option>
                    </select>
            </div>
        </form>

        
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>NISN</th>
                        <th>NAMA</th>
                        <th>KELAS</th>
                        <th>TAHUN AJARAN</th>
                        <th>STATUS PEMBAYARAN</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr>
                        <td style="font-weight: 700;">{{ $student->nisn }}</td>
                        <td>{{ $student->name }}</td>
                        <td class="val-text">{{ $student->class_name }}</td>
                        <td class="val-text">{{ $student->academic_year }}</td>
                        <td>
                            @if($student->payment_status === 'paid')
                                <span class="status-pill pill-paid">Lunas</span>
                            @else
                                <span class="status-pill pill-unpaid">Belum Lunas</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="action-btn btn-edit" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editStudentModal"
                                data-id="{{ $student->id }}"
                                data-name="{{ $student->name }}"
                                data-class="{{ $student->class_name }}"
                                data-year="{{ $student->academic_year }}"
                                data-status="{{ $student->payment_status }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data siswa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        
        <div class="table-footer">
            <div class="showing-text">
                Menampilkan {{ $students->firstItem() ?? 0 }} sampai {{ $students->lastItem() ?? 0 }} dari {{ $students->total() }} siswa
            </div>
            
            <div class="pagination-custom">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</div>

@section('modals')
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0 pt-4 px-4">
        <h5 class="modal-title fw-bold" id="editStudentModalLabel">Edit Data Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editStudentForm" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body px-4">
            <div class="mb-3">
                <label class="form-label text-muted" style="font-size: 0.75rem; font-weight: 700;">NAMA SISWA</label>
                <input type="text" id="edit_name" class="form-control" readonly style="background-color: #e2e8f0; border:none; border-radius: 10px; padding: 10px 16px;">
            </div>
            
            <div class="mb-3">
                <label class="form-label text-muted" style="font-size: 0.75rem; font-weight: 700;">KELAS</label>
                <select name="class_name" id="edit_class" class="form-select" style="border-radius: 10px; padding: 10px 16px; border: 1px solid #e2e8f0; background-color: #f8fafc;" required>
                    <option value="Belum Ditentukan">Belum Ditentukan</option>
                    <option value="X RPL">X RPL</option>
                    <option value="X TKJ">X TKJ</option>
                    <option value="X MM">X MM</option>
                    <option value="XI RPL">XI RPL</option>
                    <option value="XI TKJ">XI TKJ</option>
                    <option value="XI MM">XI MM</option>
                    <option value="XII RPL">XII RPL</option>
                    <option value="XII TKJ">XII TKJ</option>
                    <option value="XII MM">XII MM</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted" style="font-size: 0.75rem; font-weight: 700;">TAHUN AJARAN</label>
                <select name="academic_year" id="edit_year" class="form-select" style="border-radius: 10px; padding: 10px 16px; border: 1px solid #e2e8f0; background-color: #f8fafc;" required>
                    <option value="2026/2027">2026/2027</option>
                    <option value="2025/2026">2025/2026</option>
                    <option value="2024/2025">2024/2025</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label text-muted" style="font-size: 0.75rem; font-weight: 700;">STATUS PEMBAYARAN AWAL</label>
                <select name="payment_status" id="edit_status" class="form-select" style="border-radius: 10px; padding: 10px 16px; border: 1px solid #e2e8f0; background-color: #f8fafc;" required>
                    <option value="unpaid">Belum Lunas</option>
                    <option value="paid">Lunas</option>
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
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editStudentModal = document.getElementById('editStudentModal');
        if (editStudentModal) {
            editStudentModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');
                var className = button.getAttribute('data-class');
                var year = button.getAttribute('data-year');
                var status = button.getAttribute('data-status');
                
                document.getElementById('edit_name').value = name;
                
                // Set the correct option, or keep it if it exists
                var classSelect = document.getElementById('edit_class');
                var classOptionExists = Array.from(classSelect.options).some(opt => opt.value === className);
                if (!classOptionExists && className) {
                    var newOption = new Option(className, className);
                    classSelect.add(newOption);
                }
                classSelect.value = className;
                
                var yearSelect = document.getElementById('edit_year');
                var yearOptionExists = Array.from(yearSelect.options).some(opt => opt.value === year);
                if (!yearOptionExists && year) {
                    var newYearOption = new Option(year, year);
                    yearSelect.add(newYearOption);
                }
                yearSelect.value = year;

                document.getElementById('edit_status').value = status;
                
                var form = document.getElementById('editStudentForm');
                form.action = '/admin/students/' + id;
            });
        }
    });
</script>
@endsection
