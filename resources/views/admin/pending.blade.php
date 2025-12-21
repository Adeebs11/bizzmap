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

    <div class="card shadow-sm">
        <div class="card-body">
            @if($locations->isEmpty())
                <p class="mb-0 text-muted">Belum ada data pending.</p>
            @else
                <div class="table-responsive">
                    <form id="bulkForm" method="POST">
                        @csrf
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
                                        <input type="checkbox" class="row-check" name="selected[]" value="{{ $loc->id }}">
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
                                                <form method="POST" action="{{ route('admin.approve', $loc->id) }}">
                                                @csrf
                                                <button class="btn btn-success btn-sm" type="submit">Approve</button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.reject', $loc->id) }}"
                                                onsubmit="return confirm('Reject data ini? Data akan dihapus.');">
                                                @csrf
                                                <button class="btn btn-danger btn-sm" type="submit">Reject</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                    <script>
                                        const selectAll = document.getElementById('selectAll');
                                        const checks = () => Array.from(document.querySelectorAll('.row-check'));
                                        const selectedCountEl = document.getElementById('selectedCount');
                                        const btnApprove = document.getElementById('btnBulkApprove');
                                        const btnReject = document.getElementById('btnBulkReject');
                                        const bulkForm = document.getElementById('bulkForm');

                                        function updateSelectedUI() {
                                            const selected = checks().filter(c => c.checked).length;
                                            selectedCountEl.textContent = selected;

                                            const enable = selected > 0;
                                            btnApprove.disabled = !enable;
                                            btnReject.disabled = !enable;

                                            // Update selectAll state (checked kalau semua checked)
                                            const all = checks().length;
                                            selectAll.checked = (all > 0 && selected === all);
                                            selectAll.indeterminate = (selected > 0 && selected < all);
                                        }

                                        selectAll?.addEventListener('change', () => {
                                            checks().forEach(c => c.checked = selectAll.checked);
                                            updateSelectedUI();
                                        });

                                        document.addEventListener('change', (e) => {
                                            if (e.target.classList.contains('row-check')) {
                                            updateSelectedUI();
                                            }
                                        });

                                        btnApprove?.addEventListener('click', () => {
                                            bulkForm.action = "{{ route('admin.pending.bulkApprove') }}";
                                            bulkForm.submit();
                                        });

                                        btnReject?.addEventListener('click', () => {
                                            if (!confirm('Reject semua item terpilih? Data akan dihapus.')) return;
                                            bulkForm.action = "{{ route('admin.pending.bulkReject') }}";
                                            bulkForm.submit();
                                        });

                                        // init
                                        updateSelectedUI();
                                    </script>

                            </tbody>
                        </table>
                    </form>    
                </div>
            @endif
        </div>
    </div>
@endsection
