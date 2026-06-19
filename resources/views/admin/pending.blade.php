@extends('admin.layout')

@section('title', 'Data Pending - BizzMap')

@section('content')
    <style>
        .sticky-action {
            position: sticky;
            right: 0;
            background: white;
            box-shadow: -4px 0 6px -2px rgba(0,0,0,0.08);
            z-index: 2;
        }
        thead .sticky-action { background: #f8f9fa; }
    </style>

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="mb-0">Data Pending</h3>
    </div>

    <div class="d-flex align-items-center gap-2 mb-3">
        <span class="text-muted">
            Item selected: <strong id="selectedCount">0</strong>
        </span>
        <button type="button" id="btnBulkApprove"
                class="btn btn-success btn-sm d-inline-flex align-items-center gap-1" disabled>
            <i class="fa-solid fa-check"></i><span>Approve</span>
        </button>
        <button type="button" id="btnBulkReject"
                class="btn btn-danger btn-sm d-inline-flex align-items-center gap-1" disabled>
            <i class="fa-solid fa-trash"></i><span>Reject</span>
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php
        $omsetLabel = [
            'di_bawah_5jt'  => '< Rp 5jt',
            '5jt_20jt'      => 'Rp 5–20jt',
            '20jt_50jt'     => 'Rp 20–50jt',
            '50jt_100jt'    => 'Rp 50–100jt',
            'di_atas_100jt' => '> Rp 100jt',
        ];
    @endphp

    <div class="card shadow-sm">
        <div class="card-body">
            @if($locations->isEmpty())
                <div class="alert alert-success mb-0">
                    <div class="fw-semibold">Tidak ada data pending</div>
                    <div class="small">
                        Semua data yang masuk sudah ditindaklanjuti, atau belum ada user yang mengirim data baru.
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.locations') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Data Approved
                        </a>
                    </div>
                </div>
            @else
                <div class="table-responsive" style="overflow-x:auto;">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th style="width:50px;" class="text-center">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th style="min-width:180px;">Nama</th>
                                <th style="min-width:120px;">Tipe</th>
                                <th style="min-width:110px;">Segmen</th>
                                <th style="min-width:110px;">Omset</th>
                                <th style="min-width:90px;" class="text-center">Detail</th>
                                <th style="width:170px;min-width:170px;" class="text-center sticky-action">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locations as $loc)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="row-check" value="{{ $loc->id }}">
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width:200px;" title="{{ $loc->name }}">
                                        {{ $loc->name }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $loc->type === 'customer' ? 'text-bg-success' : 'text-bg-secondary' }}">
                                        {{ $loc->type === 'customer' ? 'Customer' : 'Non-Customer' }}
                                    </span>
                                </td>
                                <td class="text-nowrap">{{ $loc->segment }}</td>
                                <td class="text-nowrap">{{ $omsetLabel[$loc->omset] ?? '-' }}</td>
                                <td class="text-center">
                                    <button type="button"
                                            class="btn btn-outline-primary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetail{{ $loc->id }}">
                                        👁 Detail
                                    </button>
                                </td>
                                <td class="text-center text-nowrap sticky-action">
                                    <div class="d-inline-flex gap-2">
                                        <form method="POST" action="{{ route('admin.approve', $loc->id) }}" class="d-inline">
                                            @csrf
                                            <button class="btn btn-success btn-sm" type="submit">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.reject', $loc->id) }}" class="d-inline"
                                              onsubmit="return confirm('Reject data ini? Data akan dihapus.');">
                                            @csrf
                                            <button class="btn btn-danger btn-sm" type="submit">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>{{-- /table-responsive --}}

                {{-- Modal Detail — WAJIB di luar </table>, loop terpisah --}}
                @foreach($locations as $loc)
                <div class="modal fade" id="modalDetail{{ $loc->id }}"
                     tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius:12px;">
                      <div class="modal-header"
                           style="background:#C02016;color:white;border-radius:12px 12px 0 0;">
                        <h6 class="modal-title" style="margin:0;">
                          📋 Detail Lokasi: {{ $loc->name }}
                        </h6>
                        <button type="button" class="btn-close btn-close-white"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <table class="table table-sm table-borderless mb-0">
                          <tr>
                            <td style="width:140px;color:#666;">Alamat</td>
                            <td>: {{ $loc->address }}</td>
                          </tr>
                          <tr>
                            <td style="color:#666;">Koordinat</td>
                            <td>: {{ $loc->latitude }}, {{ $loc->longitude }}</td>
                          </tr>
                          <tr>
                            <td style="color:#666;">Nama Pemilik</td>
                            <td>: {{ $loc->owner_name ?? '-' }}</td>
                          </tr>
                          <tr>
                            <td style="color:#666;">No. Telepon</td>
                            <td>: {{ $loc->phone ?? '-' }}</td>
                          </tr>
                          <tr>
                            <td style="color:#666;">Bidang Bisnis</td>
                            <td>: {{ $loc->business_detail ?? '-' }}</td>
                          </tr>
                          <tr>
                            <td style="color:#666;">Paket Langganan</td>
                            <td>: {{ $loc->paket_langganan ?? '-' }}</td>
                          </tr>
                        </table>

                        <hr style="margin:14px 0;">
                        <div style="font-weight:600;font-size:13px;color:#333;margin-bottom:8px;">
                            📋 Riwayat Status
                        </div>
                        <div id="historyContainer{{ $loc->id }}">
                            <div style="text-align:center;color:#9CA3AF;font-size:12px;padding:10px 0;">
                                <div class="spinner-border spinner-border-sm" role="status" style="color:#C02016;"></div>
                                <div style="margin-top:4px;">Memuat riwayat...</div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach

                @php
                    $from  = $locations->firstItem() ?? 0;
                    $to    = $locations->lastItem()  ?? 0;
                    $total = $locations->total();
                @endphp

                <div class="d-flex align-items-center justify-content-between mt-3 flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted">Rows per page</span>
                        <form id="pendingPerPageForm" method="GET" action="{{ url()->current() }}" class="d-inline">
                            @foreach(request()->except('per_page', 'page') as $k => $v)
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endforeach
                            <select name="per_page" id="pendingPerPageSelect"
                                    class="form-select form-select-sm" style="width:90px">
                                <option value="10"  {{ ($perPage ?? 10) == 10  ? 'selected' : '' }}>10</option>
                                <option value="25"  {{ ($perPage ?? 10) == 25  ? 'selected' : '' }}>25</option>
                                <option value="50"  {{ ($perPage ?? 10) == 50  ? 'selected' : '' }}>50</option>
                                <option value="100" {{ ($perPage ?? 10) == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </form>
                        <span class="text-muted">|</span>
                        <span class="text-muted">Showing {{ $from }} to {{ $to }} of {{ $total }} results</span>
                    </div>
                    <div>{{ $locations->withQueryString()->links() }}</div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            /* ---- History fetch saat modal dibuka ---- */
            document.querySelectorAll('[id^="modalDetail"]').forEach(function(modalEl) {
                modalEl.addEventListener('show.bs.modal', function() {
                    var locId     = modalEl.id.replace('modalDetail', '');
                    var container = document.getElementById('historyContainer' + locId);
                    if (!container || container.dataset.loaded === '1') return;

                    fetch('/locations/' + locId + '/history')
                    .then(function(res) { return res.json(); })
                    .then(function(histories) {
                        if (!histories.length) {
                            container.innerHTML =
                                '<div style="text-align:center;color:#9CA3AF;font-size:12px;padding:10px 0;">' +
                                'ℹ️ Belum ada perubahan status</div>';
                            container.dataset.loaded = '1';
                            return;
                        }
                        var statusColor = { approved: '#10B981', pending: '#6B7280' };
                        var statusLabel = { approved: 'Approved', pending: 'Pending' };
                        var html = '<div style="position:relative;padding-left:18px;">';
                        histories.forEach(function(h, i) {
                            var color = statusColor[h.new_status] || '#6B7280';
                            html += '<div style="position:relative;margin-bottom:10px;">' +
                                '<div style="position:absolute;left:-18px;top:3px;width:9px;height:9px;' +
                                'border-radius:50%;background:' + color + ';"></div>' +
                                (i < histories.length - 1
                                    ? '<div style="position:absolute;left:-14px;top:12px;width:2px;' +
                                      'height:calc(100% + 2px);background:#E5E7EB;"></div>' : '') +
                                '<div style="background:' + color + '15;border-radius:6px;padding:6px 9px;">' +
                                '<span style="background:' + color + ';color:white;border-radius:4px;' +
                                'font-size:10px;padding:1px 6px;font-weight:600;">' +
                                statusLabel[h.new_status] + '</span>' +
                                '<div style="font-size:11px;color:#374151;margin-top:3px;">' +
                                '👤 ' + h.user + ' · ' + h.date + '</div>' +
                                (h.note ? '<div style="font-size:11px;color:#666;margin-top:2px;">📝 ' + h.note + '</div>' : '') +
                                '</div></div>';
                        });
                        html += '</div>';
                        container.innerHTML = html;
                        container.dataset.loaded = '1';
                    })
                    .catch(function() {
                        container.innerHTML =
                            '<div style="color:#C02016;font-size:12px;text-align:center;">' +
                            'Gagal memuat riwayat.</div>';
                    });
                });
            });

            /* ---- Bulk action & per-page ---- */
            const selectAll       = document.getElementById('selectAll');
            const selectedCountEl = document.getElementById('selectedCount');
            const btnApprove      = document.getElementById('btnBulkApprove');
            const btnReject       = document.getElementById('btnBulkReject');
            const perPageSelect   = document.getElementById('pendingPerPageSelect');
            const perPageForm     = document.getElementById('pendingPerPageForm');

            const checks = () => Array.from(document.querySelectorAll('.row-check'));

            function getSelectedIds() {
                return checks().filter(c => c.checked).map(c => c.value);
            }

            function updateSelectedUI() {
                const selected = getSelectedIds().length;
                selectedCountEl.textContent = selected;
                btnApprove.disabled = selected === 0;
                btnReject.disabled  = selected === 0;
                const all = checks().length;
                if (selectAll) {
                    selectAll.checked       = all > 0 && selected === all;
                    selectAll.indeterminate = selected > 0 && selected < all;
                }
            }

            function submitBulk(actionUrl, confirmMessage = null) {
                const selectedIds = getSelectedIds();
                if (selectedIds.length === 0) { alert('Pilih minimal satu data terlebih dahulu.'); return; }
                if (confirmMessage && !confirm(confirmMessage)) return;

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = actionUrl;
                form.style.display = 'none';

                const csrf = document.createElement('input');
                csrf.type = 'hidden'; csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden'; input.name = 'selected[]'; input.value = id;
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit();
            }

            selectAll?.addEventListener('change', () => {
                checks().forEach(c => c.checked = selectAll.checked);
                updateSelectedUI();
            });

            document.addEventListener('change', e => {
                if (e.target.classList.contains('row-check')) updateSelectedUI();
            });

            btnApprove?.addEventListener('click', () => submitBulk("{{ route('admin.pending.bulkApprove') }}"));
            btnReject?.addEventListener('click',  () => submitBulk("{{ route('admin.pending.bulkReject') }}", 'Reject semua item terpilih? Data akan dihapus.'));

            if (perPageSelect && perPageForm) {
                perPageSelect.addEventListener('change', () => perPageForm.submit());
            }

            updateSelectedUI();
        });
    </script>
@endsection
