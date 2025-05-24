<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Validasi - {{ $kriteria->nama_kriteria ?? 'Kriteria ' . $kriteria->id_kriteria }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body row">
            <!-- Kolom Kiri: Informasi dan Tombol -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Kriteria:</label>
                    <p>{{ $kriteria->nama_kriteria ?? 'Kriteria ' . $kriteria->id_kriteria }}</p>
                </div>
                <div class="form-group">
                    <label>Tanggal Submit:</label>
                    <p>{{ $kriteria->status_selesai === 'Submitted' ? ($kriteria->updated_at ?? $kriteria->created_at)->format('d/m/Y H:i:s') : '-' }}</p>
                </div>
                <div class="form-group">
                    <label>Komentar:</label>
                    <textarea class="form-control" id="comment_{{ $kriteria->id_kriteria }}" rows="4" placeholder="Masukkan komentar..."></textarea>
                </div>
                <div class="form-group">
                    <button onclick="validateAction('{{ url('/validasitahapsatu/' . $kriteria->id_kriteria . '/approve_ajax') }}', {{ $kriteria->id_kriteria }})" class="btn btn-success mr-2">Validasi</button>
                    <button onclick="rejectAction('{{ url('/validasitahapsatu/' . $kriteria->id_kriteria . '/reject_ajax') }}', {{ $kriteria->id_kriteria }})" class="btn btn-danger">Tolak</button>
                </div>
            </div>
            <!-- Kolom Kanan: PDF Viewer -->
            <div class="col-md-6">
                <div class="embed-responsive embed-responsive-4by3">
                    <iframe class="embed-responsive-item" src="{{ $kriteria->generatedDocument ? asset('storage/' . $kriteria->generatedDocument->file_path) : '#' }}" frameborder="0"></iframe>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            @if($googleDriveLink)
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#googleDriveModal" onclick="setGoogleDriveLink('{{ $googleDriveLink }}')">Lihat Google Drive</button>
            @endif
        </div>
    </div>
</div>

<!-- Modal untuk Google Drive Link -->
<div class="modal fade" id="googleDriveModal" tabindex="-1" role="dialog" aria-labelledby="googleDriveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="googleDriveModalLabel">Link Google Drive</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <a href="" id="googleDriveLink" target="_blank">Klik untuk membuka</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
@endpush

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<script>
    function setGoogleDriveLink(link) {
        $('#googleDriveLink').attr('href', link);
    }

    function validateAction(url, id) {
        const comment = $('#comment_' + id).val();
        if (confirm('Apakah Anda yakin ingin memvalidasi data ini?')) {
            $.post(url, {
                _token: '{{ csrf_token() }}',
                comment: comment
            }, function(data) {
                if (data.status) {
                    $('#table_validasi').DataTable().ajax.reload();
                    $('#myModal').modal('hide');
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            });
        }
    }

    function rejectAction(url, id) {
        const comment = $('#comment_' + id).val();
        if (confirm('Apakah Anda yakin ingin menolak data ini?')) {
            $.post(url, {
                _token: '{{ csrf_token() }}',
                comment: comment
            }, function(data) {
                if (data.status) {
                    $('#table_validasi').DataTable().ajax.reload();
                    $('#myModal').modal('hide');
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            });
        }
    }
</script>
@endpush