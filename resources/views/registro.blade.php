<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PIXELVHS — NUEVA CUENTA</title>
  <link rel="stylesheet" href="/PixelVHS/public/css/registro.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="{{ asset('css/alertas.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Share+Tech+Mono&family=Bebas+Neue&family=Rajdhani:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>

  <!-- HEADER -->
  <header>
    <div class="logo">
      <div class="logo-mark"></div>
      <div class="logo-words">
        <h1>PIXEL<em>VHS</em></h1>
        <small>EST. 1987 · NUEVA CUENTA</small>
      </div>
    </div>
    <div class="header-right">
      TERMINAL <span>// 01</span>
    </div>
  </header>

  <!-- MAIN -->
  <main>
    <div class="bg-grid"></div>
    <div class="bg-glow"></div>

    <div class="register-wrap">

      <!-- Top strip -->
      <div class="membership-strip">
        <span class="membership-strip-title">REGISTRO · NUEVA CUENTA</span>
        <div class="membership-strip-right">
          <div class="tape-reels">
            <div class="tape-reel spin"></div>
            <div class="tape-reel spin"></div>
          </div>
          <span>#NEW-MBR</span>
        </div>
      </div>

      <div class="register-card">

        <div class="register-heading">
          <div class="eyebrow">CREAR CUENTA DE SOCIO</div>
          <h2 data-text="REGÍSTRATE">REGÍST<em>RATE</em></h2>
          <p>// COMPLETA EL FORMULARIO PARA UNIRTE AL CLUB</p>
        </div>

        <!-- Step indicator decorativo -->
        <div class="step-indicator">
          <div class="step active">
            <div class="step-num">01</div>
            <span>DATOS</span>
          </div>
          <div class="step-line"></div>
          <div class="step">
            <div class="step-num">02</div>
            <span>ACCESO</span>
          </div>
          <div class="step-line"></div>
          <div class="step">
            <div class="step-num">03</div>
            <span>CONFIRMAR</span>
          </div>
        </div>
        {{-- Errores de validación --}}
        @if ($errors->any())
        <script>
          document.addEventListener('DOMContentLoaded', () => {
            alertaRetro({
              titulo: 'ERROR DE REGISTRO',
              texto: `
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
        `,
              icono: 'error'
            });

          });
        </script>
        @endif

        <form method="POST" action="{{ route('registro') }}" novalidate>
          @csrf
          <div class="field">
            <label for="name">NOMBRE COMPLETO</label>
            <input
              type="text"
              id="name"
              name="name"
              value="{{ old('name') }}"
              placeholder="Tu Nombre"
              autocomplete="name">
          </div>

          <div class="field">
            <label for="email">CORREO ELECTRÓNICO</label>
            <input
              type="email"
              id="email"
              name="email"
              value="{{ old('email') }}"
              placeholder="usuario@pixelvhs.com"
              autocomplete="email">
          </div>

          <div class="field">
            <label for="email">USUARIO</label>
            <input
              type="text"
              id="usuario"
              name="username"
              value="{{ old('username') }}"
              placeholder="Usuario"
              autocomplete="username">
          </div>

          <div class="field-row">
            <div class="field">
              <label for="password">CONTRASEÑA</label>
              <input
                type="password"
                id="password"
                name="password"
                placeholder="••••••••"
                autocomplete="new-password"
                oninput="checkStrength(this.value)">
              <div class="strength-bar">
                <div class="strength-seg" id="s1"></div>
                <div class="strength-seg" id="s2"></div>
                <div class="strength-seg" id="s3"></div>
                <div class="strength-seg" id="s4"></div>
              </div>
              <div class="strength-label" id="strengthLabel">// SEGURIDAD</div>
            </div>

            <div class="field">
              <label for="password_confirmation">CONFIRMAR</label>
              <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="••••••••"
                autocomplete="new-password">
            </div>
          </div>

          <button type="submit" class="btn-submit">
            CREAR CUENTA
          </button>

          <p class="terms-note">
            AL REGISTRARTE ACEPTAS LOS TÉRMINOS DE USO DE PIXELVHS · EST. 1987
          </p>
        </form>
        <div class="divider"><span>// FIN DE FORMULARIO //</span></div>
        <div class="register-footer">
          <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">INICIAR SESIÓN</a></p>
        </div>

      </div>
    </div>
  </main>

  <!-- STATUS BAR -->
  <div class="status-bar">
    <span><span class="status-dot"></span>SISTEMA EN LÍNEA</span>
    <span>PIXELVHS © 1987</span>
    <span>VER. 2.1.4</span>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/alertas.js') }}"></script>
  <script>
    function checkStrength(val) {
      const segs = [
        document.getElementById('s1'),
        document.getElementById('s2'),
        document.getElementById('s3'),
        document.getElementById('s4'),
      ];
      const label = document.getElementById('strengthLabel');

      // Reset
      segs.forEach(s => s.style.background = '#222');

      let score = 0;
      if (val.length >= 6) score++;
      if (val.length >= 10) score++;
      if (/[A-Z]/.test(val) && /[0-9]/.test(val)) score++;
      if (/[^A-Za-z0-9]/.test(val)) score++;

      const colors = ['#a55e5e', '#a5875e', '#7B5EA7', '#5ea77b'];
      const labels = ['// DÉBIL', '// REGULAR', '// FUERTE', '// ÓPTIMA'];

      for (let i = 0; i < score; i++) {
        segs[i].style.background = colors[score - 1];
      }
      label.textContent = score > 0 ? labels[score - 1] : '// SEGURIDAD';
      label.style.color = score > 0 ? colors[score - 1] : '#666';
    }
  </script>

</body>

</html>