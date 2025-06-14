@extends('layout')

@section('topbar')
<div class="d-flex align-items-center justify-content-between flex-wrap bg-white mb-4 static-top p-4 shadow">
    <h1 class="h3 mb-0 text-gray-800">Kategori</h1>
    <div class="dropdown">
        <button class="btn btn-sm dropdown-toggle d-flex align-items-center gap-2"
            type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ Auth::user()->avatar ?? asset('img/default_avatar.png') }}" alt="avatar"
                class="rounded-circle" width="32" height="32" style="object-fit: cover;">
            <span>{{ Auth::user()->name }}</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger fw-bold">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</div>
@endsection

@section('content1')
<div class="container p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="py-2 m-0">Kategori Pemasukan</h4>
        <button class="btn btn-sm btn-primary" onclick="openModal('pemasukan')">+ Tambah</button>
    </div>
    <div class="table-responsive">
        <table class="table table-striped mt-3 align-middle">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories->where('type', 'pemasukan')->sortByDesc('created_at')->values() as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm me-1"
                            onclick="openEditModal({{ $category->id }}, '{{ $category->name }}', '{{ $category->type }}')">Edit</button>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('content2')
<div class="container p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="py-2 m-0">Kategori Pengeluaran</h4>
        <button class="btn btn-sm btn-primary" onclick="openModal('pengeluaran')">+ Tambah</button>
    </div>
    <div class="table-responsive">
        <table class="table table-striped mt-3 align-middle">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories->where('type', 'pengeluaran')->sortByDesc('created_at')->values() as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm me-1"
                            onclick="openEditModal({{ $category->id }}, '{{ $category->name }}', '{{ $category->type }}')">Edit</button>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('tambah')
<!-- Modal Tambah -->
<div id="modalTambah" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Tambah Kategori</h2>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kategori</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Jenis</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="pemasukan">Pemasukan</option>
                    <option value="pengeluaran">Pengeluaran</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="modal">
    <div class="modal-content">
        <span class="close-edit">&times;</span>
        <h2>Edit Kategori</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="edit_name" class="form-label">Nama Kategori</label>
                <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="edit_type" class="form-label">Jenis</label>
                <select name="type" id="edit_type" class="form-control" required>
                    <option value="pemasukan">Pemasukan</option>
                    <option value="pengeluaran">Pengeluaran</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<style>
.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
}
.modal-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    width: 400px;
    position: relative;
}
.close, .close-edit {
    position: absolute;
    top: 10px; right: 15px;
    font-size: 20px;
    cursor: pointer;
}
</style>

<script>
function openModal(type) {
    document.getElementById('modalTambah').style.display = 'flex';
    document.getElementById('type').value = type;
}

function openEditModal(id, name, type) {
    const form = document.getElementById('editForm');
    form.action = `/categories/${id}`;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_type').value = type;
    document.getElementById('modalEdit').style.display = 'flex';
}

document.querySelector('.close').addEventListener('click', function () {
    document.getElementById('modalTambah').style.display = 'none';
});
document.querySelector('.close-edit').addEventListener('click', function () {
    document.getElementById('modalEdit').style.display = 'none';
});
window.onclick = function (event) {
    if (event.target == document.getElementById('modalTambah')) {
        document.getElementById('modalTambah').style.display = 'none';
    }
    if (event.target == document.getElementById('modalEdit')) {
        document.getElementById('modalEdit').style.display = 'none';
    }
}
</script>
@endsection
