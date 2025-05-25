<div class="table" style="max-height: 295px; overflow-y: auto; position: relative;">
    <table class="table">
        <tr style="position: sticky; top: 0; background: white; z-index: 100;">
            <th>No</th>
            <th>Tanggal</th>
            <th>Pemasukan</th>
            <th>Kategori</th>
            <th>Aksi</th>
        </tr>
        @foreach ($a->whereNotNull('pemasukan')->sortByDesc('created_at')->values() as $no => $item)
            <tr>
                <td>{{ $no + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                <td class="text-success">
                    <i class="fa-solid fa-arrow-up"></i> 
                    {{ number_format($item->pemasukan, 2, ',', '.') }}
                </td>
                <td>{{ $item->kategori->name }}</td>
                <td class="d-flex align-items-center gap-2">
                    <a href="{{ route('pages.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('pages.delete', $item->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</div>
