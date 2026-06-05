<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <style>
    body { background:#060606; color:#DEDEDE; font-family:'Courier New',monospace; margin:0; padding:0; }
    .wrap { max-width:520px; margin:0 auto; padding:40px 20px; }
    .logo { font-size:18px; letter-spacing:4px; color:#7B5EA7; margin-bottom:32px; }
    .logo em { color:#DEDEDE; font-style:normal; }
    .card { border:1px solid #4A3468; padding:28px; margin-bottom:24px; }
    .tag { font-size:9px; letter-spacing:3px; color:#7B5EA7; border:1px solid #4A3468;
           padding:3px 10px; display:inline-block; margin-bottom:16px; }
    .titulo { font-size:32px; letter-spacing:4px; color:#DEDEDE;
              font-family:Impact,sans-serif; margin-bottom:8px; }
    .formato { font-size:11px; letter-spacing:2px; color:#666; margin-bottom:24px; }
    .btn { display:inline-block; background:#7B5EA7; color:#DEDEDE; padding:13px 32px;
           text-decoration:none; font-size:10px; letter-spacing:3px; }
    .aviso { font-size:9px; letter-spacing:1px; color:#4A3468;
             border-left:2px solid #4A3468; padding:8px 12px; margin-top:24px; }
    .footer { font-size:8px; letter-spacing:2px; color:#222; margin-top:32px; }
    .divider { height:1px; background:#1a1a1a; margin:20px 0; }
  </style>
</head>
<body>
  <div class="wrap">

    <div class="logo"><em>PIXEL</em>VHS ◈</div>

    <div class="card">
      <div class="tag">◉ DISPONIBLE AHORA</div>
      <div class="titulo">{{ strtoupper($pelicula->titulo) }}</div>
      <div class="formato">
        FORMATO · {{ strtoupper($formato->nombre) }}
        &nbsp;·&nbsp;
        {{ $pelicula->anio_lanzamiento }}
      </div>

      <div class="divider"></div>

      <p style="font-size:12px;color:#888;line-height:1.7;margin-bottom:20px;">
        Hola <strong style="color:#DEDEDE;">{{ strtoupper($usuario->nombre) }}</strong>,<br>
        la película que esperabas ya está lista para ser rentada.
        Tienes <strong style="color:#7B5EA7;">24 horas</strong> para reclamarla
        antes de que pase al siguiente en la fila.
      </p>

      <a href="{{ url('/') }}" class="btn">▶ &nbsp;RENTAR AHORA</a>

      <div class="aviso">
        ⌦ &nbsp;Si no rentas en 24h, la cinta pasará al siguiente usuario en lista de espera.
      </div>
    </div>

    <div class="footer">
      // PIXELVHS &nbsp;·&nbsp; EST. 1985 &nbsp;·&nbsp; NO RESPONDAS ESTE CORREO
    </div>

  </div>
</body>
</html>