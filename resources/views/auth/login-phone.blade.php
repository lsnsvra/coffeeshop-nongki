<x-guest-layout>
  <div class="guest-title">Login WhatsApp</div>
  <div class="guest-subtitle">
    Silakan masukkan nomor WhatsApp Anda yang terdaftar untuk menerima kode OTP masuk.
  </div>

  @if($errors->any())
  <div class="error-message">
    {{ $errors->first() }}
  </div>
  @endif

  <form method="POST" action="{{ route('otp.send') }}">
    @csrf
    <div class="form-group">
      <label class="form-label" for="phone_number">Nomor WhatsApp</label>
      <input class="form-input" id="phone_number" type="text" name="phone_number" value="{{ old('phone_number') }}"
        required autofocus placeholder="Contoh: 08123456789">
    </div>

    <button type="submit" class="btn-submit">Kirim Kode OTP</button>
  </form>

  <div class="back-link">
    <a href="{{ route('login') }}"> Kembali ke Login Biasa </a>
  </div>
</x-guest-layout>