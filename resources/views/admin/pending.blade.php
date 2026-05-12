@extends('admin.layout')

@section('title', 'Data Pending - BizzMap')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="mb-0">Data Pending</h3>
    </div>

    <div class="d-flex align-items-center gap-2 mb-3">
        <span class="text-muted">
            Item selected: <strong id="selectedCount">0</strong>
        </span>

        <button type="button" id="btnBulkApprove" class="btn btn-success btn-sm d-inline-flex align-items-center gap-1" disabled>
            <i class="fa-solid fa-check"></i>
            <span>Approve</span>
        </button>

        <button type="button" id="btnBulkReject" class="btn btn-danger btn-sm d-inline-flex align-items-center gap-1" disabled>
            <i class="fa-solid fa-trash"></i>
            <span>Reject</span>
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

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
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th style="width:50px;" class="text-center">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th style="width: 180px;">Nama</th>
                                <th>Alamat</th>
                                <th style="width: 210px;">Koordinat</th>
                                <th style="width: 140px;">Tipe</th>
                                <th style="width: 140px;">Segmen</th>
                                <th style="width: 170px;" class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($locations as $loc)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" class="row-check" value="{{ $loc->id }}">
                                    </td>

                                    <td>{{ $loc->name }}</td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 420px;" title="{{ $loc->address }}">
                                            {{ $loc->address }}
                                        </div>
                                    </td>

                                    <td class="text-nowrap">{{ $loc->latitude }}, {{ $loc->longitude }}</td>
                                    <td class="text-nowrap">{{ $loc->type }}</td>
                                    <td class="text-nowrap">{{ $loc->segment }}</td>

                                    <td class="text-center text-nowrap">
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

                    @php
                        $from = $locations->firstItem() ?? 0;
                        $to   = $locations->lastItem() ?? 0;
                        $total = $locations->total();
                    @endphp

                    <div class="d-flex align-items-center justify-content-between mt-3 flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted">Rows per page</span>

                            <form id="pendingPerPageForm" method="GET" action="{{ url()->current() }}" class="d-inline">
                                @foreach(request()->except('per_page', 'page') as $k => $v)
                                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                @endforeach

                                <select name="per_page" id="pendingPerPageSelect" class="form-select form-select-sm" style="width:90px">
                                    <option value="10"  {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25"  {{ ($perPage ?? 10) == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50"  {{ ($perPage ?? 10) == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ ($perPage ?? 10) == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </form>

                            <span class="text-muted">|</span>
                            <span class="text-muted">Showing {{ $from }} to {{ $to }} of {{ $total }} results</span>
                        </div>

                        <div>
                            {{ $locations->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('selectAll');
            const selectedCountEl = document.getElementById('selectedCount');
            const btnApprove = document.getElementById('btnBulkApprove');
            const btnReject = document.getElementById('btnBulkReject');
            const perPageSelect = document.getElementById('pendingPerPageSelect');
            const perPageForm = document.getElementById('pendingPerPageForm');

            const checks = () => Array.from(document.querySelectorAll('.row-check'));

            function getSelectedIds() {
                return checks()
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);
            }

            function updateSelectedUI() {
                const selected = getSelectedIds().length;
                selectedCountEl.textContent = selected;

                const enable = selected > 0;
                btnApprove.disabled = !enable;
                btnReject.disabled = !enable;

                const all = checks().length;
                if (selectAll) {
                    selectAll.checked = all > 0 && selected === all;
                    selectAll.indeterminate = selected > 0 && selected < all;
                }
            }

            function submitBulk(actionUrl, confirmMessage = null) {
                const selectedIds = getSelectedIds();

                if (selectedIds.length === 0) {
                    alert('Pilih minimal satu data terlebih dahulu.');
                    return;
                }

                if (confirmMessage && !confirm(confirmMessage)) return;

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = actionUrl;
                form.style.display = 'none';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'selected[]';
                    input.value = id;
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit();
            }

            selectAll?.addEventListener('change', () => {
                checks().forEach(checkbox => checkbox.checked = selectAll.checked);
                updateSelectedUI();
            });

            document.addEventListener('change', (event) => {
                if (event.target.classList.contains('row-check')) {
                    updateSelectedUI();
                }
            });

            btnApprove?.addEventListener('click', () => {
                submitBulk("{{ route('admin.pending.bulkApprove') }}");
            });

            btnReject?.addEventListener('click', () => {
                submitBulk("{{ route('admin.pending.bulkReject') }}", 'Reject semua item terpilih? Data akan dihapus.');
            });

            if (perPageSelect && perPageForm) {
                perPageSelect.addEventListener('change', () => perPageForm.submit());
            }

            updateSelectedUI();
        });
    </script>
@endsection
