<style>
    /* Scroll horizontal di layar kecil */
    @media (max-width: 992px) {
        .scroll-mobile {
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin; /* Firefox */
        }

        .scroll-mobile::-webkit-scrollbar {
            height: 8px;
        }

        .scroll-mobile::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 4px;
        }

        .scroll-mobile::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }

        .scroll-mobile table {
            min-width: 600px;
        }
    }

    /* Non-scroll untuk layar besar */
    @media (min-width: 993px) {
        .scroll-mobile {
            overflow-x: unset !important;
        }

        .scroll-mobile table {
            min-width: 100% !important;
        }
    }
</style>

<div class="scroll-mobile" style="max-height: 295px; overflow-y: auto;">
    <table class="table table-bordered table-striped mb-0">
        <thead>
            <tr style="position: sticky; top: 0; background: white; z-index: 100;">
                <th>No</th>
                <th>Tanggal</th>
                <th>Pemasukan</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($a->whereNotNull('pemasukan')->sortByDesc('created_at')->values() as $no => $item)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td class="text-success">
                        <i class="fa-solid fa-arrow-up"></i> 
                        {{ number_format($item->pemasukan, 2, ',', '.') }}
                    </td>
                    <td>{{ $item->kategori->name }}</td>
                    <td class="d-flex flex-wrap gap-1">
                        <a href="{{ route('pages.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('pages.delete', $item->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
