<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a PIXELVHS</title>
</head>
<body style="
    margin:0;
    padding:0;
    background:#09040f;
    font-family:'Courier New', Courier, monospace;
">

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" style="padding:40px 20px;">

            <table width="600" cellpadding="0" cellspacing="0" style="
                background:#09040f;
                border:1px solid rgba(73,51,102,.45);
                border-radius:6px;
                overflow:hidden;
            ">

                <!-- Barra superior -->
                <tr>
                    <td style="
                        background:#0e0718;
                        border-bottom:1px solid rgba(73,51,102,.35);
                        padding:8px 18px;
                    ">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <span style="
                                        color:rgba(73,51,102,.7);
                                        font-size:10px;
                                        letter-spacing:4px;
                                        text-transform:uppercase;
                                    ">□ &nbsp; □</span>
                                </td>
                                <td align="right">
                                    <span style="
                                        color:rgba(73,51,102,.6);
                                        font-size:10px;
                                        letter-spacing:3px;
                                        text-transform:uppercase;
                                    ">#NEW-MBR</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Header -->
                <tr>
                    <td style="padding:32px 35px 24px 35px; border-bottom:1px solid rgba(73,51,102,.3);">

                        <p style="
                            margin:0 0 10px 0;
                            color:rgba(73,51,102,.8);
                            font-size:10px;
                            letter-spacing:3px;
                            text-transform:uppercase;
                        ">— PIXELVHS · SISTEMA DE MEMBRESÍAS</p>

                        <h1 style="
                            margin:0;
                            color:#f4f1ff;
                            font-size:38px;
                            font-family:Impact, 'Arial Black', sans-serif;
                            letter-spacing:4px;
                            text-transform:uppercase;
                            font-weight:900;
                            line-height:1;
                        ">REGÍST<span style="color:#8a60aa;">RATE</span></h1>

                        <p style="
                            margin:10px 0 0 0;
                            color:rgba(215,207,253,.5);
                            font-size:10px;
                            letter-spacing:3px;
                            text-transform:uppercase;
                        ">// ACCESO AL CLUB ACTIVADO · EST. 1987</p>

                    </td>
                </tr>

                <!-- Saludo -->
                <tr>
                    <td style="padding:30px 35px 0 35px;">

                        <p style="
                            margin:0 0 6px 0;
                            color:rgba(73,51,102,.8);
                            font-size:10px;
                            letter-spacing:3px;
                            text-transform:uppercase;
                        ">NUEVA MEMBRESÍA DETECTADA</p>

                        <h2 style="
                            margin:0 0 20px 0;
                            color:#f4f1ff;
                            font-size:22px;
                            font-family:Impact, 'Arial Black', sans-serif;
                            letter-spacing:3px;
                            text-transform:uppercase;
                            font-weight:900;
                        ">BIENVENIDO, {{ $usuario->nombre }}</h2>

                        <p style="
                            color:#d7cffd;
                            line-height:1.9;
                            font-size:12px;
                            letter-spacing:1px;
                            text-transform:uppercase;
                            margin:0 0 24px 0;
                        ">
                            Tu acceso al universo
                            <span style="color:#8a60aa; font-weight:bold;">PIXELVHS</span>
                            ha sido activado correctamente.
                            Tu cuenta de socio está lista para operar.
                        </p>

                    </td>
                </tr>

                <!-- Bloque de datos -->
                <tr>
                    <td style="padding:0 35px 30px 35px;">

                        <table width="100%" cellpadding="0" cellspacing="0" style="
                            background:#0e0718;
                            border:1px solid rgba(73,51,102,.35);
                            border-radius:4px;
                        ">
                            <tr>
                                <td style="
                                    padding:12px 18px;
                                    border-bottom:1px solid rgba(73,51,102,.25);
                                ">
                                    <p style="
                                        margin:0;
                                        color:rgba(73,51,102,.8);
                                        font-size:10px;
                                        letter-spacing:3px;
                                        text-transform:uppercase;
                                    ">INFORMACIÓN DE ACCESO</p>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:16px 18px;">

                                    <table width="100%" cellpadding="0" cellspacing="0">

                                        <tr>
                                            <td style="padding:7px 0; border-bottom:1px solid rgba(73,51,102,.15);">
                                                <span style="color:rgba(73,51,102,.7); font-size:10px; letter-spacing:2px; text-transform:uppercase;">□ USUARIO</span>
                                            </td>
                                            <td align="right" style="padding:7px 0; border-bottom:1px solid rgba(73,51,102,.15);">
                                                <span style="color:#d7cffd; font-size:11px; letter-spacing:2px; text-transform:uppercase;">{{ $usuario->usuario }}</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="padding:7px 0; border-bottom:1px solid rgba(73,51,102,.15);">
                                                <span style="color:rgba(73,51,102,.7); font-size:10px; letter-spacing:2px; text-transform:uppercase;">□ ESTADO</span>
                                            </td>
                                            <td align="right" style="padding:7px 0; border-bottom:1px solid rgba(73,51,102,.15);">
                                                <span style="color:#8a60aa; font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:bold;">SOCIO ACTIVO</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="padding:7px 0;">
                                                <span style="color:rgba(73,51,102,.7); font-size:10px; letter-spacing:2px; text-transform:uppercase;">□ LÍMITE VHS</span>
                                            </td>
                                            <td align="right" style="padding:7px 0;">
                                                <span style="color:#d7cffd; font-size:11px; letter-spacing:2px; text-transform:uppercase;">3 PELÍCULAS SIMULTÁNEAS</span>
                                            </td>
                                        </tr>

                                    </table>

                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>

                <!-- Separador con paso -->
                <tr>
                    <td style="padding:0 35px 30px 35px;">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="border-top:1px solid rgba(73,51,102,.25); width:40%;"></td>
                                <td align="center" style="padding:0 12px; white-space:nowrap;">
                                    <span style="color:rgba(73,51,102,.6); font-size:10px; letter-spacing:3px; text-transform:uppercase;">01 · ACCESO</span>
                                </td>
                                <td style="border-top:1px solid rgba(73,51,102,.25); width:40%;"></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- CTA -->
                <tr>
                    <td align="center" style="padding:0 35px 40px 35px;">
                        <a href="{{ url('/login') }}" style="
                            display:inline-block;
                            padding:14px 36px;
                            background:#493366;
                            color:#ffffff;
                            text-decoration:none;
                            border-radius:4px;
                            font-family:'Courier New', Courier, monospace;
                            font-size:11px;
                            font-weight:700;
                            letter-spacing:4px;
                            text-transform:uppercase;
                            border:1px solid rgba(122,85,170,.6);
                        ">★ &nbsp;INICIAR SESIÓN</a>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="
                        padding:16px 35px;
                        background:#0e0718;
                        border-top:1px solid rgba(73,51,102,.25);
                    ">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <p style="
                                        margin:0;
                                        color:rgba(73,51,102,.5);
                                        font-size:10px;
                                        letter-spacing:3px;
                                        text-transform:uppercase;
                                    ">PIXELVHS © 1987</p>
                                </td>
                                <td align="right">
                                    <p style="
                                        margin:0;
                                        color:rgba(73,51,102,.5);
                                        font-size:10px;
                                        letter-spacing:3px;
                                        text-transform:uppercase;
                                    ">// FIN DE FORMULARIO //</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>
</body>
</html>