<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIXELVHS — ADMIN</title>
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
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: repeating-linear-gradient(0deg, transparent, transparent 2px,
                    rgba(0, 0, 0, 0.08) 2px, rgba(0, 0, 0, 0.08) 4px);
            pointer-events: none;
            z-index: 9999;
        }

        /* ── HEADER ── */
        header {
            position: sticky;
            top: 0;
            z-index: 200;
            height: 62px;
            background: rgba(6, 6, 6, 0.97);
            border-bottom: 1px solid rgba(123, 94, 167, 0.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 52px;
            backdrop-filter: blur(12px);
            flex-shrink: 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .logo-mark {
            width: 32px;
            height: 32px;
            border: 1.5px solid var(--v);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .logo-mark::before {
            content: '▶';
            color: var(--v);
            font-size: 11px;
            position: relative;
            z-index: 1;
        }

        .logo-mark::after {
            content: '';
            position: absolute;
            top: 0;
            left: -130%;
            width: 55%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(123, 94, 167, 0.3), transparent);
            animation: sheen 4s linear infinite;
        }

        @keyframes sheen {
            to {
                left: 230%;
            }
        }

        .logo-words h1 {
            font-family: var(--fo);
            font-size: 14px;
            font-weight: 900;
            letter-spacing: 3.5px;
            color: var(--w);
            line-height: 1;
        }

        .logo-words h1 em {
            font-style: normal;
            color: var(--v);
        }

        .logo-words small {
            font-family: var(--fm);
            font-size: 8px;
            color: var(--g);
            letter-spacing: 2px;
            display: block;
            margin-top: 2px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .admin-badge {
            font-family: var(--fm);
            font-size: 8px;
            letter-spacing: 3px;
            color: var(--v);
            border: 1px solid var(--v-dim);
            padding: 3px 10px;
            background: rgba(123, 94, 167, 0.08);
        }

        .admin-user {
            font-family: var(--fm);
            font-size: 9px;
            color: var(--g);
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .admin-user::before {
            content: '◈';
            color: var(--v-dim);
            font-size: 10px;
        }

        /* ── LAYOUT ── */
        .shell {
            display: flex;
            flex: 1;
            min-height: 0;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 220px;
            flex-shrink: 0;
            background: var(--ink2);
            border-right: 1px solid rgba(123, 94, 167, 0.12);
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 62px;
            height: calc(100vh - 62px);
            overflow-y: auto;
            overflow-x: hidden;
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

        /* ── MAIN CONTENT ── */
        .main {
            flex: 1;
            overflow-y: auto;
            min-width: 0;
            padding: 36px 42px 60px;
        }

        /* ── VIEWS ── */
        .view {
            display: none;
        }

        .view.active {
            display: block;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 32px;
            padding-bottom: 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
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

        .page-actions {
            display: flex;
            gap: 10px;
        }

        /* ── STAT CARDS ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 5px;
            margin-bottom: 36px;
        }

        .stat-card {
            background: var(--ink3);
            border: 1px solid rgba(255, 255, 255, 0.04);
            padding: 20px 22px;
            position: relative;
            overflow: hidden;
            transition: border-color .2s;
        }

        .stat-card:hover {
            border-color: rgba(123, 94, 167, 0.25);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 2px;
            height: 100%;
            background: var(--v-dim);
        }

        .stat-card.green::before {
            background: var(--green);
        }

        .stat-card.red::before {
            background: var(--red);
        }

        .stat-card.amber::before {
            background: var(--amber);
        }

        .stat-card .sc-label {
            font-family: var(--fm);
            font-size: 8px;
            letter-spacing: 2px;
            color: var(--g);
            margin-bottom: 8px;
        }

        .stat-card .sc-value {
            font-family: var(--fh);
            font-size: 36px;
            letter-spacing: 2px;
            color: var(--w);
            line-height: 1;
        }

        .stat-card .sc-sub {
            font-family: var(--fm);
            font-size: 8px;
            color: var(--g);
            margin-top: 5px;
            letter-spacing: 1px;
        }

        /* ── SECTION TITLE ── */
        .section-title {
            font-family: var(--fm);
            font-size: 9px;
            letter-spacing: 3px;
            color: var(--v-dim);
            margin-bottom: 14px;
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

        /* ── FORM CARD ── */
        .form-card {
            background: var(--ink2);
            border: 1px solid rgba(255, 255, 255, 0.05);
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
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
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
        .form-group select {
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
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--v);
            box-shadow: 0 0 0 1px rgba(123, 94, 167, 0.2);
        }

        .form-group input::placeholder {
            color: #2a2a2a;
        }

        .form-group select option {
            background: var(--ink2);
        }

        /* error state */
        .form-group input.input-error,
        .form-group select.input-error {
            border-color: var(--red) !important;
        }

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

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
        }

        /* ── BUTTONS ── */
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

        .btn-edit {
            background: transparent;
            color: var(--g);
            border: 1px solid var(--g-dark);
        }

        .btn-edit:hover {
            border-color: var(--amber);
            color: var(--amber);
        }

        .btn-del {
            background: transparent;
            color: var(--g);
            border: 1px solid var(--g-dark);
        }

        .btn-del:hover {
            border-color: var(--red);
            color: var(--red);
        }

        .btn-success {
            background: transparent;
            color: var(--g);
            border: 1px solid var(--g-dark);
            font-family: var(--fo);
            font-size: 8px;
            letter-spacing: 2px;
            padding: 3px 9px;
            cursor: pointer;
            transition: all .18s;
        }

        .btn-success:hover {
            border-color: var(--green);
            color: var(--green);
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

        /* ── TABLE ── */
        .table-wrap {
            background: var(--ink2);
            border: 1px solid rgba(255, 255, 255, 0.05);
            overflow: hidden;
        }

        .table-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .table-topbar h3 {
            font-family: var(--fh);
            font-size: 15px;
            letter-spacing: 4px;
            color: var(--w);
        }

        .table-count {
            font-family: var(--fm);
            font-size: 9px;
            color: var(--g);
            letter-spacing: 1px;
        }

        .t-filters {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .t-search {
            display: flex;
            align-items: center;
            gap: 0;
        }

        .t-search input {
            background: var(--ink3);
            border: 1px solid var(--g-dark);
            border-right: none;
            color: var(--w);
            font-family: var(--fm);
            font-size: 10px;
            padding: 6px 12px;
            outline: none;
            letter-spacing: 1px;
            width: 180px;
            transition: border-color .18s;
        }

        .t-search input:focus {
            border-color: var(--v);
        }

        .t-search input::placeholder {
            color: #2a2a2a;
        }

        .t-search-ico {
            background: var(--v-dim);
            border: none;
            padding: 7px 12px;
            color: var(--w);
            cursor: pointer;
            font-size: 11px;
            line-height: 1;
        }

        .t-filter-select {
            background: var(--ink3);
            border: 1px solid var(--g-dark);
            color: var(--g);
            font-family: var(--fm);
            font-size: 9px;
            letter-spacing: 1px;
            padding: 6px 10px;
            outline: none;
            cursor: pointer;
            transition: all .18s;
            appearance: none;
        }

        .t-filter-select:focus {
            border-color: var(--v);
            color: var(--w);
        }

        .t-filter-select option {
            background: var(--ink2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: var(--ink3);
            border-bottom: 1px solid rgba(123, 94, 167, 0.15);
        }

        th {
            font-family: var(--fm);
            font-size: 8px;
            letter-spacing: 2px;
            color: var(--g);
            padding: 12px 16px;
            text-align: left;
            font-weight: normal;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            transition: background .15s;
        }

        tbody tr:hover {
            background: rgba(123, 94, 167, 0.06);
        }

        td {
            font-family: var(--fu);
            font-size: 13px;
            font-weight: 400;
            color: #b0b0b0;
            padding: 11px 16px;
            white-space: nowrap;
        }

        td.name-cell {
            color: var(--w);
            font-weight: 600;
        }

        td.id-cell {
            font-family: var(--fo);
            font-size: 9px;
            color: var(--v-dim);
            letter-spacing: 1px;
        }

        .status-pill {
            font-family: var(--fm);
            font-size: 8px;
            letter-spacing: 2px;
            padding: 3px 9px;
            border: 1px solid;
        }

        .status-pill.activo {
            color: var(--green);
            border-color: rgba(76, 175, 106, 0.3);
            background: rgba(76, 175, 106, 0.07);
        }

        .status-pill.inactivo {
            color: var(--g);
            border-color: var(--g-dark);
            background: transparent;
        }

        .status-pill.suspendido {
            color: var(--red);
            border-color: rgba(192, 57, 43, 0.3);
            background: rgba(192, 57, 43, 0.07);
        }

        .rol-pill {
            font-family: var(--fm);
            font-size: 8px;
            letter-spacing: 2px;
            padding: 3px 9px;
        }

        .rol-pill.admin {
            color: var(--v);
        }

        .rol-pill.empleado {
            color: var(--amber);
        }

        .rol-pill.socio {
            color: var(--g);
        }

        .row-actions {
            display: flex;
            gap: 6px;
        }

        .ra-btn {
            background: transparent;
            border: 1px solid var(--g-dark);
            color: var(--g);
            font-family: var(--fm);
            font-size: 8px;
            letter-spacing: 1px;
            padding: 3px 9px;
            cursor: pointer;
            transition: all .15s;
        }

        .ra-btn:hover {
            border-color: var(--v);
            color: var(--w);
        }

        .ra-btn.del:hover {
            border-color: var(--red);
            color: var(--red);
        }

        .ra-btn.ok:hover {
            border-color: var(--green);
            color: var(--green);
        }

        /* ── NO RESULTS ── */
        .no-results td {
            text-align: center;
            color: var(--g);
            font-family: var(--fm);
            font-size: 10px;
            letter-spacing: 2px;
            padding: 28px;
        }

        /* ── DASHBOARD ── */
        .recent-list {
            margin-top: 28px;
        }

        .recent-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 11px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .recent-row:last-child {
            border-bottom: none;
        }

        .recent-icon {
            width: 34px;
            height: 34px;
            background: var(--ink3);
            border: 1px solid rgba(123, 94, 167, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            flex-shrink: 0;
        }

        .recent-info {
            flex: 1;
        }

        .recent-info .ri-title {
            font-family: var(--fu);
            font-size: 13px;
            font-weight: 600;
            color: var(--w);
        }

        .recent-info .ri-sub {
            font-family: var(--fm);
            font-size: 8px;
            color: var(--g);
            letter-spacing: 1px;
            margin-top: 2px;
        }

        .recent-time {
            font-family: var(--fm);
            font-size: 8px;
            color: var(--v-dim);
            letter-spacing: 1px;
        }

        /* ── TOAST ── */
        .toast {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 5000;
            background: var(--ink2);
            border: 1px solid var(--v-dim);
            border-left: 3px solid var(--v);
            padding: 12px 20px;
            font-family: var(--fm);
            font-size: 10px;
            letter-spacing: 1px;
            color: var(--w);
            opacity: 0;
            transform: translateY(10px);
            transition: all .3s;
            pointer-events: none;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .toast.error {
            border-left-color: var(--red);
            border-color: rgba(192, 57, 43, 0.4);
        }

        .toast.success {
            border-left-color: var(--green);
            border-color: rgba(76, 175, 106, 0.3);
        }

        /* ── SPINNER ── */
        .spinner {
            width: 12px;
            height: 12px;
            border: 2px solid rgba(255, 255, 255, 0.2);
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

        /* ── RESPONSIVE ── */
        @media(max-width:900px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .form-grid {
                grid-template-columns: 1fr 1fr;
            }

            header,
            .main {
                padding-left: 20px;
                padding-right: 20px;
            }

            .sidebar {
                width: 180px;
            }
        }

        @media(max-width:640px) {
            .sidebar {
                display: none;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .stats-row {
                grid-template-columns: 1fr 1fr;
            }
        }

        .pr-pill {
            font-family: var(--fm);
            font-size: 8px;
            letter-spacing: 2px;
            padding: 3px 9px;
            border: 1px solid;
            white-space: nowrap;
        }

        .pr-pill.activo {
            color: var(--green);
            border-color: rgba(76, 175, 106, .3);
            background: rgba(76, 175, 106, .07);
        }

        .pr-pill.terminado {
            color: var(--g);
            border-color: var(--g-dark);
            background: transparent;
        }

        .pr-pill.cancelado {
            color: var(--red);
            border-color: rgba(192, 57, 43, .3);
            background: rgba(192, 57, 43, .07);
        }

        .pr-pill.pendiente {
            color: var(--amber);
            border-color: rgba(212, 160, 23, .3);
            background: rgba(212, 160, 23, .07);
        }

        /* ── MODAL DETALLE ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .85);
            z-index: 10000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.open {
            display: flex;
        }

        /* ── REPORTES ── */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 5px;
            margin-bottom: 32px;
        }

        .kpi-card {
            background: var(--ink3);
            border: 1px solid rgba(255, 255, 255, .04);
            border-left: 2px solid var(--v-dim);
            padding: 18px 20px;
            position: relative;
            overflow: hidden;
            transition: border-color .2s;
        }

        .kpi-card:hover {
            border-color: rgba(123, 94, 167, .3);
        }

        .kpi-card.kv {
            border-left-color: var(--v);
        }

        .kpi-card.kg {
            border-left-color: var(--green);
        }

        .kpi-card.kr {
            border-left-color: var(--red);
        }

        .kpi-card.ka {
            border-left-color: var(--amber);
        }

        .kpi-label {
            font-family: var(--fm);
            font-size: 8px;
            letter-spacing: 2px;
            color: var(--g);
            margin-bottom: 8px;
        }

        .kpi-value {
            font-family: var(--fh);
            font-size: 32px;
            letter-spacing: 2px;
            color: var(--w);
            line-height: 1;
        }

        .kpi-sub {
            font-family: var(--fm);
            font-size: 8px;
            color: var(--g);
            margin-top: 5px;
            letter-spacing: 1px;
        }

        .rep-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 28px;
        }

        .rep-card {
            background: var(--ink2);
            border: 1px solid rgba(255, 255, 255, .05);
            padding: 22px 26px;
        }

        .rep-card h4 {
            font-family: var(--fm);
            font-size: 9px;
            letter-spacing: 3px;
            color: var(--v-dim);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .rep-card h4::before {
            content: '';
            width: 14px;
            height: 1px;
            background: var(--v-dim);
        }

        /* Bar charts */
        .bar-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 11px;
        }

        .bar-label {
            font-family: var(--fm);
            font-size: 9px;
            color: var(--g);
            letter-spacing: 1px;
            width: 140px;
            flex-shrink: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .bar-track {
            flex: 1;
            height: 6px;
            background: rgba(255, 255, 255, .04);
            position: relative;
        }

        .bar-fill {
            height: 100%;
            background: var(--v-dim);
            transition: width .6s cubic-bezier(.4, 0, .2, 1);
            position: relative;
        }

        .bar-fill::after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: var(--v);
        }

        .bar-fill.green-fill {
            background: rgba(76, 175, 106, .4);
        }

        .bar-fill.green-fill::after {
            background: var(--green);
        }

        .bar-val {
            font-family: var(--fo);
            font-size: 9px;
            color: var(--v);
            letter-spacing: 1px;
            width: 36px;
            text-align: right;
            flex-shrink: 0;
        }

        /* Donut chart */
        .donut-wrap {
            display: flex;
            align-items: center;
            gap: 28px;
            justify-content: center;
            padding: 10px 0;
        }

        .donut-legend {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .donut-leg-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: var(--fm);
            font-size: 9px;
            color: var(--g);
            letter-spacing: 1px;
        }

        .donut-leg-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* Tabla top socios */
        .mini-table {
            width: 100%;
            border-collapse: collapse;
        }

        .mini-table th {
            font-family: var(--fm);
            font-size: 8px;
            letter-spacing: 2px;
            color: var(--g);
            padding: 8px 10px;
            text-align: left;
            font-weight: 400;
            border-bottom: 1px solid rgba(255, 255, 255, .05);
        }

        .mini-table td {
            font-family: var(--fu);
            font-size: 12px;
            color: #b0b0b0;
            padding: 9px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, .03);
        }

        .mini-table td.rank {
            font-family: var(--fo);
            font-size: 9px;
            color: var(--v-dim);
            letter-spacing: 1px;
        }

        .mini-table td.hi {
            color: var(--w);
            font-weight: 600;
        }

        /* Export btn */
        .btn-export {
            background: transparent;
            color: var(--v);
            border: 1px solid var(--v-dim);
            font-family: var(--fo);
            font-size: 8px;
            letter-spacing: 2px;
            padding: 9px 20px;
            cursor: pointer;
            transition: all .2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-export:hover {
            background: var(--v-soft);
            box-shadow: 0 0 14px var(--v-glow);
        }

        @media(max-width:900px) {
            .kpi-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .rep-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

</head>

<body>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            alertaRetro({
                titulo: 'INFORMACIÓN CUENTA',
                texto: `<p>{{ session('success') }}</p>`,
                icono: 'success'
            });
        });
    </script>
    @endif

    <!-- ══ HEADER ══ -->
    <header>
        <div class="logo">
            <div class="logo-mark"></div>
            <div class="logo-words">
                <h1>PIXEL<em>VHS</em></h1>
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
                <span class="nav-badge" id="nb-peliculas">—</span>
            </div>
            <div class="nav-item" onclick="navigate('usuarios', this)">
                <span class="nav-icon">⊕</span> USUARIOS
                <span class="nav-badge" id="nb-usuarios">{{ str_pad(count($usuarios), 2, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="nav-item" onclick="navigate('rentas', this)">
                <span class="nav-icon">⬡</span> RENTAS
                <span class="nav-badge" id="nb-rentas">—</span>
            </div>
            <div class="nav-item" onclick="navigate('reportes', this)">
                <span class="nav-icon">▣</span> REPORTES
            </div>
            <div class="nav-item" onclick="navigate('perfil', this)">
                <span class="nav-icon">◈</span> MI PERFIL
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
                            <input type="email" id="u-email" name="email" placeholder="correo@pixelvhs.com">
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
                            <label>CONFIRMAR PASSWORD</label>
                            <input type="password" id="u-password-confirm" name="password_confirmation" placeholder="••••••••">
                            <span class="field-error" id="err-password-confirm"></span>
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
                            <span class="table-count" id="userCount">{{ str_pad(count($usuarios), 2, '0', STR_PAD_LEFT) }} USUARIOS</span>
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
                            @forelse ($usuarios as $usuario)
                            <tr
                                data-id="{{ $usuario->id_usuario }}"
                                data-nombre="{{ strtolower($usuario->nombre) }}"
                                data-email="{{ strtolower($usuario->email) }}"
                                data-usuario="{{ strtolower($usuario->usuario) }}"
                                data-rol="{{ $usuario->rol }}"
                                data-estado="{{ $usuario->estado }}">
                                <td class="id-cell">{{ str_pad($usuario->id_usuario, 2, '0', STR_PAD_LEFT) }}</td>
                                <td class="name-cell">{{ $usuario->nombre }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->usuario }}</td>
                                <td>{{ $usuario->telefono }}</td>
                                <td>
                                    <span class="rol-pill {{ $usuario->rol }}">
                                        @switch($usuario->rol)
                                        @case('admin')
                                        ADMINISTRADOR
                                        @break
                                        @case('empleado')
                                        EMPLEADO
                                        @break
                                        @default
                                        SOCIO
                                        @endswitch
                                    </span>
                                </td>
                                <td>
                                    <span class="status-pill {{ $usuario->estado === 'Activo' ? 'activo' : 'inactivo' }}">
                                        {{ $usuario->estado === 'Activo' ? '◉ ACTIVO' : '⊘ INACTIVO' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="row-actions">
                                        @if(auth()->user()->id_usuario != $usuario->id_usuario )
                                        @if($usuario->rol !== 'socio')
                                        <button class="ra-btn del" onclick="deleteUser({{ $usuario->id_usuario }}, this)">✕ ELIMINAR</button>
                                        <button class="ra-btn edit" onclick="editUser({{ $usuario->id_usuario }}, this)">🖊 EDITAR</button>
                                        @endif
                                        @if($usuario->estado === 'Activo')
                                        <button class="ra-btn del" onclick="toggleUser({{ $usuario->id_usuario }}, this)">⊘ DESACTIVAR</button>
                                        @else
                                        <button class="ra-btn ok" onclick="toggleUser({{ $usuario->id_usuario }}, this)">◉ ACTIVAR</button>
                                        @endif
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
            <div class="view" id="view-peliculas">
                <div class="page-header">
                    <div>
                        <h2>PELÍCULAS</h2>
                        <small>// CATÁLOGO VHS · <span id="pel-count">—</span> TÍTULOS</small>
                    </div>
                    <div class="page-actions">
                        <button class="btn-export" onclick="peliculasCargar()">↺ ACTUALIZAR</button>
                    </div>
                </div>

                {{-- Filtros --}}
                <div class="form-card" style="margin-bottom:20px;">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>BUSCAR TÍTULO</label>
                            <input type="text" id="pel-search" placeholder="EJ: BLADE RUNNER..."
                                oninput="pelFiltrar()">
                        </div>
                        <div class="form-group">
                            <label>GÉNERO</label>
                            <select id="pel-genero" onchange="pelFiltrar()">
                                <option value="">— TODOS —</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>VISTA</label>
                            <div style="display:flex;gap:6px;margin-top:2px;">
                                <button id="btn-grid-view" class="btn-clear"
                                    style="border-color:var(--v);color:var(--v);"
                                    onclick="pelSetVista('grid')">⊞ CUADRÍCULA</button>
                                <button id="btn-list-view" class="btn-clear"
                                    onclick="pelSetVista('lista')">☰ LISTA</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Vista cuadrícula --}}
                <div id="pel-grid" style="
        display:grid;
        grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
        gap:12px;
        margin-bottom:32px;">
                    {{-- Cards generadas por JS --}}
                    <div style="grid-column:1/-1;text-align:center;padding:40px;
            font-family:var(--fm);font-size:9px;color:var(--g);">
                        <span class="spinner"></span> &nbsp;CARGANDO...
                    </div>
                </div>

                {{-- Vista lista (oculta por defecto) --}}
                <div id="pel-list" style="display:none;">
                    <div class="table-wrap">
                        <div class="table-topbar">
                            <h3>CATÁLOGO COMPLETO</h3>
                            <span class="table-count" id="pel-list-count">— TÍTULOS</span>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>PORTADA</th>
                                    <th>TÍTULO</th>
                                    <th>AÑO</th>
                                    <th>GÉNERO</th>
                                    <th>DIRECTOR</th>
                                    <th>DURACIÓN</th>
                                </tr>
                            </thead>
                            <tbody id="pel-tbody"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Modal detalle película --}}
            <div class="modal-overlay" id="modal-pelicula">
                <div style="background:var(--ink2);border:1px solid rgba(123,94,167,.35);
            width:100%;max-width:640px;max-height:90vh;overflow-y:auto;">
                    <div style="padding:16px 22px;border-bottom:1px solid rgba(255,255,255,.05);
                display:flex;align-items:center;justify-content:space-between;
                position:sticky;top:0;background:var(--ink2);z-index:10;">
                        <span style="font-family:var(--fh);font-size:18px;letter-spacing:5px;
                color:var(--w);">FICHA TÉCNICA</span>
                        <span onclick="pelCloseModal()" style="cursor:pointer;color:var(--g);font-size:20px;"
                            onmouseover="this.style.color='var(--red)'"
                            onmouseout="this.style.color='var(--g)'">✕</span>
                    </div>
                    <div id="pel-modal-body" style="padding:24px;"></div>
                </div>
            </div>
            <!-- ── RENTAS ── -->
            <div class="view" id="view-rentas">
                <div class="page-header">
                    <div>
                        <h2>RENTAS</h2>
                        <small>// HISTORIAL COMPLETO DE PRÉSTAMOS · SOLO LECTURA</small>
                    </div>
                    <div class="page-actions">
                        <button class="btn-export" onclick="rentasCargar()">↺ ACTUALIZAR</button>
                    </div>
                </div>

                {{-- Filtros --}}
                <div class="form-card" style="margin-bottom:20px;">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>BUSCAR SOCIO</label>
                            <input type="text" id="rn-search"
                                placeholder="NOMBRE O EMAIL..."
                                oninput="rentasFiltrar()">
                        </div>
                        <div class="form-group">
                            <label>ESTADO</label>
                            <select id="rn-estado" onchange="rentasFiltrar()">
                                <option value="">— TODOS —</option>
                                <option value="Activo">ACTIVO</option>
                                <option value="Terminado">TERMINADO</option>
                                <option value="Cancelado">CANCELADO</option>
                                <option value="Pendiente">PENDIENTE</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>DESDE</label>
                            <input type="date" id="rn-desde" onchange="rentasFiltrar()"
                                style="color-scheme:dark;">
                        </div>
                        <div class="form-group">
                            <label>HASTA</label>
                            <input type="date" id="rn-hasta" onchange="rentasFiltrar()"
                                style="color-scheme:dark;">
                        </div>
                    </div>
                </div>

                {{-- Tabla --}}
                <div class="table-wrap">
                    <div class="table-topbar">
                        <h3>PRÉSTAMOS REGISTRADOS</h3>
                        <div style="display:flex;align-items:center;gap:16px;">
                            <span class="table-count" id="rn-count">— REGISTROS</span>
                        </div>
                    </div>
                    <div style="overflow-x:auto;">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SOCIO</th>
                                    <th>EMAIL</th>
                                    <th>CINTAS</th>
                                    <th>INICIO</th>
                                    <th>VENCE</th>
                                    <th>DEVUELTO</th>
                                    <th>CARGO DIARIO</th>
                                    <th>ESTADO</th>
                                    <th>DETALLE</th>
                                </tr>
                            </thead>
                            <tbody id="rn-tbody">
                                <tr>
                                    <td colspan="10" style="font-family:var(--fm);font-size:9px;
                                    color:var(--g);padding:28px;text-align:center;">
                                        <span class="spinner"></span> &nbsp;CARGANDO...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- Paginación --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;
                            padding:14px 20px;border-top:1px solid rgba(255,255,255,.04);">
                        <span id="rn-page-label" style="font-family:var(--fm);font-size:8px;
                        color:var(--g);letter-spacing:1px;"></span>
                        <div style="display:flex;gap:8px;">
                            <button class="btn-clear" id="rn-prev" onclick="rentasPaginar(-1)">← ANT</button>
                            <span id="rn-page-info" style="font-family:var(--fm);font-size:9px;
                            color:var(--g);padding:9px 14px;letter-spacing:1px;"></span>
                            <button class="btn-clear" id="rn-next" onclick="rentasPaginar(1)">SIG →</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal detalle renta --}}
            <div class="modal-overlay" id="modal-renta">
                <div style="background:var(--ink2);border:1px solid rgba(123,94,167,.35);
                        width:100%;max-width:580px;max-height:90vh;overflow-y:auto;">
                    <div style="padding:16px 22px;border-bottom:1px solid rgba(255,255,255,.05);
                            display:flex;align-items:center;justify-content:space-between;
                            position:sticky;top:0;background:var(--ink2);z-index:10;">
                        <div>
                            <span style="font-family:var(--fh);font-size:18px;letter-spacing:5px;
                            color:var(--w);">DETALLE PRÉSTAMO</span>
                            <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;
                            color:var(--g);margin-top:3px;">// <span id="rn-modal-id"></span></div>
                        </div>
                        <span onclick="rnCloseModal()" style="cursor:pointer;color:var(--g);font-size:20px;"
                            onmouseover="this.style.color='var(--red)'"
                            onmouseout="this.style.color='var(--g)'">✕</span>
                    </div>
                    <div style="padding:24px;" id="rn-modal-body"></div>
                </div>
            </div>
            <div class="view" id="view-reportes">
                <div class="page-header">
                    <div>
                        <h2>REPORTES</h2>
                        <small>// ESTADÍSTICAS Y ANÁLISIS DEL SISTEMA</small>
                    </div>
                    <div class="page-actions">
                        <button class="btn-export" id="btn-pdf" onclick="exportarPDF()">
                            ↓ &nbsp;EXPORTAR PDF
                        </button>
                        <button class="btn-clear" onclick="reportesCargar()">↺ ACTUALIZAR</button>
                    </div>
                    <div class="form-card" style="margin-bottom:24px;">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>DESDE</label>
                                <input type="date" id="rep-desde" onchange="reportesCargar()"
                                    style="color-scheme:dark;">
                            </div>
                            <div class="form-group">
                                <label>HASTA</label>
                                <input type="date" id="rep-hasta" onchange="reportesCargar()"
                                    style="color-scheme:dark;">
                            </div>
                            <div class="form-group" style="justify-content:flex-end;">
                                <label>&nbsp;</label>
                                <button class="btn-clear" onclick="
                                    document.getElementById('rep-desde').value='';
                                    document.getElementById('rep-hasta').value='';
                                    reportesCargar();">
                                    ✕ LIMPIAR FILTRO
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KPIs --}}
                <div class="section-title">INDICADORES CLAVE</div>
                <div class="kpi-grid" id="rep-kpis">
                    <div class="kpi-card kv">
                        <div class="kpi-label">TOTAL PRÉSTAMOS</div>
                        <div class="kpi-value" id="kpi-total">—</div>
                        <div class="kpi-sub">HISTÓRICO</div>
                    </div>
                    <div class="kpi-card kg">
                        <div class="kpi-label">INGRESOS TOTALES</div>
                        <div class="kpi-value" id="kpi-ingresos">—</div>
                        <div class="kpi-sub">COP · PAGOS REGISTRADOS</div>
                    </div>
                    <div class="kpi-card kr">
                        <div class="kpi-label">MULTAS GENERADAS</div>
                        <div class="kpi-value" id="kpi-multas">—</div>
                        <div class="kpi-sub">VALOR TOTAL</div>
                    </div>
                    <div class="kpi-card ka">
                        <div class="kpi-label">ACTIVOS AHORA</div>
                        <div class="kpi-value" id="kpi-activos">—</div>
                        <div class="kpi-sub">PRÉSTAMOS EN CURSO</div>
                    </div>
                </div>

                {{-- Gráficas row 1 --}}
                <div class="rep-grid">
                    {{-- Películas más prestadas --}}
                    <div class="rep-card">
                        <h4>PELÍCULAS MÁS RENTADAS</h4>
                        <div id="rep-top-pelis">
                            <div style="font-family:var(--fm);font-size:9px;color:var(--g);
                    text-align:center;padding:20px;">
                                <span class="spinner"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Estados de préstamos --}}
                    <div class="rep-card">
                        <h4>DISTRIBUCIÓN POR ESTADO</h4>
                        <div class="donut-wrap" id="rep-donut">
                            <div style="font-family:var(--fm);font-size:9px;color:var(--g);
                    text-align:center;padding:20px;">
                                <span class="spinner"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Gráficas row 2 --}}
                <div class="rep-grid">
                    {{-- Top socios --}}
                    <div class="rep-card">
                        <h4>TOP SOCIOS POR ACTIVIDAD</h4>
                        <table class="mini-table" id="rep-top-socios">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SOCIO</th>
                                    <th>PRÉSTAMOS</th>
                                    <th>MULTAS</th>
                                </tr>
                            </thead>
                            <tbody id="rep-socios-body">
                                <tr>
                                    <td colspan="4" style="text-align:center;padding:16px;">
                                        <span class="spinner"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Géneros más alquilados --}}
                    <div class="rep-card">
                        <h4>GÉNEROS MÁS ALQUILADOS</h4>
                        <div id="rep-generos">
                            <div style="font-family:var(--fm);font-size:9px;color:var(--g);
                    text-align:center;padding:20px;">
                                <span class="spinner"></span>
                            </div>
                        </div>
                    </div>
                    <div class="rep-grid">
                        <div class="rep-card">
                            <h4>ACTORES MÁS GUSTADOS</h4>
                            <div id="rep-actores">
                                <div style="font-family:var(--fm);font-size:9px;color:var(--g);
                                    text-align:center;padding:20px;">
                                    <span class="spinner"></span>
                                </div>
                            </div>
                        </div>
                        <div class="rep-card">
                            <h4>DIRECTORES MÁS GUSTADOS</h4>
                            <div id="rep-directores">
                                <div style="font-family:var(--fm);font-size:9px;color:var(--g);
                                    text-align:center;padding:20px;">
                                    <span class="spinner"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabla multas recientes --}}
                <div class="section-title">MULTAS RECIENTES</div>
                <div class="table-wrap" style="margin-bottom:28px;">
                    <div class="table-topbar">
                        <h3>HISTORIAL DE MULTAS</h3>
                        <span class="table-count" id="rep-multas-count">— REGISTROS</span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>PRÉSTAMO</th>
                                <th>TIPO</th>
                                <th>VALOR</th>
                                <th>ESTADO PAGO</th>
                                <th>FECHA</th>
                            </tr>
                        </thead>
                        <tbody id="rep-multas-body">
                            <tr>
                                <td colspan="6" style="font-family:var(--fm);font-size:9px;
                    color:var(--g);padding:24px;text-align:center;">
                                    <span class="spinner"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Tabla pagos recientes --}}
                <div class="section-title">PAGOS RECIENTES</div>
                <div class="table-wrap">
                    <div class="table-topbar">
                        <h3>HISTORIAL DE PAGOS</h3>
                        <span class="table-count" id="rep-pagos-count">— REGISTROS</span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>TIPO</th>
                                <th>MONTO</th>
                                <th>MÉTODO</th>
                                <th>FECHA</th>
                            </tr>
                        </thead>
                        <tbody id="rep-pagos-body">
                            <tr>
                                <td colspan="5" style="font-family:var(--fm);font-size:9px;
                    color:var(--g);padding:24px;text-align:center;">
                                    <span class="spinner"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
        </main>
    </div>
    <div id="modalEditUser" style="display:none; position:fixed; inset:0; z-index:1000; background:rgba(0,0,0,0.75); align-items:center; justify-content:center;">
        <div style="background:var(--ink2); border:1px solid rgba(123,94,167,0.3); width:100%; max-width:620px; margin:0 20px; position:relative;">
            <div style="background:var(--ink3); border-bottom:1px solid rgba(123,94,167,0.15); padding:10px 18px; display:flex; align-items:center; justify-content:space-between;">
                <span style="font-family:var(--fm); font-size:8px; letter-spacing:3px; color:var(--v-dim);">□ &nbsp;PANEL DE EDICIÓN</span>
                <button onclick="closeEditModal()" style="background:transparent; border:none; color:var(--g); cursor:pointer; font-size:14px; line-height:1; transition:color .15s;" onmouseover="this.style.color='#C0392B'" onmouseout="this.style.color='var(--g)'">✕</button>
            </div>
            <div style="padding:22px 28px 0;">
                <h3 style="font-family:var(--fh); font-size:22px; letter-spacing:5px; color:var(--w); line-height:1;">EDITAR USUARIO</h3>
                <small style="font-family:var(--fm); font-size:8px; color:var(--g); letter-spacing:2px; display:block; margin-top:4px;" id="edit-subtitle">// ID: —</small>
            </div>
            <div style="padding:20px 28px 28px;">
                <input type="hidden" id="edit-id">
                <div class="form-grid" style="margin-bottom:0;">
                    <div class="form-group">
                        <label>NOMBRE COMPLETO</label>
                        <input type="text" id="edit-nombre" placeholder="EJ: CARLOS MENDOZA">
                        <span class="field-error" id="edit-err-nombre"></span>
                    </div>
                    <div class="form-group">
                        <label>EMAIL</label>
                        <input type="email" id="edit-email" placeholder="correo@pixelvhs.com">
                        <span class="field-error" id="edit-err-email"></span>
                    </div>
                    <div class="form-group">
                        <label>NOMBRE DE USUARIO</label>
                        <input type="text" id="edit-usuario" placeholder="EJ: CMENDOZA">
                        <span class="field-error" id="edit-err-usuario"></span>
                    </div>
                    <div class="form-group">
                        <label>DIRECCIÓN</label>
                        <input type="text" id="edit-direccion" placeholder="Dirección del trabajador">
                        <span class="field-error" id="edit-err-direccion"></span>
                    </div>
                    <div class="form-group">
                        <label>TELÉFONO</label>
                        <input type="text" id="edit-telefono" placeholder="3001234567">
                        <span class="field-error" id="edit-err-telefono"></span>
                    </div>
                    <div class="form-group">
                        <label>ROL</label>
                        <select id="edit-rol">
                            <option value="">— SELECCIONAR —</option>
                            <option value="admin">ADMINISTRADOR</option>
                            <option value="empleado">EMPLEADO</option>
                        </select>
                        <span class="field-error" id="edit-err-rol"></span>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="form-actions">
                    <button class="btn btn-add" id="btnGuardarEdit" onclick="submitEditUsuario()">✓ GUARDAR CAMBIOS</button>
                    <button class="btn-clear" onclick="closeEditModal()">CANCELAR</button>
                </div>
            </div>
        </div>
    </div>

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
            const q = document.getElementById('userSearch').value.toLowerCase().trim();
            const rol = document.getElementById('filterRol').value;
            const estado = document.getElementById('filterEstado').value;
            const rows = document.querySelectorAll('#userTbody tr[data-id]');

            let visible = 0;

            rows.forEach(row => {
                const matchText = !q || row.dataset.nombre.includes(q) || row.dataset.email.includes(q) || row.dataset.usuario.includes(q);
                const matchRol = !rol || row.dataset.rol === rol;
                const matchState = !estado || row.dataset.estado === estado;

                const show = matchText && matchRol && matchState;
                row.style.display = show ? '' : 'none';
                if (show) visible++;
            });
            document.getElementById('userCount').textContent =
                `// ${String(visible).padStart(2,'0')} USUARIO${visible !== 1 ? 'S' : ''}`;
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
            ['u-nombre', 'u-email', 'u-usuario', 'u-password', 'u-direccion', 'u-telefono', 'u-rol']
            .forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });
            clearFormErrors();
        }

        function clearFormErrors() {
            document.querySelectorAll('.field-error').forEach(e => {
                e.textContent = '';
                e.classList.remove('show');
            });
            document.querySelectorAll('.input-error').forEach(e => e.classList.remove('input-error'));
        }

        function showFieldError(field, msg) {
            const input = document.getElementById('u-' + field);
            const err = document.getElementById('err-' + field);
            if (input) input.classList.add('input-error');
            if (err) {
                err.textContent = msg;
                err.classList.add('show');
            }
        }

        /* Añade una fila al tbody con los datos del usuario recién creado */
        function appendUserRow(u) {
            const tbody = document.getElementById('userTbody');

            // Quitar fila vacía si existe
            const empty = tbody.querySelector('.no-results');
            if (empty) empty.remove();

            const rolLabel = {
                admin: 'ADMINISTRADOR',
                empleado: 'EMPLEADO',
                socio: 'SOCIO'
            } [u.rol] ?? u.rol.toUpperCase();
            const rolClass = u.rol; // admin | empleado | socio

            const tr = document.createElement('tr');
            tr.dataset.id = u.id_usuario;
            tr.dataset.nombre = u.nombre.toLowerCase();
            tr.dataset.email = u.email.toLowerCase();
            tr.dataset.usuario = u.usuario.toLowerCase();
            tr.dataset.rol = u.rol;
            tr.dataset.estado = 'Activo';

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
                        <button class="ra-btn" onclick="editUser(${u.id_usuario}, this)">🖊 EDITAR</button>
                        <button class="ra-btn del" onclick="toggleUser(${u.id_usuario}, this)">⊘ DESACTIVAR</button>
                    </div>
                </td>
            `;

            // Animación de entrada sutil
            tr.style.opacity = '0';
            tr.style.transition = 'opacity .4s';
            tbody.append(tr);
            requestAnimationFrame(() => tr.style.opacity = '1');
        }


        async function toggleUser(id, btn) {
            btn.disabled = true;
            const originalText = btn.textContent;
            btn.innerHTML = '<span class="spinner"></span>';
            try {
                const res = await fetch(`{{ route("admin.usuarios.toggle", ["id" => ":id"]) }}`.replace(':id', id), {
                    method: 'PUT',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    },
                });
                const data = await res.json();

                if (!res.ok) {
                    alertaRetro({
                        titulo: 'ERROR',
                        texto: `<p>${data.message ?? 'Error'}</p>`,
                        icono: 'error'
                    });
                    return;
                }

                const row = document.querySelector(`#userTbody tr[data-id="${id}"]`);
                if (row) {
                    const nuevoEstado = data.estado;
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

                alertaRetro({
                    titulo: data.estado === 'Activo' ? 'USUARIO ACTIVADO' : 'USUARIO DESACTIVADO',
                    texto: `<p>Estado actualizado a <strong>${data.estado}</strong>.</p>`,
                    icono: data.estado === 'Activo' ? 'success' : 'warning',
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
            }
        }

        function openEditModal() {
            const m = document.getElementById('modalEditUser');
            m.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            const m = document.getElementById('modalEditUser');
            m.style.display = 'none';
            document.body.style.overflow = '';
            clearEditErrors();
        }

        document.getElementById('modalEditUser').addEventListener('click', function(e) {
            if (e.target === this) closeEditModal();
        });

        function clearEditErrors() {
            document.querySelectorAll('[id^="edit-err-"]').forEach(e => {
                e.textContent = '';
                e.classList.remove('show');
            });
            document.querySelectorAll('#modalEditUser .input-error').forEach(e => e.classList.remove('input-error'));
        }

        function showEditFieldError(field, msg) {
            const input = document.getElementById('edit-' + field);
            const err = document.getElementById('edit-err-' + field);
            if (input) input.classList.add('input-error');
            if (err) {
                err.textContent = msg;
                err.classList.add('show');
            }
        }

        async function editUser(id, btn) {
            btn.disabled = true;
            const orig = btn.innerHTML;
            btn.innerHTML = '<span class="spinner"></span>';
            try {
                const res = await fetch(`{{ route("admin.usuarios.obtener", ["id" => ":id"]) }}`.replace(':id', id), {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    }
                });
                const data = await res.json();

                if (!res.ok) {
                    alertaRetro({
                        titulo: 'ERROR',
                        texto: `<p>${data.message ?? 'No se pudo cargar el usuario.'}</p>`,
                        icono: 'error'
                    });
                    return;
                }

                const u = data.usuario;
                document.getElementById('edit-id').value = u.id_usuario;
                document.getElementById('edit-nombre').value = u.nombre;
                document.getElementById('edit-email').value = u.email;
                document.getElementById('edit-usuario').value = u.usuario;
                document.getElementById('edit-direccion').value = u.direccion ?? '';
                document.getElementById('edit-telefono').value = u.telefono ?? '';
                document.getElementById('edit-rol').value = u.rol;

                document.getElementById('edit-subtitle').textContent =
                    `// ID: ${String(u.id_usuario).padStart(2,'0')} · ${u.usuario.toUpperCase()}`;

                openEditModal();

            } catch (err) {
                alertaRetro({
                    titulo: 'ERROR DE CONEXIÓN',
                    texto: '<p>No se pudo cargar el usuario.</p>',
                    icono: 'error'
                });
            } finally {
                btn.disabled = false;
                btn.innerHTML = orig;
            }
        }

        async function submitEditUsuario() {
            clearEditErrors();
            const id = document.getElementById('edit-id').value;
            const payload = {
                nombre: document.getElementById('edit-nombre').value.trim(),
                email: document.getElementById('edit-email').value.trim(),
                usuario: document.getElementById('edit-usuario').value.trim(),
                direccion: document.getElementById('edit-direccion').value.trim(),
                telefono: document.getElementById('edit-telefono').value.trim(),
                rol: document.getElementById('edit-rol').value,
            };

            const btn = document.getElementById('btnGuardarEdit');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span>';

            try {
                const res = await fetch(`{{ route("admin.usuarios.actualizar", ["id" => ":id"]) }}`.replace(':id', id), {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                    },
                    body: JSON.stringify(payload),
                });
                const data = await res.json();

                if (!res.ok) {
                    if (data.errors) {
                        Object.entries(data.errors).forEach(([field, msgs]) => {
                            showEditFieldError(field, msgs[0].toUpperCase());
                        });
                        const lista = Object.values(data.errors).map(m => `<li>${m[0]}</li>`).join('');
                        alertaRetro({
                            titulo: 'ERROR DE VALIDACIÓN',
                            texto: `<ul>${lista}</ul>`,
                            icono: 'error'
                        });
                    } else {
                        alertaRetro({
                            titulo: 'ERROR',
                            texto: `<p>${data.message ?? 'Error al guardar.'}</p>`,
                            icono: 'error'
                        });
                    }
                    return;
                }
                const u = data.usuario;
                const row = document.querySelector(`#userTbody tr[data-id="${id}"]`);
                if (row) {
                    const rolLabel = {
                        admin: 'ADMINISTRADOR',
                        empleado: 'EMPLEADO',
                        socio: 'SOCIO'
                    } [u.rol] ?? u.rol.toUpperCase();
                    row.dataset.nombre = u.nombre.toLowerCase();
                    row.dataset.email = u.email.toLowerCase();
                    row.dataset.usuario = u.usuario.toLowerCase();
                    row.dataset.rol = u.rol;

                    row.cells[1].textContent = u.nombre;
                    row.cells[2].textContent = u.email;
                    row.cells[3].textContent = u.usuario;
                    row.cells[4].textContent = u.telefono ?? '—';
                    row.cells[5].innerHTML = `<span class="rol-pill ${u.rol}">${rolLabel}</span>`;
                }

                closeEditModal();
                alertaRetro({
                    titulo: 'CAMBIOS GUARDADOS',
                    texto: `<p>El usuario <strong>${u.usuario.toUpperCase()}</strong> fue actualizado correctamente.</p>`,
                    icono: 'success',
                });

            } catch (err) {
                alertaRetro({
                    titulo: 'ERROR DE CONEXIÓN',
                    texto: '<p>No se pudo completar la acción.</p>',
                    icono: 'error'
                });
            } finally {
                btn.disabled = false;
                btn.innerHTML = '✓ GUARDAR CAMBIOS';
            }
        }

        async function deleteUser(id, btn) {
            const result = await alertaConfirmar({
                titulo: '¿ELIMINAR USUARIO?',
                texto: '<p>Esta acción no se puede deshacer.</p>',
                icono: 'warning',
                boton: 'SÍ, ELIMINAR',
                cancelar: true
            });

            if (!result.isConfirmed) {
                return;
            }
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span>';
            try {
                const res = await fetch(`{{ route("admin.usuarios.eliminar", ["id" => ":id"]) }}`.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    },
                });
                const data = await res.json();

                if (!res.ok) {
                    alertaRetro({
                        titulo: 'ERROR',
                        texto: `<p>${data.message ?? 'Error'}</p>`,
                        icono: 'error'
                    });
                    btn.disabled = false;
                    btn.textContent = '✕ ELIMINAR';
                    return;
                }

                const row = document.querySelector(`#userTbody tr[data-id="${id}"]`);
                if (row) {
                    row.style.transition = 'opacity .3s';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        updateUserCount(-1);
                    }, 300);
                }
                alertaRetro({
                    titulo: 'USUARIO ELIMINADO',
                    texto: '<p>El usuario fue eliminado correctamente.</p>',
                    icono: 'success',
                });
            } catch (err) {
                alertaRetro({
                    titulo: 'ERROR DE CONEXIÓN',
                    texto: '<p>No se pudo completar la acción.</p>',
                    icono: 'error',
                });
            }
        }

        function updateUserCount(delta) {
            const el = document.getElementById('userCount');
            const nb = document.getElementById('nb-usuarios');
            const rows = document.querySelectorAll('#userTbody tr[data-id]');
            const n = rows.length;
            el.textContent = `// ${String(n).padStart(2,'0')} USUARIO${n !== 1 ? 'S' : ''}`;
            nb.textContent = String(n).padStart(2, '0');
        }


        function notificar(tipo, titulo, texto) {
            alertaRetro({
                titulo,
                texto: `<p>${texto}</p>`,
                icono: tipo
            });
        }

        async function submitUsuario() {
            clearFormErrors();
            const payload = {
                nombre: document.getElementById('u-nombre').value.trim(),
                email: document.getElementById('u-email').value.trim(),
                usuario: document.getElementById('u-usuario').value.trim(),
                password: document.getElementById('u-password').value,
                password_confirmation: document.getElementById('u-password-confirm').value,
                direccion: document.getElementById('u-direccion').value.trim(),
                telefono: document.getElementById('u-telefono').value.trim(),
                rol: document.getElementById('u-rol').value,
            };

            const btn = document.getElementById('btnAgregarUsuario');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span>';

            try {
                const res = await fetch('{{ route("admin.registrar") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                    },
                    body: JSON.stringify(payload),
                });
                const data = await res.json();
                if (!res.ok) {
                    if (data.errors) {
                        Object.entries(data.errors).forEach(([field, msgs]) => {
                            showFieldError(field, msgs[0].toUpperCase());
                        });
                        const lista = Object.values(data.errors)
                            .map(msgs => `<li>${msgs[0]}</li>`)
                            .join('');

                        alertaRetro({
                            titulo: 'ERROR DE REGISTRO',
                            texto: `<ul>${lista}</ul>`,
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

                appendUserRow(data.usuario);
                clearUserForm();
                updateUserCount(1);

                alertaRetro({
                    titulo: 'USUARIO REGISTRADO',
                    texto: `<p>El usuario <strong>${data.usuario.usuario.toUpperCase()}</strong> fue creado correctamente.</p>`,
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
                btn.innerHTML = '+ AGREGAR';
            }
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
        const fmt = n => new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0
        }).format(n);

        const fmtDate = s => s ?
            new Date(s).toLocaleDateString('es-CO', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            }) :
            '—';

        const estadoPill = e => {
            const map = {
                Activo: 'activo',
                Terminado: 'terminado',
                Cancelado: 'cancelado',
                Pendiente: 'pendiente'
            };
            const cls = map[e] ?? 'terminado';
            return `<span class="pr-pill ${cls}">${(e ?? '—').toUpperCase()}</span>`;
        };

        let rentasData = []; // todos los registros cargados
        let rentasFilt = []; // filtrados actualmente
        let rentasPag = 1;
        const RENTAS_PER_PAGE = 12;

        /* Carga inicial desde la API */
        async function rentasCargar() {
            document.getElementById('rn-tbody').innerHTML = `
        <tr><td colspan="10" style="font-family:var(--fm);font-size:9px;
            color:var(--g);padding:28px;text-align:center;">
            <span class="spinner"></span> &nbsp;CARGANDO...</td></tr>`;

            try {
                const res = await fetch('{{ route("admin.prestamos.index") }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    }
                });
                const data = await res.json();
                rentasData = data.prestamos ?? [];
                rentasFilt = [...rentasData];
                rentasPag = 1;
                rentasRenderizar();

                /* badge sidebar */
                const nb = document.getElementById('nb-rentas');
                if (nb) nb.textContent = String(rentasData.length).padStart(2, '0');

            } catch (e) {
                document.getElementById('rn-tbody').innerHTML = `
            <tr><td colspan="10" style="font-family:var(--fm);font-size:9px;
                color:var(--red);padding:28px;text-align:center;">
                ERROR AL CARGAR DATOS</td></tr>`;
            }
        }

        function rentasFiltrar() {
            const q = (document.getElementById('rn-search').value ?? '').toLowerCase().trim();
            const estado = document.getElementById('rn-estado').value;
            const desde = document.getElementById('rn-desde').value;
            const hasta = document.getElementById('rn-hasta').value;

            rentasFilt = rentasData.filter(p => {
                const nombre = (p.socio_nombre ?? '').toLowerCase();
                const email = (p.socio_email ?? '').toLowerCase();
                const okQ = !q || nombre.includes(q) || email.includes(q);
                const okE = !estado || p.estado === estado;
                const fi = p.fecha_inicio ? new Date(p.fecha_inicio) : null;
                const okD = !desde || (fi && fi >= new Date(desde));
                const okH = !hasta || (fi && fi <= new Date(hasta + 'T23:59:59'));
                return okQ && okE && okD && okH;
            });
            rentasPag = 1;
            rentasRenderizar();
        }

        function rentasPaginar(dir) {
            const total = Math.ceil(rentasFilt.length / RENTAS_PER_PAGE);
            rentasPag = Math.min(Math.max(rentasPag + dir, 1), total);
            rentasRenderizar();
        }

        function rentasRenderizar() {
            const total = Math.ceil(rentasFilt.length / RENTAS_PER_PAGE);
            const start = (rentasPag - 1) * RENTAS_PER_PAGE;
            const slice = rentasFilt.slice(start, start + RENTAS_PER_PAGE);
            const tbody = document.getElementById('rn-tbody');

            document.getElementById('rn-count').textContent =
                `${rentasFilt.length} REGISTROS`;
            document.getElementById('rn-page-info').textContent =
                `${rentasPag} / ${total || 1}`;
            document.getElementById('rn-page-label').textContent =
                `MOSTRANDO ${start+1}–${Math.min(start+RENTAS_PER_PAGE, rentasFilt.length)} DE ${rentasFilt.length}`;
            document.getElementById('rn-prev').disabled = rentasPag === 1;
            document.getElementById('rn-next').disabled = rentasPag >= total;

            if (!slice.length) {
                tbody.innerHTML = `
            <tr><td colspan="10" style="font-family:var(--fm);font-size:9px;
                color:var(--g);padding:28px;text-align:center;">
                SIN RESULTADOS</td></tr>`;
                return;
            }

            tbody.innerHTML = slice.map(p => `
        <tr>
            <td class="id-cell">${String(p.id_prestamo).padStart(3,'0')}</td>
            <td class="name-cell">${p.socio_nombre ?? '—'}</td>
            <td style="font-size:11px;">${p.socio_email ?? '—'}</td>
            <td style="font-family:var(--fm);font-size:10px;color:var(--v);">
                ${p.cintas_count ?? '—'}
            </td>
            <td style="font-size:11px;">${fmtDate(p.fecha_inicio)}</td>
            <td style="font-size:11px;">${fmtDate(p.fecha_limite)}</td>
            <td style="font-size:11px;">${fmtDate(p.fecha_devolucion)}</td>
            <td style="font-family:var(--fm);font-size:10px;color:var(--green);">
                ${fmt(p.cargo_diario ?? 0)}
            </td>
            <td>${estadoPill(p.estado)}</td>
            <td>
                <button class="ra-btn" onclick="rnVerDetalle(${p.id_prestamo})">
                    ◈ VER
                </button>
            </td>
        </tr>
    `).join('');
        }

        async function rnVerDetalle(id) {
            const modal = document.getElementById('modal-renta');
            const body = document.getElementById('rn-modal-body');
            const idSpan = document.getElementById('rn-modal-id');

            idSpan.textContent = String(id).padStart(3, '0');
            body.innerHTML = `<div style="text-align:center;padding:30px;">
            <span class="spinner"></span>
        </div>`;
            modal.classList.add('open');

            try {
                const res = await fetch(
                    `{{ route("admin.prestamos.show", ["id" => ":id"]) }}`.replace(':id', id), {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': CSRF
                        }
                    }
                );
                const data = await res.json();
                const p = data.prestamo;

                const cintasHtml = (p.cintas ?? []).map(c => `
                <div style="display:flex;align-items:center;gap:10px;
                    padding:8px 0;border-bottom:1px solid rgba(255,255,255,.03);">
                    <span style="font-family:var(--fo);font-size:9px;
                        color:var(--v-dim);letter-spacing:1px;">
                        #${String(c.id_cinta).padStart(3,'0')}
                    </span>
                    <span style="font-family:var(--fu);font-size:13px;
                        color:var(--w);font-weight:600;flex:1;">
                        ${c.pelicula ?? '—'}
                    </span>
                    <span style="font-family:var(--fm);font-size:8px;
                        letter-spacing:2px;color:var(--g);">
                        ${c.formato ?? '—'}
                    </span>
                </div>
            `).join('') || `<div style="font-family:var(--fm);font-size:9px;
                color:var(--g);padding:12px 0;">SIN CINTAS REGISTRADAS</div>`;

                const multasHtml = (p.multas ?? []).map(m => `
                <div style="display:flex;justify-content:space-between;align-items:center;
                    padding:7px 0;border-bottom:1px solid rgba(255,255,255,.03);">
                    <span style="font-family:var(--fm);font-size:9px;
                        color:var(--amber);letter-spacing:1px;">${m.concepto ?? '—'}</span>
                    <span style="font-family:var(--fm);font-size:10px;
                        color:var(--red);">${fmt(m.valor ?? 0)}</span>
                </div>
            `).join('') || `<div style="font-family:var(--fm);font-size:9px;
                color:var(--g);padding:8px 0;">SIN MULTAS</div>`;

                const row = (label, val) => `
                <div style="display:flex;justify-content:space-between;
                    padding:6px 0;border-bottom:1px solid rgba(255,255,255,.03);">
                    <span style="font-family:var(--fm);font-size:8px;
                        letter-spacing:2px;color:var(--g);">${label}</span>
                    <span style="font-family:var(--fu);font-size:13px;
                        color:var(--w);">${val}</span>
                </div>`;

                body.innerHTML = `
                <div style="display:grid;gap:20px;">
                    <div>
                        <div style="font-family:var(--fm);font-size:8px;letter-spacing:3px;
                            color:var(--v-dim);margin-bottom:12px;">// DATOS GENERALES</div>
                        ${row('SOCIO',         p.socio_nombre ?? '—')}
                        ${row('EMAIL',         p.socio_email  ?? '—')}
                        ${row('ESTADO',        estadoPill(p.estado))}
                        ${row('CARGO DIARIO',  fmt(p.cargo_diario ?? 0))}
                        ${row('INICIO',        fmtDate(p.fecha_inicio))}
                        ${row('VENCE',         fmtDate(p.fecha_limite))}
                        ${row('DEVUELTO',      fmtDate(p.fecha_devolucion))}
                    </div>
                    <div>
                        <div style="font-family:var(--fm);font-size:8px;letter-spacing:3px;
                            color:var(--v-dim);margin-bottom:12px;">// CINTAS</div>
                        ${cintasHtml}
                    </div>
                    <div>
                        <div style="font-family:var(--fm);font-size:8px;letter-spacing:3px;
                            color:var(--v-dim);margin-bottom:12px;">// MULTAS</div>
                        ${multasHtml}
                    </div>
                    ${p.observaciones ? `
                    <div>
                        <div style="font-family:var(--fm);font-size:8px;letter-spacing:3px;
                            color:var(--v-dim);margin-bottom:8px;">// OBSERVACIONES</div>
                        <div style="font-family:var(--fm);font-size:10px;color:var(--g);
                            letter-spacing:1px;line-height:1.7;padding:10px;
                            background:var(--ink3);border-left:2px solid var(--v-dim);">
                            ${p.observaciones}
                        </div>
                    </div>` : ''}
                </div>`;

            } catch (e) {
                body.innerHTML = `<div style="font-family:var(--fm);font-size:9px;
                color:var(--red);padding:20px;text-align:center;">
                ERROR AL CARGAR DETALLE</div>`;
            }
        }

        function rnCloseModal() {
            document.getElementById('modal-renta').classList.remove('open');
        }
        document.getElementById('modal-renta')?.addEventListener('click', function(e) {
            if (e.target === this) rnCloseModal();
        });
        let repData = null;

        async function reportesCargar() {
            ['rep-top-pelis', 'rep-donut', 'rep-generos', 'rep-actores', 'rep-directores'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.innerHTML = `<div style="text-align:center;padding:20px;"><span class="spinner"></span></div>`;
            });
            ['rep-socios-body', 'rep-multas-body', 'rep-pagos-body'].forEach(id => {
                document.getElementById(id).innerHTML =
                    `<tr><td colspan="6" style="font-family:var(--fm);font-size:9px;
                    color:var(--g);padding:20px;text-align:center;">
                    <span class="spinner"></span></td></tr>`;
            });

            const desde = document.getElementById('rep-desde')?.value ?? '';
            const hasta = document.getElementById('rep-hasta')?.value ?? '';
            const params = new URLSearchParams();
            if (desde) params.set('desde', desde);
            if (hasta) params.set('hasta', hasta);

            const url = '{{ route("admin.reportes.index") }}' + (params.toString() ? '?' + params : '');

            try {
                const res = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    }
                });
                repData = await res.json();
                repRenderKPIs();
                repRenderTopPelis();
                repRenderDonut();
                repRenderTopSocios();
                repRenderGeneros();
                repRenderActores();
                repRenderDirectores();
                repRenderMultas();
                repRenderPagos();
            } catch (e) {
                console.error('Reportes error:', e);
            }
        }

        function repRenderActores() {
            const items = repData.top_actores ?? [];
            const el = document.getElementById('rep-actores');
            if (!el) return;
            if (!items.length) {
                el.innerHTML = `<div style="font-family:var(--fm);font-size:9px;color:var(--g);
                    text-align:center;padding:20px;">SIN DATOS</div>`;
                return;
            }
            const max = items[0].total ?? 1;
            el.innerHTML = items.slice(0, 8).map(a => `
                <div class="bar-item">
                    <span class="bar-label" title="${a.nombre}">${a.nombre}</span>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:${Math.round((a.total/max)*100)}%"></div>
                    </div>
                    <span class="bar-val">${a.total}</span>
                </div>
            `).join('');
        }

        function repRenderDirectores() {
            const items = repData.top_directores ?? [];
            const el = document.getElementById('rep-directores');
            if (!el) return;
            if (!items.length) {
                el.innerHTML = `<div style="font-family:var(--fm);font-size:9px;color:var(--g);
                    text-align:center;padding:20px;">SIN DATOS</div>`;
                return;
            }
            const max = items[0].total ?? 1;
            el.innerHTML = items.slice(0, 8).map(d => `
                <div class="bar-item">
                    <span class="bar-label" title="${d.nombre}">${d.nombre}</span>
                    <div class="bar-track">
                        <div class="bar-fill green-fill" style="width:${Math.round((d.total/max)*100)}%"></div>
                    </div>
                    <span class="bar-val" style="color:var(--green);">${d.total}</span>
                </div>
            `).join('');
        }

        /* ── KPIs ── */
        function repRenderKPIs() {
            document.getElementById('kpi-total').textContent = repData.total_prestamos ?? '0';
            document.getElementById('kpi-ingresos').textContent = fmt(repData.total_ingresos ?? 0)
                .replace('COP', '').trim();
            document.getElementById('kpi-multas').textContent = fmt(repData.total_multas ?? 0)
                .replace('COP', '').trim();
            document.getElementById('kpi-activos').textContent = repData.prestamos_activos ?? '0';
        }

        /* ── Top películas ── */
        function repRenderTopPelis() {
            const items = repData.top_peliculas ?? [];
            if (!items.length) {
                document.getElementById('rep-top-pelis').innerHTML =
                    `<div style="font-family:var(--fm);font-size:9px;color:var(--g);
                text-align:center;padding:20px;">SIN DATOS</div>`;
                return;
            }
            const max = items[0].total ?? 1;
            document.getElementById('rep-top-pelis').innerHTML = items.slice(0, 8).map(p => `
        <div class="bar-item">
            <span class="bar-label" title="${p.titulo}">${p.titulo}</span>
            <div class="bar-track">
                <div class="bar-fill" style="width:${Math.round((p.total/max)*100)}%"></div>
            </div>
            <span class="bar-val">${p.total}</span>
        </div>
    `).join('');
        }

        /* ── Donut estados ── */
        function repRenderDonut() {
            const estados = repData.estados ?? {};
            const colores = {
                Activo: '#4CAF6A',
                Terminado: '#666',
                Cancelado: '#C0392B',
                Pendiente: '#D4A017'
            };
            const total = Object.values(estados).reduce((a, b) => a + b, 0) || 1;

            /* SVG donut simple */
            const r = 52,
                cx = 60,
                cy = 60,
                stroke = 16;
            const circ = 2 * Math.PI * r;
            let offset = 0;
            const slices = Object.entries(estados).map(([k, v]) => {
                const pct = v / total;
                const dash = pct * circ;
                const gap = circ - dash;
                const s = `<circle cx="${cx}" cy="${cy}" r="${r}"
            fill="none"
            stroke="${colores[k] ?? '#444'}"
            stroke-width="${stroke}"
            stroke-dasharray="${dash.toFixed(2)} ${gap.toFixed(2)}"
            stroke-dashoffset="${-offset.toFixed(2)}"
            transform="rotate(-90 ${cx} ${cy})"
            style="transition:stroke-dasharray .6s ease"/>`;
                offset += dash;
                return s;
            }).join('');

            const legend = Object.entries(estados).map(([k, v]) => `
        <div class="donut-leg-item">
            <div class="donut-leg-dot" style="background:${colores[k]??'#444'}"></div>
            <span>${k.toUpperCase()} <strong style="color:var(--w);margin-left:4px;">${v}</strong></span>
        </div>`).join('');

            document.getElementById('rep-donut').innerHTML = `
        <div class="donut-wrap">
            <svg width="120" height="120" viewBox="0 0 120 120">
                <circle cx="${cx}" cy="${cy}" r="${r}" fill="none"
                    stroke="rgba(255,255,255,.04)" stroke-width="${stroke}"/>
                ${slices}
                <text x="${cx}" y="${cy+5}" text-anchor="middle"
                    font-family="'Bebas Neue',sans-serif" font-size="18"
                    fill="var(--w)" letter-spacing="1">${total}</text>
            </svg>
            <div class="donut-legend">${legend}</div>
        </div>`;
        }

        /* ── Top socios ── */
        function repRenderTopSocios() {
            const socios = repData.top_socios ?? [];
            if (!socios.length) {
                document.getElementById('rep-socios-body').innerHTML =
                    `<tr><td colspan="4" style="font-family:var(--fm);font-size:9px;
                color:var(--g);padding:16px;text-align:center;">SIN DATOS</td></tr>`;
                return;
            }
            document.getElementById('rep-socios-body').innerHTML = socios.map((s, i) => `
        <tr>
            <td class="rank">${String(i+1).padStart(2,'0')}</td>
            <td class="hi">${s.nombre ?? '—'}</td>
            <td style="font-family:var(--fo);font-size:10px;color:var(--v);">${s.total_prestamos}</td>
            <td style="font-family:var(--fo);font-size:10px;color:${s.total_multas>0?'var(--red)':'var(--g)'};">
                ${s.total_multas ?? 0}
            </td>
        </tr>`).join('');
        }

        /* ── Géneros ── */
        function repRenderGeneros() {
            const items = repData.top_generos ?? [];
            if (!items.length) {
                document.getElementById('rep-generos').innerHTML =
                    `<div style="font-family:var(--fm);font-size:9px;color:var(--g);
                text-align:center;padding:20px;">SIN DATOS</div>`;
                return;
            }
            const max = items[0].total ?? 1;
            document.getElementById('rep-generos').innerHTML = items.slice(0, 8).map(g => `
        <div class="bar-item">
            <span class="bar-label">${g.nombre}</span>
            <div class="bar-track">
                <div class="bar-fill green-fill"
                     style="width:${Math.round((g.total/max)*100)}%"></div>
            </div>
            <span class="bar-val" style="color:var(--green);">${g.total}</span>
        </div>
    `).join('');
        }

        /* ── Multas ── */
        function repRenderMultas() {
            const items = repData.multas ?? [];
            document.getElementById('rep-multas-count').textContent = `${items.length} REGISTROS`;
            if (!items.length) {
                document.getElementById('rep-multas-body').innerHTML =
                    `<tr><td colspan="6" style="font-family:var(--fm);font-size:9px;
                color:var(--g);padding:20px;text-align:center;">SIN MULTAS</td></tr>`;
                return;
            }
            const concMap = {
                Retraso: 'var(--amber)',
                Daño: 'var(--red)',
                Perdida: 'var(--red)'
            };
            const pagados = new Set((repData.pagos_multa ?? []).map(p => p.id_multa));
            document.getElementById('rep-multas-body').innerHTML = items.map(m => `
        <tr>
            <td class="id-cell">${String(m.id_multa).padStart(3,'0')}</td>
            <td style="font-family:var(--fo);font-size:9px;color:var(--v-dim);">
                #${String(m.id_prestamo).padStart(3,'0')}
            </td>
            <td style="font-family:var(--fm);font-size:9px;letter-spacing:1px;
                color:${concMap[m.concepto]??'var(--g)'};">
                ${m.concepto?.toUpperCase() ?? '—'}
            </td>
            <td style="font-family:var(--fm);font-size:10px;color:var(--red);">
                ${fmt(m.valor ?? 0)}
            </td>
            <td>${pagados.has(m.id_multa)
                ? `<span class="pr-pill activo">PAGADA</span>`
                : `<span class="pr-pill cancelado">PENDIENTE</span>`
            }</td>
            <td style="font-size:11px;">${fmtDate(m.fecha_generacion)}</td>
        </tr>`).join('');
        }

        /* ── Pagos ── */
        function repRenderPagos() {
            const items = repData.pagos ?? [];
            document.getElementById('rep-pagos-count').textContent = `${items.length} REGISTROS`;
            if (!items.length) {
                document.getElementById('rep-pagos-body').innerHTML =
                    `<tr><td colspan="5" style="font-family:var(--fm);font-size:9px;
                color:var(--g);padding:20px;text-align:center;">SIN PAGOS</td></tr>`;
                return;
            }
            const metCol = {
                Efectivo: 'var(--amber)',
                Tarjeta: 'var(--v)',
                Transferencia: 'var(--green)'
            };
            document.getElementById('rep-pagos-body').innerHTML = items.map(p => `
        <tr>
            <td class="id-cell">${String(p.id_pago).padStart(3,'0')}</td>
            <td style="font-family:var(--fm);font-size:9px;letter-spacing:1px;
                color:var(--g);">
                ${p.tipo?.toUpperCase() ?? '—'}
            </td>
            <td style="font-family:var(--fm);font-size:10px;color:var(--green);">
                ${fmt(p.monto ?? 0)}
            </td>
            <td style="font-family:var(--fm);font-size:9px;letter-spacing:1px;
                color:${metCol[p.metodo_pago]??'var(--g)'};">
                ${p.metodo_pago?.toUpperCase() ?? '—'}
            </td>
            <td style="font-size:11px;">${fmtDate(p.fecha_pago)}</td>
        </tr>`).join('');
        }
        async function exportarPDF() {
            if (!repData) {
                alertaRetro({
                    titulo: 'DATOS NO CARGADOS',
                    texto: '<p>Primero accede a la sección REPORTES para cargar los datos.</p>',
                    icono: 'warning'
                });
                return;
            }

            const btn = document.getElementById('btn-pdf');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span> &nbsp;GENERANDO...';

            /* Cargar jsPDF dinámicamente */
            if (!window.jspdf) {
                await new Promise((res, rej) => {
                    const s = document.createElement('script');
                    s.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
                    s.onload = res;
                    s.onerror = rej;
                    document.head.appendChild(s);
                });
            }

            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF({
                orientation: 'portrait',
                unit: 'mm',
                format: 'a4'
            });
            const W = 210,
                M = 16;
            let y = 0;

            const PV = [123, 94, 167];
            const PVL = [180, 150, 210];
            const PVD = [90, 65, 130];
            const PG = [34, 139, 70];
            const PR = [185, 50, 40];
            const PA = [180, 110, 10];
            const BG = [255, 255, 255];
            const BG2 = [248, 245, 255];
            const BG3 = [237, 230, 252];
            const FW = [30, 20, 50];
            const FG = [120, 100, 155];
            /* ── Fondo ── */
            const pageFill = () => {
                doc.setFillColor(...BG);
                doc.rect(0, 0, 210, 297, 'F');
            };
            pageFill();

            /* ── Header ── */
            doc.setFillColor(...PV);
            doc.rect(0, 0, W, 18, 'F');
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(16);
            doc.setTextColor(255, 255, 255);
            doc.text('PIXELVHS', M, 11);
            doc.setFontSize(8);
            doc.setFont('courier', 'normal');
            doc.setTextColor(255, 255, 255);
            doc.text('PANEL DE REPORTES  ·  ADMIN', M + 44, 11);
            const desdeVal = document.getElementById('rep-desde')?.value;
            const hastaVal = document.getElementById('rep-hasta')?.value;
            const periodoStr = (desdeVal && hastaVal) ?
                `PERÍODO: ${desdeVal} → ${hastaVal}` :
                desdeVal ? `DESDE: ${desdeVal}` :
                hastaVal ? `HASTA: ${hastaVal}` :
                `GENERADO: ${new Date().toLocaleDateString('es-CO')}`;
            doc.text(periodoStr, W - M, 11, {
                align: 'right'
            });

            /* ── Línea deco ── */
            doc.setDrawColor(...PV);
            doc.setLineWidth(.4);
            doc.line(0, 18, W, 18);
            y = 26;

            /* ── Sección helper ── */
            const section = (title) => {
                if (y > 260) {
                    doc.addPage();
                    pageFill();
                    y = 16;
                }
                doc.setFillColor(...BG3);
                doc.rect(M, y, W - M * 2, 7, 'F');
                doc.setDrawColor(...PV);
                doc.setLineWidth(.6);
                doc.line(M, y, M, y + 7);
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(8);
                doc.setTextColor(...PV);
                doc.text('// ' + title, M + 4, y + 4.5);
                y += 11;
            };

            const kpiBlock = (label, val, col) => {
                doc.setFillColor(...BG2);
                doc.rect(0, 0, 0, 0); // reset
                const bx = M,
                    bw = (W - M * 2 - 9) / 4;
                return {
                    label,
                    val,
                    col
                };
            };

            /* ── KPIs en cajas ── */
            const kpis = [{
                    label: 'TOTAL PRÉSTAMOS',
                    val: String(repData.total_prestamos ?? 0),
                    col: PV
                },
                {
                    label: 'INGRESOS (COP)',
                    val: new Intl.NumberFormat('es-CO').format(repData.total_ingresos ?? 0),
                    col: PG
                },
                {
                    label: 'MULTAS (COP)',
                    val: new Intl.NumberFormat('es-CO').format(repData.total_multas ?? 0),
                    col: PR
                },
                {
                    label: 'ACTIVOS AHORA',
                    val: String(repData.prestamos_activos ?? 0),
                    col: PA
                },
            ];
            const kw = (W - M * 2 - 9) / 4,
                kh = 20;
            kpis.forEach((k, i) => {
                const kx = M + i * (kw + 3);
                doc.setFillColor(...BG2);
                doc.rect(kx, y, kw, kh, 'F');
                doc.setFillColor(...k.col);
                doc.rect(kx, y, 1.5, kh, 'F');
                doc.setFont('courier', 'normal');
                doc.setFontSize(6.5);
                doc.setTextColor(...FG);
                doc.text(k.label, kx + 4, y + 6);
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(12);
                doc.setTextColor(...FW);
                doc.text(k.val, kx + 4, y + 15);
            });
            y += kh + 10;

            /* ── Top Películas ── */
            section('PELÍCULAS MÁS RENTADAS');
            const pelis = repData.top_peliculas ?? [];
            if (pelis.length) {
                const maxV = pelis[0].total || 1;
                const bw = W - M * 2 - 50;
                pelis.slice(0, 8).forEach((p, i) => {
                    if (y > 270) {
                        doc.addPage();
                        pageFill();
                        y = 16;
                    }
                    doc.setFont('courier', 'normal');
                    doc.setFontSize(7.5);
                    doc.setTextColor(...FG);
                    const label = p.titulo.length > 28 ? p.titulo.slice(0, 26) + '…' : p.titulo;
                    doc.text(label, M, y + 2.5);
                    /* barra */
                    const fill = Math.round((p.total / maxV) * bw);
                    doc.setFillColor(...BG3);
                    doc.rect(M + 46, y - 1, bw, 5, 'F');
                    doc.setFillColor(74, 52, 104);
                    doc.rect(M + 46, y - 1, fill, 5, 'F');
                    doc.setFillColor(...PV);
                    doc.rect(M + 46 + fill - 1.5, y - 1, 1.5, 5, 'F');
                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(7);
                    doc.setTextColor(...PV);
                    doc.text(String(p.total), M + 46 + bw + 3, y + 2.5);
                    y += 8;
                });
            } else {
                doc.setFont('courier', 'normal');
                doc.setFontSize(8);
                doc.setTextColor(...FG);
                doc.text('SIN DATOS', M, y);
                y += 8;
            }
            y += 4;

            /* ── Distribución estados ── */
            section('DISTRIBUCIÓN POR ESTADO');
            const estados = repData.estados ?? {};
            const estColores = {
                Activo: PG,
                Terminado: FG,
                Cancelado: PR,
                Pendiente: PA
            };
            Object.entries(estados).forEach(([k, v]) => {
                if (y > 275) {
                    doc.addPage();
                    pageFill();
                    y = 16;
                }
                const col = estColores[k] ?? FG;
                doc.setFillColor(...col);
                doc.circle(M + 2.5, y + 1, 2, 'F');
                doc.setFont('courier', 'normal');
                doc.setFontSize(8);
                doc.setTextColor(...FW);
                doc.text(`${k.toUpperCase()}`, M + 7, y + 2.5);
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(9);
                doc.setTextColor(...col);
                doc.text(String(v), W - M, y + 2.5, {
                    align: 'right'
                });
                y += 8;
            });
            y += 4;

            section('TOP SOCIOS POR ACTIVIDAD');
            const socios = repData.top_socios ?? [];
            if (socios.length) {
                doc.setFillColor(...BG3);
                doc.rect(M, y, W - M * 2, 6, 'F');
                doc.setFont('courier', 'normal');
                doc.setFontSize(6.5);
                doc.setTextColor(...FG);
                doc.text('#', M + 2, y + 4);
                doc.text('SOCIO', M + 10, y + 4);
                doc.text('PRÉSTAMOS', M + 90, y + 4);
                doc.text('MULTAS', W - M - 4, y + 4, {
                    align: 'right'
                });
                y += 8;
                socios.slice(0, 10).forEach((s, i) => {
                    if (y > 270) {
                        doc.addPage();
                        pageFill();
                        y = 16;
                    }
                    doc.setFillColor(i % 2 === 0 ? 22 : 17, i % 2 === 0 ? 22 : 17, i % 2 === 0 ? 22 : 17);
                    doc.rect(M, y - 1, W - M * 2, 6, 'F');
                    doc.setFont('courier', 'normal');
                    doc.setFontSize(7.5);
                    doc.setTextColor(...FG);
                    doc.text(String(i + 1).padStart(2, '0'), M + 2, y + 3);
                    doc.setTextColor(...FW);
                    const nom = (s.nombre || '—').length > 30 ? (s.nombre || '—').slice(0, 28) + '…' : (s.nombre || '—');
                    doc.text(nom, M + 10, y + 3);
                    doc.setFont('helvetica', 'bold');
                    doc.setTextColor(...PV);
                    doc.text(String(s.total_prestamos || 0), M + 90, y + 3);
                    doc.setTextColor(...(s.total_multas > 0 ? PR : FG));
                    doc.text(String(s.total_multas || 0), W - M - 4, y + 3, {
                        align: 'right'
                    });
                    y += 6;
                });
            } else {
                doc.setFont('courier', 'normal');
                doc.setFontSize(8);
                doc.setTextColor(...FG);
                doc.text('SIN DATOS', M, y);
                y += 8;
            }
            y += 6;

            /* ── Géneros ── */
            section('GÉNEROS MÁS ALQUILADOS');
            const generos = repData.top_generos ?? [];
            if (generos.length) {
                const maxG = generos[0].total || 1;
                const gw = W - M * 2 - 50;
                generos.slice(0, 8).forEach(g => {
                    if (y > 270) {
                        doc.addPage();
                        pageFill();
                        y = 16;
                    }
                    doc.setFont('courier', 'normal');
                    doc.setFontSize(7.5);
                    doc.setTextColor(...FG);
                    doc.text(g.nombre, M, y + 2.5);
                    const fill = Math.round((g.total / maxG) * gw);
                    doc.setFillColor(...BG3);
                    doc.rect(M + 46, y - 1, gw, 5, 'F');
                    doc.setFillColor(30, 70, 40);
                    doc.rect(M + 46, y - 1, fill, 5, 'F');
                    doc.setFillColor(...PG);
                    doc.rect(M + 46 + fill - 1.5, y - 1, 1.5, 5, 'F');
                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(7);
                    doc.setTextColor(...PG);
                    doc.text(String(g.total), M + 46 + gw + 3, y + 2.5);
                    y += 8;
                });
            } else {
                doc.setFont('courier', 'normal');
                doc.setFontSize(8);
                doc.setTextColor(...FG);
                doc.text('SIN DATOS', M, y);
            }
            section('ACTORES MÁS GUSTADOS');
            const actores = repData.top_actores ?? [];
            if (actores.length) {
                const maxA = actores[0].total || 1;
                const aw = W - M * 2 - 50;
                actores.slice(0, 8).forEach(a => {
                    if (y > 270) {
                        doc.addPage();
                        pageFill();
                        y = 16;
                    }
                    doc.setFont('courier', 'normal');
                    doc.setFontSize(7.5);
                    doc.setTextColor(...FG);
                    const lbl = a.nombre.length > 28 ? a.nombre.slice(0, 26) + '…' : a.nombre;
                    doc.text(lbl, M, y + 2.5);
                    const fill = Math.round((a.total / maxA) * aw);
                    doc.setFillColor(...BG3);
                    doc.rect(M + 46, y - 1, aw, 5, 'F');
                    doc.setFillColor(74, 52, 104);
                    doc.rect(M + 46, y - 1, fill, 5, 'F');
                    doc.setFillColor(...PV);
                    doc.rect(M + 46 + fill - 1.5, y - 1, 1.5, 5, 'F');
                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(7);
                    doc.setTextColor(...PV);
                    doc.text(String(a.total), M + 46 + aw + 3, y + 2.5);
                    y += 8;
                });
            } else {
                doc.setFont('courier', 'normal');
                doc.setFontSize(8);
                doc.setTextColor(...FG);
                doc.text('SIN DATOS', M, y);
                y += 8;
            }
            y += 4;

            /* ── Directores más gustados ── */
            section('DIRECTORES MÁS GUSTADOS');
            const directores = repData.top_directores ?? [];
            if (directores.length) {
                const maxD = directores[0].total || 1;
                const dw = W - M * 2 - 50;
                directores.slice(0, 8).forEach(d => {
                    if (y > 270) {
                        doc.addPage();
                        pageFill();
                        y = 16;
                    }
                    doc.setFont('courier', 'normal');
                    doc.setFontSize(7.5);
                    doc.setTextColor(...FG);
                    const lbl = d.nombre.length > 28 ? d.nombre.slice(0, 26) + '…' : d.nombre;
                    doc.text(lbl, M, y + 2.5);
                    const fill = Math.round((d.total / maxD) * dw);
                    doc.setFillColor(...BG3);
                    doc.rect(M + 46, y - 1, dw, 5, 'F');
                    doc.setFillColor(30, 70, 40);
                    doc.rect(M + 46, y - 1, fill, 5, 'F');
                    doc.setFillColor(...PG);
                    doc.rect(M + 46 + fill - 1.5, y - 1, 1.5, 5, 'F');
                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(7);
                    doc.setTextColor(...PG);
                    doc.text(String(d.total), M + 46 + dw + 3, y + 2.5);
                    y += 8;
                });
            } else {
                doc.setFont('courier', 'normal');
                doc.setFontSize(8);
                doc.setTextColor(...FG);
                doc.text('SIN DATOS', M, y);
            }

            /* ── Footer ── */
            const totalPages = doc.internal.getNumberOfPages();
            for (let i = 1; i <= totalPages; i++) {
                doc.setPage(i);
                doc.setFillColor(...BG3);
                doc.rect(0, 290, W, 7, 'F');
                doc.setDrawColor(...PV);
                doc.setLineWidth(.3);
                doc.line(0, 290, W, 290);
                doc.setFont('courier', 'normal');
                doc.setFontSize(6);
                doc.setTextColor(...FG);
                doc.text('PIXELVHS  ·  PANEL DE ADMINISTRACIÓN  ·  CONFIDENCIAL', M, 294.5);
                doc.text(`${i} / ${totalPages}`, W - M, 294.5, {
                    align: 'right'
                });
            }

            /* ── Guardar ── */
            const ts = new Date().toISOString().slice(0, 10).replace(/-/g, '');
            doc.save(`PIXELVHS_REPORTE_${ts}.pdf`);

            btn.disabled = false;
            btn.innerHTML = '↓ &nbsp;EXPORTAR PDF';

            alertaRetro({
                titulo: 'PDF GENERADO',
                texto: '<p>El reporte fue exportado correctamente.</p>',
                icono: 'success'
            });
        }

        const _navigateOriginal = window.navigate;
        window.navigate = function(view, el) {
            _navigateOriginal?.(view, el);
            if (view === 'rentas' && !rentasData.length) rentasCargar();
            if (view === 'reportes' && !repData) reportesCargar();
            if (view === 'peliculas' && !pelData.length)   peliculasCargar();
        };
        let pelData    = [];
let pelFilt_   = [];
let pelVista   = 'grid';


const PEL_IMG_BASE = '/PixelVHS/public/storage/';
const PEL_FALLBACK = `data:image/svg+xml,${encodeURIComponent(`
<svg xmlns="http://www.w3.org/2000/svg" width="180" height="260" viewBox="0 0 180 260">
  <rect width="180" height="260" fill="#151515"/>
  <rect x="0" y="0" width="3" height="260" fill="#4A3468"/>
  <text x="90" y="110" text-anchor="middle" font-family="monospace"
        font-size="32" fill="#4A3468">▶</text>
  <text x="90" y="150" text-anchor="middle" font-family="monospace"
        font-size="9" fill="#333" letter-spacing="2">SIN PORTADA</text>
</svg>`)}`;

async function peliculasCargar() {
    document.getElementById('pel-grid').innerHTML = `
        <div style="grid-column:1/-1;text-align:center;padding:40px;
            font-family:var(--fm);font-size:9px;color:var(--g);">
            <span class="spinner"></span> &nbsp;CARGANDO...
        </div>`;

    try {
        const res = await fetch('{{ route("admin.peliculas.index") }}', {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        });
        const data = await res.json();
        pelData   = data.peliculas ?? [];
        pelFilt_  = [...pelData];

        // Poblar filtro de géneros
        const generos = [...new Set(pelData.map(p => p.genero).filter(Boolean))].sort();
        const selG = document.getElementById('pel-genero');
        generos.forEach(g => {
            const o = document.createElement('option');
            o.value = g; o.textContent = g;
            selG.appendChild(o);
        });

        // Badge sidebar
        const nb = document.getElementById('nb-peliculas');
        if (nb) nb.textContent = String(pelData.length).padStart(2, '0');

        pelRenderizar();

    } catch (e) {
        document.getElementById('pel-grid').innerHTML = `
            <div style="grid-column:1/-1;text-align:center;padding:40px;
                font-family:var(--fm);font-size:9px;color:var(--red);">
                ERROR AL CARGAR PELÍCULAS
            </div>`;
    }
}

function pelFiltrar() {
    const q = document.getElementById('pel-search').value.toLowerCase().trim();
    const g = document.getElementById('pel-genero').value;
    pelFilt_ = pelData.filter(p => {
        const okQ = !q || p.titulo.toLowerCase().includes(q) ||
                    (p.director ?? '').toLowerCase().includes(q);
        const okG = !g || p.genero === g;
        return okQ && okG;
    });
    pelRenderizar();
}

function pelSetVista(v) {
    pelVista = v;
    document.getElementById('btn-grid-view').style.borderColor =
        v === 'grid' ? 'var(--v)' : 'var(--g-dark)';
    document.getElementById('btn-grid-view').style.color =
        v === 'grid' ? 'var(--v)' : 'var(--g)';
    document.getElementById('btn-list-view').style.borderColor =
        v === 'lista' ? 'var(--v)' : 'var(--g-dark)';
    document.getElementById('btn-list-view').style.color =
        v === 'lista' ? 'var(--v)' : 'var(--g)';
    document.getElementById('pel-grid').style.display = v === 'grid' ? 'grid' : 'none';
    document.getElementById('pel-list').style.display = v === 'lista' ? 'block' : 'none';
    pelRenderizar();
}

function pelRenderizar() {
    const n = pelFilt_.length;
    document.getElementById('pel-count').textContent = n;
    document.getElementById('pel-list-count') &&
        (document.getElementById('pel-list-count').textContent = `${n} TÍTULOS`);

    if (pelVista === 'grid') pelRenderGrid();
    else pelRenderLista();
}

function pelRenderGrid() {
    const grid = document.getElementById('pel-grid');
    if (!pelFilt_.length) {
        grid.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding:40px;
            font-family:var(--fm);font-size:9px;color:var(--g);">
            SIN RESULTADOS</div>`;
        return;
    }

    grid.innerHTML = pelFilt_.map(p => {
        const img = p.foto_portada
            ? `${PEL_IMG_BASE}${p.foto_portada}`
            : PEL_FALLBACK;
        return `
        <div class="pel-card" onclick="pelVerDetalle(${p.id_pelicula})"
            style="cursor:pointer;background:var(--ink3);border:1px solid rgba(255,255,255,.04);
                position:relative;overflow:hidden;transition:all .2s;group"
            onmouseover="this.style.borderColor='rgba(123,94,167,.4)';
                         this.querySelector('.pel-overlay').style.opacity='1'"
            onmouseout="this.style.borderColor='rgba(255,255,255,.04)';
                        this.querySelector('.pel-overlay').style.opacity='0'">

            {{-- Portada --}}
            <div style="position:relative;aspect-ratio:2/3;overflow:hidden;background:#0a0a0a;">
                <img src="${img}"
                    onerror="this.src='${PEL_FALLBACK}'"
                    style="width:100%;height:100%;object-fit:cover;
                           transition:transform .4s;display:block;"
                    onmouseover="this.style.transform='scale(1.06)'"
                    onmouseout="this.style.transform='scale(1)'">

                {{-- Overlay hover --}}
                <div class="pel-overlay" style="position:absolute;inset:0;
                    background:linear-gradient(to top,rgba(7,5,15,.95) 0%,rgba(7,5,15,.3) 60%,transparent 100%);
                    opacity:0;transition:opacity .25s;display:flex;flex-direction:column;
                    justify-content:flex-end;padding:12px;">
                    <span style="font-family:var(--fm);font-size:7px;letter-spacing:2px;
                        color:var(--v);margin-bottom:4px;">◈ VER DETALLE</span>
                </div>

                {{-- Año badge --}}
                <div style="position:absolute;top:8px;right:8px;
                    background:rgba(123,94,167,.85);backdrop-filter:blur(4px);
                    font-family:var(--fo);font-size:7px;letter-spacing:1px;
                    color:var(--w);padding:2px 7px;">
                    ${p.anio ?? '—'}
                </div>
            </div>

            {{-- Info --}}
            <div style="padding:10px 12px 12px;">
                <div style="font-family:var(--fh);font-size:13px;letter-spacing:2px;
                    color:var(--w);line-height:1.2;margin-bottom:4px;
                    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"
                    title="${p.titulo}">
                    ${p.titulo}
                </div>
                <div style="font-family:var(--fm);font-size:8px;letter-spacing:1px;
                    color:var(--v-dim);white-space:nowrap;overflow:hidden;
                    text-overflow:ellipsis;" title="${p.genero ?? ''}">
                    ${p.genero ?? '—'}
                </div>
                ${p.director ? `
                <div style="font-family:var(--fm);font-size:7px;letter-spacing:1px;
                    color:var(--g);margin-top:3px;white-space:nowrap;overflow:hidden;
                    text-overflow:ellipsis;">DIR. ${p.director}</div>` : ''}
            </div>

            {{-- Barra lateral morada --}}
            <div style="position:absolute;top:0;left:0;width:2px;height:100%;
                background:var(--v-dim);"></div>
        </div>`;
    }).join('');
}

function pelRenderLista() {
    const tbody = document.getElementById('pel-tbody');
    if (!pelFilt_.length) {
        tbody.innerHTML = `<tr class="no-results"><td colspan="7">SIN RESULTADOS</td></tr>`;
        return;
    }
    tbody.innerHTML = pelFilt_.map(p => {
        const img = p.foto_portada ? `${PEL_IMG_BASE}${p.foto_portada}` : PEL_FALLBACK;
        return `
        <tr style="cursor:pointer;" onclick="pelVerDetalle(${p.id_pelicula})"
            onmouseover="this.style.background='rgba(123,94,167,.08)'"
            onmouseout="this.style.background=''">
            <td class="id-cell">${String(p.id_pelicula).padStart(3,'0')}</td>
            <td style="padding:6px 16px;">
                <img src="${img}" onerror="this.src='${PEL_FALLBACK}'"
                    style="width:32px;height:46px;object-fit:cover;
                           border:1px solid rgba(123,94,167,.2);display:block;">
            </td>
            <td class="name-cell">${p.titulo}</td>
            <td style="font-family:var(--fo);font-size:9px;color:var(--v);">${p.anio ?? '—'}</td>
            <td style="font-family:var(--fm);font-size:9px;color:var(--v-dim);">
                ${p.genero ?? '—'}
            </td>
            <td style="font-size:12px;color:#b0b0b0;">${p.director ?? '—'}</td>
            <td style="font-family:var(--fm);font-size:9px;color:var(--g);">
                ${p.duracion ? p.duracion + ' MIN' : '—'}
            </td>
        </tr>`;
    }).join('');
}

async function pelVerDetalle(id) {
    const modal = document.getElementById('modal-pelicula');
    const body  = document.getElementById('pel-modal-body');
    body.innerHTML = `<div style="text-align:center;padding:40px;">
        <span class="spinner"></span></div>`;
    modal.classList.add('open');

    const p = pelData.find(x => x.id_pelicula == id);
    if (!p) { body.innerHTML = `<p style="color:var(--red)">NO ENCONTRADO</p>`; return; }

    const img = p.foto_portada ? `${PEL_IMG_BASE}${p.foto_portada}` : PEL_FALLBACK;

    body.innerHTML = `
    <div style="display:grid;grid-template-columns:160px 1fr;gap:24px;align-items:start;">
        <div>
            <img src="${img}" onerror="this.src='${PEL_FALLBACK}'"
                style="width:160px;height:230px;object-fit:cover;
                       border:1px solid rgba(123,94,167,.3);display:block;">
        </div>
        <div style="display:flex;flex-direction:column;gap:10px;">
            <div>
                <div style="font-family:var(--fh);font-size:22px;letter-spacing:4px;
                    color:var(--w);line-height:1.1;">${p.titulo}</div>
                <div style="font-family:var(--fo);font-size:9px;letter-spacing:2px;
                    color:var(--v);margin-top:4px;">${p.anio ?? '—'}</div>
            </div>
            ${[
                ['GÉNERO',    p.genero   ?? '—'],
                ['DIRECTOR',  p.director ?? '—'],
                ['DURACIÓN',  p.duracion ? p.duracion + ' MIN' : '—'],
            ].map(([l,v]) => `
            <div style="display:flex;justify-content:space-between;
                padding:6px 0;border-bottom:1px solid rgba(255,255,255,.04);">
                <span style="font-family:var(--fm);font-size:8px;
                    letter-spacing:2px;color:var(--g);">${l}</span>
                <span style="font-family:var(--fu);font-size:13px;
                    color:var(--w);">${v}</span>
            </div>`).join('')}
        </div>
    </div>
    ${p.sinopsis ? `
    <div style="margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,.05);">
        <div style="font-family:var(--fm);font-size:8px;letter-spacing:3px;
            color:var(--v-dim);margin-bottom:10px;">// SINOPSIS</div>
        <div style="font-family:var(--fu);font-size:13px;color:#b0b0b0;
            line-height:1.7;">${p.sinopsis}</div>
    </div>` : ''}`;
}

function pelCloseModal() {
    document.getElementById('modal-pelicula').classList.remove('open');
}
document.getElementById('modal-pelicula')?.addEventListener('click', function(e) {
    if (e.target === this) pelCloseModal();
});

    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/alertas.js') }}"></script>
</body>

</html>