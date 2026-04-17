<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verifikasi Email - NONGKI Coffee</title>
</head>

<body
  style="background-color: #0F0C07; color: #F5EDD8; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">

  <div
    style="background-color: #1A1611; padding: 40px; border-radius: 12px; text-align: center; max-width: 400px; width: 100%; border: 1px solid #C9A84C;">

    <svg style="width: 64px; height: 64px; color: #C9A84C; margin-bottom: 20px;" fill="none" stroke="currentColor"
      viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
    </svg>

    <h2 style="color: #C9A84C; margin-bottom: 10px;">Cek Inbox Email Anda</h2>
    <p style="font-size: 14px; margin-bottom: 30px; color: #A8A092;">
      Kami telah mengirimkan 6 digit kode keamanan ke alamat email Anda. Masukkan kode tersebut di bawah ini.
    </p>

    @if (session('message'))
    <div
      style="background-color: rgba(201, 168, 76, 0.2); color: #E8C96A; padding: 10px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
      {{ session('message') }}
    </div>
    @endif

    <form action="{{ route('2fa.store') }}" method="POST">
      @csrf
      <div style="margin-bottom: 20px;">
        <input type="number" name="code" placeholder="Masukkan 6 Digit OTP" required
          style="width: 100%; padding: 15px; background-color: #0F0C07; border: 1px solid #4A3F2C; color: #F5EDD8; border-radius: 8px; text-align: center; font-size: 20px; letter-spacing: 5px; box-sizing: border-box;">
        @error('code')
        <span style="color: #E05252; font-size: 12px; display: block; margin-top: 8px;">{{ $message }}</span>
        @enderror
      </div>

      <button type="submit"
        style="width: 100%; padding: 15px; background-color: #C9A84C; color: #0F0C07; border: none; border-radius: 8px; font-weight: bold; font-size: 16px; cursor: pointer;">
        Verifikasi Email
      </button>
    </form>

    <p style="margin-top: 20px; font-size: 12px; color: #6D6455;">
      Tidak menerima email? Coba cek folder Spam atau <a href="{{ route('login') }}"
        style="color: #C9A84C; text-decoration: none;">Login ulang</a>.
    </p>
  </div>

</body>

</html>