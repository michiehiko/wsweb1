<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Verifikasi OTP</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
    
    <style>
        .otp-input {
            letter-spacing: 5px; 
            font-weight: bold;
            font-size: 1.5rem;
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo text-center">
                  <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
                </div>
                
                <h4 class="text-center">Verifikasi Dua Langkah</h4>
                <h6 class="font-weight-light text-center mb-4">
                    Masukkan 6 digit kode yang telah kami kirim ke email Anda.
                </h6>

                @if(session('error'))
                    <div class="alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <form class="pt-3" action="{{ route('otp.verify') }}" method="POST">
                  @csrf <div class="form-group">
                    <input type="text" 
                           name="otp" 
                           class="form-control form-control-lg text-center otp-input" 
                           id="otpInput" 
                           placeholder="X X X X X X" 
                           maxlength="6" 
                           required 
                           autofocus>
                  </div>
                  
                  <div class="mt-3 d-grid gap-2">
                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                        VERIFIKASI
                    </button>
                  </div>
                  
                  <div class="text-center mt-4 font-weight-light">
                    Tidak menerima kode? <a href="{{ route('otp.resend') }}" class="text-primary">Kirim Ulang</a>
                    <br><br>
                    <a href="/" class="text-secondary small">Kembali ke Login</a>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
  </body>
</html>