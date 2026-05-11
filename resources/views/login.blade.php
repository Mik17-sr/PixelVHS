<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>
  <link rel="stylesheet" href="/PixelVHS/public/css/login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="{{ asset('css/alertas.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Share+Tech+Mono&family=Bebas+Neue&family=Rajdhani:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  @if(session('success'))
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      alertaRetro({
        titulo: 'INFORMACION CUENTA',

        texto: `
            <p>{{ session('success') }}</p>
        `,
        icono: 'success'
      });

    });
  </script>
  @endif
  <!-- HEADER -->
  <header>
    <div class="logo">
      <div class="logo-mark"></div>
      <div class="logo-words">
        <h1>PIXEL<em>VHS</em></h1>
        <small>EST. 1987 · MIEMBRO REQUERIDO</small>
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

    <div class="login-wrap">

      <!-- Tape label decorative top -->
      <div class="tape-label">
        <span class="tape-label-title">ACCESO · MIEMBROS</span>
        <div class="tape-reels">
          <div class="tape-reel spin"></div>
          <div class="tape-reel spin"></div>
        </div>
        <span class="tape-label-num">#SYS-001</span>
      </div>

      <div class="login-card">

        <div class="login-heading">
          <div class="eyebrow">IDENTIFICACIÓN DE USUARIO</div>
          <h2 data-text="INICIAR SESIÓN">INICIAR <em>SESIÓN</em></h2>
          <p>// INTRODUCE TUS CREDENCIALES PARA CONTINUAR</p>
        </div>
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
        <form method="POST" action="{{ route('login') }}" novalidate>
          @csrf

          <div class="field">
            <label for="email">USUARIO</label>
            <input
              type="text"
              id="usuario"
              name="usuario"
              value="{{ old('usuario') }}"
              placeholder="Usuario"
              autocomplete="username">
          </div>

          <div class="field">
            <label for="password">CONTRASEÑA</label>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="••••••••"
              autocomplete="current-password">
          </div>

          <button type="submit" class="btn-submit">
            ENTRAR AL SISTEMA
          </button>

          <div style="text-align:center; margin-top:14px;">
            <a href="{{ route('password.request') }}"
              style="font-family:'Share Tech Mono',monospace; font-size:9px; color:#4A3468; letter-spacing:2px; text-decoration:none; border-bottom:1px solid transparent; transition:border-color .18s;"
              onmouseover="this.style.color='#7B5EA7'; this.style.borderColor='#7B5EA7';"
              onmouseout="this.style.color='#4A3468'; this.style.borderColor='transparent';">
              ¿OLVIDASTE TU CONTRASEÑA?
            </a>
          </div>
        </form>

        <div class="divider"><span>// FIN DE FORMULARIO //</span></div>

        <div class="login-footer">
          <p>¿No tienes cuenta? <a href="{{ route('registro') }}">REGÍSTRATE AQUÍ</a></p>
        </div>

      </div>
    </div>
  </main>
  <div class="status-bar">
    <span><span class="status-dot"></span>SISTEMA EN LÍNEA</span>
    <span>PIXELVHS © 1987</span>
    <span>VER. 2.1.4</span>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/alertas.js') }}"></script>
</body>

</html>