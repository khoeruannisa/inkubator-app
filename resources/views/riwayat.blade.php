@extends('layout')

@section('content')

<h4 class="mb-4 fw-bold text-dark">
    <i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>Riwayat Data Inkubator
</h4>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold text-dark">
            <i class="fa-solid fa-filter text-secondary me-2"></i>Filter Riwayat
        </h6>
        <span class="badge bg-light text-dark border py-2 px-3 rounded-pill fw-semibold">
            Total: {{ $riwayat->total() }} Data
        </span>
    </div>

    <div class="card-body p-4">

        {{-- ─── FILTER TANGGAL ──────────────────────── --}}
        <form method="GET" action="/riwayat" class="mb-2">
            <div class="row g-3 align-items-end">
                <div class="col-md-4 col-sm-6">
                    <label class="form-label small fw-bold text-secondary mb-2">
                        <i class="fa-regular fa-calendar-days text-primary me-1"></i>Pilih Tanggal
                    </label>
                    <input
                        type="date"
                        name="tanggal"
                        class="form-control py-2.5"
                        value="{{ $tanggal }}"
                        style="border-radius: 12px; border: 1px solid #e2e8f0;">
                </div>
                <div class="col-md-4 col-sm-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 py-2.5 fw-semibold" style="border-radius: 12px; background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%); border: none;">
                        <i class="fa-solid fa-magnifying-glass me-2"></i>Cari
                    </button>
                    @if($tanggal)
                        <a href="/riwayat" class="btn btn-outline-secondary px-4 py-2.5 fw-semibold" style="border-radius: 12px;">
                            <i class="fa-solid fa-arrow-rotate-left me-2"></i>Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>

    </div>
</div>

{{-- ─── TABEL RIWAYAT ─────────────────────────── --}}
<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-secondary small text-uppercase">
                <tr>
                    <th class="py-3 px-4">No</th>
                    <th class="py-3">Suhu</th>
                    <th class="py-3">Kelembapan</th>
                    <th class="py-3">Status Sistem</th>
                    <th class="py-3">Tanggal</th>
                    <th class="py-3 px-4">Jam</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $item)
                <tr>
                    <td class="py-3 px-4 fw-medium text-secondary">{{ $riwayat->firstItem() + $loop->index }}</td>
                    <td class="py-3 fw-bold text-danger">
                        <i class="fa-solid fa-temperature-half me-1"></i>{{ $item->suhu ?? '-' }} °C
                    </td>
                    <td class="py-3 fw-bold text-primary">
                        <i class="fa-solid fa-droplet me-1"></i>{{ $item->kelembapan ?? '-' }} %
                    </td>
                    <td class="py-3">
                        <span class="badge {{ str_contains($item->status ?? '', 'ON') ? 'badge-soft-success' : 'badge-soft-secondary' }} px-3 py-2 rounded-pill">
                            <i class="fa-solid {{ str_contains($item->status ?? '', 'ON') ? 'fa-bolt' : 'fa-circle-pause' }} me-1"></i>{{ $item->status ?? '-' }}
                        </span>
                    </td>
                    <td class="py-3 text-dark fw-medium">
                        <i class="fa-regular fa-calendar me-1 text-secondary"></i>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d F Y') : '-' }}
                    </td>
                    <td class="py-3 px-4 text-secondary">
                        <i class="fa-regular fa-clock me-1 text-secondary"></i>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('H:i:s') : '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="fa-solid fa-folder-open fs-2 text-secondary mb-3 d-block"></i>
                        Data tidak ditemukan
                        @if($tanggal)
                            untuk tanggal <strong>{{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</strong>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($riwayat->hasPages())
        <div class="card-footer bg-white border-0 py-4 px-4 d-flex justify-content-center">
            {{ $riwayat->appends(['tanggal' => $tanggal])->links() }}
        </div>
    @endif
</div>

<style>
    .badge-soft-success {
        background-color: #d1fae5;
        color: #065f46;
    }
    .badge-soft-secondary {
        background-color: #e5e7eb;
        color: #374151;
    }
    /* Pagination customizations */
    .pagination {
        margin-bottom: 0;
        gap: 4px;
    }
    .page-item .page-link {
        border-radius: 8px;
        color: #4f46e5;
        border: 1px solid #e2e8f0;
        padding: 8px 16px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .page-item.active .page-link {
        background-color: #4f46e5;
        border-color: #4f46e5;
        color: white;
    }
    .page-item:first-child .page-link, .page-item:last-child .page-link {
        border-radius: 8px !important;
    }
</style>

@endsection