@extends('layout')

@section('content')

<h4 class="mb-4 fw-bold">📋 Riwayat Data Inkubator</h4>

<div class="card">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Data per Hari / Jam</h6>
        <span class="badge bg-secondary">{{ $riwayat->total() }} data</span>
    </div>

    <div class="card-body">

        {{-- ─── FILTER TANGGAL ──────────────────────── --}}
        <form method="GET" action="/riwayat" class="mb-3">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">📅 Filter Tanggal</label>
                    <input
                        type="date"
                        name="tanggal"
                        class="form-control"
                        value="{{ $tanggal }}">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary">🔍 Filter</button>
                    <a href="/riwayat" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </form>

        <hr>

        {{-- ─── TABEL ────────────────────────────────── --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Suhu (°C)</th>
                        <th>Kelembapan (%)</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $item)
                    <tr>
                        <td>{{ $riwayat->firstItem() + $loop->index }}</td>
                        <td>{{ $item->suhu }} °C</td>
                        <td>{{ $item->kelembapan ?? '-' }} %</td>
                        <td>
                            <span class="badge {{ str_contains($item->status, 'ON') ? 'bg-success' : 'bg-secondary' }}">
                                {{ $item->status ?? '-' }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            📭 Data tidak ditemukan
                            @if($tanggal)
                                untuk tanggal <strong>{{ $tanggal }}</strong>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ─── PAGINATION ──────────────────────────── --}}
        {{ $riwayat->appends(['tanggal' => $tanggal])->links() }}

    </div>
</div>

@endsection