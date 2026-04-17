<x-guest-layout>
  <x-slot name="title">
    <h2 class="text-center text-2xl font-bold text-gold">Verifikasi Kode</h2>
  </x-slot>

  <div
    style="font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 500; text-align: center; color: #F5EDD8; margin-bottom: 0.5rem;">
    Masukkan Kode OTP
  </div>

  <div
    style="text-align: center; color: rgba(245,237,216,0.5); font-size: 0.85rem; margin-bottom: 2rem; line-height: 1.5;">
    Silakan masukkan 6 digit kode verifikasi yang telah dikirimkan ke WhatsApp: <strong
      style="color: #C9A84C;">{{ session('phone_number') }}</strong>.
  </div>

  @if (session('message'))
  <div
    style="background: rgba(82,183,136,0.15); border: 1px solid rgba(82,183,136,0.3); color: #7bdcb5; border-radius: 12px; padding: 0.8rem 1rem; margin-bottom: 1.5rem; font-size: 0.85rem; backdrop-filter: blur(4px);">
    {{ session('message') }}
  </div>
  @endif

  @if($errors->any())
  <div
    style="background: rgba(224,82,82,0.15); border: 1px solid rgba(224,82,82,0.3); color: #ff8a8a; border-radius: 12px; padding: 0.8rem 1rem; margin-bottom: 1.5rem; font-size: 0.85rem; backdrop-filter: blur(4px);">
    {{ $errors->first() }}
  </div>
  @endif

  <form method="POST" action="{{ route('2fa.store') }}">
    @csrf

    <div style="margin-bottom: 1.25rem;">
      <label
        style="display: block; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(245,237,216,0.7); margin-bottom: 0.5rem;"
        for="code">
        KODE OTP WHATSAPP
      </label>

      <input id="code" type="text" name="code" required autofocus placeholder="123456" maxlength="6"
        style="width: 100%; padding: 0.9rem 1rem; background: rgba(0,0,0,0.4); border: 1px solid rgba(201,168,76,0.25); border-radius: 14px; color: #F5EDD8; font-size: 1.2rem; letter-spacing: 0.3em; text-align: center; outline: none; transition: all 0.2s ease;"
        onfocus="this.style.borderColor='#C9A84C'; this.style.background='rgba(0,0,0,0.6)'; this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.15)';"
        onblur="this.style.borderColor='rgba(201,168,76,0.25)'; this.style.background='rgba(0,0,0,0.4)'; this.style.boxShadow='none';">
    </div>

    <button type="submit"
      style="width: 100%; padding: 0.9rem; background: linear-gradient(105deg, #C9A84C 0%, #E8C96A 100%); border: none; border-radius: 40px; color: #0F0C07; font-weight: 700; font-size: 0.95rem; cursor: pointer; transition: all 0.3s ease; letter-spacing: 0.5px; margin-top: 0.5rem;"
      onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(201,168,76,0.35)'; this.style.filter='brightness(1.05)';"
      onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.filter='brightness(1)';"
      onclick="this.style.transform='translateY(1px)';">
      Verifikasi Kode
    </button>
  </form>

  <div style="text-align: center; margin-top: 1.8rem; font-size: 0.85rem;">
    <span style="color: rgba(245,237,216,0.5);">Tidak menerima kode?</span>
    <button type="submit" form="resend-form"
      style="background: none; border: none; padding: 0; color: #C9A84C; cursor: pointer; text-decoration: underline; font-family: inherit; font-size: inherit; margin-left: 5px; transition: color 0.2s;"
      onmouseover="this.style.color='#E8C96A';" onmouseout="this.style.color='#C9A84C';">
      Kirim ulang kode
    </button>
  </div>

  <form id="resend-form" method="POST" action="{{ route('2fa.resend') }}">
    @csrf
  </form>
</x-guest-layout>