<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>Registrasi Akun Mahasiswa - PERPUSKIM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('home/img/image.png')}}" type="image/png">
    <link rel="stylesheet" href="{{asset('traveland/assets/css/bootstrap.4.5.2.min.css')}}">
    <link rel="stylesheet" href="{{asset('traveland/assets/css/default.css')}}">
    <link rel="stylesheet" href="{{asset('traveland/assets/css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .register-card {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .register-card h3 {
            margin-bottom: 30px;
            color: #333;
            font-weight: bold;
            text-align: center;
        }
        .form-control {
            height: 50px;
            border-radius: 5px;
        }
        .file-upload-wrapper {
            border: 2px dashed #ccc;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            background: #f9f9f9;
            margin-bottom: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .file-upload-wrapper:hover {
            border-color: #667eea;
        }
        #preview-image {
            max-width: 100%;
            max-height: 200px;
            display: none;
            margin-top: 15px;
            border-radius: 5px;
        }
        .camera-container {
            display: none;
            text-align: center;
            margin-bottom: 20px;
        }
        #camera-video {
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            border: 2px solid #ccc;
            background: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="register-card">
                    <h3>Registrasi Akun Mahasiswa via Kartu</h3>
                    <p class="text-center text-muted mb-4">Mohon isi data sesuai dengan yang tertera di Kartu Perpustakaan Anda. Pastikan mengunggah foto kartu yang jelas (termasuk foto wajah Anda).</p>
                    
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ url('/mahasiswa/register') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>NPM (14 digit)</label>
                                <input class="form-control" type="text" name="npm" pattern="\d{14}" maxlength="14" value="{{ old('npm') }}" required>
                                @error('npm') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Nama Lengkap</label>
                                <input class="form-control" type="text" name="nama" value="{{ old('nama') }}" required>
                                @error('nama') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Fakultas</label>
                                <input class="form-control" type="text" name="fakultas" value="{{ old('fakultas') }}" required>
                                @error('fakultas') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Email</label>
                                <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat" rows="2" style="height: auto;" required>{{ old('alamat') }}</textarea>
                            @error('alamat') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>No HP / WhatsApp</label>
                                <input class="form-control" type="text" name="no_telp" value="{{ old('no_telp') }}" required>
                                @error('no_telp') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Password Akun</label>
                                <input class="form-control" type="password" name="password" required>
                                @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Upload Foto Kartu Perpustakaan (Harus terlihat jelas wajah dan data Anda)</label>
                            
                            <div class="d-flex mb-2 gap-2 justify-content-center">
                                <button type="button" class="btn btn-secondary btn-sm" id="btn-open-camera" style="margin-right: 10px;"><i class="fas fa-camera"></i> Buka Kamera</button>
                            </div>

                            <div class="camera-container" id="camera-container">
                                <video id="camera-video" autoplay playsinline></video>
                                <canvas id="camera-canvas" style="display:none;"></canvas>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-success btn-sm" id="btn-capture"><i class="fas fa-camera"></i> Ambil Foto</button>
                                    <button type="button" class="btn btn-danger btn-sm" id="btn-close-camera"><i class="fas fa-times"></i> Tutup Kamera</button>
                                </div>
                            </div>

                            <div class="file-upload-wrapper" id="upload-wrapper">
                                <div id="upload-text">Klik di sini untuk Memilih Foto (Atau gunakan tombol Buka Kamera di atas)<br><small>Format: JPG, PNG. Maksimal 2MB</small></div>
                                <input type="file" name="foto_kartu" id="foto_kartu" accept="image/*" style="width: 0.1px; height: 0.1px; opacity: 0; overflow: hidden; position: absolute; z-index: -1;" required capture="environment">
                                <img id="preview-image" src="#" alt="Preview">
                            </div>
                            @error('foto_kartu') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <button class="main-btn w-100 text-center mt-3" type="submit">Kirim Registrasi</button>
                        <div class="mt-4 text-center">
                            <a href="{{ url('/') }}" style="color: #333; text-decoration: underline;">Kembali ke Halaman Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('traveland/assets/js/vendor/jquery-1.12.4.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            // Logika Klik Manual (File Input)
            $('#upload-wrapper').click(function(e) {
                if (e.target.id !== 'foto_kartu') {
                    $('#foto_kartu').click();
                }
            });

            $('#foto_kartu').change(function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-image').attr('src', e.target.result).show();
                        $('#upload-text').hide();
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Logika Kamera (Webcam)
            let video = document.getElementById('camera-video');
            let canvas = document.getElementById('camera-canvas');
            let stream = null;

            $('#btn-open-camera').click(function() {
                $('#camera-container').show();
                
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
                    .then(function(cameraStream) {
                        stream = cameraStream;
                        video.srcObject = stream;
                    })
                    .catch(function(err) {
                        alert("Tidak dapat mengakses kamera: " + err.message);
                        $('#camera-container').hide();
                    });
                } else {
                    alert("Browser Anda tidak mendukung akses kamera.");
                    $('#camera-container').hide();
                }
            });

            $('#btn-close-camera').click(function() {
                if (stream) {
                    let tracks = stream.getTracks();
                    tracks.forEach(track => track.stop());
                }
                video.srcObject = null;
                $('#camera-container').hide();
            });

            $('#btn-capture').click(function() {
                if (!stream) return;
                
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                
                let dataUrl = canvas.toDataURL('image/jpeg');
                $('#preview-image').attr('src', dataUrl).show();
                $('#upload-text').hide();
                
                // Konversi Data URL ke File object
                fetch(dataUrl)
                    .then(res => res.blob())
                    .then(blob => {
                        let file = new File([blob], "capture.jpg", { type: "image/jpeg" });
                        let dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        document.getElementById('foto_kartu').files = dataTransfer.files;
                    });
                
                $('#btn-close-camera').click(); // Tutup kamera setelah ambil foto
            });
        });
    </script>
</body>
</html>
