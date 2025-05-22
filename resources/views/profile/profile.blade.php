@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Profile User</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Kolom kiri: Foto profil dan form upload -->
                <div class="col-md-4 text-center">
                    <!-- Menampilkan foto profil, jika tidak ada pakai default -->
                    <img 
                        src="{{ $user->photo_profile ? asset('storage/'.$user->photo_profile) : asset('adminlte/dist/img/default-profile.jpg') }}" 
                        class="img-circle elevation-2" 
                        alt="User Image" 
                        style="width: 200px; height: 200px; object-fit: cover;">
                    
                    <!-- Form upload foto -->
                    <form 
                        action="{{ url('/updatephoto') }}" 
                        method="POST" 
                        enctype="multipart/form-data" 
                        class="mt-3">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input 
                                        type="file" 
                                        class="custom-file-input" 
                                        id="photo_profile" 
                                        name="photo_profile" 
                                        accept="image/*">
                                    <label class="custom-file-label" for="photo_profile">Pilih Foto</label>
                                </div>
                            </div>
                            <!-- Menampilkan pesan error jika ada -->
                            @error('photo_profile')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Upload Foto</button>
                    </form>
                </div>

                <!-- Kolom kanan: Data user -->
                <div class="col-md-8">
                    <h4>Data User</h4>
                    <table class="table">
                        <tr>
                            <th width="30%">Username</th>
                            <td>: {{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>: {{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Level</th>
                            <td>: {{ $user->level->level_nama ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Script untuk menampilkan nama file yang dipilih di label
        $(document).ready(function() {
            $('#photo_profile').on('change', function() {
                // Ambil nama file
                var fileName = $(this).val().split('\\').pop();
                // Tampilkan nama file di label
                $(this).next('.custom-file-label').html(fileName);

                // Preview gambar langsung saat dipilih
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        // Ganti src gambar dengan hasil upload sementara
                        $('img.img-circle').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endpush