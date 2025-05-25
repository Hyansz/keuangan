@extends('layout')

@section('topbar')
    <div class="d-flex align-items-center justify-content-between flex-wrap bg-white mb-4 static-top p-4 shadow">
        <h1 class="h3 mb-0 text-gray-800">Data Pemasukan</h1>
        <div class="d-flex align-items-center gap-2">
            {{-- <a href="#" class="btn btn-sm btn-primary shadow-sm mt-2 mt-sm-0" data-bs-toggle="modal" data-bs-target="#modalCetak">
                <i class="fas fa-download fa-sm text-white-50"></i> Cetak
            </a> --}}

            <div class="dropdown">
                <button class="btn btn-sm dropdown-toggle d-flex align-items-center gap-2" 
                    type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ Auth::user()->avatar ?? asset('img/default_avatar.png') }}" alt="avatar" 
                        class="rounded-circle" width="32" height="32" style="object-fit: cover;">
                    <span>{{ Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    {{-- <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li> --}}
                    {{-- <li><hr class="dropdown-divider"></li> --}}
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger fw-bold">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal Cetak -->
    {{-- <div class="modal fade" id="modalCetak" tabindex="-1" aria-labelledby="modalCetakLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('cetak.laporan') }}" method="GET" target="_blank">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCetakLabel">Cetak Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select class="form-control" name="bulan" id="bulan">
                                <option value="">-- Semua Bulan --</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select class="form-control" name="tahun" id="tahun">
                                @for ($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Cetak</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}
@endsection

@section('tambah')
    <!-- Tombol untuk membuka modal -->
    <div class="card h-100 text-decoration-none shadow" id="openModal" style="cursor: pointer;">
        <div class="card h-100 py-2 bg-primary border-primary shadow">
            <div class="card-body bg-primary text-white d-flex justify-content-center align-items-center">
                <p class="mb-0 fw-bold">Tambah Aktivitas</p>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modalTambah" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h4 class="py-2">Tambah Aktivitas</h4>
            <form action="{{ route('pages.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="number" name="nominal" class="form-control text-black panah" placeholder="Nominal" required>
                </div>
                <div class="mb-3 d-flex gap-3 justify-content-center">
                    <label>
                        <input type="radio" name="tipe" value="pemasukan" onchange="updateKategori()" required> Pemasukan
                    </label>
                    <label>
                        <input type="radio" name="tipe" value="pengeluaran" onchange="updateKategori()" required> Pengeluaran
                    </label>
                </div>        
                <div class="mb-3 pl-1">
                    <label for="kategori_id">Kategori:</label>
                    <select name="kategori_id" id="kategori_id" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>   
                </div>
                <div class="mb-3">
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="mb-3">
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" placeholder="Deskripsi"></textarea>
                </div>
                <button class="btn btn-primary">Tambah</button>
            </form>
        </div>
    </div>

    <style>
        .panah{
            -moz-appearance: textfield;
        }

        .panah::-webkit-outer-spin-button,
        .panah::-webkit-inner-spin-button {
            margin: 0;
            -webkit-appearance: none;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
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

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
        }
    </style>

    <script>
        document.getElementById('openModal').addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah redirect ke halaman tambah
            document.getElementById('modalTambah').style.display = 'flex';
        });

        document.querySelector('.close').addEventListener('click', function() {
            document.getElementById('modalTambah').style.display = 'none';
        });

        window.onclick = function(event) {
            if (event.target == document.getElementById('modalTambah')) {
                document.getElementById('modalTambah').style.display = 'none';
            }
        };
    </script>
@endsection

@section('content1')
    <div class="p-3">

        {{-- Filter Kategori dan Tahun Pemasukan --}}
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div class="text-center">
                <h4 class="pt-2">Aktifitas Pemasukan</h4>
            </div>
            
            <div class="d-flex align-items-center">
                <div>
                    <select name="kategori_pemasukan" id="kategori_pemasukan" class="form-select" style="width: 150px;">
                        <option value="">Kategori</option>
                        @foreach ($categories->where('type', 'pemasukan') as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="tahun_pemasukan" id="tahun_pemasukan" class="form-select" style="width: 100px;">
                        <option value="">Tahun</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Tabel Pemasukan --}}
        <div id="table-content-pemasukan">
            @include('pages.table_pemasukan', ['a' => $a])
        </div>
    </div>

    <script>
        function filterPemasukan() {
            let kategori = document.getElementById('kategori_pemasukan').value;
            let tahun = document.getElementById('tahun_pemasukan').value;

            fetch("{{ route('pages.filterPemasukan') }}?kategori=" + kategori + "&tahun=" + tahun)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('table-content-pemasukan').innerHTML = html;
                });
        }

        document.getElementById('kategori_pemasukan').addEventListener('change', filterPemasukan);
        document.getElementById('tahun_pemasukan').addEventListener('change', filterPemasukan);
    </script>
@endsection

@section('content2')
    <div class="p-3">

        {{-- Filter Kategori dan Tahun Pengeluaran --}}
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div class="text-center">
                <h4 class="pt-2">Aktifitas Pengeluaran</h4>
            </div>

            <div class="d-flex align-items-center">
                <div>
                    <select name="kategori_pengeluaran" id="kategori_pengeluaran" class="form-select" style="width: 150px;">
                        <option value="">Kategori</option>
                        @foreach ($categories->where('type', 'pengeluaran') as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <select name="tahun_pengeluaran" id="tahun_pengeluaran" class="form-select" style="width: 100px;">
                        <option value="">Tahun</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Tabel Pengeluaran --}}
        <div id="table-content-pengeluaran">
            @include('pages.table_pengeluaran', ['x' => $x])
        </div>
    </div>

    <script>
        function filterPengeluaran() {
            let kategori = document.getElementById('kategori_pengeluaran').value;
            let tahun = document.getElementById('tahun_pengeluaran').value;

            fetch("{{ route('pages.filterPengeluaran') }}?kategori=" + kategori + "&tahun=" + tahun)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('table-content-pengeluaran').innerHTML = html;
                });
        }

        document.getElementById('kategori_pengeluaran').addEventListener('change', filterPengeluaran);
        document.getElementById('tahun_pengeluaran').addEventListener('change', filterPengeluaran);
    </script>
@endsection

@section('content3')
    <div class="p-3">
        <div class="text-center mb-3">
            <h4 class="py-2">📊 Grafik Keuangan - Pemasukan & Pengeluaran</h4>
        </div>

        {{-- Pilihan Jangka Waktu --}}
        <div class="mb-3 text-center">
            <button class="btn btn-outline-primary btn-sm filter-btn" data-days="7">1 Minggu</button>
            <button class="btn btn-outline-primary btn-sm filter-btn" data-days="30">1 Bulan</button>
            <button class="btn btn-outline-primary btn-sm filter-btn" data-days="365">1 Tahun</button>
        </div>

        {{-- Area Grafik Full Width --}}
        <div class="chart-container" style="position: relative; height: 400px; width: 100%;">
            <canvas id="keuanganChart"></canvas>
        </div>
    </div>

    {{-- Import Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

    <script>
        let keuanganChart;
        function updateChart(days) {
            fetch("{{ route('pages.getChartData') }}?days=" + days)
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('keuanganChart').getContext('2d');
                    
                    if (keuanganChart) {
                        keuanganChart.destroy();
                    }

                    const gradientPemasukan = ctx.createLinearGradient(0, 0, 0, 400);
                    gradientPemasukan.addColorStop(0, 'rgba(0, 200, 83, 0.8)');
                    gradientPemasukan.addColorStop(1, 'rgba(0, 200, 83, 0.2)');
                    
                    const gradientPengeluaran = ctx.createLinearGradient(0, 0, 0, 400);
                    gradientPengeluaran.addColorStop(0, 'rgba(244, 67, 54, 0.8)');
                    gradientPengeluaran.addColorStop(1, 'rgba(244, 67, 54, 0.2)');

                    keuanganChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [
                                {
                                    label: '📈 Pemasukan',
                                    data: data.pemasukan,
                                    borderColor: 'rgba(0, 255, 100, 1)',
                                    backgroundColor: gradientPemasukan,
                                    borderWidth: 3,
                                    tension: 0.5,
                                    fill: true,
                                    pointBackgroundColor: 'rgba(0, 255, 100, 1)',
                                    pointBorderWidth: 2,
                                    pointHoverRadius: 6,
                                    pointHoverBackgroundColor: 'rgba(0, 255, 100, 1)',
                                    pointHoverBorderColor: '#fff'
                                },
                                {
                                    label: '📉 Pengeluaran',
                                    data: data.pengeluaran,
                                    borderColor: 'rgba(255, 50, 50, 1)',
                                    backgroundColor: gradientPengeluaran,
                                    borderWidth: 3,
                                    tension: 0.5,
                                    fill: true,
                                    pointBackgroundColor: 'rgba(255, 50, 50, 1)',
                                    pointBorderWidth: 2,
                                    pointHoverRadius: 6,
                                    pointHoverBackgroundColor: 'rgba(255, 50, 50, 1)',
                                    pointHoverBorderColor: '#fff'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    type: 'time',
                                    time: { unit: 'day' }
                                },
                                y: { beginAtZero: true }
                            },
                            plugins: {
                                tooltip: {
                                    intersect: false,
                                    mode: 'index',
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return "💰 " + new Intl.NumberFormat('id-ID').format(tooltipItem.raw);
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
        }

        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                updateChart(this.dataset.days);
            });
        });

        updateChart(30);
    </script>
@endsection
