<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIXELVHS — EMPLEADO</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Share+Tech+Mono&family=Bebas+Neue&family=Rajdhani:wght@400;600&display=swap" rel="stylesheet">
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

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--ink);
            color: var(--w);
            font-family: var(--fu);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0, 0, 0, .08) 2px, rgba(0, 0, 0, .08) 4px);
            pointer-events: none;
            z-index: 9999;
        }

        .shell {
            display: flex;
            flex: 1;
            min-height: 100vh;
        }


        /* ── SIDEBAR ── */
        .sidebar {
            width: 220px;
            flex-shrink: 0;
            background: var(--ink2);
            border-right: 1px solid rgba(123, 94, 167, 0.12);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 100;
        }

        .sidebar-label {
            font-family: var(--fm);
            font-size: 8px;
            letter-spacing: 3px;
            color: var(--g-dark);
            padding: 22px 22px 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 22px;
            cursor: pointer;
            font-family: var(--fm);
            font-size: 11px;
            letter-spacing: 2px;
            color: var(--g);
            border-left: 2px solid transparent;
            transition: all .18s;
            user-select: none;
        }

        .nav-item:hover {
            background: var(--v-soft);
            color: var(--w);
            border-left-color: var(--v-dim);
        }

        .nav-item.active {
            background: rgba(123, 94, 167, 0.12);
            color: var(--w);
            border-left-color: var(--v);
        }

        .nav-item .nav-icon {
            font-size: 13px;
            width: 16px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-badge {
            margin-left: auto;
            font-family: var(--fo);
            font-size: 7px;
            letter-spacing: 1px;
            color: var(--v);
            background: rgba(123, 94, 167, 0.15);
            padding: 1px 6px;
            border: 1px solid var(--v-dim);
        }

        .sidebar-sep {
            height: 1px;
            background: rgba(255, 255, 255, 0.04);
            margin: 8px 0;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding: 16px 22px;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
        }

        .logout-btn {
            font-family: var(--fm);
            font-size: 10px;
            letter-spacing: 2px;
            color: var(--g);
            background: transparent;
            border: 1px solid var(--g-dark);
            padding: 8px 14px;
            cursor: pointer;
            transition: all .18s;
            width: 100%;
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
        }

        .logout-btn:hover {
            border-color: #C0392B;
            color: #C0392B;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 32px;
            padding-bottom: 18px;
            border-bottom: 1px solid rgba(255, 255, 255, .05);
        }

        .page-header h2 {
            font-family: var(--fh);
            font-size: 34px;
            letter-spacing: 6px;
            color: var(--w);
            line-height: 1;
        }

        .page-header small {
            font-family: var(--fm);
            font-size: 9px;
            color: var(--g);
            letter-spacing: 2px;
            display: block;
            margin-top: 5px;
        }

        /* ── FORM CARD ── */
        .form-card {
            background: var(--ink2);
            border: 1px solid rgba(255, 255, 255, .05);
            padding: 28px 32px;
            margin-bottom: 28px;
        }

        .form-card h3 {
            font-family: var(--fh);
            font-size: 18px;
            letter-spacing: 4px;
            color: var(--w);
            margin-bottom: 24px;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, .05);
        }

        .section-title {
            font-family: var(--fm);
            font-size: 9px;
            letter-spacing: 3px;
            color: var(--v-dim);
            margin-bottom: 14px;
            margin-top: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            width: 16px;
            height: 1px;
            background: var(--v-dim);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .form-grid-1 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .col-span-2 {
            grid-column: span 2;
        }

        .col-span-3 {
            grid-column: span 3;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-family: var(--fm);
            font-size: 8px;
            letter-spacing: 2px;
            color: var(--g);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            background: var(--ink3);
            border: 1px solid var(--g-dark);
            border-left: 2px solid var(--v-dim);
            color: var(--w);
            font-family: var(--fm);
            font-size: 11px;
            padding: 9px 12px;
            outline: none;
            letter-spacing: 1px;
            transition: all .18s;
            appearance: none;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--v);
            box-shadow: 0 0 0 1px rgba(123, 94, 167, .2);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #2a2a2a;
        }

        .form-group select option {
            background: var(--ink2);
        }

        /* ── UPLOAD ZONE ── */
        .upload-zone {
            background: var(--ink3);
            border: 1px dashed var(--v-dim);
            padding: 24px 16px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            position: relative;
            overflow: hidden;
        }

        .upload-zone:hover,
        .upload-zone.dragover {
            border-color: var(--v);
            background: rgba(123, 94, 167, .08);
        }

        .upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
            border: none;
            padding: 0;
        }

        .upload-zone .uz-icon {
            font-size: 22px;
            color: var(--v-dim);
            display: block;
            margin-bottom: 8px;
        }

        .upload-zone .uz-label {
            font-family: var(--fm);
            font-size: 8px;
            letter-spacing: 2px;
            color: var(--g);
        }

        .upload-zone .uz-sub {
            font-family: var(--fm);
            font-size: 7px;
            letter-spacing: 1px;
            color: #333;
            margin-top: 4px;
        }

        .upload-zone .uz-preview {
            display: none;
            width: 100%;
            max-height: 140px;
            object-fit: contain;
            margin-bottom: 6px;
        }

        .upload-zone .uz-filename {
            font-family: var(--fm);
            font-size: 8px;
            color: var(--v);
            letter-spacing: 1px;
            margin-top: 4px;
            display: none;
            word-break: break-all;
        }

        /* ── FORMATO PORTADAS GRID ── */
        .formatos-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .formato-card {
            background: var(--ink3);
            border: 1px solid var(--g-dark);
            padding: 0;
            position: relative;
            transition: border-color .2s;
        }

        .formato-card:hover {
            border-color: rgba(123, 94, 167, .4);
        }

        .formato-card .fc-header {
            background: rgba(123, 94, 167, .08);
            border-bottom: 1px solid rgba(123, 94, 167, .15);
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .formato-card .fc-name {
            font-family: var(--fo);
            font-size: 9px;
            letter-spacing: 2px;
            color: var(--v);
        }

        .formato-card .fc-mult {
            font-family: var(--fm);
            font-size: 7px;
            color: var(--g);
            letter-spacing: 1px;
        }

        .formato-card .upload-zone {
            border: none;
            border-radius: 0;
            padding: 16px 10px;
        }

        .formato-card .upload-zone .uz-icon {
            font-size: 16px;
        }

        .formato-card .upload-zone .uz-label {
            font-size: 7px;
        }

        /* ── REPARTO TAGS ── */
        .reparto-wrap {
            background: var(--ink3);
            border: 1px solid var(--g-dark);
            border-left: 2px solid var(--v-dim);
            min-height: 44px;
            padding: 6px 8px;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            align-items: center;
            cursor: text;
            transition: border-color .18s;
        }

        .reparto-wrap:focus-within {
            border-color: var(--v);
            box-shadow: 0 0 0 1px rgba(123, 94, 167, .2);
        }

        .reparto-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(123, 94, 167, .18);
            border: 1px solid var(--v-dim);
            padding: 3px 8px 3px 6px;
            font-family: var(--fm);
            font-size: 9px;
            letter-spacing: 1px;
            color: var(--w);
            animation: tagIn .2s ease;
        }

        @keyframes tagIn {
            from {
                opacity: 0;
                transform: scale(.85);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .reparto-tag .tag-remove {
            cursor: pointer;
            color: var(--g);
            font-size: 10px;
            line-height: 1;
            transition: color .15s;
        }

        .reparto-tag .tag-remove:hover {
            color: var(--red);
        }

        .reparto-search-wrap {
            display: flex;
            gap: 8px;
            margin-top: 8px;
            align-items: center;
        }

        .reparto-search-wrap input {
            flex: 1;
            background: var(--ink3);
            border: 1px solid var(--g-dark);
            border-left: 2px solid var(--v-dim);
            color: var(--w);
            font-family: var(--fm);
            font-size: 11px;
            padding: 7px 10px;
            outline: none;
            transition: border-color .18s;
        }

        .reparto-search-wrap input:focus {
            border-color: var(--v);
        }

        .reparto-search-wrap input::placeholder {
            color: #2a2a2a;
        }

        .actor-dropdown {
            position: absolute;
            z-index: 100;
            background: var(--ink2);
            border: 1px solid var(--v-dim);
            width: 100%;
            max-height: 180px;
            overflow-y: auto;
            display: none;
        }

        .actor-dropdown.open {
            display: block;
        }

        .actor-dropdown-item {
            padding: 9px 14px;
            font-family: var(--fm);
            font-size: 10px;
            letter-spacing: 1px;
            color: var(--g);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, .03);
            transition: background .12s;
        }

        .actor-dropdown-item:hover {
            background: var(--v-soft);
            color: var(--w);
        }

        .actor-dropdown-item .adi-thumb {
            width: 26px;
            height: 26px;
            background: var(--ink3);
            border: 1px solid var(--v-dim);
            object-fit: cover;
            flex-shrink: 0;
        }

        .actor-dropdown-item .adi-name {
            flex: 1;
        }

        .actor-dropdown-empty {
            padding: 12px 14px;
            font-family: var(--fm);
            font-size: 9px;
            color: var(--g);
            letter-spacing: 1px;
        }

        /* ── DIRECTOR SEARCH ── */
        .director-search-wrap {
            position: relative;
        }

        .director-selected {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(123, 94, 167, .1);
            border: 1px solid var(--v-dim);
            padding: 7px 12px;
            margin-top: 6px;
        }

        .director-selected .ds-name {
            font-family: var(--fm);
            font-size: 10px;
            letter-spacing: 1px;
            color: var(--w);
            flex: 1;
        }

        .director-selected .ds-clear {
            cursor: pointer;
            color: var(--g);
            font-size: 12px;
            transition: color .15s;
        }

        .director-selected .ds-clear:hover {
            color: var(--red);
        }

        /* ── FORM ACTIONS ── */
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, .04);
        }

        .btn {
            font-family: var(--fo);
            font-size: 8px;
            letter-spacing: 2px;
            border: none;
            padding: 10px 24px;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-add {
            background: var(--v);
            color: var(--w);
        }

        .btn-add:hover {
            background: #9370C8;
            box-shadow: 0 0 14px var(--v-glow);
        }

        .btn-add:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        .btn-clear {
            background: transparent;
            color: var(--g);
            border: 1px solid var(--g-dark);
            font-family: var(--fm);
            font-size: 9px;
            letter-spacing: 2px;
            padding: 9px 18px;
            cursor: pointer;
            transition: all .18s;
        }

        .btn-clear:hover {
            border-color: var(--v-dim);
            color: var(--w);
        }

        /* ── FIELD ERROR ── */
        .field-error {
            font-family: var(--fm);
            font-size: 8px;
            color: var(--red);
            letter-spacing: 1px;
            margin-top: 2px;
            display: none;
        }

        .field-error.show {
            display: block;
        }

        .input-error {
            border-color: var(--red) !important;
        }

        /* ── VIEWS ── */
        .view {
            display: none;
        }

        .view.active {
            display: block;
        }

        /* ── HINT ── */
        .hint-box {
            background: rgba(123, 94, 167, .06);
            border: 1px solid rgba(123, 94, 167, .15);
            border-left: 3px solid var(--v-dim);
            padding: 10px 16px;
            font-family: var(--fm);
            font-size: 9px;
            letter-spacing: 1px;
            color: var(--g);
            margin-bottom: 20px;
        }

        /* ── REPARTO POSITION wrapper ── */
        .reparto-outer {
            position: relative;
        }

        .main {
            flex: 1;
            margin-left: 220px;
            padding: 32px 36px 60px;
            min-width: 0;
            overflow-x: hidden;
            overflow-y: auto;
            height: 100vh;
        }

        /* ── SPINENR ── */
        .spinner {
            width: 12px;
            height: 12px;
            border: 2px solid rgba(255, 255, 255, .2);
            border-top-color: var(--w);
            border-radius: 50%;
            animation: spin .6s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media(max-width:900px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
            }

            .formatos-grid {
                grid-template-columns: 1fr 1fr;
            }

            .main {
                padding: 20px 20px 60px;
            }
        }

        @media(max-width:600px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .formatos-grid {
                grid-template-columns: 1fr 1fr;
            }

            .col-span-2,
            .col-span-3 {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>
    <div class="shell">
        <nav class="sidebar">
            <div class="sidebar-label">// MÓDULOS</div>
            <div class="nav-item" onclick="switchView('director', this)">
                <span class="nav-icon">⬡</span> DIRECTOR
                <span class="nav-badge">{{ str_pad(count($directores), 2, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="nav-item" onclick="switchView('actor', this)">
                <span class="nav-icon">◈</span> ACTOR
                <span class="nav-badge">{{ str_pad(count($actores), 2, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="nav-item" onclick="switchView('pelicula', this)">
                <span class="nav-icon">▶</span> PELÍCULA
                <span class="nav-badge">{{ str_pad(count($peliculas), 2, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="nav-item" onclick="switchView('ingreso', this)">
                <span class="nav-icon">⊞</span> INGRESO CINTAS
                <span class="nav-badge">{{ str_pad(count($formatos), 2, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="nav-item" onclick="switchView('perfil', this)">
                <span class="nav-icon">◈</span> MI PERFIL
            </div>
            <div class="nav-item" onclick="switchView('estado-cintas', this)">
                <span class="nav-icon">◧</span> ESTADO CINTAS
            </div>
            <div class="nav-item" onclick="switchView('prestamos', this)">
                <span class="nav-icon">⬡</span> PRÉSTAMOS
            </div>
            <div class="sidebar-sep"></div>
            <div class="sidebar-label">// SISTEMA</div>
            <div class="nav-item" onclick="switchView('config', this)">
                <span class="nav-icon">⚙</span> CONFIGURACIÓN
            </div>

            <div class="sidebar-bottom">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-btn" type="submit">⎋ &nbsp;CERRAR SESIÓN</button>
                </form>
            </div>
        </nav>
    <main class="main">
        <div class="view active" id="view-director">
            <div class="page-header">
                <div>
                    <h2>DIRECTORES</h2>
                    <small>// REGISTRO DE DIRECTORES CINEMATOGRÁFICOS</small>
                </div>
                <div>
                    <button class="btn-clear" onclick="clearForm('dir')">LIMPIAR FORM</button>
                </div>
            </div>
            <div class="form-card">
                <h3>AGREGAR DIRECTOR</h3>
                <div class="form-grid">
                    <div class="form-group col-span-2">
                        <label>NOMBRE COMPLETO</label>
                        <input type="text" id="dir-nombre" placeholder="EJ: RIDLEY SCOTT">
                        <span class="field-error" id="dir-err-nombre"></span>
                    </div>
                    <div class="form-group">
                        <label>FOTOGRAFÍA</label>
                        <div class="upload-zone" id="dir-foto-zone" ondragover="dzDrag(this)" ondragleave="dzLeave(this)" ondrop="dzDrop(this,'dir-foto-input','dir-foto-prev')">
                            <input type="file" id="dir-foto-input" accept="image/*" onchange="previewUpload(this,'dir-foto-prev','dir-foto-zone')">
                            <img class="uz-preview" id="dir-foto-prev">
                            <span class="uz-icon">⬡</span>
                            <div class="uz-label">ARRASTRAR O CLIC</div>
                            <div class="uz-sub">JPG / PNG / WEBP · MAX 2MB</div>
                            <div class="uz-filename" id="dir-foto-name"></div>
                        </div>
                        <span class="field-error" id="dir-err-foto"></span>
                    </div>
                    <div class="form-group col-span-3">
                        <label>BIOGRAFÍA</label>
                        <textarea id="dir-bio" rows="5" placeholder="Descripción del director, trayectoria, estilo cinematográfico..."></textarea>
                        <span class="field-error" id="dir-err-bio"></span>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn btn-add" id="btnDir" onclick="submitDirector()">+ REGISTRAR DIRECTOR</button>
                    <button class="btn-clear" onclick="clearForm('dir')">LIMPIAR</button>
                </div>
            </div>
            <div class="form-card">
                <h3>DIRECTORES REGISTRADOS</h3>
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="border-bottom:1px solid rgba(255,255,255,.06);">
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">#</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">FOTO</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">NOMBRE</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">BIOGRAFÍA</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:center;font-weight:400;">ACCIÓN</th>
                            </tr>
                        </thead>
                        <tbody id="directores-tbody">
                            @forelse($directores as $d)
                            <tr data-id="{{ $d->id_director }}"
                                data-nombre="{{ strtoupper($d->nombre) }}"
                                data-bio="{{ $d->biografia ?? '' }}"
                                data-foto="{{ $d->foto ? asset('storage/'.$d->foto) : '' }}"
                                style="border-bottom:1px solid rgba(255,255,255,.03); transition:background .15s;"
                                onmouseover="this.style.background='rgba(123,94,167,.05)'"
                                onmouseout="this.style.background='transparent'">
                                <td style="font-family:var(--fm);font-size:9px;color:var(--g);padding:12px 12px;">
                                    {{ str_pad($d->id_director, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td style="padding:12px 12px;">
                                    @if($d->foto)
                                    <img src="{{ asset('storage/' . $d->foto) }}"
                                        style="width:36px;height:36px;object-fit:cover;border:1px solid var(--v-dim);">
                                    @else
                                    <div style="width:36px;height:36px;background:var(--ink3);border:1px solid var(--g-dark);display:flex;align-items:center;justify-content:center;font-family:var(--fo);font-size:10px;color:var(--v-dim);">
                                        {{ strtoupper(substr($d->nombre, 0, 2)) }}
                                    </div>
                                    @endif
                                </td>
                                <td style="font-family:var(--fm);font-size:10px;letter-spacing:1px;color:var(--w);padding:12px 12px;">
                                    {{ strtoupper($d->nombre) }}
                                </td>
                                <td style="font-family:var(--fm);font-size:9px;color:var(--g);padding:12px 12px;max-width:300px;">
                                    {{ $d->biografia ? Str::limit($d->biografia, 70) : '—' }}
                                </td>
                                <td style="padding:12px 12px;text-align:center;">
                                    <div style="display:flex;gap:6px;justify-content:center;">
                                        <button class="btn-edit-director"
                                            style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--v);background:transparent;border:1px solid var(--v-dim);padding:5px 12px;cursor:pointer;transition:all .18s;">
                                            ✎ EDITAR
                                        </button>
                                        <button class="btn-del-director"
                                            style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--red);background:transparent;border:1px solid var(--red);padding:5px 12px;cursor:pointer;transition:all .18s;opacity:.7;"
                                            onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='.7'">
                                            ✕ ELIMINAR
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="directores-empty">
                                <td colspan="5" style="font-family:var(--fm);font-size:9px;color:var(--g);padding:24px;text-align:center;letter-spacing:2px;">
                                    ⌦ SIN DIRECTORES REGISTRADOS
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="modal-edit-director" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.7); z-index:10000; align-items:center; justify-content:center;">
                <div style="background:var(--ink2); border:1px solid rgba(123,94,167,.3); width:100%; max-width:520px; margin:0 20px;">
                    <div style="padding:18px 24px; border-bottom:1px solid rgba(255,255,255,.05); display:flex; align-items:center; justify-content:space-between;">
                        <span style="font-family:var(--fh);font-size:18px;letter-spacing:4px;color:var(--w);">EDITAR DIRECTOR</span>
                        <span onclick="closeEditDirector()" style="cursor:pointer;color:var(--g);font-size:18px;transition:color .15s;"
                            onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--g)'">✕</span>
                    </div>
                    <div style="padding:24px;">
                        <input type="hidden" id="edit-dir-id">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
                            <div class="form-group" style="grid-column:span 2;">
                                <label>NOMBRE COMPLETO</label>
                                <input type="text" id="edit-dir-nombre" placeholder="EJ: RIDLEY SCOTT">
                                <span class="field-error" id="edit-dir-err-nombre"></span>
                            </div>
                            <div class="form-group" style="grid-column:span 2;">
                                <label>BIOGRAFÍA</label>
                                <textarea id="edit-dir-bio" rows="4" placeholder="Descripción del director..."></textarea>
                            </div>
                            <div class="form-group" style="grid-column:span 2;">
                                <label>FOTO ACTUAL / NUEVA FOTO</label>
                                <div style="display:flex;gap:12px;align-items:center;">
                                    <img id="edit-dir-foto-prev" src=""
                                        style="width:52px;height:52px;object-fit:cover;border:1px solid var(--v-dim);display:none;">
                                    <div id="edit-dir-foto-initials"
                                        style="width:52px;height:52px;background:var(--ink3);border:1px solid var(--g-dark);display:flex;align-items:center;justify-content:center;font-family:var(--fo);font-size:14px;color:var(--v-dim);">
                                    </div>
                                    <div class="upload-zone" style="flex:1;padding:12px;">
                                        <input type="file" id="edit-dir-foto-input" accept="image/*"
                                            onchange="previewEditFoto(this)">
                                        <span class="uz-icon" style="font-size:16px;">⬡</span>
                                        <div class="uz-label">CAMBIAR FOTO</div>
                                        <div class="uz-sub">JPG/PNG/WEBP · MAX 2MB</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="display:flex;gap:10px;padding-top:16px;border-top:1px solid rgba(255,255,255,.04);">
                            <button class="btn btn-add" id="btnEditarDirector" onclick="submitEditDirector()">✓ GUARDAR CAMBIOS</button>
                            <button class="btn-clear" onclick="closeEditDirector()">CANCELAR</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="view" id="view-actor">
            <div class="page-header">
                <div>
                    <h2>ACTORES</h2>
                    <small>// REGISTRO DE ACTORES Y ACTRICES</small>
                </div>
                <div>
                    <button class="btn-clear" onclick="clearForm('act')">LIMPIAR FORM</button>
                </div>
            </div>

            <div class="form-card">
                <h3>AGREGAR ACTOR</h3>
                <div class="form-grid">
                    <div class="form-group col-span-2">
                        <label>NOMBRE COMPLETO</label>
                        <input type="text" id="act-nombre" placeholder="EJ: HARRISON FORD">
                        <span class="field-error" id="act-err-nombre"></span>
                    </div>
                    <div class="form-group">
                        <label>FOTOGRAFÍA</label>
                        <div class="upload-zone" id="act-foto-zone" ondragover="dzDrag(this)" ondragleave="dzLeave(this)">
                            <input type="file" id="act-foto-input" accept="image/*" onchange="previewUpload(this,'act-foto-prev','act-foto-zone')">
                            <img class="uz-preview" id="act-foto-prev">
                            <span class="uz-icon">◈</span>
                            <div class="uz-label">ARRASTRAR O CLIC</div>
                            <div class="uz-sub">JPG / PNG / WEBP · MAX 2MB</div>
                            <div class="uz-filename" id="act-foto-name"></div>
                        </div>
                        <span class="field-error" id="act-err-foto"></span>
                    </div>
                    <div class="form-group col-span-3">
                        <label>BIOGRAFÍA</label>
                        <textarea id="act-bio" rows="5" placeholder="Descripción del actor, filmografía destacada, premios..."></textarea>
                        <span class="field-error" id="act-err-bio"></span>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn btn-add" id="btnAct" onclick="submitActor()">+ REGISTRAR ACTOR</button>
                    <button class="btn-clear" onclick="clearForm('act')">LIMPIAR</button>
                </div>
            </div>

            <div class="form-card">
                <h3>ACTORES REGISTRADOS</h3>
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="border-bottom:1px solid rgba(255,255,255,.06);">
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">#</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">FOTO</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">NOMBRE</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">BIOGRAFÍA</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:center;font-weight:400;">ACCIÓN</th>
                            </tr>
                        </thead>
                        <tbody id="actores-tbody">
                            @forelse($actores as $a)
                            <tr data-id="{{ $a->id_actor }}"
                                data-nombre="{{ strtoupper($a->nombre) }}"
                                data-bio="{{ $a->biografia ?? '' }}"
                                data-foto="{{ $a->foto ? asset('storage/'.$a->foto) : '' }}"
                                style="border-bottom:1px solid rgba(255,255,255,.03); transition:background .15s;"
                                onmouseover="this.style.background='rgba(123,94,167,.05)'"
                                onmouseout="this.style.background='transparent'">
                                <td style="font-family:var(--fm);font-size:9px;color:var(--g);padding:12px 12px;">
                                    {{ str_pad($a->id_actor, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td style="padding:12px 12px;">
                                    @if($a->foto)
                                    <img src="{{ asset('storage/' . $a->foto) }}" style="width:36px;height:36px;object-fit:cover;border:1px solid var(--v-dim);">
                                    @else
                                    <div style="width:36px;height:36px;background:var(--ink3);border:1px solid var(--g-dark);display:flex;align-items:center;justify-content:center;font-family:var(--fo);font-size:10px;color:var(--v-dim);">
                                        {{ strtoupper(substr($a->nombre, 0, 2)) }}
                                    </div>
                                    @endif
                                </td>
                                <td style="font-family:var(--fm);font-size:10px;letter-spacing:1px;color:var(--w);padding:12px 12px;">
                                    {{ strtoupper($a->nombre) }}
                                </td>
                                <td style="font-family:var(--fm);font-size:9px;color:var(--g);padding:12px 12px;max-width:300px;">
                                    {{ $a->biografia ? Str::limit($a->biografia, 70) : '—' }}
                                </td>
                                <td style="padding:12px 12px;text-align:center;">
                                    <div style="display:flex;gap:6px;justify-content:center;">
                                        <button class="btn-edit-actor"
                                            style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--v);background:transparent;border:1px solid var(--v-dim);padding:5px 12px;cursor:pointer;transition:all .18s;">
                                            ✎ EDITAR
                                        </button>
                                        <button class="btn-del-actor"
                                            style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--red);background:transparent;border:1px solid var(--red);padding:5px 12px;cursor:pointer;transition:all .18s;opacity:.7;"
                                            onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='.7'">
                                            ✕ ELIMINAR
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="actores-empty">
                                <td colspan="5" style="font-family:var(--fm);font-size:9px;color:var(--g);padding:24px;text-align:center;letter-spacing:2px;">
                                    ⌦ SIN ACTORES REGISTRADOS
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MODAL EDITAR ACTOR -->
            <div id="modal-edit-actor" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.7); z-index:10000; align-items:center; justify-content:center;">
                <div style="background:var(--ink2); border:1px solid rgba(123,94,167,.3); width:100%; max-width:520px; margin:0 20px;">
                    <div style="padding:18px 24px; border-bottom:1px solid rgba(255,255,255,.05); display:flex; align-items:center; justify-content:space-between;">
                        <span style="font-family:var(--fh);font-size:18px;letter-spacing:4px;color:var(--w);">EDITAR ACTOR</span>
                        <span onclick="closeEditActor()" style="cursor:pointer;color:var(--g);font-size:18px;transition:color .15s;"
                            onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--g)'">✕</span>
                    </div>
                    <div style="padding:24px;">
                        <input type="hidden" id="edit-act-id">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
                            <div class="form-group" style="grid-column:span 2;">
                                <label>NOMBRE COMPLETO</label>
                                <input type="text" id="edit-act-nombre" placeholder="EJ: HARRISON FORD">
                                <span class="field-error" id="edit-act-err-nombre"></span>
                            </div>
                            <div class="form-group" style="grid-column:span 2;">
                                <label>BIOGRAFÍA</label>
                                <textarea id="edit-act-bio" rows="4" placeholder="Descripción del actor..."></textarea>
                            </div>
                            <div class="form-group" style="grid-column:span 2;">
                                <label>FOTO ACTUAL / NUEVA FOTO</label>
                                <div style="display:flex;gap:12px;align-items:center;">
                                    <img id="edit-act-foto-prev" src="" style="width:52px;height:52px;object-fit:cover;border:1px solid var(--v-dim);display:none;">
                                    <div id="edit-act-foto-initials" style="width:52px;height:52px;background:var(--ink3);border:1px solid var(--g-dark);display:flex;align-items:center;justify-content:center;font-family:var(--fo);font-size:14px;color:var(--v-dim);"></div>
                                    <div class="upload-zone" style="flex:1;padding:12px;">
                                        <input type="file" id="edit-act-foto-input" accept="image/*" onchange="previewEditActorFoto(this)">
                                        <span class="uz-icon" style="font-size:16px;">◈</span>
                                        <div class="uz-label">CAMBIAR FOTO</div>
                                        <div class="uz-sub">JPG/PNG/WEBP · MAX 2MB</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display:flex;gap:10px;padding-top:16px;border-top:1px solid rgba(255,255,255,.04);">
                            <button class="btn btn-add" id="btnEditarActor" onclick="submitEditActor()">✓ GUARDAR CAMBIOS</button>
                            <button class="btn-clear" onclick="closeEditActor()">CANCELAR</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="view" id="view-pelicula">
            <div class="page-header">
                <div>
                    <h2>PELÍCULAS</h2>
                    <small>// REGISTRO DE TÍTULOS EN CATÁLOGO</small>
                </div>
                <div>
                    <button class="btn-clear" onclick="clearForm('pel')">LIMPIAR FORM</button>
                </div>
            </div>
            <div class="form-card">
                <h3>INFORMACIÓN PRINCIPAL</h3>
                <div class="form-grid">
                    <div class="form-group col-span-2">
                        <label>TÍTULO</label>
                        <input type="text" id="pel-titulo" placeholder="EJ: BLADE RUNNER">
                        <span class="field-error" id="pel-err-titulo"></span>
                    </div>
                    <div class="form-group">
                        <label>AÑO DE LANZAMIENTO</label>
                        <input type="number" id="pel-anio" placeholder="1982" min="1880" max="2099">
                        <span class="field-error" id="pel-err-anio"></span>
                    </div>
                    <div class="form-group">
                        <label>DURACIÓN (MIN)</label>
                        <input type="number" id="pel-duracion" placeholder="117" min="1">
                        <span class="field-error" id="pel-err-duracion"></span>
                    </div>
                    <div class="form-group">
                        <label>ESTUDIO</label>
                        <input type="text" id="pel-estudio" placeholder="EJ: WARNER BROS.">
                        <span class="field-error" id="pel-err-estudio"></span>
                    </div>
                    <div class="form-group">
                        <label>PRECIO ALQUILER (BASE)</label>
                        <input type="number" id="pel-precio" placeholder="50000" step="0.01" min="0">
                        <span class="field-error" id="pel-err-precio"></span>
                    </div>
                    <div class="form-group">
                        <label>CLASIFICACIÓN</label>
                        <select id="pel-clasificacion">
                            <option value="">— SELECCIONAR —</option>
                            <option value="G">G — TODO PÚBLICO</option>
                            <option value="PG">PG — GUÍA PARENTAL</option>
                            <option value="PG-13">PG-13 — MAYORES DE 13</option>
                            <option value="R">R — RESTRINGIDA</option>
                            <option value="NC-17">NC-17 — SOLO ADULTOS</option>
                        </select>
                        <span class="field-error" id="pel-err-clasificacion"></span>
                    </div>
                    <div class="form-group">
                        <label>GÉNERO</label>
                        <select id="pel-genero">
                            <option value="">— SELECCIONAR —</option>
                            @foreach($generos as $g)
                            <option value="{{ $g->id_genero }}">{{ strtoupper($g->nombre) }}</option>
                            @endforeach
                        </select>
                        <span class="field-error" id="pel-err-genero"></span>
                    </div>
                    <div class="form-group col-span-3">
                        <label>RESUMEN / SINOPSIS</label>
                        <textarea id="pel-resumen" rows="4" placeholder="Descripción argumental de la película..."></textarea>
                        <span class="field-error" id="pel-err-resumen"></span>
                    </div>
                </div>
            </div>
            <div class="form-card">
                <h3>DIRECTOR</h3>
                <div class="form-group director-search-wrap">
                    <label>BUSCAR DIRECTOR</label>
                    <div style="position:relative;">
                        <input type="text" id="pel-dir-search" placeholder="EJ: RIDLEY SCOTT" oninput="searchDirector(this.value)" autocomplete="off">
                        <input type="hidden" id="pel-id-director">
                        <div class="actor-dropdown" id="dir-dropdown">
                        </div>
                    </div>
                    <div class="director-selected" id="dir-selected-box" style="display:none;">
                        <span class="ds-name" id="dir-selected-name"></span>
                        <span class="ds-clear" onclick="clearDirectorSelection()" title="Quitar selección">✕</span>
                    </div>
                    <span class="field-error" id="pel-err-director"></span>
                </div>
            </div>
            <div class="form-card">
                <h3>REPARTO</h3>
                <div class="form-group">
                    <label>ACTORES SELECCIONADOS</label>
                    <div class="reparto-wrap" id="reparto-tags" onclick="document.getElementById('reparto-search').focus()">
                        <span id="reparto-placeholder" style="font-family:var(--fm);font-size:9px;color:#333;letter-spacing:1px;pointer-events:none;">SIN ACTORES AGREGADOS...</span>
                    </div>
                </div>
                <div class="reparto-outer" style="margin-top:10px;">
                    <div class="reparto-search-wrap">
                        <input type="text" id="reparto-search" placeholder="BUSCAR ACTOR POR NOMBRE..." oninput="searchActor(this.value)" autocomplete="off">
                        <button class="btn btn-add" style="padding:7px 16px;font-size:8px;" onclick="addCurrentActor()">+ AÑADIR</button>
                    </div>
                    <div class="actor-dropdown" id="actor-dropdown">
                    </div>
                </div>
                <input type="hidden" id="pel-reparto-ids"><!-- comma-separated ids -->
                <span class="field-error" id="pel-err-reparto"></span>
            </div>
            <div class="form-card">
                <h3>PORTADA POR FORMATO</h3>
                <div class="hint-box">⌦ &nbsp;Cada formato puede tener su propia portada.</div>
                <div class="formatos-grid">
                    <div class="formato-card">
                        <div class="fc-header">
                            <span class="fc-name">DVD</span>
                            <span class="fc-mult">×1.00 BASE</span>
                        </div>
                        <div class="upload-zone" ondragover="dzDrag(this)" ondragleave="dzLeave(this)">
                            <input type="file" id="fmt-dvd" accept="image/*" data-formato="1" onchange="previewUpload(this,'fmt-dvd-prev',null)">
                            <img class="uz-preview" id="fmt-dvd-prev">
                            <span class="uz-icon">▣</span>
                            <div class="uz-label">PORTADA DVD</div>
                            <div class="uz-sub">JPG/PNG · MAX 4MB</div>
                        </div>
                    </div>
                    <div class="formato-card">
                        <div class="fc-header">
                            <span class="fc-name">BLU-RAY</span>
                            <span class="fc-mult">×1.50</span>
                        </div>
                        <div class="upload-zone" ondragover="dzDrag(this)" ondragleave="dzLeave(this)">
                            <input type="file" id="fmt-bluray" accept="image/*" data-formato="2" onchange="previewUpload(this,'fmt-bluray-prev',null)">
                            <img class="uz-preview" id="fmt-bluray-prev">
                            <span class="uz-icon">▣</span>
                            <div class="uz-label">PORTADA BLU-RAY</div>
                            <div class="uz-sub">JPG/PNG · MAX 4MB</div>
                        </div>
                    </div>
                    <div class="formato-card">
                        <div class="fc-header">
                            <span class="fc-name">BLU-RAY UHD</span>
                            <span class="fc-mult">×2.50</span>
                        </div>
                        <div class="upload-zone" ondragover="dzDrag(this)" ondragleave="dzLeave(this)">
                            <input type="file" id="fmt-uhdbd" accept="image/*" data-formato="3" onchange="previewUpload(this,'fmt-uhdbd-prev',null)">
                            <img class="uz-preview" id="fmt-uhdbd-prev">
                            <span class="uz-icon">▣</span>
                            <div class="uz-label">PORTADA UHD</div>
                            <div class="uz-sub">JPG/PNG · MAX 4MB</div>
                        </div>
                    </div>
                    <div class="formato-card" style="border-color:rgba(123,94,167,.3);">
                        <div class="fc-header" style="background:rgba(123,94,167,.15); border-color:rgba(123,94,167,.3);">
                            <span class="fc-name" style="color:var(--v);">VHS ★</span>
                            <span class="fc-mult">×2.00</span>
                        </div>
                        <div class="upload-zone" ondragover="dzDrag(this)" ondragleave="dzLeave(this)">
                            <input type="file" id="fmt-vhs" accept="image/*" data-formato="4" onchange="previewUpload(this,'fmt-vhs-prev',null)">
                            <img class="uz-preview" id="fmt-vhs-prev">
                            <span class="uz-icon" style="color:var(--v);">▣</span>
                            <div class="uz-label">CARATULA VHS</div>
                            <div class="uz-sub">JPG/PNG · MAX 4MB</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-card">
                <h3>IMÁGENES DE LA PELÍCULA</h3>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label>FOTO PORTADA PRINCIPAL</label>
                        <div class="upload-zone" ondragover="dzDrag(this)" ondragleave="dzLeave(this)">
                            <input type="file" id="pel-portada" accept="image/*" onchange="previewUpload(this,'pel-portada-prev',null)">
                            <img class="uz-preview" id="pel-portada-prev">
                            <span class="uz-icon">▶</span>
                            <div class="uz-label">FOTO PORTADA</div>
                            <div class="uz-sub">JPG/PNG/WEBP · MAX 4MB</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>BANNER / BACKDROP</label>
                        <div class="upload-zone" style="height:100%;" ondragover="dzDrag(this)" ondragleave="dzLeave(this)">
                            <input type="file" id="pel-banner" accept="image/*" onchange="previewUpload(this,'pel-banner-prev',null)">
                            <img class="uz-preview" id="pel-banner-prev">
                            <span class="uz-icon">⬡</span>
                            <div class="uz-label">BANNER HORIZONTAL</div>
                            <div class="uz-sub">JPG/PNG/WEBP · MAX 8MB · 16:9 RECOMENDADO</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button class="btn btn-add" id="btnPel" onclick="submitPelicula()">+ REGISTRAR PELÍCULA</button>
                <button class="btn-clear" onclick="clearForm('pel')">LIMPIAR</button>
            </div>
        </div>
        <div class="view" id="view-cinta">
            <div class="page-header">
                <div>
                    <h2>CINTAS</h2>
                    <small>// REGISTRO DE UNIDADES FÍSICAS EN INVENTARIO</small>
                </div>
                <div>
                    <button class="btn-clear" onclick="clearForm('cin')">LIMPIAR FORM</button>
                </div>
            </div>

            <div class="form-card">
                <h3>REGISTRAR CINTA</h3>
                <div class="hint-box">⌦ &nbsp;Cada cinta es una unidad física única. Una misma película puede tener múltiples cintas con distintos IDs de inventario.</div>

                <div class="form-grid">
                    <div class="form-group col-span-2">
                        <label>PELÍCULA ASOCIADA</label>
                        <div style="position:relative;">
                            <input type="text" id="cin-pel-search" placeholder="BUSCAR PELÍCULA..." oninput="searchPelicula(this.value)" autocomplete="off">
                            <input type="hidden" id="cin-id-pelicula">
                            <div class="actor-dropdown" id="pel-dropdown"></div>
                        </div>
                        <div class="director-selected" id="cin-pel-selected" style="display:none;">
                            <span class="ds-name" id="cin-pel-selected-name"></span>
                            <span class="ds-clear" onclick="clearPeliculaSelection()" title="Quitar">✕</span>
                        </div>
                        <span class="field-error" id="cin-err-pelicula"></span>
                    </div>
                    <div class="form-group">
                        <label>NÚMERO DE CINTA / ID FÍSICO</label>
                        <input type="text" id="cin-codigo" placeholder="EJ: 055">
                        <span class="field-error" id="cin-err-codigo"></span>
                    </div>
                    <div class="form-group">
                        <label>ESTADO DE LA CINTA</label>
                        <select id="cin-estado">
                            <option value="">— SELECCIONAR —</option>
                            <option value="disponible">DISPONIBLE</option>
                            <option value="prestada">PRESTADA</option>
                            <option value="dañada">DAÑADA</option>
                            <option value="perdida">PERDIDA</option>
                        </select>
                        <span class="field-error" id="cin-err-estado"></span>
                    </div>
                    <div class="form-group">
                        <label>FORMATO</label>
                        <select id="cin-formato">
                            <option value="">— SELECCIONAR —</option>
                            <option value="1">DVD</option>
                            <option value="2">BLU-RAY</option>
                            <option value="3">BLU-RAY UHD</option>
                            <option value="4">VHS</option>
                        </select>
                        <span class="field-error" id="cin-err-formato"></span>
                    </div>
                    <div class="form-group">
                        <label>CONDICIÓN</label>
                        <select id="cin-condicion">
                            <option value="">— SELECCIONAR —</option>
                            <option value="excelente">EXCELENTE</option>
                            <option value="buena">BUENA</option>
                            <option value="regular">REGULAR</option>
                            <option value="mala">MALA</option>
                        </select>
                        <span class="field-error" id="cin-err-condicion"></span>
                    </div>
                    <div class="form-group col-span-3">
                        <label>NOTAS INTERNAS</label>
                        <textarea id="cin-notas" rows="3" placeholder="Observaciones, daños menores, procedencia..."></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button class="btn btn-add" id="btnCin" onclick="submitCinta()">+ REGISTRAR CINTA</button>
                    <button class="btn-clear" onclick="clearForm('cin')">LIMPIAR</button>
                </div>
            </div>
        </div>
        <div class="view" id="view-perfil">
            <div class="page-header">
                <div>
                    <h2>MI PERFIL</h2>
                    <small>// DATOS DE TU CUENTA</small>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:280px 1fr; gap:20px; align-items:start;">
                <div class="form-card" style="display:flex; flex-direction:column; align-items:center; gap:20px; padding:32px 24px;">
                    <div id="avatar-wrap" style="position:relative; width:120px; height:120px;">
                        <div style="width:120px; height:120px; border:2px solid var(--v-dim); overflow:hidden; background:var(--ink3); display:flex; align-items:center; justify-content:center;">
                            @if(auth()->user()->foto_perfil)
                            <img id="avatar-img" src="{{ asset('storage/' . auth()->user()->foto_perfil) }}"
                                style="width:100%; height:100%; object-fit:cover;">
                            @else
                            <img id="avatar-img" src="" style="width:100%; height:100%; object-fit:cover; display:none;">
                            <span id="avatar-initials" style="font-family:var(--fo); font-size:32px; color:var(--v); letter-spacing:2px;">
                                {{ strtoupper(substr(auth()->user()->nombre, 0, 2)) }}
                            </span>
                            @endif
                        </div>
                        <label for="fotoInput" style="position:absolute; inset:0; background:rgba(0,0,0,0); display:flex; align-items:center; justify-content:center; cursor:pointer; transition:background .2s;"
                            onmouseover="this.style.background='rgba(123,94,167,0.45)'; this.querySelector('span').style.opacity='1'"
                            onmouseout="this.style.background='rgba(0,0,0,0)'; this.querySelector('span').style.opacity='0'">
                            <span style="font-family:var(--fm); font-size:8px; letter-spacing:2px; color:var(--w); opacity:0; transition:opacity .2s;">CAMBIAR</span>
                        </label>
                        <input type="file" id="fotoInput" accept="image/*" style="display:none" onchange="uploadFoto(this)">
                    </div>
                    <div id="foto-loading" style="display:none;">
                        <span class="spinner"></span>
                    </div>

                    <!-- Nombre y rol -->
                    <div style="text-align:center;">
                        <div id="perfil-nombre-display" style="font-family:var(--fh); font-size:20px; letter-spacing:4px; color:var(--w);">
                            {{ strtoupper(auth()->user()->nombre) }}
                        </div>
                        <div style="font-family:var(--fm); font-size:9px; letter-spacing:2px; margin-top:4px;
                    color:{{ auth()->user()->rol === 'admin' ? 'var(--v)' : 'var(--amber)' }}">
                            {{ strtoupper(auth()->user()->rol) }}
                        </div>
                    </div>

                    <!-- Estado -->
                    <span class="status-pill activo" style="font-size:8px;">◉ ACTIVO</span>

                    <!-- ID -->
                    <div style="font-family:var(--fm); font-size:8px; color:var(--g); letter-spacing:2px;">
                        ID · {{ str_pad(auth()->user()->id_usuario, 4, '0', STR_PAD_LEFT) }}
                    </div>
                </div>
                <div style="display:flex; flex-direction:column; gap:16px;">
                    <div class="form-card" style="margin-bottom:0;">
                        <h3 style="font-size:14px; letter-spacing:4px; margin-bottom:20px; padding-bottom:12px;">INFORMACIÓN PERSONAL</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>NOMBRE COMPLETO</label>
                                <input type="text" id="p-nombre" value="{{ auth()->user()->nombre }}">
                            </div>
                            <div class="form-group">
                                <label>EMAIL</label>
                                <input type="email" id="p-email" value="{{ auth()->user()->email }}">
                            </div>
                            <div class="form-group">
                                <label>NOMBRE DE USUARIO</label>
                                <input type="text" id="p-usuario" value="{{ auth()->user()->usuario }}"
                                    style="opacity:.6; cursor:not-allowed;" disabled>
                            </div>
                            <div class="form-group">
                                <label>TELÉFONO</label>
                                <input type="text" id="p-telefono" value="{{ auth()->user()->telefono ?? '—' }}">
                            </div>
                            <div class="form-group">
                                <label>DIRECCIÓN</label>
                                <input type="text" id="p-direccion" value="{{ auth()->user()->direccion ?? '—' }}">
                            </div>
                            <div class="form-group">
                                <label>ROL</label>
                                <input type="text" value="{{ strtoupper(auth()->user()->rol) }}"
                                    style="opacity:.6; cursor:not-allowed;" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-card" style="margin-bottom:0;">
                        <h3 style="font-size:14px; letter-spacing:4px; margin-bottom:20px; padding-bottom:12px;">SISTEMA</h3>
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label>ESTADO DE CUENTA</label>
                                <input type="text" value="{{ strtoupper(auth()->user()->estado) }}" disabled
                                    style="opacity:.6; cursor:not-allowed;">
                            </div>
                            <div class="form-group">
                                <label>MIEMBRO DESDE</label>
                                <input type="text" value="{{ auth()->user()->created_at?->format('d/m/Y') ?? '—' }}" disabled
                                    style="opacity:.6; cursor:not-allowed;">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn btn-add" id="btnGuardarPerfil" onclick="submitPerfil()">✓ GUARDAR CAMBIOS</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="view" id="view-ingreso">
            <div class="page-header">
                <div>
                    <h2>INGRESAR CINTAS</h2>
                    <small>// INGRESO DE UNIDADES FÍSICAS POR LOTE · INVENTARIO</small>
                </div>
                <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--v-dim);">⬛ MÓDULO · CINTAS</div>
            </div>

            <div class="form-card">
                <h3>01 · SELECCIONAR PELÍCULA</h3>
                <div class="form-group" style="position:relative;">
                    <label>BUSCAR PELÍCULA EN CATÁLOGO</label>
                    <input type="text" id="ing-pel-search" placeholder="ESCRIBE EL TÍTULO..." oninput="ingSearchPelicula(this.value)" autocomplete="off">
                    <div class="actor-dropdown" id="ing-pel-dropdown"></div>
                    <span class="field-error" id="ing-err-pel"></span>
                </div>
                <div class="director-selected" id="ing-pel-sel" style="display:none;">
                    <span class="ds-name" id="ing-pel-sel-name"></span>
                    <span class="ds-clear" onclick="ingClearPelicula()">✕</span>
                </div>
                <input type="hidden" id="ing-id-pelicula">
            </div>

            <div class="form-card">
                <h3>02 · CANTIDAD POR FORMATO</h3>
                <div class="hint-box">⌦ &nbsp;Define cuántas unidades físicas ingresar de cada formato. Cada unidad recibirá un ID único de inventario automáticamente.</div>
                <div class="formatos-grid">
                    <div class="formato-card">
                        <div class="fc-header">
                            <span class="fc-name">DVD</span>
                            <span class="fc-mult">FMT·01</span>
                        </div>
                        <div style="padding:16px 12px;">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <button onclick="ingChangeQty('dvd',-1)" style="width:30px;height:30px;background:transparent;border:1px solid var(--g-dark);color:var(--g);font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .18s;flex-shrink:0;" onmouseover="this.style.borderColor='var(--v-dim)';this.style.color='var(--v)'" onmouseout="this.style.borderColor='var(--g-dark)';this.style.color='var(--g)'">−</button>
                                <span id="ing-qty-dvd" style="font-family:var(--fo);font-size:22px;letter-spacing:2px;color:var(--w);min-width:28px;text-align:center;flex:1;">0</span>
                                <button onclick="ingChangeQty('dvd',1)" style="width:30px;height:30px;background:transparent;border:1px solid var(--g-dark);color:var(--g);font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .18s;flex-shrink:0;" onmouseover="this.style.borderColor='var(--v-dim)';this.style.color='var(--v)'" onmouseout="this.style.borderColor='var(--g-dark)';this.style.color='var(--g)'">+</button>
                            </div>
                            <div style="font-family:var(--fm);font-size:7px;letter-spacing:2px;color:var(--g);margin-top:6px;text-align:center;">UNIDADES</div>
                        </div>
                    </div>
                    <div class="formato-card">
                        <div class="fc-header">
                            <span class="fc-name">BLU-RAY</span>
                            <span class="fc-mult">FMT·02</span>
                        </div>
                        <div style="padding:16px 12px;">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <button onclick="ingChangeQty('blu',-1)" style="width:30px;height:30px;background:transparent;border:1px solid var(--g-dark);color:var(--g);font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .18s;flex-shrink:0;" onmouseover="this.style.borderColor='var(--v-dim)';this.style.color='var(--v)'" onmouseout="this.style.borderColor='var(--g-dark)';this.style.color='var(--g)'">−</button>
                                <span id="ing-qty-blu" style="font-family:var(--fo);font-size:22px;letter-spacing:2px;color:var(--w);min-width:28px;text-align:center;flex:1;">0</span>
                                <button onclick="ingChangeQty('blu',1)" style="width:30px;height:30px;background:transparent;border:1px solid var(--g-dark);color:var(--g);font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .18s;flex-shrink:0;" onmouseover="this.style.borderColor='var(--v-dim)';this.style.color='var(--v)'" onmouseout="this.style.borderColor='var(--g-dark)';this.style.color='var(--g)'">+</button>
                            </div>
                            <div style="font-family:var(--fm);font-size:7px;letter-spacing:2px;color:var(--g);margin-top:6px;text-align:center;">UNIDADES</div>
                        </div>
                    </div>
                    <div class="formato-card">
                        <div class="fc-header">
                            <span class="fc-name">BLU-RAY UHD</span>
                            <span class="fc-mult">FMT·03</span>
                        </div>
                        <div style="padding:16px 12px;">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <button onclick="ingChangeQty('uhd',-1)" style="width:30px;height:30px;background:transparent;border:1px solid var(--g-dark);color:var(--g);font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .18s;flex-shrink:0;" onmouseover="this.style.borderColor='var(--v-dim)';this.style.color='var(--v)'" onmouseout="this.style.borderColor='var(--g-dark)';this.style.color='var(--g)'">−</button>
                                <span id="ing-qty-uhd" style="font-family:var(--fo);font-size:22px;letter-spacing:2px;color:var(--w);min-width:28px;text-align:center;flex:1;">0</span>
                                <button onclick="ingChangeQty('uhd',1)" style="width:30px;height:30px;background:transparent;border:1px solid var(--g-dark);color:var(--g);font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .18s;flex-shrink:0;" onmouseover="this.style.borderColor='var(--v-dim)';this.style.color='var(--v)'" onmouseout="this.style.borderColor='var(--g-dark)';this.style.color='var(--g)'">+</button>
                            </div>
                            <div style="font-family:var(--fm);font-size:7px;letter-spacing:2px;color:var(--g);margin-top:6px;text-align:center;">UNIDADES</div>
                        </div>
                    </div>
                    <div class="formato-card" style="border-color:rgba(123,94,167,.3);">
                        <div class="fc-header" style="background:rgba(123,94,167,.15);border-color:rgba(123,94,167,.3);">
                            <span class="fc-name" style="color:var(--v);">VHS ★</span>
                            <span class="fc-mult">FMT·04</span>
                        </div>
                        <div style="padding:16px 12px;">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <button onclick="ingChangeQty('vhs',-1)" style="width:30px;height:30px;background:transparent;border:1px solid var(--g-dark);color:var(--g);font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .18s;flex-shrink:0;" onmouseover="this.style.borderColor='var(--v-dim)';this.style.color='var(--v)'" onmouseout="this.style.borderColor='var(--g-dark)';this.style.color='var(--g)'">−</button>
                                <span id="ing-qty-vhs" style="font-family:var(--fo);font-size:22px;letter-spacing:2px;color:var(--w);min-width:28px;text-align:center;flex:1;">0</span>
                                <button onclick="ingChangeQty('vhs',1)" style="width:30px;height:30px;background:transparent;border:1px solid var(--g-dark);color:var(--g);font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .18s;flex-shrink:0;" onmouseover="this.style.borderColor='var(--v-dim)';this.style.color='var(--v)'" onmouseout="this.style.borderColor='var(--g-dark)';this.style.color='var(--g)'">+</button>
                            </div>
                            <div style="font-family:var(--fm);font-size:7px;letter-spacing:2px;color:var(--g);margin-top:6px;text-align:center;">UNIDADES</div>
                        </div>
                    </div>
                </div>
                <div style="background:rgba(123,94,167,.06);border:1px solid rgba(123,94,167,.12);padding:12px 16px;display:flex;align-items:center;justify-content:space-between;">
                    <span style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);">TOTAL DE UNIDADES A INGRESAR</span>
                    <span id="ing-total" style="font-family:var(--fo);font-size:22px;letter-spacing:3px;color:var(--v);">00</span>
                </div>
            </div>

            <div class="form-actions">
                <button class="btn btn-add" id="btn-ing" onclick="ingSubmitLote()">⬛ GENERAR CINTAS</button>
                <button class="btn-clear" onclick="ingResetForm()">LIMPIAR</button>
            </div>

            {{-- MODAL RESULTADO --}}
            <div id="modal-ingreso" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.82);z-index:10000;align-items:center;justify-content:center;padding:20px;">
                <div style="background:var(--ink2);border:1px solid rgba(123,94,167,.35);width:100%;max-width:700px;max-height:88vh;overflow-y:auto;">
                    <div style="padding:18px 24px;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;background:var(--ink2);z-index:10;">
                        <div>
                            <span style="font-family:var(--fh);font-size:22px;letter-spacing:5px;color:var(--w);">CINTAS GENERADAS</span>
                            <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-top:3px;">// REGISTRO EXITOSO · ETIQUETA CADA UNIDAD FÍSICA CON SU ID</div>
                        </div>
                        <span onclick="ingCloseModal()" style="cursor:pointer;color:var(--g);font-size:20px;transition:color .15s;line-height:1;" onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--g)'">✕</span>
                    </div>
                    <div style="padding:24px;" id="ing-modal-body"></div>
                </div>
            </div>
        </div>
        <div class="view" id="view-estado-cintas">
            <div class="page-header">
                <div>
                    <h2>ESTADO DE CINTAS</h2>
                    <small>// GESTIÓN DE ESTADO · INVENTARIO FÍSICO</small>
                </div>
            </div>

            <div class="form-card">
                <h3>FILTRAR CINTAS</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>BUSCAR POR PELÍCULA</label>
                        <input type="text" id="ec-search" placeholder="TÍTULO..." oninput="ecFiltrar()">
                    </div>
                    <div class="form-group">
                        <label>FORMATO</label>
                        <select id="ec-formato" onchange="ecFiltrar()">
                            <option value="">— TODOS —</option>
                            <option value="1">DVD</option>
                            <option value="2">BLU-RAY</option>
                            <option value="3">BLU-RAY UHD</option>
                            <option value="4">VHS</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>ESTADO ACTUAL</label>
                        <select id="ec-estado" onchange="ecFiltrar()">
                            <option value="">— TODOS —</option>
                            <option value="disponible">DISPONIBLE</option>
                            <option value="dañada">DAÑADA</option>
                            <option value="en mantenimiento">EN MANTENIMIENTO</option>
                            <option value="perdida">PERDIDA</option>
                            <option value="prestada">PRESTADA</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <h3>CINTAS EN INVENTARIO</h3>
                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr style="border-bottom:1px solid rgba(255,255,255,.06);">
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">ID</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">PELÍCULA</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">FORMATO</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">ESTADO</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:center;font-weight:400;">CAMBIAR ESTADO</th>
                            </tr>
                        </thead>
                        <tbody id="ec-tbody">
                            <tr id="ec-loading">
                                <td colspan="5" style="font-family:var(--fm);font-size:9px;color:var(--g);padding:24px;text-align:center;letter-spacing:2px;">
                                    <span class="spinner"></span> &nbsp;CARGANDO CINTAS...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-top:14px;padding-top:12px;border-top:1px solid rgba(255,255,255,.04);">
                    <span id="ec-count" style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);"></span>
                    <div style="display:flex;gap:8px;">
                        <button class="btn-clear" id="ec-prev" onclick="ecPaginar(-1)">← ANTERIOR</button>
                        <span id="ec-page-info" style="font-family:var(--fm);font-size:9px;color:var(--g);padding:9px 14px;letter-spacing:1px;"></span>
                        <button class="btn-clear" id="ec-next" onclick="ecPaginar(1)">SIGUIENTE →</button>
                    </div>
                </div>
            </div>

            {{-- MODAL CAMBIO DE ESTADO --}}
            <div id="modal-ec" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.82);z-index:10000;align-items:center;justify-content:center;padding:20px;">
                <div style="background:var(--ink2);border:1px solid rgba(123,94,167,.35);width:100%;max-width:440px;">
                    <div style="padding:18px 24px;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;justify-content:space-between;">
                        <div>
                            <span style="font-family:var(--fh);font-size:18px;letter-spacing:4px;color:var(--w);">CAMBIAR ESTADO</span>
                            <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-top:3px;">// CINTA · <span id="ec-modal-id"></span></div>
                        </div>
                        <span onclick="ecCloseModal()" style="cursor:pointer;color:var(--g);font-size:20px;transition:color .15s;" onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--g)'">✕</span>
                    </div>
                    <div style="padding:24px;">
                        <div style="background:rgba(123,94,167,.08);border:1px solid rgba(123,94,167,.2);padding:12px 16px;margin-bottom:20px;">
                            <div style="font-family:var(--fh);font-size:16px;letter-spacing:3px;color:var(--w);" id="ec-modal-pelicula"></div>
                            <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-top:4px;" id="ec-modal-formato"></div>
                        </div>
                        <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-bottom:10px;">ESTADO ACTUAL</div>
                        <div id="ec-modal-estado-actual" style="margin-bottom:20px;"></div>
                        <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-bottom:10px;">CAMBIAR A</div>
                        <div style="display:flex;flex-direction:column;gap:8px;" id="ec-modal-opciones"></div>
                        <input type="hidden" id="ec-modal-cinta-id">
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-papel-actor" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.75); z-index:20000; align-items:center; justify-content:center;">
            <div style="background:var(--ink2); border:1px solid rgba(123,94,167,.3); width:100%; max-width:420px; margin:0 20px;">

                <!-- Header -->
                <div style="padding:16px 24px; border-bottom:1px solid rgba(255,255,255,.05); display:flex; align-items:center; justify-content:space-between;">
                    <div>
                        <span style="font-family:var(--fh); font-size:18px; letter-spacing:4px; color:var(--w);">AÑADIR AL REPARTO</span>
                        <div style="font-family:var(--fm); font-size:8px; letter-spacing:2px; color:var(--g); margin-top:3px;">
                            // DEFINE EL ROL DEL ACTOR EN LA PELÍCULA
                        </div>
                    </div>
                    <span onclick="cerrarModalPapel()"
                        style="cursor:pointer; color:var(--g); font-size:18px; transition:color .15s; line-height:1;"
                        onmouseover="this.style.color='var(--red)'"
                        onmouseout="this.style.color='var(--g)'">✕</span>
                </div>

                <!-- Body -->
                <div style="padding:24px;">

                    <!-- Actor seleccionado -->
                    <div style="display:flex; align-items:center; gap:12px; background:rgba(123,94,167,.08); border:1px solid rgba(123,94,167,.2); padding:10px 14px; margin-bottom:20px;">
                        <span style="font-family:var(--fo); font-size:11px; color:var(--v);">◈</span>
                        <div>
                            <div id="modal-papel-nombre" style="font-family:var(--fm); font-size:11px; letter-spacing:2px; color:var(--w);"></div>
                            <div style="font-family:var(--fm); font-size:8px; letter-spacing:1px; color:var(--g); margin-top:2px;">ACTOR SELECCIONADO</div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:20px;">
                        <label>PAPEL / ROL EN LA PELÍCULA</label>
                        <input type="text"
                            id="modal-papel-input"
                            placeholder="EJ: PROTAGONISTA, ANTAGONISTA, SECUNDARIO"
                            onkeydown="if(event.key==='Enter') confirmarPapel()"
                            style="letter-spacing:1px;">
                        <span style="font-family:var(--fm); font-size:8px; letter-spacing:1px; color:var(--g); margin-top:4px; display:block;">
                            ⌦ &nbsp;OPCIONAL — DEJA VACÍO SI NO APLICA
                        </span>
                    </div>
                    <div style="display:flex; gap:10px; padding-top:16px; border-top:1px solid rgba(255,255,255,.04);">
                        <button class="btn btn-add" onclick="confirmarPapel()" style="flex:1;">
                            + AÑADIR AL REPARTO
                        </button>
                        <button class="btn-clear" onclick="cerrarModalPapel()">CANCELAR</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="view" id="view-prestamos">
            <div class="page-header">
                <div>
                    <h2>PRÉSTAMOS</h2>
                    <small>// GESTIÓN DE RENTAS ACTIVAS E HISTORIAL</small>
                </div>
            </div>

            <div class="form-card">
                <h3>FILTRAR</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>BUSCAR SOCIO</label>
                        <input type="text" id="pr-search" placeholder="NOMBRE O EMAIL..." oninput="prFiltrar()">
                    </div>
                    <div class="form-group">
                        <label>ESTADO</label>
                        <select id="pr-estado" onchange="prFiltrar()">
                            <option value="">— TODOS —</option>
                            <option value="activo">ACTIVO</option>
                            <option value="devuelto">DEVUELTO</option>
                            <option value="cancelado">CANCELADO</option>
                        </select>
                    </div>
                    <div class="form-group" style="align-self:end;">
                        <button class="btn btn-add" onclick="prCargar()" style="width:100%;">↺ ACTUALIZAR</button>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <h3>PRÉSTAMOS</h3>
                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr style="border-bottom:1px solid rgba(255,255,255,.06);">
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">ID</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">SOCIO</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">CINTAS</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">VENCE</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:left;font-weight:400;">ESTADO</th>
                                <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:10px 12px;text-align:center;font-weight:400;">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="pr-tbody">
                            <tr>
                                <td colspan="6" style="font-family:var(--fm);font-size:9px;color:var(--g);padding:24px;text-align:center;">
                                    <span class="spinner"></span> &nbsp;CARGANDO...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-top:14px;padding-top:12px;border-top:1px solid rgba(255,255,255,.04);">
                    <span id="pr-count" style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);"></span>
                    <div style="display:flex;gap:8px;">
                        <button class="btn-clear" id="pr-prev" onclick="prPaginar(-1)">← ANTERIOR</button>
                        <span id="pr-page-info" style="font-family:var(--fm);font-size:9px;color:var(--g);padding:9px 14px;letter-spacing:1px;"></span>
                        <button class="btn-clear" id="pr-next" onclick="prPaginar(1)">SIGUIENTE →</button>
                    </div>
                </div>
            </div>

            <div id="modal-pr" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:10000;align-items:center;justify-content:center;padding:20px;">
                <div style="background:var(--ink2);border:1px solid rgba(123,94,167,.35);width:100%;max-width:560px;max-height:90vh;overflow-y:auto;">
                    <div style="padding:18px 24px;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;background:var(--ink2);z-index:10;">
                        <div>
                            <span style="font-family:var(--fh);font-size:18px;letter-spacing:4px;color:var(--w);">PRÉSTAMO</span>
                            <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-top:3px;">// <span id="pr-modal-id"></span></div>
                        </div>
                        <span onclick="prCloseModal()" style="cursor:pointer;color:var(--g);font-size:20px;"
                            onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--g)'">✕</span>
                    </div>
                    <div style="padding:24px;" id="pr-modal-body"></div>
                </div>
            </div>
        </div>
    </main>
    </div>
    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
        const TIPOS_MULTA_DB = @json($tiposMulta);
        const MULTA_TIPOS = [
            {
                id: 1,
                key: 'retraso',
                label: 'RETRASO',
                icon: '⧖',
                color: 'var(--amber)',
                bg: 'rgba(212,160,23,.08)',
                border: 'rgba(212,160,23,.25)',
                multiplicador: (TIPOS_MULTA_DB.find(t => t.id_tipo_multa === 1)?.multiplicador ?? 0.1),
                _auto: true,
            },
            {
                id: 2,
                key: 'danio',
                label: 'DAÑO',
                icon: '◌',
                color: 'var(--red)',
                bg: 'rgba(192,57,43,.08)',
                border: 'rgba(192,57,43,.25)',
                multiplicador: (TIPOS_MULTA_DB.find(t => t.id_tipo_multa === 2)?.multiplicador ?? 0.5),
            },
            {
                id: 3,
                key: 'perdida',
                label: 'PÉRDIDA',
                icon: '○',
                color: 'var(--g)',
                bg: 'rgba(102,102,102,.08)',
                border: 'rgba(102,102,102,.20)',
                multiplicador: (TIPOS_MULTA_DB.find(t => t.id_tipo_multa === 3)?.multiplicador ?? 2.0),
            },
        ];
        let _devIdPrestamo = null;
        let _devMultasExtra = [];

        async function _renderModalDevolucion() {
    document.getElementById('modal-devolucion')?.remove();

    const p = prTodos.find(x => x.id_prestamo === _devIdPrestamo);
    if (!p) return;

    // ── Calcular datos UNA SOLA VEZ ──────────────────────────────
    const nombreSocio     = (p.socio?.nombre ?? '—').toUpperCase();
    const totalPrestamo   = parseFloat(p.monto_total ?? p.cargo_diario ?? 0);
    const diasRetraso     = (p.vencido && (p.estado ?? '').toLowerCase() === 'activo')
                            ? Math.abs(p.dias_restantes ?? 0) : 0;
    const tipoRetraso     = TIPOS_MULTA_DB.find(t => t.id_tipo_multa === 1);
    const multRetraso     = parseFloat(tipoRetraso?.multiplicador ?? 0.1);
    const valorMultaEstim = diasRetraso > 0
                            ? Math.round(totalPrestamo * multRetraso * diasRetraso) : 0;

    // ── Agregar multa auto de retraso si aplica ──────────────────
    if (diasRetraso > 0 && !_devMultasExtra.find(m => m.tipo_id === 1)) {
        _devMultasExtra.push({
            tipo_id:  1,
            concepto: `RETRASO ${diasRetraso} DÍA${diasRetraso !== 1 ? 'S' : ''}`,
            valor:    valorMultaEstim,
            _auto:    true,
        });
    }

    // ── Construir HTML usando solo las variables calculadas arriba ─
    const alertaRetraso = diasRetraso > 0 ? `
        <div style="background:rgba(212,160,23,.07);border:1px solid rgba(212,160,23,.3);
                    border-left:3px solid var(--amber);padding:14px 16px;margin-bottom:20px;">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
                <span style="font-size:18px;flex-shrink:0;">⧖</span>
                <div>
                    <div style="font-family:var(--fo);font-size:9px;letter-spacing:2px;
                                color:var(--amber);margin-bottom:3px;">RETRASO DETECTADO</div>
                    <div style="font-family:var(--fm);font-size:9px;letter-spacing:1px;color:var(--g);">
                        ${diasRetraso} día${diasRetraso !== 1 ? 's' : ''} de retraso
                    </div>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1px;background:rgba(212,160,23,.15);">
                ${[
                    ['TOTAL PRÉSTAMO',  '$' + totalPrestamo.toLocaleString('es-CO')],
                    ['× MULTIPLICADOR', '×' + multRetraso + ' × ' + diasRetraso + 'd'],
                    ['MULTA ESTIMADA',  '$' + valorMultaEstim.toLocaleString('es-CO')],
                ].map(([l,v]) => `
                    <div style="background:rgba(212,160,23,.06);padding:10px 12px;">
                        <div style="font-family:var(--fm);font-size:7px;color:var(--g);letter-spacing:2px;">${l}</div>
                        <div style="font-family:var(--fo);font-size:13px;color:var(--amber);margin-top:3px;">${v}</div>
                    </div>`).join('')}
            </div>
            <div style="font-family:var(--fm);font-size:8px;letter-spacing:1px;
                        color:var(--g-dark);margin-top:8px;">
                ⌦ &nbsp;El valor exacto lo confirma el sistema al guardar.
            </div>
        </div>` : `
        <div style="background:rgba(76,175,106,.06);border:1px solid rgba(76,175,106,.2);
                    border-left:3px solid var(--green);padding:12px 16px;margin-bottom:20px;
                    display:flex;align-items:center;gap:12px;">
            <span style="font-size:18px;flex-shrink:0;color:var(--green);">◉</span>
            <div style="font-family:var(--fm);font-size:9px;letter-spacing:1px;color:var(--g);">
                Devolución <strong style="color:var(--green);">a tiempo</strong> — sin multa por retraso.
            </div>
        </div>`;

    const html = `
        <div id="modal-devolucion"
            style="position:fixed;inset:0;background:rgba(0,0,0,.88);z-index:25000;
                    display:flex;align-items:center;justify-content:center;padding:20px;"
            onclick="_bgCloseDevolucion(event)">
            <div style="background:var(--ink2);border:1px solid rgba(123,94,167,.35);
                        width:100%;max-width:560px;max-height:90vh;overflow-y:auto;">
                <div style="padding:18px 24px;border-bottom:1px solid rgba(255,255,255,.05);
                            display:flex;align-items:center;justify-content:space-between;
                            position:sticky;top:0;background:var(--ink2);z-index:10;">
                    <div>
                        <span style="font-family:var(--fh);font-size:20px;letter-spacing:5px;color:var(--w);">
                            REGISTRAR DEVOLUCIÓN
                        </span>
                        <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;
                                    color:var(--g);margin-top:3px;">
                            // PRÉSTAMO #${String(_devIdPrestamo).padStart(5,'0')} · ${nombreSocio}
                        </div>
                    </div>
                    <span onclick="_closeModalDevolucion()"
                        style="cursor:pointer;color:var(--g);font-size:20px;line-height:1;transition:color .15s;"
                        onmouseover="this.style.color='var(--red)'"
                        onmouseout="this.style.color='var(--g)'">✕</span>
                </div>
                <div style="padding:24px;">
                    ${alertaRetraso}

                    <div style="margin-bottom:20px;">
                        <div style="font-family:var(--fm);font-size:8px;letter-spacing:3px;
                                    color:var(--v-dim);margin-bottom:12px;
                                    display:flex;align-items:center;gap:10px;">
                            <span style="width:16px;height:1px;background:var(--v-dim);display:inline-block;"></span>
                            MULTAS ADICIONALES
                        </div>
                        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px;">
                            ${MULTA_TIPOS.filter(t => !t._auto).map(t => `
                            <button onclick="_devAgregarMulta(${t.id})"
                                    id="btn-multa-${t.id}"
                                    style="font-family:var(--fm);font-size:8px;letter-spacing:2px;
                                        color:${t.color};background:${t.bg};
                                        border:1px solid ${t.border};padding:7px 14px;
                                        cursor:pointer;transition:all .18s;display:flex;
                                        align-items:center;gap:6px;"
                                    onmouseover="this.style.opacity='.8'"
                                    onmouseout="this.style.opacity='1'">
                                ${t.icon} + ${t.label}
                            </button>`).join('')}
                        </div>
                        <div id="dev-multas-lista"></div>
                    </div>

                    <div style="background:rgba(123,94,167,.08);border:1px solid rgba(123,94,167,.2);
                                padding:14px 18px;margin-bottom:20px;
                                display:flex;align-items:center;justify-content:space-between;">
                        <div>
                            <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);">
                                TOTAL MULTAS
                            </div>
                            <div style="font-family:var(--fm);font-size:7px;color:var(--g-dark);margin-top:2px;"
                                id="dev-multas-desc">calculando...</div>
                        </div>
                        <div id="dev-total-multas"
                            style="font-family:var(--fo);font-size:24px;letter-spacing:3px;color:var(--v);">
                            $0
                        </div>
                    </div>

                    <div id="dev-pago-wrap"></div>

                    <div style="display:flex;gap:10px;padding-top:16px;
                                border-top:1px solid rgba(255,255,255,.04);">
                        <button onclick="_confirmarDevolucion()"
                                id="btn-confirmar-dev"
                                style="font-family:var(--fo);font-size:9px;letter-spacing:2px;
                                    background:var(--green);color:#060606;border:none;
                                    padding:12px 20px;cursor:pointer;flex:1;transition:all .2s;"
                                onmouseover="this.style.opacity='.85'"
                                onmouseout="this.style.opacity='1'">
                            ✓ &nbsp;CONFIRMAR DEVOLUCIÓN
                        </button>
                        <button onclick="_closeModalDevolucion()"
                                style="font-family:var(--fo);font-size:9px;letter-spacing:2px;
                                    background:transparent;color:var(--g);
                                    border:1px solid var(--g-dark);padding:11px 16px;
                                    cursor:pointer;transition:all .2s;"
                                onmouseover="this.style.borderColor='var(--v-dim)';this.style.color='var(--w)'"
                                onmouseout="this.style.borderColor='var(--g-dark)';this.style.color='var(--g)'">
                            CANCELAR
                        </button>
                    </div>
                </div>
            </div>
        </div>`;

    // ── Primero insertar, LUEGO renderizar la lista ──────────────
    document.body.insertAdjacentHTML('beforeend', html);
    _renderDevMultasLista();   // ← #dev-multas-lista ya existe en el DOM
}

        function _devAgregarMulta(tipoId) {
            const tipo = MULTA_TIPOS.find(t => t.id === tipoId);
            if (!tipo) return;

            if (_devMultasExtra.find(m => m.tipo_id === tipoId)) {
                alertaRetro({
                    titulo: 'YA AGREGADA',
                    texto: `<p>Ya hay una multa de tipo <strong>${tipo.label}</strong> en esta devolución.</p>`,
                    icono: 'error',
                });
                return;
            }

            const p = prTodos.find(x => x.id_prestamo === _devIdPrestamo);
            const totalPrestamo = p?.monto_total ?? p?.cargo_diario ?? 0;
            const valorSugerido = Math.round(totalPrestamo * tipo.multiplicador);

            _devMultasExtra.push({
                tipo_id:  tipoId,
                concepto: tipo.label,
                valor:    valorSugerido,
            });
            _renderDevMultasLista();
}
        function _devQuitarMulta(tipoId) {
            _devMultasExtra = _devMultasExtra.filter(m => m.tipo_id !== tipoId);
            _renderDevMultasLista();
        }

        function _renderDevMultasLista() {
            const lista = document.getElementById('dev-multas-lista');
            if (!lista) return;
        
            if (_devMultasExtra.length === 0) {
                lista.innerHTML = `
                    <div style="font-family:var(--fm);font-size:9px;letter-spacing:1px;
                                color:var(--g-dark);padding:12px 0;text-align:center;">
                        ⌦ &nbsp;SIN MULTAS ADICIONALES
                    </div>`;
            } else {
                lista.innerHTML = _devMultasExtra.map((m, idx) => {
                    const tipo = MULTA_TIPOS.find(t => t.id === m.tipo_id);
                    return `
                    <div style="display:flex;align-items:center;gap:10px;
                                padding:10px 14px;background:${tipo.bg};
                                border:1px solid ${tipo.border};margin-bottom:6px;">
        
                        <span style="font-size:14px;color:${tipo.color};flex-shrink:0;">${tipo.icon}</span>
        
                        <div style="flex:1;">
                            <div style="font-family:var(--fo);font-size:9px;letter-spacing:2px;
                                        color:${tipo.color};margin-bottom:4px;">
                                ${tipo.label}
                                ${m._auto ? `<span style="font-family:var(--fm);font-size:7px;
                                                color:var(--g);letter-spacing:1px;margin-left:6px;">
                                                AUTO</span>` : ''}
                            </div>
                            <div style="font-family:var(--fm);font-size:9px;letter-spacing:1px;
                                        color:var(--g);margin-top:4px;">
                                ${tipo.label}
                            </div>
                        </div>
        
                        <div style="flex-shrink:0;display:flex;flex-direction:column;gap:4px;align-items:flex-end;">
                            <div style="display:flex;align-items:center;gap:4px;">
                                <span style="font-family:var(--fm);font-size:8px;color:var(--g);">$</span>
                                <input type="number"
                                    value="${m.valor}"
                                    min="0" step="1000"
                                    oninput="_devUpdateMulta(${idx},'valor',this.value)"
                                    title="Valor sugerido: $${Number(m.valor).toLocaleString('es-CO')} · Editable"
                                    style="width:110px;background:var(--ink3);
                                            border:1px solid var(--g-dark);
                                            border-left:2px solid ${tipo.border};
                                            color:var(--w);font-family:var(--fo);
                                            font-size:12px;padding:5px 8px;outline:none;
                                            letter-spacing:1px;transition:border-color .18s;"
                                    onfocus="this.style.borderColor='${tipo.color}'"
                                    onblur="this.style.borderColor='var(--g-dark)'">
                                    <div style="font-family:var(--fm);font-size:7px;letter-spacing:1px;
                                                color:var(--g-dark);margin-top:3px;text-align:right;">
                                        SUGERIDO · EDITABLE
                                    </div>
                            </div>
                            ${!m._auto ? `
                            <button onclick="_devQuitarMulta(${m.tipo_id})"
                                    style="font-family:var(--fm);font-size:7px;letter-spacing:1px;
                                        color:var(--red);background:transparent;
                                        border:1px solid rgba(192,57,43,.3);
                                        padding:3px 8px;cursor:pointer;transition:all .18s;"
                                    onmouseover="this.style.background='rgba(192,57,43,.1)'"
                                    onmouseout="this.style.background='transparent'">
                                ✕ QUITAR
                            </button>` : ''}
                        </div>
                    </div>`;
                }).join('');
            }
        
            _actualizarTotalDevolucion();
        }

        function _devUpdateMulta(idx, field, value) {
            if (!_devMultasExtra[idx]) return;
            if (field === 'valor') {
                _devMultasExtra[idx].valor = parseFloat(value) || 0;
            } else {
                _devMultasExtra[idx].concepto = value;
            }
            _actualizarTotalDevolucion();
        }

        function _actualizarTotalDevolucion() {
            const total = _devMultasExtra.reduce((s, m) => s + (parseFloat(m.valor) || 0), 0);
            const el = document.getElementById('dev-total-multas');
            const desc = document.getElementById('dev-multas-desc');
            if (el) el.textContent = `$${total.toLocaleString('es-CO')}`;
            if (desc) {
                const partes = _devMultasExtra.map(m => {
                    const t = MULTA_TIPOS.find(x => x.id === m.tipo_id);
                    return t?.label ?? m.concepto;
                });
                desc.textContent = partes.length ? partes.join(' + ') : 'sin multas';
            }
            const pagoWrap = document.getElementById('dev-pago-wrap');
            if (!pagoWrap) return;
        
            if (total > 0) {
                pagoWrap.innerHTML = `
                <div style="margin-bottom:20px;">
                    <div style="font-family:var(--fm);font-size:8px;letter-spacing:3px;
                                color:var(--v-dim);margin-bottom:12px;
                                display:flex;align-items:center;gap:10px;">
                        <span style="width:16px;height:1px;background:var(--v-dim);display:inline-block;"></span>
                        MÉTODO DE PAGO
                    </div>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;">
                        ${['EFECTIVO','TARJETA','TRANSFERENCIA'].map(m => `
                        <button onclick="_devSelMetodo('${m}')"
                                id="dev-metodo-${m}"
                                class="dev-metodo-btn"
                                style="font-family:var(--fm);font-size:9px;letter-spacing:2px;
                                    color:var(--g);background:var(--ink3);
                                    border:1px solid var(--g-dark);padding:9px 16px;
                                    cursor:pointer;transition:all .18s;flex:1;"
                                onmouseover="this.style.borderColor='var(--v-dim)';this.style.color='var(--w)'"
                                onmouseout="if(!this.dataset.sel){this.style.borderColor='var(--g-dark)';this.style.color='var(--g)'}">
                            ${m}
                        </button>`).join('')}
                    </div>
                    <input type="hidden" id="dev-metodo-valor" value="EFECTIVO">
                </div>`;
        
                _devSelMetodo('EFECTIVO');
            } else {
                pagoWrap.innerHTML = '';
            }
        }

        function _devSelMetodo(metodo) {
            document.querySelectorAll('.dev-metodo-btn').forEach(b => {
                b.style.borderColor   = 'var(--g-dark)';
                b.style.color         = 'var(--g)';
                b.style.background    = 'var(--ink3)';
                b.dataset.sel         = '';
            });
            const sel = document.getElementById(`dev-metodo-${metodo}`);
            if (sel) {
                sel.style.borderColor = 'var(--v)';
                sel.style.color       = 'var(--w)';
                sel.style.background  = 'rgba(123,94,167,.12)';
                sel.dataset.sel       = '1';
            }
            const inp = document.getElementById('dev-metodo-valor');
            if (inp) inp.value = metodo;
        }
        
        async function _confirmarDevolucion() {
    
            const total = _devMultasExtra.reduce((s, m) => s + (parseFloat(m.valor) || 0), 0);
            const metodoPago = document.getElementById('dev-metodo-valor')?.value ?? 'EFECTIVO';

            const btn = document.getElementById('btn-confirmar-dev');
            if (btn) { btn.disabled = true; btn.innerHTML = '<span class="spinner"></span>'; }

            try {
                const res = await fetch(
                    `{{ url('empleado/prestamos') }}/` + _devIdPrestamo + `/devolver`,
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': CSRF,
                        },
                        body: JSON.stringify({
                            multas_adicionales: _devMultasExtra
                                .filter(m => m.tipo_id !== 1)
                                .filter(m => parseFloat(m.valor) > 0)
                                .map(m => ({
                                    id_tipo_multa: m.tipo_id,
                                    valor:         parseFloat(m.valor),
                                })),
                            metodo_pago: total > 0 ? metodoPago : null,
                        }),
                    }
                );

                const data = await res.json();

                if (!res.ok) {
                    alertaRetro({
                        titulo: 'ERROR',
                        texto: `<p>${data.message?.toUpperCase() ?? 'NO SE PUDO REGISTRAR'}</p>`,
                        icono: 'error',
                    });
                    return;
                }

                _closeModalDevolucion();
                prCloseModal();
                prCargar();

                const totalFinal = data.total_multas ?? 0;
                alertaRetro({
                    titulo: totalFinal > 0 ? 'DEVUELTO CON MULTAS' : 'DEVUELTO',
                    texto: totalFinal > 0
                        ? `<p>Devolución registrada.</p>
                        <p style="margin-top:10px;">Total multas: <strong>$${Number(totalFinal).toLocaleString('es-CO')}</strong> · ${metodoPago}</p>`
                        : '<p>Devolución registrada correctamente. Sin multas.</p>',
                    icono: totalFinal > 0 ? 'warning' : 'success',
                });

            } catch (err) {
                console.error(err);
                alertaRetro({
                    titulo: 'ERROR DE CONEXIÓN',
                    texto: '<p>No se pudo conectar con el servidor.</p>',
                    icono: 'error',
                });
            } finally {
                if (btn) { btn.disabled = false; btn.innerHTML = '✓ &nbsp;CONFIRMAR DEVOLUCIÓN'; }
            }
        }
        
        // ── Helpers de cierre ──────────────────────────────────────────────
        function _closeModalDevolucion() {
            document.getElementById('modal-devolucion')?.remove();
            document.body.style.overflow = '';
            _devIdPrestamo  = null;
            _devMultasExtra = [];
        }
        
        function _bgCloseDevolucion(e) {
            if (e.target.id === 'modal-devolucion') _closeModalDevolucion();
        }
        

        function switchView(id, btn) {
            const target = document.getElementById('view-' + id);
            if (!target) return;
            document.querySelectorAll('.view').forEach(v => v.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            target.classList.add('active');
            if (btn) btn.classList.add('active');
            document.querySelector('.main').scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function previewUpload(input, previewId, zoneId) {
            const file = input.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.getElementById(previewId);
                if (img) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                }
                const zone = input.closest('.upload-zone');
                if (zone) {
                    const icon = zone.querySelector('.uz-icon');
                    const label = zone.querySelector('.uz-label');
                    const sub = zone.querySelector('.uz-sub');
                    if (icon) icon.style.display = 'none';
                    if (label) label.textContent = file.name.length > 22 ? file.name.substring(0, 22) + '…' : file.name;
                    if (sub) sub.textContent = (file.size / 1024).toFixed(0) + ' KB';
                }
            };
            reader.readAsDataURL(file);
        }

        function dzDrag(el) {
            el.classList.add('dragover');
        }

        function dzLeave(el) {
            el.classList.remove('dragover');
        }

        function dzDrop(el, inputId, previewId) {
            el.classList.remove('dragover');
            const dt = event.dataTransfer;
            const input = document.getElementById(inputId);
            if (dt.files.length && input) {
                input.files = dt.files;
                previewUpload(input, previewId, null);
            }
            event.preventDefault();
        }

        function clearForm(prefix) {
            document.querySelectorAll(`[id^="${prefix}-"]`).forEach(el => {
                if (el.tagName === 'INPUT' && el.type !== 'file' && el.type !== 'hidden') el.value = '';
                else if (el.tagName === 'SELECT') el.selectedIndex = 0;
                else if (el.tagName === 'TEXTAREA') el.value = '';
            });
            document.querySelectorAll(`[id$="-prev"]`).forEach(img => img.style.display = 'none');
            document.querySelectorAll('.upload-zone').forEach(zone => {
                zone.classList.remove('dragover');
                const icon = zone.querySelector('.uz-icon');
                const label = zone.querySelector('.uz-label');
                const sub = zone.querySelector('.uz-sub');
                if (icon) icon.style.display = '';
                if (label) label.textContent = label.dataset.original ?? label.textContent;
                if (sub) sub.textContent = sub.dataset.original ?? sub.textContent;
            });
            if (prefix === 'pel') {
                repartoItems = [];
                renderRepartoTags();
                clearDirectorSelection();
            }
            if (prefix === 'cin') clearPeliculaSelection();
        }



        const MOCK_DIRECTORES = @json($directores -> map(fn($d) => [
            'id' => $d -> id_director,
            'nombre' => strtoupper($d -> nombre),
        ]));

        let selectedDirectorId = null;

        function searchDirector(q) {
            const dd = document.getElementById('dir-dropdown');
            if (!q.trim()) {
                dd.classList.remove('open');
                return;
            }
            const results = MOCK_DIRECTORES.filter(d => d.nombre.toLowerCase().includes(q.toLowerCase()));
            if (!results.length) {
                dd.innerHTML = `<div class="actor-dropdown-empty">SIN COINCIDENCIAS — REGISTRA EL DIRECTOR PRIMERO</div>`;
            } else {
                dd.innerHTML = results.map(d =>
                    `<div class="actor-dropdown-item" onclick="selectDirector(${d.id},'${d.nombre}')">
                <span class="adi-name">${d.nombre}</span>
             </div>`
                ).join('');
            }
            dd.classList.add('open');
        }

        function selectDirector(id, nombre) {
            selectedDirectorId = id;
            document.getElementById('pel-id-director').value = id;
            document.getElementById('pel-dir-search').value = '';
            document.getElementById('dir-dropdown').classList.remove('open');
            document.getElementById('dir-selected-name').textContent = '⬡ ' + nombre;
            document.getElementById('dir-selected-box').style.display = 'flex';
        }

        function clearDirectorSelection() {
            selectedDirectorId = null;
            document.getElementById('pel-id-director').value = '';
            document.getElementById('pel-dir-search').value = '';
            document.getElementById('dir-selected-box').style.display = 'none';
            document.getElementById('dir-dropdown').classList.remove('open');
        }

        document.addEventListener('click', e => {
            if (!e.target.closest('.director-search-wrap')) {
                document.querySelectorAll('.actor-dropdown').forEach(d => d.classList.remove('open'));
            }
        });

        let repartoItems = [];
        let pendingActorId = null;
        let pendingActorName = null;

        function searchActor(q) {
            const dd = document.getElementById('actor-dropdown');
            if (!q.trim()) {
                dd.classList.remove('open');
                return;
            }

            const results = MOCK_ACTORES.filter(a =>
                a.nombre.toLowerCase().includes(q.toLowerCase()) &&
                !repartoItems.find(r => r.id === a.id)
            );

            dd.innerHTML = results.length ?
                results.map(a =>
                    `<div class="actor-dropdown-item" onclick="setPendingActor(${a.id}, '${a.nombre}')">
                        <span class="adi-name">${a.nombre}</span>
                    </div>`
                ).join('') :
                `<div class="actor-dropdown-empty">SIN COINCIDENCIAS — REGISTRA EL ACTOR PRIMERO</div>`;

            dd.classList.add('open');
        }


        function setPendingActor(id, nombre) {
            pendingActorId = id;
            pendingActorName = nombre;
            document.getElementById('reparto-search').value = nombre;
            document.getElementById('actor-dropdown').classList.remove('open');
        }

        function addCurrentActor() {
            if (!pendingActorId) {
                const q = document.getElementById('reparto-search').value.trim().toUpperCase();
                const match = MOCK_ACTORES.find(a => a.nombre === q && !repartoItems.find(r => r.id === a.id));
                if (!match) return;
                pendingActorId = match.id;
                pendingActorName = match.nombre;
            }
            if (repartoItems.find(r => r.id === pendingActorId)) {
                resetPendingActor();
                return;
            }
            abrirModalPapel(pendingActorId, pendingActorName);
        }

        function removeActor(id) {
            repartoItems = repartoItems.filter(r => r.id !== id);
            renderRepartoTags();
        }

        function renderRepartoTags() {
            const wrap = document.getElementById('reparto-tags');
            const placeholder = document.getElementById('reparto-placeholder');
            wrap.querySelectorAll('.reparto-tag').forEach(t => t.remove());

            if (repartoItems.length === 0) {
                placeholder.style.display = '';
            } else {
                placeholder.style.display = 'none';
                repartoItems.forEach(({
                    id,
                    nombre,
                    papel
                }) => {
                    const tag = document.createElement('span');
                    tag.className = 'reparto-tag';
                    tag.dataset.id = id;
                    tag.innerHTML = `
                        ◈ ${nombre}
                        ${papel
                            ? `<em style="font-style:normal; color:var(--v-dim); font-size:8px; letter-spacing:1px;">[${papel.toUpperCase()}]</em>`
                            : ''}
                        <span class="tag-remove" onclick="removeActor(${id})">✕</span>
                    `;
                    wrap.appendChild(tag);
                });
            }
            document.getElementById('pel-reparto-ids').value = repartoItems.map(r => r.id).join(',');
        }

        const MOCK_PELICULAS = @json($peliculas -> map(fn($p) => [
            'id' => $p -> id_pelicula,
            'nombre' => strtoupper($p -> titulo),
        ]));

        let selectedPeliculaId = null;

        function searchPelicula(q) {
            const dd = document.getElementById('pel-dropdown');
            if (!q.trim()) {
                dd.classList.remove('open');
                return;
            }
            const results = MOCK_PELICULAS.filter(p => p.nombre.toLowerCase().includes(q.toLowerCase()));
            if (!results.length) {
                dd.innerHTML = `<div class="actor-dropdown-empty">SIN COINCIDENCIAS — REGISTRA LA PELÍCULA PRIMERO</div>`;
            } else {
                dd.innerHTML = results.map(p =>
                    `<div class="actor-dropdown-item" onclick="selectPelicula(${p.id},'${p.nombre}')">
                <span class="adi-name">${p.nombre}</span>
             </div>`
                ).join('');
            }
            dd.classList.add('open');
        }

        function selectPelicula(id, nombre) {
            selectedPeliculaId = id;
            document.getElementById('cin-id-pelicula').value = id;
            document.getElementById('cin-pel-search').value = '';
            document.getElementById('pel-dropdown').classList.remove('open');
            document.getElementById('cin-pel-selected-name').textContent = '▶ ' + nombre;
            document.getElementById('cin-pel-selected').style.display = 'flex';
        }

        function clearPeliculaSelection() {
            selectedPeliculaId = null;
            document.getElementById('cin-id-pelicula').value = '';
            document.getElementById('cin-pel-search').value = '';
            document.getElementById('cin-pel-selected').style.display = 'none';
        }

        function submitActor() {
            const nombre = document.getElementById('act-nombre').value.trim();
            const bio = document.getElementById('act-bio').value.trim();
            const foto = document.getElementById('act-foto-input').files[0];
            if (!nombre) {
                showErr('act-err-nombre', 'NOMBRE REQUERIDO');
                return;
            }

            const formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('biografia', bio);
            if (foto) formData.append('foto', foto);

            console.log('POST /admin/actores → FormData');
            alert('✓ DEMO: Actor listo para enviar.');
        }

        function submitCinta() {
            if (!document.getElementById('cin-id-pelicula').value) {
                showErr('cin-err-pelicula', 'SELECCIONA UNA PELÍCULA');
                return;
            }
            const estado = document.getElementById('cin-estado').value;
            if (!estado) {
                showErr('cin-err-estado', 'ESTADO REQUERIDO');
                return;
            }

            const payload = {
                id_pelicula: document.getElementById('cin-id-pelicula').value,
                codigo: document.getElementById('cin-codigo').value.trim(),
                estado: estado,
                id_formato: document.getElementById('cin-formato').value,
                condicion: document.getElementById('cin-condicion').value,
                notas: document.getElementById('cin-notas').value.trim(),
            };

            console.log('POST /admin/cintas → JSON', payload);
            alert('✓ DEMO: Cinta lista para enviar.\nRevisa console.');
        }

        function showErr(id, msg) {
            const el = document.getElementById(id);
            if (!el) return;
            el.textContent = msg;
            el.classList.add('show');
            setTimeout(() => {
                el.textContent = '';
                el.classList.remove('show');
            }, 3500);
        }

        async function submitPerfil() {
            const payload = {
                nombre: document.getElementById('p-nombre').value.trim(),
                email: document.getElementById('p-email').value.trim(),
                telefono: document.getElementById('p-telefono').value.trim(),
                direccion: document.getElementById('p-direccion').value.trim(),
            };

            const btn = document.getElementById('btnGuardarPerfil');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span>';

            try {
                const res = await fetch('{{ route("perfil.datos") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'X-HTTP-Method-Override': 'PUT',
                    },
                    body: JSON.stringify(payload),
                });
                const data = await res.json();
                if (!res.ok) {
                    alertaRetro({
                        titulo: 'ERROR',
                        texto: `<p>${data.message ?? 'No se pudo guardar.'}</p>`,
                        icono: 'error'
                    });
                    return;
                }
                document.getElementById('perfil-nombre-display').textContent =
                    data.usuario.nombre.toUpperCase();

                alertaRetro({
                    titulo: 'PERFIL ACTUALIZADO',
                    texto: '<p>Tus datos fueron guardados correctamente.</p>',
                    icono: 'success'
                });

            } catch (err) {
                alertaRetro({
                    titulo: 'ERROR DE CONEXIÓN',
                    texto: '<p>No se pudo conectar con el servidor.</p>',
                    icono: 'error'
                });
            } finally {
                btn.disabled = false;
                btn.innerHTML = '✓ GUARDAR CAMBIOS';
            }
        }

        async function uploadFoto(input) {
            if (!input.files.length) return;

            const file = input.files[0];
            if (file.size > 2 * 1024 * 1024) {
                alertaRetro({
                    titulo: 'ARCHIVO MUY GRANDE',
                    texto: '<p>Máximo 2MB permitido.</p>',
                    icono: 'error'
                });
                input.value = '';
                return;
            }
            const loading = document.getElementById('foto-loading');
            loading.style.display = 'block';
            const formData = new FormData();
            formData.append('foto', file);
            try {
                const res = await fetch('{{ route("perfil.foto") }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                    },
                    body: formData,
                });
                const data = await res.json();

                if (!res.ok) {
                    alertaRetro({
                        titulo: 'ERROR',
                        texto: `<p>${data.message ?? 'No se pudo subir la foto.'}</p>`,
                        icono: 'error'
                    });
                    return;
                }

                const img = document.getElementById('avatar-img');
                const initials = document.getElementById('avatar-initials');
                img.src = data.url + '?t=' + Date.now();
                img.style.display = 'block';
                if (initials) initials.style.display = 'none';

                alertaRetro({
                    titulo: 'FOTO ACTUALIZADA',
                    texto: '<p>Tu foto de perfil fue actualizada.</p>',
                    icono: 'success'
                });

            } catch (err) {
                alertaRetro({
                    titulo: 'ERROR DE CONEXIÓN',
                    texto: '<p>No se pudo subir la foto.</p>',
                    icono: 'error'
                });
            } finally {
                loading.style.display = 'none';
                input.value = '';
            }
        }

        // Director
        async function submitDirector() {
            const nombre = document.getElementById('dir-nombre').value.trim();
            const bio = document.getElementById('dir-bio').value.trim();
            const foto = document.getElementById('dir-foto-input').files[0];

            if (!nombre) {
                alertaRetro({
                    titulo: 'DIRECTOR REQUERIDO',
                    texto: `<p>El nombre del director es un campo requerido.</p>`,
                    icono: 'error',
                });
                return;
            }

            if (foto && foto.size > 4 * 1024 * 1024) {
                alertaRetro({
                    titulo: 'FOTO DEMASIADO GRANDE',
                    texto: '<p>La foto no debe superar los 4MB.</p>',
                    icono: 'error'
                });
                return;
            }

            const formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('biografia', bio);
            if (foto) formData.append('foto', foto);

            const btn = document.getElementById('btnDir');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span>';

            try {
                const res = await fetch('{{ route("empleado.directores.registrar") }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                    },
                    body: formData,
                });

                const data = await res.json();
                console.log('DATA COMPLETA SUBMIT:', JSON.stringify(data));
                if (!res.ok) {
                    if (data.errors) {
                        Object.entries(data.errors).forEach(([field, msgs]) => {
                            const map = {
                                nombre: 'dir-err-nombre',
                                biografia: 'dir-err-bio',
                                foto: 'dir-err-foto'
                            };
                            if (map[field]) showErr(map[field], msgs[0].toUpperCase());
                        });
                        const lista = Object.values(data.errors).map(m => `<li>${m[0]}</li>`).join('');
                        alertaRetro({
                            titulo: 'ERROR DE REGISTRO',
                            texto: `<ul>${lista}</ul>`,
                            icono: 'error'
                        });
                    } else {
                        alertaRetro({
                            titulo: 'ERROR',
                            texto: `<p>${data.message?.toUpperCase() ?? 'ERROR AL REGISTRAR'}</p>`,
                            icono: 'error',
                        });
                    }
                    return;
                }
                const director = data.director ?? data;

                appendDirectorRow(director);

                MOCK_DIRECTORES.push({
                    id: director.id_director,
                    nombre: director.nombre.toUpperCase(),
                });

                updateDirectorCount(1);
                clearForm('dir');

                alertaRetro({
                    titulo: 'DIRECTOR REGISTRADO',
                    texto: `<p>El director <strong>${director.nombre.toUpperCase()}</strong> fue registrado correctamente.</p>`,
                    icono: 'success',
                });
            } catch (err) {
                console.error(err);
                alertaRetro({
                    titulo: 'ERROR DE CONEXIÓN',
                    texto: '<p>No se pudo conectar con el servidor. Intenta de nuevo.</p>',
                    icono: 'error',
                });
            } finally {
                btn.disabled = false;
                btn.innerHTML = '+ REGISTRAR DIRECTOR';
            }
        }

        function openEditDirector(id, nombre, bio, fotoUrl) {
            document.getElementById('edit-dir-id').value = id;
            document.getElementById('edit-dir-nombre').value = nombre;
            document.getElementById('edit-dir-bio').value = bio;
            const prev = document.getElementById('edit-dir-foto-prev');
            const initials = document.getElementById('edit-dir-foto-initials');
            if (fotoUrl) {
                prev.src = fotoUrl;
                prev.style.display = 'block';
                initials.style.display = 'none';
            } else {
                prev.style.display = 'none';
                initials.style.display = 'flex';
                initials.textContent = nombre.substring(0, 2).toUpperCase();
            }
            document.getElementById('modal-edit-director').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeEditDirector() {
            document.getElementById('modal-edit-director').style.display = 'none';
            document.body.style.overflow = '';
            document.getElementById('edit-dir-foto-input').value = '';
        }

        function previewEditFoto(input) {
            const file = input.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const prev = document.getElementById('edit-dir-foto-prev');
                prev.src = e.target.result;
                prev.style.display = 'block';
                document.getElementById('edit-dir-foto-initials').style.display = 'none';
            };
            reader.readAsDataURL(file);
        }

        async function submitEditDirector() {
            const id = document.getElementById('edit-dir-id').value;
            const nombre = document.getElementById('edit-dir-nombre').value.trim();
            const bio = document.getElementById('edit-dir-bio').value.trim();
            const foto = document.getElementById('edit-dir-foto-input').files[0];
            console.log({
                id,
                nombre,
                bio,
                foto
            });
            if (!nombre) {
                showErr('edit-dir-err-nombre', 'NOMBRE REQUERIDO');
                return;
            }
            const formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('biografia', bio);
            if (foto) formData.append('foto', foto);
            const btn = document.getElementById('btnEditarDirector');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span>';
            try {
                const res = await fetch(`{{ route("empleado.directores.actualizar", ["id" => ":id"]) }}`.replace(":id", id), {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                    },
                    body: formData,
                });
                const data = await res.json();


                if (!res.ok) {
                    if (data.errors) {
                        Object.entries(data.errors).forEach(([field, msgs]) => {
                            if (field === 'nombre') showErr('edit-dir-err-nombre', msgs[0].toUpperCase());
                        });
                    }
                    alertaRetro({
                        titulo: 'ERROR',
                        texto: `<p>${data.message?.toUpperCase() ?? 'ERROR AL EDITAR'}</p>`,
                        icono: 'error'
                    });
                    return;
                }
                const director = data.director ?? data;
                updateDirectorRow(director);
                const idx = MOCK_DIRECTORES.findIndex(d => d.id === director.id_director);
                if (idx !== -1) MOCK_DIRECTORES[idx].nombre = director.nombre.toUpperCase();

                closeEditDirector();
                alertaRetro({
                    titulo: 'DIRECTOR ACTUALIZADO',
                    texto: `<p>${director.nombre.toUpperCase()} fue actualizado.</p>`,
                    icono: 'success'
                });
            } catch (err) {
                console.error(err);
                alertaRetro({
                    titulo: 'ERROR DE CONEXIÓN',
                    texto: '<p>No se pudo conectar.</p>',
                    icono: 'error'
                });
            } finally {
                btn.disabled = false;
                btn.innerHTML = '✓ GUARDAR CAMBIOS';
            }
        }

        function updateDirectorRow(director) {
            const tr = document.querySelector(`#directores-tbody tr[data-id="${director.id_director}"]`);
            if (!tr) return;
            const base = `{{ asset('storage') }}`;
            const fotoUrl = director.foto ?
                `${base}/${director.foto}` :
                tr.dataset.foto || '';

            const nombre = (director.nombre ?? '').toUpperCase();
            const bio = director.biografia ?? '';

            tr.dataset.nombre = nombre;
            tr.dataset.bio = bio;
            tr.dataset.foto = fotoUrl;

            const celdas = tr.querySelectorAll('td');

            celdas[1].innerHTML = fotoUrl ?
                `<img src="${fotoUrl}?t=${Date.now()}" style="width:36px;height:36px;object-fit:cover;border:1px solid var(--v-dim);">` :
                `<div style="width:36px;height:36px;background:var(--ink3);border:1px solid var(--g-dark);display:flex;align-items:center;justify-content:center;font-family:var(--fo);font-size:10px;color:var(--v-dim);">${nombre.substring(0,2)}</div>`;

            celdas[2].textContent = nombre;
            celdas[3].textContent = bio ? bio.substring(0, 70) + (bio.length > 70 ? '…' : '') : '—';
        }

        document.getElementById('directores-tbody').addEventListener('click', function(e) {
            const tr = e.target.closest('tr[data-id]');
            if (!tr) return;

            const id = tr.dataset.id;
            const nom = tr.dataset.nombre ?? '';
            const bio = tr.dataset.bio ?? '';
            const foto = tr.dataset.foto ?? '';

            if (e.target.closest('.btn-edit-director')) {
                openEditDirector(id, nom, bio, foto);
            }

            if (e.target.closest('.btn-del-director')) {
                confirmarEliminarDirector(Number(id), nom);
            }
        });

        function appendDirectorRow(director) {
            const tbody = document.getElementById('directores-tbody');
            if (!tbody) return;

            const empty = document.getElementById('directores-empty');
            if (empty) empty.remove();
            const base = `{{ asset('storage') }}`;
            const fotoUrl = director.foto ? `${base}/${director.foto}` : '';
            const nombre = (director.nombre ?? '').toUpperCase();
            const bio = director.biografia ?? '';

            const tr = document.createElement('tr');
            tr.dataset.id = director.id_director;
            tr.dataset.nombre = nombre;
            tr.dataset.bio = bio;
            tr.dataset.foto = fotoUrl;
            tr.style.cssText = 'border-bottom:1px solid rgba(255,255,255,.03); transition:background .15s;';
            tr.setAttribute('onmouseover', "this.style.background='rgba(123,94,167,.05)'");
            tr.setAttribute('onmouseout', "this.style.background='transparent'");

            tr.innerHTML = `
        <td style="font-family:var(--fm);font-size:9px;color:var(--g);padding:12px 12px;">
            ${String(director.id_director).padStart(4, '0')}
        </td>
        <td style="padding:12px 12px;">
            ${fotoUrl
                ? `<img src="${fotoUrl}" style="width:36px;height:36px;object-fit:cover;border:1px solid var(--v-dim);">`
                : `<div style="width:36px;height:36px;background:var(--ink3);border:1px solid var(--g-dark);display:flex;align-items:center;justify-content:center;font-family:var(--fo);font-size:10px;color:var(--v-dim);">${nombre.substring(0,2)}</div>`
            }
        </td>
        <td style="font-family:var(--fm);font-size:10px;letter-spacing:1px;color:var(--w);padding:12px 12px;">
            ${nombre}
        </td>
        <td style="font-family:var(--fm);font-size:9px;color:var(--g);padding:12px 12px;max-width:300px;">
            ${bio ? bio.substring(0, 70) + (bio.length > 70 ? '…' : '') : '—'}
        </td>
        <td style="padding:12px 12px;text-align:center;">
            <div style="display:flex;gap:6px;justify-content:center;">
                <button class="btn-edit-director"
                    style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--v);background:transparent;border:1px solid var(--v-dim);padding:5px 12px;cursor:pointer;transition:all .18s;">
                    ✎ EDITAR
                </button>
                <button class="btn-del-director"
                    style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--red);background:transparent;border:1px solid var(--red);padding:5px 12px;cursor:pointer;transition:all .18s;opacity:.7;"
                    onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='.7'">
                    ✕ ELIMINAR
                </button>
            </div>
        </td>
    `;
            tbody.appendChild(tr);
        }

        function updateDirectorCount(delta) {
            const badge = document.querySelector('.nav-item[onclick*="director"] .nav-badge');
            if (!badge) return;
            const current = parseInt(badge.textContent) || 0;
            badge.textContent = String(current + delta).padStart(2, '0');
        }

        function confirmarEliminarDirector(id, nombre) {
            alertaConfirmar({
                titulo: 'ELIMINAR DIRECTOR',
                texto: `<p>¿Estás seguro de eliminar a <strong>${nombre}</strong>? Esta acción no se puede deshacer.</p>`,
                icono: 'warning',
                boton: 'SÍ, ELIMINAR',
                cancelar: true,
            }).then(result => {
                if (result.isConfirmed) eliminarDirector(id);
            });
        }

        async function eliminarDirector(id) {
            try {
                const res = await fetch(`{{ route('empleado.directores.destroy', ['id' => ':id']) }}`.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: '_method=DELETE',
                });

                const data = await res.json();
                console.log('RESPUESTA COMPLETA:', data);

                if (!res.ok) {
                    alertaRetro({
                        titulo: 'ERROR',
                        texto: `<p>${data.message?.toUpperCase() ?? 'NO SE PUDO ELIMINAR'}</p>`,
                        icono: 'error'
                    });
                    return;
                }

                const tr = document.querySelector(`#directores-tbody tr[data-id="${id}"]`);
                if (tr) tr.remove();
                const idx = MOCK_DIRECTORES.findIndex(d => d.id === id);
                if (idx !== -1) MOCK_DIRECTORES.splice(idx, 1);
                updateDirectorCount(-1);
                const tbody = document.getElementById('directores-tbody');
                if (tbody && tbody.querySelectorAll('tr').length === 0) {
                    tbody.innerHTML = `
                <tr id="directores-empty">
                    <td colspan="5" style="font-family:var(--fm);font-size:9px;color:var(--g);padding:24px;text-align:center;letter-spacing:2px;">
                        ⌦ SIN DIRECTORES REGISTRADOS
                    </td>
                </tr>`;
                }

                alertaRetro({
                    titulo: 'DIRECTOR ELIMINADO',
                    texto: '<p>El director fue eliminado del sistema.</p>',
                    icono: 'success'
                });

            } catch (err) {
                console.error(err);
                alertaRetro({
                    titulo: 'ERROR DE CONEXIÓN',
                    texto: '<p>No se pudo conectar con el servidor.</p>',
                    icono: 'error'
                });
            }
        }

        const MOCK_ACTORES = @json($actores -> map(fn($a) => [
            'id' => $a -> id_actor,
            'nombre' => strtoupper($a -> nombre),
        ]));

        async function submitActor() {
            const nombre = document.getElementById('act-nombre').value.trim();
            const bio = document.getElementById('act-bio').value.trim();
            const foto = document.getElementById('act-foto-input').files[0];

            if (!nombre) {
                alertaRetro({
                    titulo: 'ACTOR REQUERIDO',
                    texto: '<p>El nombre del actor es un campo requerido.</p>',
                    icono: 'error'
                });
                return;
            }
            if (foto && foto.size > 4 * 1024 * 1024) {
                alertaRetro({
                    titulo: 'FOTO DEMASIADO GRANDE',
                    texto: '<p>La foto no debe superar los 4MB.</p>',
                    icono: 'error'
                });
                return;
            }

            const formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('biografia', bio);
            if (foto) formData.append('foto', foto);

            const btn = document.getElementById('btnAct');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span>';

            try {
                const res = await fetch('{{ route("empleado.actores.registrar") }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    },
                    body: formData,
                });
                const data = await res.json();

                if (!res.ok) {
                    if (data.errors) {
                        const map = {
                            nombre: 'act-err-nombre',
                            biografia: 'act-err-bio',
                            foto: 'act-err-foto'
                        };
                        Object.entries(data.errors).forEach(([f, msgs]) => {
                            if (map[f]) showErr(map[f], msgs[0].toUpperCase());
                        });
                        alertaRetro({
                            titulo: 'ERROR DE REGISTRO',
                            texto: `<ul>${Object.values(data.errors).map(m=>`<li>${m[0]}</li>`).join('')}</ul>`,
                            icono: 'error'
                        });
                    } else {
                        alertaRetro({
                            titulo: 'ERROR',
                            texto: `<p>${data.message?.toUpperCase() ?? 'ERROR AL REGISTRAR'}</p>`,
                            icono: 'error'
                        });
                    }
                    return;
                }

                const actor = data.actor ?? data;
                appendActorRow(actor);
                MOCK_ACTORES.push({
                    id: actor.id_actor,
                    nombre: actor.nombre.toUpperCase()
                });
                updateActorCount(1);
                clearForm('act');
                alertaRetro({
                    titulo: 'ACTOR REGISTRADO',
                    texto: `<p>El actor <strong>${actor.nombre.toUpperCase()}</strong> fue registrado correctamente.</p>`,
                    icono: 'success'
                });

            } catch (err) {
                console.error(err);
                alertaRetro({
                    titulo: 'ERROR DE CONEXIÓN',
                    texto: '<p>No se pudo conectar con el servidor.</p>',
                    icono: 'error'
                });
            } finally {
                btn.disabled = false;
                btn.innerHTML = '+ REGISTRAR ACTOR';
            }
        }

        function appendActorRow(actor) {
            const tbody = document.getElementById('actores-tbody');
            if (!tbody) return;
            const empty = document.getElementById('actores-empty');
            if (empty) empty.remove();

            const base = `{{ asset('storage') }}`;
            const fotoUrl = actor.foto ? `${base}/${actor.foto}` : '';
            const nombre = (actor.nombre ?? '').toUpperCase();
            const bio = actor.biografia ?? '';

            const tr = document.createElement('tr');
            tr.dataset.id = actor.id_actor;
            tr.dataset.nombre = nombre;
            tr.dataset.bio = bio;
            tr.dataset.foto = fotoUrl;
            tr.style.cssText = 'border-bottom:1px solid rgba(255,255,255,.03); transition:background .15s;';
            tr.setAttribute('onmouseover', "this.style.background='rgba(123,94,167,.05)'");
            tr.setAttribute('onmouseout', "this.style.background='transparent'");

            tr.innerHTML = `
        <td style="font-family:var(--fm);font-size:9px;color:var(--g);padding:12px 12px;">${String(actor.id_actor).padStart(4,'0')}</td>
        <td style="padding:12px 12px;">
            ${fotoUrl
                ? `<img src="${fotoUrl}" style="width:36px;height:36px;object-fit:cover;border:1px solid var(--v-dim);">`
                : `<div style="width:36px;height:36px;background:var(--ink3);border:1px solid var(--g-dark);display:flex;align-items:center;justify-content:center;font-family:var(--fo);font-size:10px;color:var(--v-dim);">${nombre.substring(0,2)}</div>`}
        </td>
        <td style="font-family:var(--fm);font-size:10px;letter-spacing:1px;color:var(--w);padding:12px 12px;">${nombre}</td>
        <td style="font-family:var(--fm);font-size:9px;color:var(--g);padding:12px 12px;max-width:300px;">${bio ? bio.substring(0,70)+(bio.length>70?'…':'') : '—'}</td>
        <td style="padding:12px 12px;text-align:center;">
            <div style="display:flex;gap:6px;justify-content:center;">
                <button class="btn-edit-actor" style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--v);background:transparent;border:1px solid var(--v-dim);padding:5px 12px;cursor:pointer;transition:all .18s;">✎ EDITAR</button>
                <button class="btn-del-actor" style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--red);background:transparent;border:1px solid var(--red);padding:5px 12px;cursor:pointer;transition:all .18s;opacity:.7;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='.7'">✕ ELIMINAR</button>
            </div>
        </td>`;
            tbody.appendChild(tr);
        }

        function updateActorRow(actor) {
            const tr = document.querySelector(`#actores-tbody tr[data-id="${actor.id_actor}"]`);
            if (!tr) return;
            const base = `{{ asset('storage') }}`;
            const fotoUrl = actor.foto ? `${base}/${actor.foto}` : tr.dataset.foto || '';
            const nombre = (actor.nombre ?? '').toUpperCase();
            const bio = actor.biografia ?? '';

            tr.dataset.nombre = nombre;
            tr.dataset.bio = bio;
            tr.dataset.foto = fotoUrl;

            const celdas = tr.querySelectorAll('td');
            celdas[1].innerHTML = fotoUrl ?
                `<img src="${fotoUrl}?t=${Date.now()}" style="width:36px;height:36px;object-fit:cover;border:1px solid var(--v-dim);">` :
                `<div style="width:36px;height:36px;background:var(--ink3);border:1px solid var(--g-dark);display:flex;align-items:center;justify-content:center;font-family:var(--fo);font-size:10px;color:var(--v-dim);">${nombre.substring(0,2)}</div>`;
            celdas[2].textContent = nombre;
            celdas[3].textContent = bio ? bio.substring(0, 70) + (bio.length > 70 ? '…' : '') : '—';
        }

        function updateActorCount(delta) {
            const badge = document.querySelector('.nav-item[onclick*="actor"] .nav-badge');
            if (!badge) return;
            const current = parseInt(badge.textContent) || 0;
            badge.textContent = String(current + delta).padStart(2, '0');
        }

        function openEditActor(id, nombre, bio, fotoUrl) {
            document.getElementById('edit-act-id').value = id;
            document.getElementById('edit-act-nombre').value = nombre;
            document.getElementById('edit-act-bio').value = bio;
            const prev = document.getElementById('edit-act-foto-prev');
            const initials = document.getElementById('edit-act-foto-initials');
            if (fotoUrl) {
                prev.src = fotoUrl;
                prev.style.display = 'block';
                initials.style.display = 'none';
            } else {
                prev.style.display = 'none';
                initials.style.display = 'flex';
                initials.textContent = nombre.substring(0, 2).toUpperCase();
            }
            document.getElementById('modal-edit-actor').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeEditActor() {
            document.getElementById('modal-edit-actor').style.display = 'none';
            document.body.style.overflow = '';
            document.getElementById('edit-act-foto-input').value = '';
        }

        function previewEditActorFoto(input) {
            const file = input.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const prev = document.getElementById('edit-act-foto-prev');
                prev.src = e.target.result;
                prev.style.display = 'block';
                document.getElementById('edit-act-foto-initials').style.display = 'none';
            };
            reader.readAsDataURL(file);
        }

        async function submitEditActor() {
            const id = document.getElementById('edit-act-id').value;
            const nombre = document.getElementById('edit-act-nombre').value.trim();
            const bio = document.getElementById('edit-act-bio').value.trim();
            const foto = document.getElementById('edit-act-foto-input').files[0];

            if (!nombre) {
                showErr('edit-act-err-nombre', 'NOMBRE REQUERIDO');
                return;
            }

            const formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('biografia', bio);
            if (foto) formData.append('foto', foto);

            const btn = document.getElementById('btnEditarActor');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span>';

            try {
                const res = await fetch(`{{ route("empleado.actores.actualizar", ["id" => ":id"]) }}`.replace(':id', id), {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    },
                    body: formData,
                });
                const data = await res.json();

                if (!res.ok) {
                    if (data.errors) Object.entries(data.errors).forEach(([f, msgs]) => {
                        if (f === 'nombre') showErr('edit-act-err-nombre', msgs[0].toUpperCase());
                    });
                    alertaRetro({
                        titulo: 'ERROR',
                        texto: `<p>${data.message?.toUpperCase() ?? 'ERROR AL EDITAR'}</p>`,
                        icono: 'error'
                    });
                    return;
                }

                const actor = data.actor ?? data;
                updateActorRow(actor);
                const idx = MOCK_ACTORES.findIndex(a => a.id === actor.id_actor);
                if (idx !== -1) MOCK_ACTORES[idx].nombre = actor.nombre.toUpperCase();
                closeEditActor();
                alertaRetro({
                    titulo: 'ACTOR ACTUALIZADO',
                    texto: `<p>${actor.nombre.toUpperCase()} fue actualizado.</p>`,
                    icono: 'success'
                });

            } catch (err) {
                console.error(err);
                alertaRetro({
                    titulo: 'ERROR DE CONEXIÓN',
                    texto: '<p>No se pudo conectar.</p>',
                    icono: 'error'
                });
            } finally {
                btn.disabled = false;
                btn.innerHTML = '✓ GUARDAR CAMBIOS';
            }
        }

        function confirmarEliminarActor(id, nombre) {
            alertaConfirmar({
                titulo: 'ELIMINAR ACTOR',
                texto: `<p>¿Estás seguro de eliminar a <strong>${nombre}</strong>? Esta acción no se puede deshacer.</p>`,
                icono: 'warning',
                boton: 'SÍ, ELIMINAR',
                cancelar: true,
            }).then(result => {
                if (result.isConfirmed) eliminarActor(id);
            });
        }

        async function eliminarActor(id) {
            try {
                const res = await fetch(`{{ route('empleado.actores.destroy', ['id' => ':id']) }}`.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: '_method=DELETE',
                });
                const data = await res.json();

                if (!res.ok) {
                    alertaRetro({
                        titulo: 'ERROR',
                        texto: `<p>${data.message?.toUpperCase() ?? 'NO SE PUDO ELIMINAR'}</p>`,
                        icono: 'error'
                    });
                    return;
                }

                const tr = document.querySelector(`#actores-tbody tr[data-id="${id}"]`);
                if (tr) tr.remove();
                const idx = MOCK_ACTORES.findIndex(a => a.id === id);
                if (idx !== -1) MOCK_ACTORES.splice(idx, 1);
                updateActorCount(-1);
                const tbody = document.getElementById('actores-tbody');
                if (tbody && tbody.querySelectorAll('tr').length === 0) {
                    tbody.innerHTML = `<tr id="actores-empty"><td colspan="5" style="font-family:var(--fm);font-size:9px;color:var(--g);padding:24px;text-align:center;letter-spacing:2px;">⌦ SIN ACTORES REGISTRADOS</td></tr>`;
                }
                alertaRetro({
                    titulo: 'ACTOR ELIMINADO',
                    texto: '<p>El actor fue eliminado del sistema.</p>',
                    icono: 'success'
                });

            } catch (err) {
                console.error(err);
                alertaRetro({
                    titulo: 'ERROR DE CONEXIÓN',
                    texto: '<p>No se pudo conectar con el servidor.</p>',
                    icono: 'error'
                });
            }
        }

        document.getElementById('actores-tbody').addEventListener('click', function(e) {
            const tr = e.target.closest('tr[data-id]');
            if (!tr) return;
            const id = tr.dataset.id;
            const nom = tr.dataset.nombre ?? '';
            const bio = tr.dataset.bio ?? '';
            const foto = tr.dataset.foto ?? '';
            if (e.target.closest('.btn-edit-actor')) openEditActor(id, nom, bio, foto);
            if (e.target.closest('.btn-del-actor')) confirmarEliminarActor(Number(id), nom);
        });

        // Pelicula 
        function setPendingActor(id, nombre) {
            pendingActorId = id;
            pendingActorName = nombre;
            document.getElementById('reparto-search').value = nombre;
            document.getElementById('actor-dropdown').classList.remove('open');
        }

        function removeActor(id) {
            repartoIds = repartoIds.filter(i => i !== id);
            renderRepartoTags();
        }

        function renderRepartoTags() {
            const wrap = document.getElementById('reparto-tags');
            const placeholder = document.getElementById('reparto-placeholder');
            wrap.querySelectorAll('.reparto-tag').forEach(t => t.remove());

            if (repartoItems.length === 0) {
                placeholder.style.display = '';
            } else {
                placeholder.style.display = 'none';
                repartoItems.forEach(({
                    id,
                    nombre,
                    papel
                }) => {
                    const tag = document.createElement('span');
                    tag.className = 'reparto-tag';
                    tag.dataset.id = id;
                    tag.innerHTML = `◈ ${nombre}${papel ? ` <em style="font-style:normal;color:var(--v-dim);font-size:8px;letter-spacing:1px;">[${papel.toUpperCase()}]</em>` : ''} <span class="tag-remove" onclick="removeActor(${id})">✕</span>`;
                    wrap.appendChild(tag);
                });
            }
            document.getElementById('pel-reparto-ids').value = repartoItems.map(r => r.id).join(',');
        }

        async function submitPelicula() {
            const titulo = document.getElementById('pel-titulo').value.trim();
            const anio = document.getElementById('pel-anio').value.trim();
            const duracion = document.getElementById('pel-duracion').value.trim();
            const idDirector = document.getElementById('pel-id-director').value;
            const idGenero = document.getElementById('pel-genero').value;
            if (!titulo) {
                showErr('pel-err-titulo', 'TÍTULO REQUERIDO');
                return;
            }
            if (!anio) {
                showErr('pel-err-anio', 'AÑO REQUERIDO');
                return;
            }
            if (!duracion) {
                showErr('pel-err-duracion', 'DURACIÓN REQUERIDA');
                return;
            }
            if (!idGenero) {
                showErr('pel-err-genero', 'GÉNERO REQUERIDO');
                return;
            }
            if (!idDirector) {
                showErr('pel-err-director', 'SELECCIONA UN DIRECTOR');
                return;
            }
            const fd = new FormData();
            fd.append('titulo', titulo);
            fd.append('anio_lanzamiento', anio);
            fd.append('duracion', duracion);
            fd.append('estudio', document.getElementById('pel-estudio').value.trim());
            fd.append('precio_alquiler', document.getElementById('pel-precio').value.trim());
            fd.append('clasificacion', document.getElementById('pel-clasificacion').value);
            fd.append('id_genero', idGenero);
            fd.append('resumen', document.getElementById('pel-resumen').value.trim());
            fd.append('id_director', idDirector);
            repartoItems.forEach((item, index) => {
                fd.append(`reparto[${index}][id]`, item.id);
                fd.append(`reparto[${index}][papel]`, item.papel ?? '');
            });
            const formatoMap = {
                dvd: 1,
                bluray: 2,
                uhdbd: 3,
                vhs: 4
            };
            Object.entries(formatoMap).forEach(([key, idFormato]) => {
                const file = document.getElementById(`fmt-${key}`)?.files[0];
                if (file) fd.append(`portadas[${idFormato}]`, file);
            });
            const portada = document.getElementById('pel-portada')?.files[0];
            const banner = document.getElementById('pel-banner')?.files[0];
            if (portada) fd.append('foto_portada', portada);
            if (banner) fd.append('banner', banner);
            const btn = document.getElementById('btnPel');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span>';
            try {
                const res = await fetch('{{ route("empleado.peliculas.registrar") }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                    },
                    body: fd,
                });
                const data = await res.json();
                if (!res.ok) {
                    if (data.errors) {

                        const errorMap = {
                            titulo: 'pel-err-titulo',
                            anio_lanzamiento: 'pel-err-anio',
                            duracion: 'pel-err-duracion',
                            estudio: 'pel-err-estudio',
                            precio_alquiler: 'pel-err-precio',
                            clasificacion: 'pel-err-clasificacion',
                            id_genero: 'pel-err-genero',
                            resumen: 'pel-err-resumen',
                            id_director: 'pel-err-director',
                        };

                        Object.entries(data.errors).forEach(([field, msgs]) => {
                            if (errorMap[field]) {
                                showErr(errorMap[field], msgs[0].toUpperCase());
                            }
                        });

                        alertaRetro({
                            titulo: 'ERROR DE REGISTRO',
                            texto: `<ul>${Object.values(data.errors).map(m => `<li>${m[0]}</li>`).join('')}</ul>`,
                            icono: 'error',
                        });
                    } else {
                        alertaRetro({
                            titulo: 'ERROR',
                            texto: `<p>${data.message?.toUpperCase() ?? 'ERROR AL REGISTRAR'}</p>`,
                            icono: 'error',
                        });
                    }
                    return;
                }
                const pelicula = data.pelicula ?? data;
                MOCK_PELICULAS.push({
                    id: pelicula.id_pelicula,
                    nombre: pelicula.titulo.toUpperCase(),
                });
                updatePeliculaCount(1);
                clearForm('pel');
                alertaRetro({
                    titulo: 'PELÍCULA REGISTRADA',
                    texto: `<p>La película <strong>${pelicula.titulo.toUpperCase()}</strong> fue registrada correctamente.</p>`,
                    icono: 'success',
                });
            } catch (err) {
                console.error(err);
                alertaRetro({
                    titulo: 'ERROR DE CONEXIÓN',
                    texto: '<p>No se pudo conectar con el servidor. Intenta de nuevo.</p>',
                    icono: 'error',
                });
            } finally {
                btn.disabled = false;
                btn.innerHTML = '+ REGISTRAR PELÍCULA';
            }
        }

        function abrirModalPapel(id, nombre) {
            pendingActorId = id;
            pendingActorName = nombre;
            document.getElementById('modal-papel-nombre').textContent = nombre;
            document.getElementById('modal-papel-input').value = '';
            document.getElementById('modal-papel-actor').style.display = 'flex';
            document.body.style.overflow = 'hidden';
            setTimeout(() => document.getElementById('modal-papel-input').focus(), 80);
        }

        function cerrarModalPapel() {
            document.getElementById('modal-papel-actor').style.display = 'none';
            document.body.style.overflow = '';
            resetPendingActor();
        }

        function confirmarPapel() {
            const papel = document.getElementById('modal-papel-input').value.trim();
            repartoItems.push({
                id: pendingActorId,
                nombre: pendingActorName,
                papel: papel || null,
            });
            renderRepartoTags();
            document.getElementById('modal-papel-actor').style.display = 'none';
            document.body.style.overflow = '';
            resetPendingActor();
        }

        function updatePeliculaCount(delta) {
            const badge = document.querySelector('.nav-item[onclick*="pelicula"] .nav-badge');
            if (!badge) return;
            const current = parseInt(badge.textContent) || 0;
            badge.textContent = String(current + delta).padStart(2, '0');
        }

        document.getElementById('modal-papel-actor').addEventListener('click', function(e) {
            if (e.target === this) cerrarModalPapel();
        });

        function resetPendingActor() {
            pendingActorId = null;
            pendingActorName = null;
            document.getElementById('reparto-search').value = '';
            document.getElementById('actor-dropdown').classList.remove('open');
        }
        let ingQtys = {
            dvd: 0,
            blu: 0,
            uhd: 0,
            vhs: 0
        };
        let ingPelId = null;
        let ingPelNombre = '';

        const ING_FORMATOS = {
            dvd: {
                id: 1,
                nombre: 'DVD'
            },
            blu: {
                id: 2,
                nombre: 'BLU-RAY'
            },
            uhd: {
                id: 3,
                nombre: 'BLU-RAY UHD'
            },
            vhs: {
                id: 4,
                nombre: 'VHS'
            },
        };

        function ingSearchPelicula(q) {
            const dd = document.getElementById('ing-pel-dropdown');
            if (!q.trim()) {
                dd.classList.remove('open');
                return;
            }
            const results = MOCK_PELICULAS.filter(p => p.nombre.toLowerCase().includes(q.toLowerCase()));
            dd.innerHTML = results.length ?
                results.map(p => `<div class="actor-dropdown-item" onclick="ingSelectPelicula(${p.id},'${p.nombre}')"><span class="adi-name">▶ ${p.nombre}</span></div>`).join('') :
                `<div class="actor-dropdown-empty">SIN COINCIDENCIAS — REGISTRA LA PELÍCULA PRIMERO</div>`;
            dd.classList.add('open');
        }

        function ingSelectPelicula(id, nombre) {
            ingPelId = id;
            ingPelNombre = nombre;
            document.getElementById('ing-id-pelicula').value = id;
            document.getElementById('ing-pel-search').value = '';
            document.getElementById('ing-pel-dropdown').classList.remove('open');
            document.getElementById('ing-pel-sel-name').textContent = '▶ ' + nombre;
            document.getElementById('ing-pel-sel').style.display = 'flex';
            document.getElementById('ing-err-pel').classList.remove('show');
        }

        function ingClearPelicula() {
            ingPelId = null;
            ingPelNombre = '';
            document.getElementById('ing-id-pelicula').value = '';
            document.getElementById('ing-pel-search').value = '';
            document.getElementById('ing-pel-sel').style.display = 'none';
        }

        function ingChangeQty(fmt, delta) {
            ingQtys[fmt] = Math.max(0, ingQtys[fmt] + delta);
            document.getElementById('ing-qty-' + fmt).textContent = ingQtys[fmt];
            const total = Object.values(ingQtys).reduce((a, b) => a + b, 0);
            document.getElementById('ing-total').textContent = String(total).padStart(2, '0');
        }

        function ingResetForm() {
            ingClearPelicula();
            ['dvd', 'blu', 'uhd', 'vhs'].forEach(f => {
                ingQtys[f] = 0;
                document.getElementById('ing-qty-' + f).textContent = '0';
            });
            document.getElementById('ing-total').textContent = '00';
        }

        async function ingSubmitLote() {
            if (!ingPelId) {
                showErr('ing-err-pel', 'SELECCIONA UNA PELÍCULA');
                return;
            }
            const total = Object.values(ingQtys).reduce((a, b) => a + b, 0);
            if (total === 0) {
                alertaRetro({
                    titulo: 'SIN UNIDADES',
                    texto: '<p>Agrega al menos una unidad en algún formato.</p>',
                    icono: 'error'
                });
                return;
            }

            const lotes = Object.entries(ING_FORMATOS)
                .filter(([k]) => ingQtys[k] > 0)
                .map(([k, fmt]) => ({
                    id_formato: fmt.id,
                    cantidad: ingQtys[k]
                }));

            const btn = document.getElementById('btn-ing');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span>';

            try {
                const res = await fetch('{{ route("empleado.cintas.lote") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    },
                    body: JSON.stringify({
                        id_pelicula: ingPelId,
                        lotes
                    }),
                });
                const data = await res.json();
                if (!res.ok) {
                    alertaRetro({
                        titulo: 'ERROR',
                        texto: `<p>${data.message?.toUpperCase() ?? 'ERROR AL REGISTRAR'}</p>`,
                        icono: 'error'
                    });
                    return;
                }
                ingRenderModal(data.cintas);
            } catch (err) {
                console.error(err);
                alertaRetro({
                    titulo: 'ERROR DE CONEXIÓN',
                    texto: '<p>No se pudo conectar con el servidor.</p>',
                    icono: 'error'
                });
            } finally {
                btn.disabled = false;
                btn.innerHTML = '⬛ GENERAR CINTAS';
            }
        }

        function ingRenderModal(cintas) {
            const total = cintas.length;
            const grupos = {};
            cintas.forEach(c => {
                const key = Object.keys(ING_FORMATOS).find(k => ING_FORMATOS[k].id === c.id_formato) ?? 'dvd';
                if (!grupos[key]) grupos[key] = [];
                grupos[key].push(c);
            });

            let html = `
        <div style="background:rgba(123,94,167,.08);border:1px solid rgba(123,94,167,.2);padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:16px;">
            <div style="flex:1;">
                <div style="font-family:var(--fh);font-size:18px;letter-spacing:4px;color:var(--w);">${ingPelNombre}</div>
                <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-top:4px;">PELÍCULA ASOCIADA</div>
            </div>
            <span style="font-family:var(--fo);font-size:11px;letter-spacing:2px;color:var(--v);background:rgba(123,94,167,.15);border:1px solid var(--v-dim);padding:4px 12px;">${String(total).padStart(2,'0')} CINTAS INGRESADAS</span>
        </div>`;

            Object.entries(grupos).forEach(([key, items]) => {
                const fmt = ING_FORMATOS[key];
                html += `
            <div style="margin-bottom:20px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;padding-bottom:8px;border-bottom:1px solid rgba(255,255,255,.04);">
                    <span style="font-family:var(--fo);font-size:9px;letter-spacing:2px;color:var(--v);background:rgba(123,94,167,.12);border:1px solid var(--v-dim);padding:3px 10px;">${fmt.nombre}</span>
                    <span style="font-family:var(--fm);font-size:8px;color:var(--g);letter-spacing:1px;">· ${items.length} UNIDAD${items.length>1?'ES':''}</span>
                </div>
                <table style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="border-bottom:1px solid rgba(255,255,255,.04);">
                            <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:8px 12px;text-align:left;font-weight:400;">ID INVENTARIO</th>
                            <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:8px 12px;text-align:left;font-weight:400;">FORMATO</th>
                            <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:8px 12px;text-align:left;font-weight:400;">ESTADO</th>
                            <th style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);padding:8px 12px;text-align:left;font-weight:400;">ETIQUETA FÍSICA</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${items.map(c => `
                            <tr style="border-bottom:1px solid rgba(255,255,255,.025);">
                                <td style="padding:10px 12px;font-family:var(--fo);font-size:12px;letter-spacing:2px;color:var(--v);">#${String(c.id_cinta).padStart(5,'0')}</td>
                                <td style="padding:10px 12px;font-family:var(--fm);font-size:9px;color:var(--g);letter-spacing:1px;">${fmt.nombre}</td>
                                <td style="padding:10px 12px;">
                                    <span style="display:inline-flex;align-items:center;gap:5px;font-family:var(--fm);font-size:8px;letter-spacing:1px;color:var(--green);background:rgba(76,175,106,.08);border:1px solid rgba(76,175,106,.25);padding:3px 10px;">◉ DISPONIBLE</span>
                                </td>
                                <td style="padding:10px 12px;font-family:var(--fo);font-size:9px;color:var(--g-dark);letter-spacing:1px;">⬛ ${String(c.id_cinta).padStart(5,'0')}·${fmt.nombre.substring(0,3)}</td>
                            </tr>`).join('')}
                    </tbody>
                </table>
            </div>`;
            });

            html += `
        <div style="background:rgba(123,94,167,.04);border:1px solid rgba(255,255,255,.04);padding:12px 16px;margin-top:8px;display:flex;align-items:flex-start;gap:12px;">
            <span style="font-size:14px;flex-shrink:0;margin-top:1px;color:var(--v);">⬡</span>
            <div>
                <div style="font-family:var(--fo);font-size:8px;letter-spacing:2px;color:var(--v);margin-bottom:5px;">INSTRUCCIONES DE ETIQUETADO FÍSICO</div>
                <div style="font-family:var(--fm);font-size:9px;letter-spacing:1px;color:var(--g);line-height:1.7;">
                    Imprime este listado y adhiere una etiqueta con el <strong style="color:var(--w);">ID INVENTARIO</strong> en cada unidad física.
                    Formato de etiqueta: <span style="font-family:var(--fo);color:var(--v);">#NNNNN · FMT</span> — Ej: <span style="font-family:var(--fo);color:var(--v);">#01042 · DVD</span>.
                </div>
            </div>
        </div>
        <div style="display:flex;gap:10px;padding-top:16px;border-top:1px solid rgba(255,255,255,.04);margin-top:20px;">
            <button onclick="window.print()" style="font-family:var(--fo);font-size:8px;letter-spacing:2px;background:transparent;color:var(--v);border:1px solid var(--v-dim);padding:10px 20px;cursor:pointer;transition:all .18s;" onmouseover="this.style.background='var(--v-soft)'" onmouseout="this.style.background='transparent'">⬡ IMPRIMIR LISTADO</button>
            <button class="btn-clear" onclick="ingCloseModal();ingResetForm();">REGISTRAR OTRO LOTE</button>
        </div>`;

            document.getElementById('ing-modal-body').innerHTML = html;
            document.getElementById('modal-ingreso').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function ingCloseModal() {
            document.getElementById('modal-ingreso').style.display = 'none';
            document.body.style.overflow = '';
        }

        document.getElementById('modal-ingreso').addEventListener('click', function(e) {
            if (e.target === this) ingCloseModal();
        });

        const EC_FORMATOS = {
            1: 'DVD',
            2: 'BLU-RAY',
            3: 'BLU-RAY UHD',
            4: 'VHS'
        };

        const EC_ESTADOS = {
            disponible: {
                color: 'var(--green)',
                bg: 'rgba(76,175,106,.08)',
                border: 'rgba(76,175,106,.25)',
                dot: '◉'
            },
            prestada: {
                color: '#378ADD',
                bg: 'rgba(55,138,221,.08)',
                border: 'rgba(55,138,221,.25)',
                dot: '◈'
            },
            'dañada': {
                color: 'var(--red)',
                bg: 'rgba(192,57,43,.08)',
                border: 'rgba(192,57,43,.25)',
                dot: '◌'
            },
            'en mantenimiento': {
                color: 'var(--amber)',
                bg: 'rgba(212,160,23,.08)',
                border: 'rgba(212,160,23,.25)',
                dot: '◎'
            },
            perdida: {
                color: 'var(--g)',
                bg: 'rgba(102,102,102,.08)',
                border: 'rgba(102,102,102,.2)',
                dot: '○'
            },
        };

        const EC_TRANSICIONES = {
            disponible: ['dañada', 'en mantenimiento', 'perdida'],
            rentada: [],
            'dañada': ['disponible', 'en mantenimiento', 'perdida'],
            'en mantenimiento': ['disponible', 'dañada', 'perdida'],
            perdida: [],
        };

        let ecTodas = [];
        let ecFiltradas = [];
        let ecPagina = 1;
        const EC_POR_PAGINA = 15;

        function ecEstadoPill(estado) {
            const e = EC_ESTADOS[estado] ?? EC_ESTADOS['disponible'];
            return `<span style="display:inline-flex;align-items:center;gap:5px;font-family:var(--fm);font-size:8px;letter-spacing:1px;color:${e.color};background:${e.bg};border:1px solid ${e.border};padding:3px 10px;">${e.dot} ${estado.toUpperCase()}</span>`;
        }

        async function ecCargar() {
            try {
                const res = await fetch('{{ route("empleado.cintas.index") }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    }
                });
                const data = await res.json();
                ecTodas = (data.cintas ?? []).map(c => ({
                    ...c,
                    estado: c.estado.toLowerCase().trim()
                }));


                ecFiltradas = [...ecTodas];
                ecRenderTabla();
            } catch (err) {
                console.error('Error cargando cintas:', err);
                document.getElementById('ec-tbody').innerHTML = `
                    <tr><td colspan="5" style="font-family:var(--fm);font-size:9px;color:var(--red);padding:24px;text-align:center;letter-spacing:2px;">
                        ⌦ ERROR AL CARGAR CINTAS
                    </td></tr>`;
            }
        }

        function ecFiltrar() {
            const q = document.getElementById('ec-search').value.toLowerCase();
            const fmt = document.getElementById('ec-formato').value;
            const estado = document.getElementById('ec-estado').value;

            ecFiltradas = ecTodas.filter(c => {
                const matchQ = !q || c.pelicula.toLowerCase().includes(q);
                const matchFmt = !fmt || String(c.id_formato) === fmt;
                const matchEstado = !estado || c.estado === estado;
                return matchQ && matchFmt && matchEstado;
            });
            ecPagina = 1;
            ecRenderTabla();
        }

        function ecRenderTabla() {
            const tbody = document.getElementById('ec-tbody');
            const inicio = (ecPagina - 1) * EC_POR_PAGINA;
            const pagina = ecFiltradas.slice(inicio, inicio + EC_POR_PAGINA);
            const totalPags = Math.ceil(ecFiltradas.length / EC_POR_PAGINA) || 1;

            if (!pagina.length) {
                tbody.innerHTML = `<tr><td colspan="5" style="font-family:var(--fm);font-size:9px;color:var(--g);padding:24px;text-align:center;letter-spacing:2px;">⌦ SIN CINTAS QUE COINCIDAN</td></tr>`;
            } else {
                tbody.innerHTML = pagina.map(c => `
                    <tr data-id="${c.id_cinta}" style="border-bottom:1px solid rgba(255,255,255,.03);transition:background .15s;"
                        onmouseover="this.style.background='rgba(123,94,167,.05)'" onmouseout="this.style.background='transparent'">
                        <td style="font-family:var(--fo);font-size:10px;letter-spacing:2px;color:var(--v);padding:12px 12px;">#${String(c.id_cinta).padStart(5,'0')}</td>
                        <td style="font-family:var(--fm);font-size:10px;letter-spacing:1px;color:var(--w);padding:12px 12px;">${c.pelicula.toUpperCase()}</td>
                        <td style="font-family:var(--fm);font-size:9px;color:var(--g);padding:12px 12px;">${EC_FORMATOS[c.id_formato] ?? '—'}</td>
                        <td style="padding:12px 12px;">${ecEstadoPill(c.estado)}</td>
                        <td style="padding:12px 12px;text-align:center;">
                            ${EC_TRANSICIONES[c.estado]?.length
                                ? `<button onclick="ecAbrirModal(${c.id_cinta})"
                                    style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--v);background:transparent;border:1px solid var(--v-dim);padding:5px 12px;cursor:pointer;transition:all .18s;"
                                    onmouseover="this.style.background='var(--v-soft)'" onmouseout="this.style.background='transparent'">
                                    ◧ CAMBIAR
                                </button>`
                                : `<span style="font-family:var(--fm);font-size:8px;letter-spacing:1px;color:var(--g-dark);">— SIN CAMBIOS —</span>`
                            }
                        </td>
                    </tr>`).join('');
            }

            document.getElementById('ec-count').textContent = `${ecFiltradas.length} CINTAS ENCONTRADAS`;
            document.getElementById('ec-page-info').textContent = `PÁG ${ecPagina} / ${totalPags}`;
            document.getElementById('ec-prev').style.opacity = ecPagina <= 1 ? '.3' : '1';
            document.getElementById('ec-next').style.opacity = ecPagina >= totalPags ? '.3' : '1';
        }

        function ecPaginar(delta) {
            const totalPags = Math.ceil(ecFiltradas.length / EC_POR_PAGINA) || 1;
            ecPagina = Math.max(1, Math.min(totalPags, ecPagina + delta));
            ecRenderTabla();
        }

        function ecAbrirModal(id) {
            const c = ecTodas.find(x => x.id_cinta === id);
            if (!c) return;

            document.getElementById('ec-modal-id').textContent = `#${String(c.id_cinta).padStart(5,'0')}`;
            document.getElementById('ec-modal-pelicula').textContent = c.pelicula.toUpperCase();
            document.getElementById('ec-modal-formato').textContent = EC_FORMATOS[c.id_formato] ?? '—';
            document.getElementById('ec-modal-estado-actual').innerHTML = ecEstadoPill(c.estado);
            document.getElementById('ec-modal-cinta-id').value = c.id_cinta;

            const opciones = EC_TRANSICIONES[c.estado] ?? [];
            document.getElementById('ec-modal-opciones').innerHTML = opciones.map(op => {
                const e = EC_ESTADOS[op];
                return `<button onclick="ecCambiarEstado(${c.id_cinta},'${op}')"
                        style="width:100%;text-align:left;font-family:var(--fm);font-size:10px;letter-spacing:2px;color:${e.color};background:${e.bg};border:1px solid ${e.border};padding:11px 16px;cursor:pointer;transition:all .18s;"
                        onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">
                        ${e.dot} &nbsp;${op.toUpperCase()}
                    </button>`;
            }).join('');

            document.getElementById('modal-ec').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function ecCloseModal() {
            document.getElementById('modal-ec').style.display = 'none';
            document.body.style.overflow = '';
        }

        async function ecCambiarEstado(id, nuevoEstado) {
            try {
                const res = await fetch(`{{ route('empleado.cintas.estado', ['id' => ':id']) }}`.replace(':id', id), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    },
                    body: JSON.stringify({
                        estado: nuevoEstado
                    }),
                });
                const data = await res.json();
                if (!res.ok) {
                    alertaRetro({
                        titulo: 'ERROR',
                        texto: `<p>${data.message?.toUpperCase() ?? 'NO SE PUDO CAMBIAR'}</p>`,
                        icono: 'error'
                    });
                    return;
                }
                const c = ecTodas.find(x => x.id_cinta === id);
                if (c) c.estado = nuevoEstado;
                ecFiltrar();
                ecCloseModal();
                alertaRetro({
                    titulo: 'ESTADO ACTUALIZADO',
                    texto: `<p>Cinta <strong>#${String(id).padStart(5,'0')}</strong> ahora está en estado <strong>${nuevoEstado.toUpperCase()}</strong>.</p>`,
                    icono: 'success'
                });
            } catch (err) {
                alertaRetro({
                    titulo: 'ERROR DE CONEXIÓN',
                    texto: '<p>No se pudo conectar con el servidor.</p>',
                    icono: 'error'
                });
            }
        }

        document.getElementById('modal-ec').addEventListener('click', function(e) {
            if (e.target === this) ecCloseModal();
        });

        // Cargar cintas cuando se abre el panel
        document.querySelector('.nav-item[onclick*="estado-cintas"]').addEventListener('click', () => {
            if (!ecTodas.length) ecCargar();
        });

        // ── PRÉSTAMOS EMPLEADO ────────────────────────────────────────
        let prTodos = [];
        let prPagina = 1;
        const PR_POR_PAGINA = 15;

        const PR_ESTADOS = {
            activo: {
                color: '#378ADD',
                bg: 'rgba(55,138,221,.08)',
                border: 'rgba(55,138,221,.25)',
                dot: '◈'
            },
            pendiente: {
                color: 'var(--amber)',
                bg: 'rgba(212,160,23,.08)',
                border: 'rgba(212,160,23,.25)',
                dot: '◎'
            },
            devuelto: {
                color: 'var(--green)',
                bg: 'rgba(76,175,106,.08)',
                border: 'rgba(76,175,106,.25)',
                dot: '◉'
            },
            cancelado: {
                color: 'var(--g)',
                bg: 'rgba(102,102,102,.08)',
                border: 'rgba(102,102,102,.2)',
                dot: '○'
            },
        };

        function prEstadoPill(estado) {
            const e = PR_ESTADOS[estado] ?? PR_ESTADOS.cancelado;
            return `<span style="display:inline-flex;align-items:center;gap:5px;font-family:var(--fm);font-size:8px;letter-spacing:1px;color:${e.color};background:${e.bg};border:1px solid ${e.border};padding:3px 10px;">${e.dot} ${estado.toUpperCase()}</span>`;
        }

        async function prCargar() {
            const search = document.getElementById('pr-search')?.value ?? '';
            const estado = document.getElementById('pr-estado')?.value ?? '';

            document.getElementById('pr-tbody').innerHTML = `
        <tr><td colspan="6" style="font-family:var(--fm);font-size:9px;color:var(--g);padding:24px;text-align:center;">
            <span class="spinner"></span>
        </td></tr>`;

            try {
                const params = new URLSearchParams({
                    search,
                    estado,
                    page: prPagina
                });
                const res = await fetch(`{{ route('empleado.prestamos.index') }}?${params}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    }
                });
                const data = await res.json();
                prTodos = data.prestamos ?? [];
                prRenderTabla(data);
            } catch (err) {
                console.error(err);
            }
        }

        function prFiltrar() {
            prPagina = 1;
            prCargar();
        }

        function prPaginar(delta) {
            prPagina = Math.max(1, prPagina + delta);
            prCargar();
        }

        function prRenderTabla(data) {
            const tbody = document.getElementById('pr-tbody');

            if (!prTodos.length) {
                tbody.innerHTML = `<tr><td colspan="6" style="font-family:var(--fm);font-size:9px;color:var(--g);padding:24px;text-align:center;letter-spacing:2px;">⌦ SIN PRÉSTAMOS</td></tr>`;
            } else {
                tbody.innerHTML = prTodos.map(p => {
                const vencido = p.vencido && p.estado === 'activo';
                const estadoKey = (p.estado ?? '').toLowerCase();
                const pill = PR_ESTADOS[estadoKey] ?? PR_ESTADOS.cancelado;

                // Color de fondo por estado
                const rowBg = {
                    activo:    'rgba(55,138,221,.04)',
                    pendiente: 'rgba(212,160,23,.04)',
                    devuelto:  'rgba(76,175,106,.04)',
                    cancelado: 'transparent',
                }[estadoKey] ?? 'transparent';

                const rowBgHover = {
                    activo:    'rgba(55,138,221,.09)',
                    pendiente: 'rgba(212,160,23,.09)',
                    devuelto:  'rgba(76,175,106,.09)',
                    cancelado: 'rgba(123,94,167,.05)',
                }[estadoKey] ?? 'rgba(123,94,167,.05)';

                const diasInfo = estadoKey === 'activo'
                    ? (vencido
                        ? `<span style="color:var(--red);font-family:var(--fm);font-size:8px;letter-spacing:1px;">⚠ VENCIDO ${Math.abs(p.dias_restantes)}D</span>`
                        : `<span style="color:var(--amber);font-family:var(--fm);font-size:8px;letter-spacing:1px;">◎ ${p.dias_restantes}D RESTANTES</span>`)
                    : '—';

                return `
                <tr style="border-bottom:1px solid rgba(255,255,255,.04);
                        border-left:3px solid ${pill.color};
                        background:${rowBg};
                        transition:background .15s;"
                    onmouseover="this.style.background='${rowBgHover}'"
                    onmouseout="this.style.background='${rowBg}'">

                    <td style="font-family:var(--fo);font-size:10px;letter-spacing:2px;
                            color:var(--v);padding:12px 12px;">
                        #${String(p.id_prestamo).padStart(5,'0')}
                    </td>

                    <td style="padding:12px 12px;">
                        <div style="font-family:var(--fm);font-size:10px;color:var(--w);">
                            ${(p.socio?.nombre ?? '—').toUpperCase()}
                        </div>
                        <div style="font-family:var(--fm);font-size:8px;color:var(--g);">
                            ${p.socio?.email ?? ''}
                        </div>
                    </td>

                    <td style="font-family:var(--fm);font-size:9px;color:var(--g);padding:12px 12px;">
                        ${p.cintas.map(c =>
                            `<div style="margin-bottom:2px;">
                                ${c.pelicula.toUpperCase()}
                                <span style="color:var(--v-dim);">·</span>
                                ${c.formato}
                            </div>`
                        ).join('')}
                    </td>

                    <td style="padding:12px 12px;">
                        <div style="font-family:var(--fm);font-size:9px;color:var(--g);">
                            ${new Date(p.fecha_limite).toLocaleDateString('es-CO')}
                        </div>
                        <div style="margin-top:3px;">${diasInfo}</div>
                    </td>

                    <td style="padding:12px 12px;">
                        <span style="display:inline-flex;align-items:center;gap:5px;
                                    font-family:var(--fm);font-size:8px;letter-spacing:1px;
                                    color:${pill.color};background:${pill.bg};
                                    border:1px solid ${pill.border};padding:4px 12px;">
                            ${pill.dot} ${estadoKey.toUpperCase()}
                        </span>
                    </td>

                    <td style="padding:12px 12px;text-align:center;">
                        <div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap;">
                            <button onclick="prAbrirModal(${p.id_prestamo})"
                                style="font-family:var(--fm);font-size:8px;letter-spacing:2px;
                                    color:var(--v);background:transparent;
                                    border:1px solid var(--v-dim);padding:5px 12px;
                                    cursor:pointer;transition:all .18s;"
                                onmouseover="this.style.background='var(--v-soft)'"
                                onmouseout="this.style.background='transparent'">
                                ◧ GESTIONAR
                            </button>
                            ${estadoKey === 'activo' ? `
                            <button onclick="prDevolver(${p.id_prestamo})"
                                style="font-family:var(--fm);font-size:8px;letter-spacing:2px;
                                    color:var(--green);background:transparent;
                                    border:1px solid rgba(76,175,106,.5);padding:5px 12px;
                                    cursor:pointer;transition:all .18s;"
                                onmouseover="this.style.background='rgba(76,175,106,.12)'"
                                onmouseout="this.style.background='transparent'">
                                ✓ DEVOLVER
                            </button>` : ''}
                        </div>
                    </td>
                </tr>`;
            }).join('');
            }

            document.getElementById('pr-count').textContent = `${data.total ?? prTodos.length} PRÉSTAMOS`;
            document.getElementById('pr-page-info').textContent = `PÁG ${data.pagina ?? 1} / ${data.paginas ?? 1}`;
            document.getElementById('pr-prev').style.opacity = prPagina <= 1 ? '.3' : '1';
            document.getElementById('pr-next').style.opacity = (data.pagina >= data.paginas) ? '.3' : '1';
        }

        function prAbrirModal(id) {
            const p = prTodos.find(x => x.id_prestamo === id);
            if (!p) return;

            document.getElementById('pr-modal-id').textContent = `#${String(p.id_prestamo).padStart(5,'0')} · ${p.socio?.nombre?.toUpperCase() ?? '—'}`;

            const multasHtml = p.multas.length ? `
        <div style="margin-top:16px;padding-top:16px;border-top:1px solid rgba(255,255,255,.04);">
            <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--amber);margin-bottom:10px;">⚠ MULTAS</div>
            ${p.multas.map(m => `
                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 12px;background:rgba(212,160,23,.06);border:1px solid rgba(212,160,23,.2);margin-bottom:6px;">
                    <div>
                        <div style="font-family:var(--fm);font-size:9px;color:var(--w);">
                            ${m.tipo_multa?.nombre ?? m.concepto ?? '—'}
                        </div>
                        <div style="font-family:var(--fm);font-size:8px;color:var(--g);">${m.pagada ? '✓ PAGADA' : '○ PENDIENTE'}</div>
                    </div>
                    <div style="font-family:var(--fo);font-size:13px;color:var(--amber);">$${Number(m.valor).toLocaleString('es-CO')}</div>
                    ${!m.pagada ? `
                        <button onclick="prRegistrarPago(${p.id_prestamo},'multa',${m.id_multa},${m.valor})"
                            style="font-family:var(--fm);font-size:8px;letter-spacing:1px;color:var(--amber);background:transparent;border:1px solid rgba(212,160,23,.4);padding:5px 10px;cursor:pointer;margin-left:10px;">
                            PAGAR
                        </button>
                    ` : ''}
                </div>
            `).join('')}
        </div>` : '';

            const accionesHtml = p.estado === 'activo' ? `
            <div style="display:flex;gap:8px;margin-top:20px;padding-top:16px;
                        border-top:1px solid rgba(255,255,255,.04);">
                <button onclick="prDevolver(${p.id_prestamo})"
                    style="font-family:var(--fo);font-size:9px;letter-spacing:2px;
                        background:var(--green);color:#060606;border:none;
                        padding:12px 20px;cursor:pointer;flex:1;transition:all .2s;
                        display:flex;align-items:center;justify-content:center;gap:8px;"
                    onmouseover="this.style.opacity='.85'"
                    onmouseout="this.style.opacity='1'">
                    ✓ &nbsp;REGISTRAR DEVOLUCIÓN
                </button>
                <button onclick="prCancelar(${p.id_prestamo})"
                    style="font-family:var(--fo);font-size:9px;letter-spacing:2px;
                        background:transparent;color:var(--red);
                        border:1px solid var(--red);padding:11px 16px;
                        cursor:pointer;transition:all .2s;"
                    onmouseover="this.style.background='rgba(192,57,43,.1)'"
                    onmouseout="this.style.background='transparent'">
                    ✕ CANCELAR
                </button>
            </div>
            <div style="margin-top:8px;">
                <button onclick="prRegistrarPago(${p.id_prestamo},'prestamo',null,${
                    p.monto_total ?? p.cintas.reduce((s,c) => s + Number(c.precio), 0)
                })"
                    style="font-family:var(--fm);font-size:8px;letter-spacing:2px;
                        color:var(--v);background:transparent;
                        border:1px solid var(--v-dim);padding:9px 16px;
                        cursor:pointer;width:100%;transition:all .18s;"
                    onmouseover="this.style.background='var(--v-soft)'"
                    onmouseout="this.style.background='transparent'">
                    REGISTRAR PAGO MANUAL
                </button>
                    </div>` : p.estado === 'pendiente' ? `
                    <div style="margin-top:20px;padding:14px 16px;
                    background:rgba(212,160,23,.06);
                    border:1px solid rgba(212,160,23,.2);
                    border-left:3px solid var(--amber);">
            <div style="font-family:var(--fm);font-size:9px;
                        letter-spacing:1px;color:var(--g);margin-bottom:12px;">
                Este préstamo está pendiente de pago PSE por el socio.
            </div>
            <button onclick="prCancelarAdmin(${p.id_prestamo})"
                style="font-family:var(--fo);font-size:9px;letter-spacing:2px;
                    background:transparent;color:var(--red);
                    border:1px solid var(--red);padding:10px 20px;
                    cursor:pointer;width:100%;transition:all .2s;"
                onmouseover="this.style.background='rgba(192,57,43,.1)'"
                onmouseout="this.style.background='transparent'">
                ✕ CANCELAR PRÉSTAMO
            </button>
        </div>` : '';

            document.getElementById('pr-modal-body').innerHTML = `
        <div style="background:rgba(123,94,167,.08);border:1px solid rgba(123,94,167,.2);padding:12px 16px;margin-bottom:16px;">
            <div style="font-family:var(--fh);font-size:16px;letter-spacing:3px;color:var(--w);">${p.socio?.nombre?.toUpperCase() ?? '—'}</div>
            <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-top:4px;">${p.socio?.email ?? ''}</div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1px;background:var(--g-dark);margin-bottom:16px;">
            ${[
                ['INICIO', new Date(p.fecha_inicio).toLocaleDateString('es-CO')],
                ['LÍMITE', new Date(p.fecha_limite).toLocaleDateString('es-CO')],
                ['ESTADO', p.estado.toUpperCase()],
            ].map(([l,v]) => `
                <div style="background:var(--ink3);padding:12px 14px;">
                    <div style="font-family:var(--fm);font-size:7px;color:var(--g);letter-spacing:2px;">${l}</div>
                    <div style="font-family:var(--fh);font-size:15px;color:var(--w);margin-top:3px;">${v}</div>
                </div>
            `).join('')}
        </div>

            <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;
                color:var(--g);margin-bottom:10px;">CINTAS</div>

            ${p.cintas.map(c => `
                <div style="display:flex;align-items:center;justify-content:space-between;
                            padding:10px 12px;background:var(--ink3);
                            border:1px solid var(--g-dark);margin-bottom:4px;">
                    <div style="flex:1;">
                        <div style="font-family:var(--fm);font-size:9px;
                                    color:var(--w);margin-bottom:3px;">
                            ${c.pelicula.toUpperCase()}
                        </div>
                        <div style="display:flex;gap:8px;align-items:center;">
                            <span style="font-family:var(--fm);font-size:8px;color:var(--g);">
                                ${c.formato}
                            </span>
                            <span style="font-family:var(--fo);font-size:8px;color:var(--v-dim);">
                                #${String(c.id_cinta).padStart(5,'0')}
                            </span>
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-family:var(--fo);font-size:13px;color:var(--v);">
                            $${Number(c.precio).toLocaleString('es-CO')}
                        </div>
                        <div style="font-family:var(--fm);font-size:7px;
                                    letter-spacing:1px;color:var(--g);margin-top:2px;">
                            PRECIO CINTA
                        </div>
                    </div>
                </div>
            `).join('')}

            <div style="display:flex;align-items:center;justify-content:space-between;
                        padding:12px 16px;margin-top:2px;margin-bottom:16px;
                        background:rgba(123,94,167,.08);border:1px solid rgba(123,94,167,.2);">
                <div>
                    <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);">
                        TOTAL PRÉSTAMO
                    </div>
                    <div style="font-family:var(--fm);font-size:7px;color:var(--g-dark);margin-top:2px;">
                        ${p.cintas.length} CINTA${p.cintas.length !== 1 ? 'S' : ''}
                        · ${p.dias_totales ?? '?'} DÍA${(p.dias_totales ?? 1) !== 1 ? 'S' : ''}
                    </div>
                </div>
                <div style="font-family:var(--fo);font-size:22px;letter-spacing:2px;color:var(--v);">
                    $${Number(
                        p.monto_total ?? p.cintas.reduce((s, c) => s + Number(c.precio), 0)
                    ).toLocaleString('es-CO')}
                </div>
            </div>

        ${multasHtml}
        ${accionesHtml}
    `;

            document.getElementById('modal-pr').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function prCloseModal() {
            document.getElementById('modal-pr').style.display = 'none';
            document.body.style.overflow = '';
        }
        async function prCancelarAdmin(id) {
            alertaConfirmar({
                titulo: 'CANCELAR PRÉSTAMO',
                texto: '<p>¿Confirmas la cancelación? Las cintas volverán a estar disponibles.</p>',
                icono: 'warning',
                boton: 'SÍ, CANCELAR',
                cancelar: true,
            }).then(async result => {
                if (!result.isConfirmed) return;
                try {
                    const res = await fetch(
                        `{{ url('empleado/prestamos') }}/${id}/cancelar-admin`,
                        {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': CSRF,
                            },
                        }
                    );
                    const data = await res.json();
                    if (!res.ok) {
                        alertaRetro({
                            titulo: 'ERROR',
                            texto: `<p>${data.message?.toUpperCase() ?? 'NO SE PUDO CANCELAR'}</p>`,
                            icono: 'error'
                        });
                        return;
                    }
                    prCloseModal();
                    prCargar();
                    alertaRetro({
                        titulo: 'CANCELADO',
                        texto: '<p>Préstamo cancelado correctamente.</p>',
                        icono: 'success'
                    });
                } catch (err) {
                    alertaRetro({
                        titulo: 'ERROR DE CONEXIÓN',
                        texto: '<p>No se pudo conectar con el servidor.</p>',
                        icono: 'error'
                    });
                }
            });
        }

        function strtolowerEstado(e) { return (e ?? '').toLowerCase(); }
        function prDevolver(id) {
            _devIdPrestamo  = id;
            _devMultasExtra = [];
            _renderModalDevolucion();
        }

        async function prCancelar(id) {
            alertaConfirmar({
                titulo: 'CANCELAR PRÉSTAMO',
                texto: '<p>¿Confirmas la cancelación? Las cintas volverán a estar disponibles.</p>',
                icono: 'warning',
                boton: 'SÍ, CANCELAR',
                cancelar: true,
            }).then(async result => {
                if (!result.isConfirmed) return;
                const res = await fetch(`{{ route('empleado.prestamos.cancelar', ['id' => ':id']) }}`.replace(':id', id), {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    },
                });
                prCloseModal();
                prCargar();
                alertaRetro({
                    titulo: 'CANCELADO',
                    texto: '<p>Préstamo cancelado.</p>',
                    icono: 'success'
                });
            });
        }

        function prRegistrarPago(idPrestamo, tipo, idMulta, montoSugerido) {
            const metodos = ['EFECTIVO', 'TARJETA', 'TRANSFERENCIA'];
            const metodoHtml = metodos.map(m =>
                `<option value="${m}">${m}</option>`
            ).join('');

            const html = `
    <div id="modal-pago" style="position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:30000;display:flex;align-items:center;justify-content:center;padding:20px;">
        <div style="background:var(--ink2);border:1px solid rgba(123,94,167,.35);width:100%;max-width:380px;">
            <div style="padding:16px 24px;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;justify-content:space-between;">
                <span style="font-family:var(--fh);font-size:16px;letter-spacing:4px;color:var(--w);">REGISTRAR PAGO</span>
                <span onclick="document.getElementById('modal-pago').remove()" style="cursor:pointer;color:var(--g);font-size:18px;">✕</span>
            </div>
            <div style="padding:24px;">
                <div class="form-group" style="margin-bottom:14px;">
                    <label>MONTO</label>
                    <input type="number" id="pago-monto" value="${montoSugerido}" min="0" step="0.01">
                </div>
                <div class="form-group" style="margin-bottom:20px;">
                    <label>MÉTODO DE PAGO</label>
                    <select id="pago-metodo">${metodoHtml}</select>
                </div>
                <button onclick="enviarPago(${idPrestamo},'${tipo}',${idMulta ?? 'null'})"
                    style="font-family:var(--fo);font-size:9px;letter-spacing:2px;background:var(--v);color:var(--w);border:none;padding:11px 24px;cursor:pointer;width:100%;">
                    ✓ CONFIRMAR PAGO
                </button>
            </div>
        </div>
    </div>`;

            document.body.insertAdjacentHTML('beforeend', html);
        }

        async function enviarPago(idPrestamo, tipo, idMulta) {
            const monto = document.getElementById('pago-monto').value;
            const metodo = document.getElementById('pago-metodo').value;

            const res = await fetch(`{{ route('empleado.prestamos.pago', ['id' => ':id']) }}`.replace(':id', idPrestamo), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF
                },
                body: JSON.stringify({
                    monto,
                    metodo_pago: metodo,
                    tipo,
                    id_multa: idMulta
                }),
            });

            document.getElementById('modal-pago')?.remove();
            prCloseModal();
            prCargar();
            alertaRetro({
                titulo: 'PAGO REGISTRADO',
                texto: `<p>Pago de $${Number(monto).toLocaleString('es-CO')} registrado.</p>`,
                icono: 'success'
            });
        }

        // Cargar préstamos cuando se abre el panel
        document.querySelector('.nav-item[onclick*="prestamos"]')?.addEventListener('click', () => prCargar());

        // También actualizar switchView para cargar préstamos
        const _origSwitchView = window.switchView;
        window.switchView = function(id, btn) {
            _origSwitchView(id, btn);
            if (id === 'prestamos') prCargar();
            if (id === 'estado-cintas' && !ecTodas.length) ecCargar();
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/alertas.js') }}"></script>
</body>

</html>