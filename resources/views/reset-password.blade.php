<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BEBOP VIDEO — NUEVA CONTRASEÑA</title>
<link rel="stylesheet" href="/PixelVHS/public/css/reset-password.css">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Share+Tech+Mono&family=Bebas+Neue&family=Rajdhani:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <div class="logo">
      <div class="logo-mark"></div>
      <div class="logo-words">
        <h1>BEBOP <em>VIDEO</em></h1>
        <small>EST. 1987 · NUEVA CONTRASEÑA</small>
      </div>
    </div>
    <div class="header-right">
      TERMINAL <span>// 01</span>
    </div>
  </header>

  <main>
    <div class="bg-grid"></div>
    <div class="bg-glow"></div>

    <div class="wrap">

      <div class="tape-label">
        <span class="tape-label-title">NUEVA · CONTRASEÑA</span>
        <span class="tape-label-num">#REC-002</span>
      </div>

      <div class="card">

        <div class="heading">
          <div class="eyebrow">RESTABLECER ACCESO</div>
          <h2>NUEVA <em>CLAVE</em></h2>
          <p>// INGRESA Y CONFIRMA TU NUEVA CONTRASEÑA PARA RECUPERAR EL ACCESO.</p>
        </div>
        {{-- Errores --}}
        @if ($errors->any())
          <div class="errors">
            @foreach ($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" novalidate>
          @csrf

          {{-- Token oculto, obligatorio para que Laravel valide el reset --}}
          <input type="hidden" name="token" value="{{ $token }}">

          <div class="field">
            <label for="email">CORREO ELECTRÓNICO</label>
            <input
              type="email"
              id="email"
              name="email"
              value="{{ old('email') }}"
              placeholder="usuario@bebop.com"
              autocomplete="email"
            >
          </div>

          <div class="field">
            <label for="password">NUEVA CONTRASEÑA</label>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="••••••••"
              autocomplete="new-password"
              oninput="checkStrength(this.value)"
            >
            <div class="strength-bar">
              <div class="strength-seg" id="s1"></div>
              <div class="strength-seg" id="s2"></div>
              <div class="strength-seg" id="s3"></div>
              <div class="strength-seg" id="s4"></div>
            </div>
            <div class="strength-label" id="strengthLabel">// SEGURIDAD</div>
          </div>

          <div class="field">
            <label for="password_confirmation">CONFIRMAR CONTRASEÑA</label>
            <input
              type="password"
              id="password_confirmation"
              name="password_confirmation"
              placeholder="••••••••"
              autocomplete="new-password"
            >
          </div>

          <button type="submit" class="btn-submit">
            GUARDAR CONTRASEÑA
          </button>
        </form>

        <div class="divider"><span>// FIN DE FORMULARIO //</span></div>

        <div class="footer-link">
          <p>¿Recordaste tu contraseña? <a href="{{ route('login') }}">INICIAR SESIÓN</a></p>
        </div>

      </div>
    </div>
  </main>

  <div class="status-bar">
    <span><span class="status-dot"></span>SISTEMA EN LÍNEA</span>
    <span>BEBOP VIDEO © 1987</span>
    <span>VER. 2.1.4</span>
  </div>

  <script>
    function checkStrength(val) {
      const segs = [
        document.getElementById('s1'),
        document.getElementById('s2'),
        document.getElementById('s3'),
        document.getElementById('s4'),
      ];
      const label = document.getElementById('strengthLabel');

      segs.forEach(s => s.style.background = '#222');

      let score = 0;
      if (val.length >= 6)  score++;
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
