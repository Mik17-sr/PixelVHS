<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BEBOP VIDEO — RECUPERAR ACCESO</title>
  <link rel="stylesheet" href="/PixelVHS/public/css/forgot-password.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="{{ asset('css/alertas.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Share+Tech+Mono&family=Bebas+Neue&family=Rajdhani:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>

  <header>
    <div class="logo">
      <div class="logo-mark"></div>
      <div class="logo-words">
        <h1>BEBOP <em>VIDEO</em></h1>
        <small>EST. 1987 · RECUPERAR ACCESO</small>
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
        <span class="tape-label-title">RECUPERAR · CONTRASEÑA</span>
        <span class="tape-label-num">#REC-001</span>
      </div>

      <div class="card">

        <div class="heading">
          <div class="eyebrow">RESTABLECER ACCESO</div>
          <h2>OLVIDÉ MI <em>CLAVE</em></h2>
          <p>// INGRESA TU CORREO Y TE ENVIAREMOS UN ENLACE PARA RESTABLECER TU CONTRASEÑA.</p>
        </div>

        {{-- Mensaje de éxito --}}
        @if(session('success'))
        <script>
          document.addEventListener('DOMContentLoaded', () => {
            alertaRetro({
              titulo: 'RESTABLECER CONTRASEÑA',
              texto: `
            <p>{{ session('success') }}</p>
        `,
              icono: 'success'
            });
          });
        </script>
        @endif
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

        <form method="POST" action="{{ route('password.email') }}" novalidate>
          @csrf

          <div class="field">
            <label for="email">CORREO ELECTRÓNICO</label>
            <input
              type="email"
              id="email"
              name="email"
              value="{{ old('email') }}"
              placeholder="usuario@bebop.com"
              autocomplete="email">
            <p class="field-hint">// EL ENLACE EXPIRA EN 60 MINUTOS</p>
          </div>

          <button type="submit" class="btn-submit">
            ENVIAR ENLACE
          </button>
        </form>

        <div class="divider"><span>// FIN DE FORMULARIO //</span></div>

        <div class="footer-links">
          <p>¿Recordaste tu contraseña? <a href="{{ route('login') }}">INICIAR SESIÓN</a></p>
          <p>¿No tienes cuenta? <a href="{{ route('registro') }}">REGÍSTRATE</a></p>
        </div>

      </div>
    </div>
  </main>

  <div class="status-bar">
    <span><span class="status-dot"></span>SISTEMA EN LÍNEA</span>
    <span>BEBOP VIDEO © 1987</span>
    <span>VER. 2.1.4</span>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/alertas.js') }}"></script>
</body>

</html>