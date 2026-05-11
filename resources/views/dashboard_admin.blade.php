<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BEBOP VIDEO — ADMIN</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Share+Tech+Mono&family=Bebas+Neue&family=Rajdhani:wght@400;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('css/alertas.css') }}">
    <style>
        :root {
            --v: #7B5EA7;
            --v-dim: #4A3468;
            --v-soft: rgba(123, 94, 167, 0.15);
            --v-glow: rgba(123, 94, 167, 0.4);
            --w: #DEDEDE;
            --g: #666;
            --g-dark: #222;
            --ink: #060606;
            --ink2: #0E0E0E;
            --ink3: #151515;
            --fh: 'Bebas Neue', sans-serif;
            --fm: 'Share Tech Mono', monospace;
            --fu: 'Rajdhani', sans-serif;
            --fo: 'Orbitron', sans-serif;
            --green: #4CAF6A;
            --red: #C0392B;
            --amber: #D4A017;
        }

        *, *::before, *::after {
            margin: 0; padding: 0; box-sizing: border-box;
        }

        body {
            background: var(--ink);
            color: var(--w);
            font-family: var(--fu);
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: repeating-linear-gradient(0deg, transparent, transparent 2px,
                rgba(0,0,0,0.08) 2px, rgba(0,0,0,0.08) 4px);
            pointer-events: none;
            z-index: 9999;
        }

        /* ── HEADER ── */
        header {
            position: sticky;
            top: 0;
            z-index: 200;
            height: 62px;
            background: rgba(6,6,6,0.97);
            border-bottom: 1px solid rgba(123,94,167,0.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 52px;
            backdrop-filter: blur(12px);
            flex-shrink: 0;
        }

        .logo { display: flex; align-items: center; gap: 13px; }

        .logo-mark {
            width: 32px; height: 32px;
            border: 1.5px solid var(--v);
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden; flex-shrink: 0;
        }
        .logo-mark::before { content: '▶'; color: var(--v); font-size: 11px; position: relative; z-index: 1; }
        .logo-mark::after {
            content: '';
            position: absolute; top: 0; left: -130%; width: 55%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(123,94,167,0.3), transparent);
            animation: sheen 4s linear infinite;
        }
        @keyframes sheen { to { left: 230%; } }

        .logo-words h1 { font-family: var(--fo); font-size: 14px; font-weight: 900; letter-spacing: 3.5px; color: var(--w); line-height: 1; }
        .logo-words h1 em { font-style: normal; color: var(--v); }
        .logo-words small { font-family: var(--fm); font-size: 8px; color: var(--g); letter-spacing: 2px; display: block; margin-top: 2px; }

        .header-right { display: flex; align-items: center; gap: 16px; }

        .admin-badge {
            font-family: var(--fm); font-size: 8px; letter-spacing: 3px; color: var(--v);
            border: 1px solid var(--v-dim); padding: 3px 10px; background: rgba(123,94,167,0.08);
        }

        .admin-user {
            font-family: var(--fm); font-size: 9px; color: var(--g); letter-spacing: 1px;
            display: flex; align-items: center; gap: 7px;
        }
        .admin-user::before { content: '◈'; color: var(--v-dim); font-size: 10px; }

        /* ── LAYOUT ── */
        .shell { display: flex; flex: 1; min-height: 0; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 220px; flex-shrink: 0;
            background: var(--ink2);
            border-right: 1px solid rgba(123,94,167,0.12);
            display: flex; flex-direction: column;
            position: sticky; top: 62px;
            height: calc(100vh - 62px);
            overflow-y: auto; overflow-x: hidden;
        }

        .sidebar-label {
            font-family: var(--fm); font-size: 8px; letter-spacing: 3px;
            color: var(--g-dark); padding: 22px 22px 8px;
            border-bottom: 1px solid rgba(255,255,255,0.03);
        }

        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 13px 22px; cursor: pointer;
            font-family: var(--fm); font-size: 11px; letter-spacing: 2px;
            color: var(--g); border-left: 2px solid transparent;
            transition: all .18s; user-select: none;
        }
        .nav-item:hover { background: var(--v-soft); color: var(--w); border-left-color: var(--v-dim); }
        .nav-item.active { background: rgba(123,94,167,0.12); color: var(--w); border-left-color: var(--v); }
        .nav-item .nav-icon { font-size: 13px; width: 16px; text-align: center; flex-shrink: 0; }

        .nav-badge {
            margin-left: auto; font-family: var(--fo); font-size: 7px; letter-spacing: 1px;
            color: var(--v); background: rgba(123,94,167,0.15); padding: 1px 6px;
            border: 1px solid var(--v-dim);
        }

        .sidebar-sep { height: 1px; background: rgba(255,255,255,0.04); margin: 8px 0; }

        .sidebar-bottom {
            margin-top: auto; padding: 16px 22px;
            border-top: 1px solid rgba(255,255,255,0.04);
        }

        .logout-btn {
            font-family: var(--fm); font-size: 10px; letter-spacing: 2px;
            color: var(--g); background: transparent; border: 1px solid var(--g-dark);
            padding: 8px 14px; cursor: pointer; transition: all .18s;
            width: 100%; display: flex; align-items: center; gap: 8px; justify-content: center;
        }
        .logout-btn:hover { border-color: #C0392B; color: #C0392B; }

        /* ── MAIN CONTENT ── */
        .main { flex: 1; overflow-y: auto; min-width: 0; padding: 36px 42px 60px; }

        /* ── VIEWS ── */
        .view { display: none; }
        .view.active { display: block; }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex; align-items: flex-end; justify-content: space-between;
            margin-bottom: 32px; padding-bottom: 18px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .page-header h2 { font-family: var(--fh); font-size: 34px; letter-spacing: 6px; color: var(--w); line-height: 1; }
        .page-header small { font-family: var(--fm); font-size: 9px; color: var(--g); letter-spacing: 2px; display: block; margin-top: 5px; }
        .page-actions { display: flex; gap: 10px; }

        /* ── STAT CARDS ── */
        .stats-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 5px; margin-bottom: 36px; }

        .stat-card {
            background: var(--ink3); border: 1px solid rgba(255,255,255,0.04);
            padding: 20px 22px; position: relative; overflow: hidden; transition: border-color .2s;
        }
        .stat-card:hover { border-color: rgba(123,94,167,0.25); }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 2px; height: 100%; background: var(--v-dim); }
        .stat-card.green::before { background: var(--green); }
        .stat-card.red::before   { background: var(--red); }
        .stat-card.amber::before { background: var(--amber); }
        .stat-card .sc-label { font-family: var(--fm); font-size: 8px; letter-spacing: 2px; color: var(--g); margin-bottom: 8px; }
        .stat-card .sc-value { font-family: var(--fh); font-size: 36px; letter-spacing: 2px; color: var(--w); line-height: 1; }
        .stat-card .sc-sub   { font-family: var(--fm); font-size: 8px; color: var(--g); margin-top: 5px; letter-spacing: 1px; }

        /* ── SECTION TITLE ── */
        .section-title {
            font-family: var(--fm); font-size: 9px; letter-spacing: 3px; color: var(--v-dim);
            margin-bottom: 14px; display: flex; align-items: center; gap: 10px;
        }
        .section-title::before { content: ''; width: 16px; height: 1px; background: var(--v-dim); }

        /* ── FORM CARD ── */
        .form-card { background: var(--ink2); border: 1px solid rgba(255,255,255,0.05); padding: 28px 32px; margin-bottom: 28px; }
        .form-card h3 { font-family: var(--fh); font-size: 18px; letter-spacing: 4px; color: var(--w); margin-bottom: 24px; padding-bottom: 14px; border-bottom: 1px solid rgba(255,255,255,0.05); }

        .form-grid   { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; }
        .form-grid-2 { display: grid; grid-template-columns: repeat(2,1fr); gap: 16px; }

        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-family: var(--fm); font-size: 8px; letter-spacing: 2px; color: var(--g); }
        .form-group input,
        .form-group select {
            background: var(--ink3); border: 1px solid var(--g-dark); border-left: 2px solid var(--v-dim);
            color: var(--w); font-family: var(--fm); font-size: 11px; padding: 9px 12px;
            outline: none; letter-spacing: 1px; transition: all .18s; appearance: none;
        }
        .form-group input:focus,
        .form-group select:focus { border-color: var(--v); box-shadow: 0 0 0 1px rgba(123,94,167,0.2); }
        .form-group input::placeholder { color: #2a2a2a; }
        .form-group select option { background: var(--ink2); }

        /* error state */
        .form-group input.input-error,
        .form-group select.input-error { border-color: var(--red) !important; }
        .field-error { font-family: var(--fm); font-size: 8px; color: var(--red); letter-spacing: 1px; margin-top: 2px; display: none; }
        .field-error.show { display: block; }

        .form-actions { display: flex; gap: 10px; margin-top: 24px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.04); }

        /* ── BUTTONS ── */
        .btn { font-family: var(--fo); font-size: 8px; letter-spacing: 2px; border: none; padding: 10px 24px; cursor: pointer; transition: all .2s; }
        .btn-add  { background: var(--v); color: var(--w); }
        .btn-add:hover { background: #9370C8; box-shadow: 0 0 14px var(--v-glow); }
        .btn-add:disabled { opacity: .5; cursor: not-allowed; }
        .btn-edit { background: transparent; color: var(--g); border: 1px solid var(--g-dark); }
        .btn-edit:hover { border-color: var(--amber); color: var(--amber); }
        .btn-del  { background: transparent; color: var(--g); border: 1px solid var(--g-dark); }
        .btn-del:hover  { border-color: var(--red); color: var(--red); }
        .btn-success { background: transparent; color: var(--g); border: 1px solid var(--g-dark); font-family: var(--fo); font-size: 8px; letter-spacing: 2px; padding: 3px 9px; cursor: pointer; transition: all .18s; }
        .btn-success:hover { border-color: var(--green); color: var(--green); }
        .btn-clear { background: transparent; color: var(--g); border: 1px solid var(--g-dark); font-family: var(--fm); font-size: 9px; letter-spacing: 2px; padding: 9px 18px; cursor: pointer; transition: all .18s; }
        .btn-clear:hover { border-color: var(--v-dim); color: var(--w); }

        /* ── TABLE ── */
        .table-wrap { background: var(--ink2); border: 1px solid rgba(255,255,255,0.05); overflow: hidden; }
        .table-topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .table-topbar h3 { font-family: var(--fh); font-size: 15px; letter-spacing: 4px; color: var(--w); }
        .table-count { font-family: var(--fm); font-size: 9px; color: var(--g); letter-spacing: 1px; }

        .t-filters { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
        .t-search { display: flex; align-items: center; gap: 0; }
        .t-search input {
            background: var(--ink3); border: 1px solid var(--g-dark); border-right: none;
            color: var(--w); font-family: var(--fm); font-size: 10px;
            padding: 6px 12px; outline: none; letter-spacing: 1px; width: 180px; transition: border-color .18s;
        }
        .t-search input:focus { border-color: var(--v); }
        .t-search input::placeholder { color: #2a2a2a; }
        .t-search-ico { background: var(--v-dim); border: none; padding: 7px 12px; color: var(--w); cursor: pointer; font-size: 11px; line-height: 1; }

        .t-filter-select {
            background: var(--ink3); border: 1px solid var(--g-dark);
            color: var(--g); font-family: var(--fm); font-size: 9px; letter-spacing: 1px;
            padding: 6px 10px; outline: none; cursor: pointer; transition: all .18s; appearance: none;
        }
        .t-filter-select:focus { border-color: var(--v); color: var(--w); }
        .t-filter-select option { background: var(--ink2); }

        table { width: 100%; border-collapse: collapse; }
        thead tr { background: var(--ink3); border-bottom: 1px solid rgba(123,94,167,0.15); }
        th { font-family: var(--fm); font-size: 8px; letter-spacing: 2px; color: var(--g); padding: 12px 16px; text-align: left; font-weight: normal; white-space: nowrap; }
        tbody tr { border-bottom: 1px solid rgba(255,255,255,0.03); transition: background .15s; }
        tbody tr:hover { background: rgba(123,94,167,0.06); }
        td { font-family: var(--fu); font-size: 13px; font-weight: 400; color: #b0b0b0; padding: 11px 16px; white-space: nowrap; }
        td.name-cell { color: var(--w); font-weight: 600; }
        td.id-cell { font-family: var(--fo); font-size: 9px; color: var(--v-dim); letter-spacing: 1px; }

        .status-pill { font-family: var(--fm); font-size: 8px; letter-spacing: 2px; padding: 3px 9px; border: 1px solid; }
        .status-pill.activo    { color: var(--green); border-color: rgba(76,175,106,0.3);   background: rgba(76,175,106,0.07); }
        .status-pill.inactivo  { color: var(--g);     border-color: var(--g-dark);           background: transparent; }
        .status-pill.suspendido{ color: var(--red);   border-color: rgba(192,57,43,0.3);    background: rgba(192,57,43,0.07); }

        .rol-pill { font-family: var(--fm); font-size: 8px; letter-spacing: 2px; padding: 3px 9px; }
        .rol-pill.admin   { color: var(--v); }
        .rol-pill.empleado{ color: var(--amber); }
        .rol-pill.socio   { color: var(--g); }

        .row-actions { display: flex; gap: 6px; }
        .ra-btn { background: transparent; border: 1px solid var(--g-dark); color: var(--g); font-family: var(--fm); font-size: 8px; letter-spacing: 1px; padding: 3px 9px; cursor: pointer; transition: all .15s; }
        .ra-btn:hover     { border-color: var(--v);   color: var(--w); }
        .ra-btn.del:hover { border-color: var(--red); color: var(--red); }
        .ra-btn.ok:hover  { border-color: var(--green); color: var(--green); }

        /* ── NO RESULTS ── */
        .no-results td { text-align: center; color: var(--g); font-family: var(--fm); font-size: 10px; letter-spacing: 2px; padding: 28px; }

        /* ── DASHBOARD ── */
        .recent-list { margin-top: 28px; }
        .recent-row { display: flex; align-items: center; gap: 14px; padding: 11px 0; border-bottom: 1px solid rgba(255,255,255,0.04); }
        .recent-row:last-child { border-bottom: none; }
        .recent-icon { width: 34px; height: 34px; background: var(--ink3); border: 1px solid rgba(123,94,167,0.2); display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; }
        .recent-info { flex: 1; }
        .recent-info .ri-title { font-family: var(--fu); font-size: 13px; font-weight: 600; color: var(--w); }
        .recent-info .ri-sub   { font-family: var(--fm); font-size: 8px; color: var(--g); letter-spacing: 1px; margin-top: 2px; }
        .recent-time { font-family: var(--fm); font-size: 8px; color: var(--v-dim); letter-spacing: 1px; }

        /* ── TOAST ── */
        .toast {
            position: fixed; bottom: 28px; right: 28px; z-index: 5000;
            background: var(--ink2); border: 1px solid var(--v-dim); border-left: 3px solid var(--v);
            padding: 12px 20px; font-family: var(--fm); font-size: 10px; letter-spacing: 1px; color: var(--w);
            opacity: 0; transform: translateY(10px); transition: all .3s; pointer-events: none;
        }
        .toast.show  { opacity: 1; transform: translateY(0); }
        .toast.error   { border-left-color: var(--red);   border-color: rgba(192,57,43,0.4); }
        .toast.success { border-left-color: var(--green); border-color: rgba(76,175,106,0.3); }

        /* ── SPINNER ── */
        .spinner {
            width: 12px; height: 12px; border: 2px solid rgba(255,255,255,0.2);
            border-top-color: var(--w); border-radius: 50%; animation: spin .6s linear infinite; display: inline-block;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── RESPONSIVE ── */
        @media(max-width:900px) {
            .stats-row  { grid-template-columns: repeat(2,1fr); }
            .form-grid  { grid-template-columns: 1fr 1fr; }
            header, .main { padding-left: 20px; padding-right: 20px; }
            .sidebar { width: 180px; }
        }
        @media(max-width:640px) {
            .sidebar { display: none; }
            .form-grid { grid-template-columns: 1fr; }
            .stats-row { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>

<body>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            alertaRetro({ titulo: 'INFORMACIÓN CUENTA', texto: `<p>{{ session('success') }}</p>`, icono: 'success' });
        });
    </script>
    @endif

    <!-- ══ HEADER ══ -->
    <header>
        <div class="logo">
            <div class="logo-mark"></div>
            <div class="logo-words">
                <h1>BEBOP<em>VIDEO</em></h1>
                <small>EST. 1985 &nbsp;·&nbsp; VHS RENTALS</small>
            </div>
        </div>
        <div class="header-right">
            <div class="admin-badge">PANEL DE CONTROL</div>
            <div class="admin-user">ADMIN &nbsp;·&nbsp; CMENDOZA</div>
        </div>
    </header>

    <div class="shell">

        <!-- ══ SIDEBAR ══ -->
        <nav class="sidebar">
            <div class="sidebar-label">// MÓDULOS</div>

            <div class="nav-item active" onclick="navigate('dashboard', this)">
                <span class="nav-icon">◈</span> DASHBOARD
            </div>
            <div class="nav-item" onclick="navigate('peliculas', this)">
                <span class="nav-icon">▶</span> PELÍCULAS
                <span class="nav-badge">08</span>
            </div>
            <div class="nav-item" onclick="navigate('usuarios', this)">
                <span class="nav-icon">⊕</span> USUARIOS
                <span class="nav-badge" id="nb-usuarios">{{ str_pad(count($usuarios), 2, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="nav-item" onclick="navigate('rentas', this)">
                <span class="nav-icon">⬡</span> RENTAS
            </div>

            <div class="sidebar-sep"></div>
            <div class="sidebar-label">// SISTEMA</div>
            <div class="nav-item" onclick="navigate('config', this)">
                <span class="nav-icon">⚙</span> CONFIGURACIÓN
            </div>

            <div class="sidebar-bottom">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-btn" type="submit">⎋ &nbsp;CERRAR SESIÓN</button>
                </form>
            </div>
        </nav>

        <!-- ══ MAIN ══ -->
        <main class="main">

            <!-- ── DASHBOARD ── -->
            <div class="view active" id="view-dashboard">
                <div class="page-header">
                    <div>
                        <h2>DASHBOARD</h2>
                        <small>// RESUMEN GENERAL DEL SISTEMA</small>
                    </div>
                </div>
                <div class="stats-row">
                    <div class="stat-card">
                        <div class="sc-label">TÍTULOS EN CATÁLOGO</div>
                        <div class="sc-value">08</div>
                        <div class="sc-sub">CINTAS VHS REGISTRADAS</div>
                    </div>
                    <div class="stat-card green">
                        <div class="sc-label">DISPONIBLES</div>
                        <div class="sc-value">07</div>
                        <div class="sc-sub">LISTAS PARA RENTAR</div>
                    </div>
                    <div class="stat-card red">
                        <div class="sc-label">RENTADAS</div>
                        <div class="sc-value">01</div>
                        <div class="sc-sub">BLADE RUNNER · #055</div>
                    </div>
                    <div class="stat-card amber">
                        <div class="sc-label">USUARIOS ACTIVOS</div>
                        <div class="sc-value" id="dash-activos">{{ $usuarios->where('estado','Activo')->count() }}</div>
                        <div class="sc-sub">DE {{ count($usuarios) }} REGISTRADOS</div>
                    </div>
                </div>
                <div class="section-title">ACTIVIDAD RECIENTE</div>
                <div class="form-card">
                    <div class="recent-list">
                        <div class="recent-row">
                            <div class="recent-icon">▶</div>
                            <div class="recent-info">
                                <div class="ri-title">BLADE RUNNER rentada</div>
                                <div class="ri-sub">POR: LPEREZ &nbsp;·&nbsp; CINTA #055</div>
                            </div>
                            <div class="recent-time">HOY 14:32</div>
                        </div>
                        <div class="recent-row">
                            <div class="recent-icon">⊕</div>
                            <div class="recent-info">
                                <div class="ri-title">HALLOWEEN añadida al catálogo</div>
                                <div class="ri-sub">DIRECTOR: JOHN CARPENTER &nbsp;·&nbsp; 1978</div>
                            </div>
                            <div class="recent-time">AYER 09:10</div>
                        </div>
                        <div class="recent-row">
                            <div class="recent-icon">⊕</div>
                            <div class="recent-info">
                                <div class="ri-title">Usuario ARUIZ suspendido</div>
                                <div class="ri-sub">ACCIÓN: ACTUALIZACIÓN DE ESTADO</div>
                            </div>
                            <div class="recent-time">LUNES 11:45</div>
                        </div>
                        <div class="recent-row">
                            <div class="recent-icon">⬡</div>
                            <div class="recent-info">
                                <div class="ri-title">CHINATOWN devuelta</div>
                                <div class="ri-sub">POR: CMENDOZA &nbsp;·&nbsp; CINTA #063</div>
                            </div>
                            <div class="recent-time">LUNES 10:20</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── PELÍCULAS ── -->
            <div class="view" id="view-peliculas">
                <div class="page-header">
                    <div>
                        <h2>PELÍCULAS</h2>
                        <small>// GESTIÓN DE CATÁLOGO VHS</small>
                    </div>
                </div>
                {{-- El CRUD de películas se implementará aquí con su propio controlador PHP --}}
                <div class="form-card">
                    <h3 style="color:var(--g);font-size:14px;letter-spacing:3px;border:none;margin:0;padding:0">
                        // MÓDULO EN DESARROLLO
                    </h3>
                </div>
            </div>

            <!-- ── USUARIOS ── -->
            <div class="view" id="view-usuarios">
                <div class="page-header">
                    <div>
                        <h2>USUARIOS</h2>
                        <small>// ADMINISTRACIÓN DE CUENTAS</small>
                    </div>
                    <div class="page-actions">
                        <button class="btn-clear" onclick="clearUserForm()">LIMPIAR FORM</button>
                    </div>
                </div>

                <!-- Formulario AJAX -->
                <div class="form-card">
                    <h3>AGREGAR USUARIO</h3>
                    <div class="form-grid" id="userFormGrid">
                        <div class="form-group">
                            <label>NOMBRE COMPLETO</label>
                            <input type="text" id="u-nombre" name="nombre" placeholder="EJ: CARLOS MENDOZA">
                            <span class="field-error" id="err-nombre"></span>
                        </div>
                        <div class="form-group">
                            <label>EMAIL</label>
                            <input type="email" id="u-email" name="email" placeholder="correo@bebopvideo.com">
                            <span class="field-error" id="err-email"></span>
                        </div>
                        <div class="form-group">
                            <label>NOMBRE DE USUARIO</label>
                            <input type="text" id="u-usuario" name="usuario" placeholder="EJ: CMENDOZA">
                            <span class="field-error" id="err-usuario"></span>
                        </div>
                        <div class="form-group">
                            <label>PASSWORD</label>
                            <input type="password" id="u-password" name="password" placeholder="••••••••">
                            <span class="field-error" id="err-password"></span>
                        </div>
                        <div class="form-group">
                            <label>DIRECCIÓN</label>
                            <input type="text" id="u-direccion" name="direccion" placeholder="Dirección del trabajador">
                            <span class="field-error" id="err-direccion"></span>
                        </div>
                        <div class="form-group">
                            <label>TELÉFONO</label>
                            <input type="text" id="u-telefono" name="telefono" placeholder="3001234567">
                            <span class="field-error" id="err-telefono"></span>
                        </div>
                        <div class="form-group">
                            <label>ROL</label>
                            <select id="u-rol" name="rol">
                                <option value="">— SELECCIONAR —</option>
                                <option value="admin">ADMINISTRADOR</option>
                                <option value="empleado">EMPLEADO</option>
                            </select>
                            <span class="field-error" id="err-rol"></span>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-add" id="btnAgregarUsuario" onclick="submitUsuario()">+ AGREGAR</button>
                    </div>
                </div>

                <!-- Tabla de usuarios -->
                <div class="table-wrap">
                    <div class="table-topbar">
                        <h3>USUARIOS REGISTRADOS</h3>
                        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                            <span class="table-count" id="userCount">// {{ str_pad(count($usuarios), 2, '0', STR_PAD_LEFT) }} USUARIOS</span>
                            <div class="t-filters">
                                <!-- Filtro por rol -->
                                <select class="t-filter-select" id="filterRol" onchange="filterUsers()">
                                    <option value="">TODOS LOS ROLES</option>
                                    <option value="admin">ADMIN</option>
                                    <option value="empleado">EMPLEADO</option>
                                    <option value="socio">SOCIO</option>
                                </select>
                                <!-- Filtro por estado -->
                                <select class="t-filter-select" id="filterEstado" onchange="filterUsers()">
                                    <option value="">TODOS LOS ESTADOS</option>
                                    <option value="Activo">ACTIVO</option>
                                    <option value="Inactivo">INACTIVO</option>
                                </select>
                                <!-- Búsqueda texto -->
                                <div class="t-search">
                                    <input type="text" placeholder="BUSCAR..." id="userSearch" oninput="filterUsers()">
                                    <button class="t-search-ico">⌕</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NOMBRE</th>
                                <th>EMAIL</th>
                                <th>USUARIO</th>
                                <th>TELÉFONO</th>
                                <th>ROL</th>
                                <th>ESTADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="userTbody">
                            @forelse ($usuarios as $u)
                            <tr
                                data-id="{{ $u->id_usuario }}"
                                data-nombre="{{ strtolower($u->nombre) }}"
                                data-email="{{ strtolower($u->email) }}"
                                data-usuario="{{ strtolower($u->usuario) }}"
                                data-rol="{{ $u->rol }}"
                                data-estado="{{ $u->estado }}"
                            >
                                <td class="id-cell">{{ str_pad($u->id_usuario, 2, '0', STR_PAD_LEFT) }}</td>
                                <td class="name-cell">{{ $u->nombre }}</td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->usuario }}</td>
                                <td>{{ $u->telefono }}</td>
                                <td>
                                    <span class="rol-pill {{ $u->rol }}">
                                        @switch($u->rol)
                                            @case('admin')    ADMINISTRADOR @break
                                            @case('empleado') EMPLEADO      @break
                                            @default          SOCIO
                                        @endswitch
                                    </span>
                                </td>
                                <td>
                                    <span class="status-pill {{ $u->estado === 'Activo' ? 'activo' : 'inactivo' }}">
                                        {{ $u->estado === 'Activo' ? '◉ ACTIVO' : '⊘ INACTIVO' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="row-actions">
                                        @if($u->rol !== 'socio')
                                            <button class="ra-btn del" onclick="deleteUser({{ $u->id_usuario }}, this)">✕ ELIMINAR</button>
                                        @endif
                                        @if($u->estado === 'Activo')
                                            <button class="ra-btn del" onclick="toggleUser({{ $u->id_usuario }}, this)">⊘ DESACTIVAR</button>
                                        @else
                                            <button class="ra-btn ok" onclick="toggleUser({{ $u->id_usuario }}, this)">◉ ACTIVAR</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr class="no-results">
                                <td colspan="8">NO HAY USUARIOS REGISTRADOS</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ── RENTAS ── -->
            <div class="view" id="view-rentas">
                <div class="page-header">
                    <div>
                        <h2>RENTAS</h2>
                        <small>// HISTORIAL DE RENTAS VHS</small>
                    </div>
                </div>
                <div class="form-card">
                    <h3 style="color:var(--g);font-size:14px;letter-spacing:3px;border:none;margin:0;padding:0">
                        // MÓDULO EN DESARROLLO
                    </h3>
                </div>
            </div>

            <!-- ── CONFIG ── -->
            <div class="view" id="view-config">
                <div class="page-header">
                    <div>
                        <h2>CONFIGURACIÓN</h2>
                        <small>// PARÁMETROS DEL SISTEMA</small>
                    </div>
                </div>
                <div class="form-card">
                    <h3 style="color:var(--g);font-size:14px;letter-spacing:3px;border:none;margin:0;padding:0">
                        // MÓDULO EN DESARROLLO
                    </h3>
                </div>
            </div>

        </main>
    </div>

    <div class="toast" id="toast"></div>

    <script>
    /* ══════════════════════════════════════════════
       NAVEGACIÓN
    ══════════════════════════════════════════════ */
    function navigate(view, el) {
        document.querySelectorAll('.view').forEach(v => v.classList.remove('active'));
        document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
        document.getElementById('view-' + view).classList.add('active');
        el.classList.add('active');
    }

    /* ══════════════════════════════════════════════
       TOAST
    ══════════════════════════════════════════════ */
    function toast(msg, type = 'success') {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.className = 'toast show ' + type;
        setTimeout(() => t.className = 'toast', 2800);
    }

    /* ══════════════════════════════════════════════
       CSRF helper
    ══════════════════════════════════════════════ */
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;

    /* ══════════════════════════════════════════════
       USUARIOS — FILTRO / BÚSQUEDA (client-side)
       Opera sobre los <tr> ya renderizados por Blade.
    ══════════════════════════════════════════════ */
    function filterUsers() {
        const q       = document.getElementById('userSearch').value.toLowerCase().trim();
        const rol     = document.getElementById('filterRol').value;
        const estado  = document.getElementById('filterEstado').value;
        const rows    = document.querySelectorAll('#userTbody tr[data-id]');

        let visible = 0;

        rows.forEach(row => {
            const matchText  = !q || row.dataset.nombre.includes(q) || row.dataset.email.includes(q) || row.dataset.usuario.includes(q);
            const matchRol   = !rol    || row.dataset.rol    === rol;
            const matchState = !estado || row.dataset.estado === estado;

            const show = matchText && matchRol && matchState;
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        // Actualizar conteo
        document.getElementById('userCount').textContent =
            `// ${String(visible).padStart(2,'0')} USUARIO${visible !== 1 ? 'S' : ''}`;

        // Mostrar "sin resultados" si no hay filas
        const noRes = document.querySelector('#userTbody .no-results');
        if (noRes) noRes.style.display = visible === 0 ? '' : 'none';
        else if (visible === 0) {
            const tr = document.createElement('tr');
            tr.className = 'no-results';
            tr.innerHTML = '<td colspan="8">SIN RESULTADOS PARA ESA BÚSQUEDA</td>';
            tr.id = 'noResTemp';
            document.getElementById('userTbody').appendChild(tr);
        } else {
            const tmp = document.getElementById('noResTemp');
            if (tmp) tmp.remove();
        }
    }

    /* ══════════════════════════════════════════════
       USUARIOS — LIMPIAR FORMULARIO
    ══════════════════════════════════════════════ */
    function clearUserForm() {
        ['u-nombre','u-email','u-usuario','u-password','u-direccion','u-telefono','u-rol']
            .forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
        clearFormErrors();
    }

    function clearFormErrors() {
        document.querySelectorAll('.field-error').forEach(e => { e.textContent = ''; e.classList.remove('show'); });
        document.querySelectorAll('.input-error').forEach(e => e.classList.remove('input-error'));
    }

    function showFieldError(field, msg) {
        const input = document.getElementById('u-' + field);
        const err   = document.getElementById('err-' + field);
        if (input) input.classList.add('input-error');
        if (err)   { err.textContent = msg; err.classList.add('show'); }
    }

    /* ══════════════════════════════════════════════
       USUARIOS — AGREGAR (AJAX)
    ══════════════════════════════════════════════ */
    async function submitUsuario() {
        clearFormErrors();

        const payload = {
            nombre:    document.getElementById('u-nombre').value.trim(),
            email:     document.getElementById('u-email').value.trim(),
            usuario:   document.getElementById('u-usuario').value.trim(),
            password:  document.getElementById('u-password').value,
            direccion: document.getElementById('u-direccion').value.trim(),
            telefono:  document.getElementById('u-telefono').value.trim(),
            rol:       document.getElementById('u-rol').value,
        };

        const btn = document.getElementById('btnAgregarUsuario');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner"></span>';

        try {
            const res  = await fetch('{{ route("admin.registrar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept':       'application/json',
                    'X-CSRF-TOKEN': CSRF,
                },
                body: JSON.stringify(payload),
            });

            const data = await res.json();

            if (!res.ok) {
                // Errores de validación (422) u otros
                if (data.errors) {
                    Object.entries(data.errors).forEach(([field, msgs]) => {
                        showFieldError(field, msgs[0].toUpperCase());
                    });
                    toast('REVISA LOS CAMPOS MARCADOS', 'error');
                } else {
                    toast(data.message?.toUpperCase() ?? 'ERROR AL REGISTRAR', 'error');
                }
                return;
            }

            // Éxito: insertar nueva fila en la tabla
            appendUserRow(data.usuario);
            clearUserForm();
            updateUserCount(1);
            toast('✓ USUARIO REGISTRADO CORRECTAMENTE');

        } catch (err) {
            console.error(err);
            toast('ERROR DE CONEXIÓN', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '+ AGREGAR';
        }
    }

    /* Añade una fila al tbody con los datos del usuario recién creado */
    function appendUserRow(u) {
        const tbody = document.getElementById('userTbody');

        // Quitar fila vacía si existe
        const empty = tbody.querySelector('.no-results');
        if (empty) empty.remove();

        const rolLabel = { admin: 'ADMINISTRADOR', empleado: 'EMPLEADO', socio: 'SOCIO' }[u.rol] ?? u.rol.toUpperCase();
        const rolClass = u.rol; // admin | empleado | socio

        const tr = document.createElement('tr');
        tr.dataset.id      = u.id_usuario;
        tr.dataset.nombre  = u.nombre.toLowerCase();
        tr.dataset.email   = u.email.toLowerCase();
        tr.dataset.usuario = u.usuario.toLowerCase();
        tr.dataset.rol     = u.rol;
        tr.dataset.estado  = 'Activo';

        tr.innerHTML = `
            <td class="id-cell">${String(u.id_usuario).padStart(2,'0')}</td>
            <td class="name-cell">${u.nombre}</td>
            <td>${u.email}</td>
            <td>${u.usuario}</td>
            <td>${u.telefono ?? '—'}</td>
            <td><span class="rol-pill ${rolClass}">${rolLabel}</span></td>
            <td><span class="status-pill activo">◉ ACTIVO</span></td>
            <td>
                <div class="row-actions">
                    <button class="ra-btn del" onclick="deleteUser(${u.id_usuario}, this)">✕ ELIMINAR</button>
                    <button class="ra-btn del" onclick="toggleUser(${u.id_usuario}, this)">⊘ DESACTIVAR</button>
                </div>
            </td>
        `;

        // Animación de entrada sutil
        tr.style.opacity = '0';
        tr.style.transition = 'opacity .4s';
        tbody.prepend(tr);
        requestAnimationFrame(() => tr.style.opacity = '1');
    }

    /* ══════════════════════════════════════════════
       USUARIOS — TOGGLE ESTADO (AJAX)
    ══════════════════════════════════════════════ */
    async function toggleUser(id, btn) {
        btn.disabled = true;
        const originalText = btn.textContent;
        btn.innerHTML = '<span class="spinner"></span>';

        try {
            const res  = await fetch(`/admin/usuarios/${id}/toggle`, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
            });
            const data = await res.json();

            if (!res.ok) { toast(data.message?.toUpperCase() ?? 'ERROR', 'error'); return; }

            // Actualizar fila
            const row = document.querySelector(`#userTbody tr[data-id="${id}"]`);
            if (row) {
                const nuevoEstado = data.estado; // 'Activo' | 'Inactivo'
                row.dataset.estado = nuevoEstado;

                const pill = row.querySelector('.status-pill');
                if (nuevoEstado === 'Activo') {
                    pill.className = 'status-pill activo';
                    pill.textContent = '◉ ACTIVO';
                    btn.className = 'ra-btn del';
                    btn.textContent = '⊘ DESACTIVAR';
                } else {
                    pill.className = 'status-pill inactivo';
                    pill.textContent = '⊘ INACTIVO';
                    btn.className = 'ra-btn ok';
                    btn.textContent = '◉ ACTIVAR';
                }
            }

            toast(`✓ USUARIO ${data.estado === 'Activo' ? 'ACTIVADO' : 'DESACTIVADO'}`);

        } catch (err) {
            console.error(err);
            toast('ERROR DE CONEXIÓN', 'error');
        } finally {
            btn.disabled = false;
        }
    }

    /* ══════════════════════════════════════════════
       USUARIOS — ELIMINAR (AJAX)
    ══════════════════════════════════════════════ */
    async function deleteUser(id, btn) {
        if (!confirm('¿ELIMINAR ESTE USUARIO? ESTA ACCIÓN NO SE PUEDE DESHACER.')) return;

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner"></span>';

        try {
            const res  = await fetch(`/admin/usuarios/${id}`, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
            });
            const data = await res.json();

            if (!res.ok) { toast(data.message?.toUpperCase() ?? 'ERROR', 'error'); btn.disabled = false; btn.textContent = '✕ ELIMINAR'; return; }

            const row = document.querySelector(`#userTbody tr[data-id="${id}"]`);
            if (row) {
                row.style.transition = 'opacity .3s';
                row.style.opacity = '0';
                setTimeout(() => { row.remove(); updateUserCount(-1); }, 300);
            }

            toast('✕ USUARIO ELIMINADO', 'error');

        } catch (err) {
            console.error(err);
            toast('ERROR DE CONEXIÓN', 'error');
            btn.disabled = false;
            btn.textContent = '✕ ELIMINAR';
        }
    }

    /* ══════════════════════════════════════════════
       HELPERS
    ══════════════════════════════════════════════ */
    function updateUserCount(delta) {
        const el   = document.getElementById('userCount');
        const nb   = document.getElementById('nb-usuarios');
        const rows = document.querySelectorAll('#userTbody tr[data-id]');
        const n    = rows.length;
        el.textContent = `// ${String(n).padStart(2,'0')} USUARIO${n !== 1 ? 'S' : ''}`;
        nb.textContent = String(n).padStart(2,'0');
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/alertas.js') }}"></script>
</body>
</html>