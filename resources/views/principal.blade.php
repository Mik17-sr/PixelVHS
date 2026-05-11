<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BEBOP VIDEO - Renta de Películas</title>
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Share+Tech+Mono&family=Bebas+Neue&family=Rajdhani:wght@400;600&display=swap" rel="stylesheet">
<style>
  :root {
    --v:      #7B5EA7;
    --v-dim:  #4A3468;
    --v-soft: rgba(123,94,167,0.15);
    --v-glow: rgba(123,94,167,0.4);
    --w:      #DEDEDE;
    --g:      #666;
    --g-dark: #222;
    --ink:    #060606;
    --ink2:   #0E0E0E;
    --ink3:   #151515;
    --fh: 'Bebas Neue', sans-serif;
    --fm: 'Share Tech Mono', monospace;
    --fu: 'Rajdhani', sans-serif;
    --fo: 'Orbitron', sans-serif;
  }

  *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

  body {
    background:var(--ink);
    color:var(--w);
    font-family:var(--fu);
    min-height:100vh;
    overflow-x:hidden;
  }

  body::before {
    content:''; position:fixed; inset:0;
    background:repeating-linear-gradient(
      0deg,transparent,transparent 2px,
      rgba(0,0,0,0.08) 2px,rgba(0,0,0,0.08) 4px
    );
    pointer-events:none; z-index:9999;
  }

  /* ── HEADER ── */
  header {
    position:sticky; top:0; z-index:200;
    height:62px;
    background:rgba(6,6,6,0.97);
    border-bottom:1px solid rgba(123,94,167,0.2);
    display:flex; align-items:center; justify-content:space-between;
    padding:0 52px;
    backdrop-filter:blur(12px);
  }

  .logo { display:flex; align-items:center; gap:13px; }

  .logo-mark {
    width:32px; height:32px;
    border:1.5px solid var(--v);
    display:flex; align-items:center; justify-content:center;
    position:relative; overflow:hidden; flex-shrink:0;
  }
  .logo-mark::before { content:'▶'; color:var(--v); font-size:11px; position:relative; z-index:1; }
  .logo-mark::after {
    content:''; position:absolute;
    top:0; left:-130%; width:55%; height:100%;
    background:linear-gradient(90deg,transparent,rgba(123,94,167,0.3),transparent);
    animation:sheen 4s linear infinite;
  }
  @keyframes sheen { to { left:230%; } }

  .logo-words h1 {
    font-family:var(--fo); font-size:14px; font-weight:900;
    letter-spacing:3.5px; color:var(--w); line-height:1;
  }
  .logo-words h1 em { font-style:normal; color:var(--v); }
  .logo-words small {
    font-family:var(--fm); font-size:8px;
    color:var(--g); letter-spacing:2px; display:block; margin-top:2px;
  }

  .nav-right { display:flex; align-items:center; gap:14px; }

  .ico-btn {
    background:transparent;
    border:1px solid var(--g-dark);
    color:var(--g); font-family:var(--fm); font-size:10px;
    padding:6px 14px; letter-spacing:2px;
    cursor:pointer; transition:all .18s;
    display:flex; align-items:center; gap:6px;
  }
  .ico-btn:hover, .ico-btn.on { border-color:var(--v); color:var(--w); box-shadow:0 0 10px rgba(123,94,167,0.2); }

  /* ── USER DROPDOWN ── */
  .user-menu-container { position:relative; }

  .user-dropdown {
    position:absolute; top:100%; right:0; margin-top:8px;
    background:var(--ink2);
    border:1px solid rgba(123,94,167,0.3);
    border-radius:3px;
    min-width:180px;
    display:none; flex-direction:column;
    box-shadow:0 10px 40px rgba(0,0,0,0.8);
    z-index:300;
  }
  .user-dropdown.active { display:flex; }

  .dropdown-item {
    padding:12px 16px;
    color:var(--w);
    border-bottom:1px solid rgba(255,255,255,0.05);
    cursor:pointer;
    font-family:var(--fu); font-size:11px;
    transition:all .15s;
    display:flex; align-items:center; gap:8px;
  }
  .dropdown-item:last-child { border-bottom:none; }
  .dropdown-item:hover { background:var(--v-soft); color:var(--v); }
  .dropdown-item.logout:hover { background:rgba(200,50,50,0.2); color:#ff6b6b; }

  /* ── SEARCH PANEL ── */
  .search-panel {
    overflow:hidden; max-height:0;
    background:var(--ink2);
    border-bottom:1px solid transparent;
    transition:max-height .32s cubic-bezier(.4,0,.2,1),border-color .32s,padding .32s;
    padding:0 52px;
  }
  .search-panel.open { max-height:68px; padding:13px 52px; border-color:rgba(123,94,167,0.12); }

  .s-wrap { position:relative; max-width:520px; }
  .s-wrap::before { content:'⌕'; position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:14px; color:var(--v-dim); pointer-events:none; }
  .s-input {
    width:100%; background:var(--ink3);
    border:1px solid var(--g-dark); border-left:2px solid var(--v);
    color:var(--w); font-family:var(--fm); font-size:12px;
    padding:9px 14px 9px 34px; outline:none; letter-spacing:1px; transition:all .2s;
  }
  .s-input:focus { border-color:var(--v); box-shadow:0 0 0 1px rgba(123,94,167,0.2); }
  .s-input::placeholder { color:#2a2a2a; }

  /* ── SEARCH RESULTS DROPDOWN ── */
  .search-results {
    position:absolute; top:100%; left:0; right:0;
    background:var(--ink2);
    border:1px solid rgba(123,94,167,0.3); border-top:none;
    max-height:400px; overflow-y:auto;
    display:none; z-index:250;
  }
  .search-results.active { display:block; }

  .search-result-item {
    padding:10px 16px;
    border-bottom:1px solid rgba(255,255,255,0.03);
    cursor:pointer; transition:all .15s;
  }
  .search-result-item:hover { background:var(--v-soft); }
  .result-title { color:var(--w); font-weight:600; font-size:12px; }
  .result-genre { color:var(--g); font-size:10px; margin-top:3px; }

  /* ── BROWSE ── */
  .browse { background:var(--ink2); border-bottom:1px solid rgba(255,255,255,0.04); }
  .browse-trigger {
    display:flex; align-items:center; justify-content:space-between;
    padding:0 52px; height:42px; cursor:pointer; user-select:none; transition:background .18s;
  }
  .browse-trigger:hover { background:var(--v-soft); }
  .browse-lbl {
    font-family:var(--fm); font-size:10px; color:var(--g); letter-spacing:3px;
    display:flex; align-items:center; gap:9px;
  }
  .browse-lbl::before { content:''; width:10px; height:1px; background:var(--v-dim); }
  .chev { font-size:9px; color:var(--v-dim); transition:transform .28s ease; }
  .chev.open { transform:rotate(180deg); }
  .genre-panel {
    overflow:hidden; max-height:0; background:var(--ink3);
    border-top:1px solid rgba(255,255,255,0.03);
    transition:max-height .3s cubic-bezier(.4,0,.2,1),padding .3s; padding:0 52px;
  }
  /* CORREGIDO: max-height alineado con v2 (64px) */
  .genre-panel.open { max-height:64px; padding:11px 52px; }
  .tags { display:flex; gap:6px; flex-wrap:wrap; }
  .tag {
    font-family:var(--fu); font-size:10px; font-weight:600;
    letter-spacing:2px; padding:4px 13px;
    border:1px solid var(--g-dark); background:transparent; color:var(--g);
    cursor:pointer; transition:all .15s; text-transform:uppercase;
  }
  .tag:hover { color:var(--w); border-color:#444; }
  .tag.on { background:var(--v); color:var(--w); border-color:var(--v); }

  /* ── SHELVES ── */
  /* CORREGIDO: padding-bottom alineado con v2 (64px) */
  .movies-main { padding:30px 0 64px; }

  .shelf { margin-bottom:44px; }

  .shelf-head {
    display:flex; align-items:center; justify-content:space-between;
    padding:0 52px; margin-bottom:14px;
  }
  .shelf-head h2 { font-family:var(--fh); font-size:20px; letter-spacing:5px; color:var(--w); }
  .shelf-head span {
    font-family:var(--fm); font-size:9px; color:var(--v-dim); letter-spacing:1px;
    cursor:pointer; transition:color .15s;
  }
  .shelf-head span:hover { color:var(--v); }

  /* CORREGIDO: popular-grid con width y box-sizing alineados a v2 */
  .popular-grid {
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:5px;
    padding:10px 52px 18px;
    width:100%;
    box-sizing:border-box;
  }
  .popular-grid .card { width:100%; flex:none; }

  /* Scroll horizontal para otras shelves */
  .scroll-row {
    display:flex; gap:5px;
    overflow-x:auto; overflow-y:visible;
    padding:10px 52px 18px;
    scroll-snap-type:x mandatory;
    -webkit-overflow-scrolling:touch;
    scrollbar-width:none;
  }
  .scroll-row::-webkit-scrollbar { display:none; }
  .scroll-row .card { flex:0 0 160px; scroll-snap-align:start; }

  /* ── GRID FILTRADO ── */
  .grid-section {
    padding:0 52px 60px;
    display:none;
  }
  .grid-head {
    display:flex; align-items:baseline; gap:10px;
    margin-bottom:16px; padding-top:8px;
  }
  .grid-head h2 { font-family:var(--fh); font-size:20px; letter-spacing:5px; color:var(--w); }
  .grid-head span { font-family:var(--fm); font-size:9px; color:var(--g); letter-spacing:1px; }

  .grid { display:grid; grid-template-columns:repeat(5,1fr); gap:5px; }

  /* ── CARD ── */
  .card {
    position:relative; background:var(--ink3);
    cursor:pointer; overflow:visible;
    transition:transform .3s cubic-bezier(.25,.46,.45,.94),box-shadow .3s ease,z-index 0s .3s;
    z-index:1;
  }
  .card:hover {
    transform:scale(1.09);
    box-shadow:0 28px 60px rgba(0,0,0,0.95),0 0 0 1px rgba(123,94,167,0.3),0 0 36px rgba(123,94,167,0.1);
    z-index:20;
    transition:transform .3s cubic-bezier(.25,.46,.45,.94),box-shadow .3s ease,z-index 0s;
  }
  .card:hover .thumb { transform:scale(1.07); filter:sepia(12%) contrast(1.06) brightness(0.65); }
  .card:hover .strip { opacity:0; }
  .card:hover .hpanel { opacity:1; transform:translateY(0); }

  .tw { position:relative; overflow:hidden; }
  .thumb {
    width:100%; aspect-ratio:2/3; object-fit:cover; display:block;
    filter:sepia(16%) contrast(1.04) brightness(0.82);
    transition:transform .45s ease,filter .4s ease;
  }
  .tw::after {
    content:''; position:absolute; inset:0;
    background:repeating-linear-gradient(0deg,transparent,transparent 3px,rgba(0,0,0,0.07) 3px,rgba(0,0,0,0.07) 4px);
    pointer-events:none; z-index:1;
  }

  .strip {
    position:absolute; bottom:0; left:0; width:100%;
    background:linear-gradient(to top,rgba(6,6,6,1) 0%,rgba(6,6,6,.65) 38%,transparent 100%);
    padding:32px 11px 11px; z-index:2; transition:opacity .18s;
  }
  .strip h3 { font-family:var(--fh); font-size:13px; letter-spacing:2px; color:var(--w); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
  .strip .yr { font-family:var(--fm); font-size:8px; color:var(--g); margin-top:1px; }

  .hpanel {
    position:absolute; bottom:0; left:0; width:100%;
    background:linear-gradient(to top,rgba(6,6,6,1) 0%,rgba(8,6,12,.97) 50%,rgba(14,8,22,.5) 78%,transparent 100%);
    padding:46px 11px 13px;
    opacity:0; transform:translateY(6px);
    transition:opacity .28s ease,transform .28s ease; z-index:3;
  }
  .hpanel h3 { font-family:var(--fh); font-size:16px; letter-spacing:2px; color:var(--w); margin-bottom:2px; }
  .hpanel p  { font-family:var(--fm); font-size:9px; color:var(--g); letter-spacing:1px; margin-bottom:10px; }

  .acts { display:flex; align-items:center; gap:5px; }
  .btn-info {
    font-family:var(--fo); font-size:7px; letter-spacing:2px;
    color:var(--w); background:var(--v);
    border:none; padding:7px 12px; cursor:pointer; transition:all .18s;
  }
  .btn-info:hover { background:#9370C8; box-shadow:0 0 14px var(--v-glow); }
  .btn-wish {
    font-size:12px; color:var(--g); background:transparent;
    border:1px solid var(--g-dark); padding:5px 8px;
    cursor:pointer; transition:all .18s; line-height:1;
  }
  .btn-wish:hover { border-color:var(--v); color:var(--v); }

  /* ── BADGES ── */
  .b-rating {
    position:absolute; top:8px; right:8px;
    background:rgba(6,6,6,0.85); border:1px solid rgba(123,94,167,0.4);
    font-family:var(--fo); font-size:7px; color:var(--v);
    padding:2px 6px; letter-spacing:1px; z-index:4;
  }
  .b-genre {
    position:absolute; top:8px; left:8px;
    background:rgba(6,6,6,0.78); border-left:2px solid var(--v-dim);
    font-family:var(--fm); font-size:7px; color:var(--g);
    padding:2px 7px; letter-spacing:2px; text-transform:uppercase; z-index:4;
  }
  .b-rented {
    position:absolute; top:50%; left:50%;
    transform:translate(-50%,-50%) rotate(-15deg);
    font-family:var(--fh); font-size:20px; letter-spacing:4px;
    color:var(--v); border:2px solid var(--v); padding:4px 10px;
    opacity:.85; text-shadow:0 0 14px var(--v-glow); box-shadow:0 0 16px var(--v-glow);
    z-index:5; pointer-events:none;
  }

  /* ── VINTAGE REVIEW BLOCK ── */
  .review-block {
    margin-bottom:28px;
    border-left:2px solid var(--v-dim);
    padding:14px 18px;
    background:rgba(123,94,167,0.05);
  }
  .review-block::before {
    content:'RESEÑA CRÍTICA';
    font-family:var(--fm); font-size:8px; letter-spacing:3px;
    color:var(--v-dim); display:block; margin-bottom:10px;
  }
  .stars-row { display:flex; align-items:center; gap:10px; margin-bottom:10px; }
  .stars { display:flex; gap:3px; }
  .star { font-size:13px; color:var(--g-dark); }
  .star.on { color:var(--v); text-shadow:0 0 8px var(--v-glow); }
  .score-num { font-family:var(--fo); font-size:11px; color:var(--v); letter-spacing:1px; }
  .verdict-pill {
    font-family:var(--fm); font-size:8px; letter-spacing:2px;
    color:var(--w); border:1px solid var(--v-dim);
    padding:2px 8px; margin-left:4px;
    background:rgba(123,94,167,0.12);
  }
  .review-quote {
    font-family:var(--fm); font-size:11px; color:#aaa;
    line-height:1.65; font-style:italic; letter-spacing:.3px; margin-bottom:8px;
  }
  .review-quote::before { content:'" '; color:var(--v); }
  .review-quote::after  { content:' "'; color:var(--v); }
  .review-critic { font-family:var(--fm); font-size:8px; color:var(--g); letter-spacing:2px; }

  /* ── EMPTY STATE ── */
  .empty-state {
    text-align:center; padding:40px 20px;
    color:var(--g); font-family:var(--fm); font-size:12px; letter-spacing:2px;
  }

  /* ── FOOTER ── */
  footer {
    background:var(--ink2); border-top:1px solid rgba(123,94,167,0.1);
    padding:18px 52px; display:flex; align-items:center; justify-content:space-between;
  }
  footer p { font-family:var(--fm); font-size:9px; color:#2a2a2a; letter-spacing:2px; }
  .foot-logo { font-family:var(--fo); font-size:9px; letter-spacing:3px; color:var(--v-dim); }

  /* ══ VHS INSERT ANIMATION ══ */
  .detail-overlay {
    position:fixed; inset:0; z-index:1000;
    background:rgba(4,3,8,0.0);
    display:none;
    transition:background .4s ease;
  }
  .detail-overlay.visible { background:rgba(4,3,8,0.92); }

  /* CORREGIDO: dimensiones del cassette alineadas con v2 (220×72px, translateY -160px) */
  .vhs-loader {
    position:fixed; top:0; left:50%; transform:translateX(-50%) translateY(-160px);
    z-index:1100; width:220px;
    display:none;
    flex-direction:column; align-items:center;
    animation:none;
  }

  /* CORREGIDO: vhs-body 220×72px igual que v2 */
  .vhs-body {
    width:220px; height:72px;
    background:linear-gradient(180deg,#1a1422 0%,#0e0c18 100%);
    border:1.5px solid var(--v-dim);
    border-radius:4px 4px 8px 8px;
    position:relative;
    box-shadow:0 0 24px rgba(123,94,167,0.3), inset 0 1px 0 rgba(255,255,255,0.05);
    display:flex; align-items:center; justify-content:center;
  }

  /* CORREGIDO: vhs-label dimensiones iguales a v2 */
  .vhs-label {
    position:absolute; top:7px; left:12px; right:12px; height:28px;
    background:linear-gradient(135deg,#1e1630,#281e42);
    border:1px solid var(--v-dim);
    display:flex; align-items:center; justify-content:space-between;
    padding:0 8px;
  }
  .vhs-label-title {
    font-family:var(--fo); font-size:7px; letter-spacing:2px; color:var(--v); white-space:nowrap; overflow:hidden;
  }
  .vhs-label-year { font-family:var(--fm); font-size:8px; color:var(--g); }

  .vhs-reels {
    position:absolute; bottom:7px; left:0; right:0;
    display:flex; justify-content:space-around; padding:0 18px;
  }
  /* CORREGIDO: vhs-reel 22×22px, ::after inset:4px, igual que v2 */
  .vhs-reel {
    width:22px; height:22px; border-radius:50%;
    border:1.5px solid var(--v-dim);
    background:radial-gradient(circle,#0a0814 40%,#1a1428 100%);
    position:relative;
  }
  .vhs-reel::after {
    content:''; position:absolute; inset:4px; border-radius:50%;
    background:var(--v-dim); opacity:.3;
  }
  /* CORREGIDO: velocidad de spin 0.8s igual que v2 */
  .reel-spin { animation:spin .8s linear infinite; }
  @keyframes spin { to { transform:rotate(360deg); } }

  /* CORREGIDO: vhs-slot 240×8px igual que v2 */
  .vhs-slot {
    position:fixed; top:0; left:50%; transform:translateX(-50%);
    width:240px; height:8px; z-index:1050;
    display:none;
  }
  .vhs-slot-inner {
    width:100%; height:100%;
    background:linear-gradient(180deg,#0a0814,#060608);
    border:1px solid var(--v-dim); border-top:none;
    border-radius:0 0 3px 3px;
    box-shadow:inset 0 2px 6px rgba(0,0,0,0.8);
  }

  /* CORREGIDO: keyframes de cassette-insert alineados con v2 */
  @keyframes cassette-insert {
    0%   { transform:translateX(-50%) translateY(-160px); opacity:0; }
    15%  { opacity:1; }
    60%  { transform:translateX(-50%) translateY(0px); }
    75%  { transform:translateX(-50%) translateY(-6px); }
    85%  { transform:translateX(-50%) translateY(-1px); }
    100% { transform:translateX(-50%) translateY(-80px); opacity:0; }
  }

  /* CORREGIDO: slot-glow intensidad alineada con v2 (12px / 4px) */
  @keyframes slot-glow {
    0%,100% { box-shadow:none; }
    50%     { box-shadow:0 0 12px var(--v-glow), 0 0 4px var(--v); }
  }

  /* ── DETAIL PANEL ── */
  .detail-panel {
    position:fixed; inset:0; z-index:1001;
    display:none; overflow-y:auto;
    opacity:0; transform:scale(.97);
    transition:opacity .5s ease, transform .5s ease;
  }
  .detail-panel.show { opacity:1; transform:scale(1); }

  .detail-backdrop {
    position:fixed; inset:0; z-index:0;
    background-size:cover; background-position:center;
    filter:blur(40px) brightness(0.18) saturate(1.4);
    transform:scale(1.08);
    transition:background-image .3s;
  }
  .detail-backdrop::after {
    content:''; position:absolute; inset:0;
    background:radial-gradient(ellipse at center,transparent 20%,rgba(6,6,6,0.85) 100%);
  }

  .detail-content {
    position:relative; z-index:1;
    min-height:100vh;
    display:flex; flex-direction:column;
  }

  .detail-topbar {
    display:flex; align-items:center; justify-content:space-between;
    padding:20px 52px 0;
    flex-shrink:0;
  }

  .back-btn {
    font-family:var(--fm); font-size:11px; color:var(--g); letter-spacing:2px;
    background:transparent; border:1px solid var(--g-dark);
    padding:7px 16px; cursor:pointer; transition:all .18s;
    display:flex; align-items:center; gap:8px;
  }
  .back-btn:hover { border-color:var(--v); color:var(--w); }
  .back-btn::before { content:'←'; font-size:13px; }

  .detail-logo { font-family:var(--fo); font-size:11px; letter-spacing:3px; color:var(--v-dim); }

  .detail-body {
    display:flex; gap:52px;
    padding:40px 52px 60px;
    flex:1;
    align-items:flex-start;
  }

  .detail-poster {
    flex-shrink:0; width:240px;
    position:relative;
  }
  .detail-poster img {
    width:100%; aspect-ratio:2/3; object-fit:cover; display:block;
    filter:sepia(10%) contrast(1.05);
    box-shadow:0 20px 60px rgba(0,0,0,0.8), 0 0 0 1px rgba(123,94,167,0.2);
  }
  .detail-poster::after {
    content:''; position:absolute; inset:0;
    background:repeating-linear-gradient(
      0deg,transparent,transparent 3px,rgba(0,0,0,0.06) 3px,rgba(0,0,0,0.06) 4px
    );
    pointer-events:none;
  }

  .detail-rented-banner {
    position:absolute; top:50%; left:50%;
    transform:translate(-50%,-50%) rotate(-15deg);
    font-family:var(--fh); font-size:28px; letter-spacing:5px;
    color:var(--v); border:2px solid var(--v); padding:6px 14px;
    opacity:.9; text-shadow:0 0 20px var(--v-glow); box-shadow:0 0 24px var(--v-glow);
    pointer-events:none; z-index:2;
  }

  .detail-info { flex:1; padding-top:8px; }

  .detail-genre-tag {
    font-family:var(--fm); font-size:9px; letter-spacing:3px; color:var(--v);
    border:1px solid var(--v-dim); padding:3px 10px;
    display:inline-block; margin-bottom:16px;
  }

  .detail-title {
    font-family:var(--fh); font-size:62px; letter-spacing:5px;
    color:var(--w); line-height:.95; margin-bottom:14px;
  }

  .detail-meta {
    display:flex; align-items:center; gap:16px; margin-bottom:24px; flex-wrap:wrap;
  }
  .detail-meta span {
    font-family:var(--fm); font-size:10px; color:var(--g); letter-spacing:1px;
  }
  .detail-meta .dot { color:var(--v-dim); }
  .detail-meta .rating-pill {
    border:1px solid rgba(123,94,167,0.4); color:var(--v);
    padding:2px 8px; font-size:9px;
  }

  .detail-divider {
    width:48px; height:1px; background:var(--v-dim); margin-bottom:20px;
  }

  .detail-synopsis-label {
    font-family:var(--fm); font-size:9px; color:var(--v-dim); letter-spacing:3px; margin-bottom:8px;
  }
  .detail-synopsis {
    font-family:var(--fu); font-size:15px; font-weight:400;
    color:#b0b0b0; line-height:1.7; max-width:540px; margin-bottom:28px;
  }

  .detail-stats {
    display:grid; grid-template-columns:repeat(3,1fr); gap:1px;
    background:var(--g-dark); margin-bottom:28px; max-width:440px;
  }
  .stat-cell { background:var(--ink2); padding:14px 16px; }
  .stat-cell .label { font-family:var(--fm); font-size:8px; color:var(--g); letter-spacing:2px; margin-bottom:4px; }
  .stat-cell .value { font-family:var(--fh); font-size:18px; letter-spacing:1px; color:var(--w); }

  .detail-actions { display:flex; gap:10px; align-items:center; }

  .btn-primary {
    font-family:var(--fo); font-size:9px; letter-spacing:2px;
    color:var(--w); background:var(--v);
    border:none; padding:12px 28px; cursor:pointer; transition:all .2s;
  }
  .btn-primary:hover { background:#9370C8; box-shadow:0 0 20px var(--v-glow); }
  .btn-primary.disabled {
    background:var(--g-dark); color:var(--g); cursor:not-allowed; box-shadow:none;
  }

  .btn-secondary {
    font-family:var(--fo); font-size:9px; letter-spacing:2px;
    color:var(--g); background:transparent;
    border:1px solid var(--g-dark); padding:11px 20px;
    cursor:pointer; transition:all .2s;
  }
  .btn-secondary:hover { border-color:var(--v); color:var(--w); }

  .detail-panel::before {
    content:''; position:fixed; inset:0; z-index:2;
    background:repeating-linear-gradient(
      0deg,transparent,transparent 2px,rgba(0,0,0,0.07) 2px,rgba(0,0,0,0.07) 4px
    );
    pointer-events:none;
  }

  /* ── RESPONSIVE ── */
  @media(max-width:900px){
    .grid{ grid-template-columns:repeat(3,1fr); }
    .popular-grid{ grid-template-columns:repeat(2,1fr); }
    header,.search-panel,.browse-trigger,.genre-panel,footer,
    .detail-topbar,.detail-body,
    .shelf-head,.popular-grid,.grid-section { padding-left:20px; padding-right:20px; }
    .search-panel.open,.genre-panel.open{ padding-left:20px; padding-right:20px; }
    .scroll-row { padding-left:20px; padding-right:20px; }
    .detail-body { flex-direction:column; gap:28px; }
    .detail-poster { width:180px; }
    .detail-title { font-size:44px; }
  }
  @media(max-width:560px){
    .grid{ grid-template-columns:repeat(2,1fr); gap:3px; }
    .popular-grid{ grid-template-columns:repeat(2,1fr); gap:3px; }
    .logo-words h1{font-size:11px;}
    .detail-stats{grid-template-columns:repeat(2,1fr);}
    .detail-title{font-size:36px;}
  }
</style>
</head>
<body>

{{-- ── PHP / BLADE ── --}}
@php
    $movieMap = [];
    foreach ($peliculasDestacadas as $pelicula) {
        $movieMap[$pelicula->id_pelicula] = [
            'id_pelicula'      => $pelicula->id_pelicula,
            'titulo'           => $pelicula->titulo,
            'resumen'          => $pelicula->resumen,
            'anio_lanzamiento' => $pelicula->anio_lanzamiento,
            'precio_alquiler'  => $pelicula->precio_alquiler,
            'foto_caratula'    => $pelicula->foto_caratula,
            'foto_portada'     => $pelicula->foto_portada,
            'genero'           => $pelicula->genero,
            'director'         => $pelicula->director,
            'actores'          => $pelicula->actores,
            'cintas'           => $pelicula->cintas,
        ];
    }
    foreach ($peliculasPorGenero as $grupoPeliculas) {
        foreach ($grupoPeliculas as $pelicula) {
            $movieMap[$pelicula->id_pelicula] = [
                'id_pelicula'      => $pelicula->id_pelicula,
                'titulo'           => $pelicula->titulo,
                'resumen'          => $pelicula->resumen,
                'anio_lanzamiento' => $pelicula->anio_lanzamiento,
                'precio_alquiler'  => $pelicula->precio_alquiler,
                'foto_caratula'    => $pelicula->foto_caratula,
                'foto_portada'     => $pelicula->foto_portada,
                'genero'           => $pelicula->genero,
                'director'         => $pelicula->director,
                'actores'          => $pelicula->actores,
                'cintas'           => $pelicula->cintas,
            ];
        }
    }
@endphp
<script>window.MOVIE_MAP = @json($movieMap);</script>

<!-- ══ MAIN VIEW ══ -->
<div id="mainView">

  <header>
    <div class="logo">
      <div class="logo-mark"></div>
      <div class="logo-words">
        <h1><em>◈</em>BEBOP</h1>
        <small>VIDEO STORE</small>
      </div>
    </div>
    <div class="nav-right">
      <button class="ico-btn" id="sBtn" onclick="toggleSearch()">⌕ &nbsp;BUSCAR</button>
      <div class="user-menu-container">
        <button class="ico-btn" id="userBtn" onclick="toggleUserMenu()">👤 PERFIL</button>
        <div class="user-dropdown" id="userDropdown">
          <div class="dropdown-item">📋 Ver Perfil</div>
          <div class="dropdown-item">🎬 Mis Películas</div>
          <div class="dropdown-item">📋 Mis Facturas</div>
          <div class="dropdown-item">⚙️ Configuración</div>
          <div class="dropdown-item logout">🚪 Cerrar Sesión</div>
        </div>
      </div>
    </div>
  </header>

  <!-- Búsqueda con resultados en dropdown -->
  <div class="search-panel" id="sPanel">
    <div class="s-wrap">
      <input type="text" id="sInput" class="s-input"
             placeholder="TÍTULO, DIRECTOR, AÑO..."
             oninput="applyFilters()">
      <div class="search-results" id="searchResults"></div>
    </div>
  </div>

  <div class="browse">
    <div class="browse-trigger" onclick="toggleBrowse()">
      <span class="browse-lbl">EXPLORAR GÉNEROS</span>
      <span class="chev" id="chev">▼</span>
    </div>
    <div class="genre-panel" id="gPanel">
      <div class="tags">
        <span class="tag on" onclick="setGenre(this,'all')">TODAS</span>
        @foreach($generos as $genero)
          <span class="tag" onclick="setGenre(this,{{ $genero->id_genero }})">{{ strtoupper($genero->nombre) }}</span>
        @endforeach
      </div>
    </div>
  </div>

  <!-- ══ SHELVES ══ -->
  <div class="movies-main" id="moviesMain">

    <!-- SHELF: DESTACADAS (grid 4 columnas) -->
    <div class="shelf" id="shelfDestacadas">
      <div class="shelf-head">
        <h2>DESTACADAS</h2>
        <span onclick="showAllGrid('DESTACADAS', 'destacadas')">VER TODO →</span>
      </div>
      <div class="popular-grid" id="rowDestacadas">
        @foreach($peliculasDestacadas as $pelicula)
          @php $disponibles = $pelicula->cintas->where('rentada', 0)->count() ?? $pelicula->cintas->count(); @endphp
          <div class="card"
               data-genre="{{ $pelicula->genero->id_genero ?? 'n/a' }}"
               data-title="{{ strtolower($pelicula->titulo) }}"
               data-year="{{ $pelicula->anio_lanzamiento }}"
               onclick="openDetail({{ json_encode($pelicula) }})">
            @if($pelicula->clasificacion)
              <div class="b-rating">{{ $pelicula->clasificacion }}</div>
            @endif
            <div class="b-genre">{{ strtoupper($pelicula->genero->nombre ?? 'N/A') }}</div>
            @if($disponibles === 0)
              <div class="b-rented">NO DISPONIBLE</div>
            @endif
            <div class="tw">
              <img src="{{ asset($pelicula->foto_portada) }}"
                   alt="{{ $pelicula->titulo }}" class="thumb" loading="lazy">
            </div>
            <div class="strip">
              <h3>{{ strtoupper($pelicula->titulo) }}</h3>
              <div class="yr">{{ $pelicula->anio_lanzamiento }}</div>
            </div>
            <div class="hpanel">
              <h3>{{ strtoupper($pelicula->titulo) }}</h3>
              <p>{{ strtoupper($pelicula->genero->nombre ?? 'N/A') }} · {{ $pelicula->anio_lanzamiento }}</p>
              <div class="acts">
                <button class="btn-info" onclick="event.stopPropagation(); openDetail({{ json_encode($pelicula) }})">VER MÁS</button>
                <button class="btn-wish" onclick="event.stopPropagation()">♡</button>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- SHELF: RECIÉN AGREGADAS (scroll horizontal) -->
    <div class="shelf" id="shelfRecientes">
      <div class="shelf-head">
        <h2>RECIÉN AGREGADAS</h2>
        <span onclick="showAllGrid('RECIÉN AGREGADAS', 'recientes')">VER TODO →</span>
      </div>
      <div class="scroll-row" id="rowRecientes">
        @foreach($peliculasDestacadas->sortByDesc('created_at')->take(10) as $pelicula)
          @php $disponibles = $pelicula->cintas->where('rentada', 0)->count() ?? $pelicula->cintas->count(); @endphp
          <div class="card"
               data-genre="{{ $pelicula->genero->id_genero ?? 'n/a' }}"
               data-title="{{ strtolower($pelicula->titulo) }}"
               onclick="openDetail({{ json_encode($pelicula) }})">
            @if($pelicula->clasificacion)
              <div class="b-rating">{{ $pelicula->clasificacion }}</div>
            @endif
            <div class="b-genre">{{ strtoupper($pelicula->genero->nombre ?? 'N/A') }}</div>
            @if($disponibles === 0)
              <div class="b-rented">NO DISPONIBLE</div>
            @endif
            <div class="tw">
              <img src="{{ asset($pelicula->foto_caratula) }}"
                   alt="{{ $pelicula->titulo }}" class="thumb" loading="lazy">
            </div>
            <div class="strip">
              <h3>{{ strtoupper($pelicula->titulo) }}</h3>
              <div class="yr">{{ $pelicula->anio_lanzamiento }}</div>
            </div>
            <div class="hpanel">
              <h3>{{ strtoupper($pelicula->titulo) }}</h3>
              <p>{{ strtoupper($pelicula->genero->nombre ?? 'N/A') }} · {{ $pelicula->anio_lanzamiento }}</p>
              <div class="acts">
                <button class="btn-info" onclick="event.stopPropagation(); openDetail({{ json_encode($pelicula) }})">VER MÁS</button>
                <button class="btn-wish" onclick="event.stopPropagation()">♡</button>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- SHELVES: POR GÉNERO (scroll horizontal) -->
    @foreach($generos as $genero)
      @if(isset($peliculasPorGenero[$genero->nombre]) && $peliculasPorGenero[$genero->nombre]->count() > 0)
        <div class="shelf" id="shelfGenero{{ $genero->id_genero }}">
          <div class="shelf-head">
            <h2>{{ strtoupper($genero->nombre) }}</h2>
            <span onclick="showAllGrid('{{ strtoupper($genero->nombre) }}', {{ $genero->id_genero }})">
              VER TODO → <small style="color:var(--g)">// {{ $peliculasPorGenero[$genero->nombre]->count() }}</small>
            </span>
          </div>
          <div class="scroll-row">
            @foreach($peliculasPorGenero[$genero->nombre] as $pelicula)
              @php $disponibles = $pelicula->cintas->where('rentada', 0)->count() ?? $pelicula->cintas->count(); @endphp
              <div class="card"
                   data-genre="{{ $pelicula->genero->id_genero ?? 'n/a' }}"
                   data-title="{{ strtolower($pelicula->titulo) }}"
                   onclick="openDetail({{ json_encode($pelicula) }})">
                @if($pelicula->clasificacion)
                  <div class="b-rating">{{ $pelicula->clasificacion }}</div>
                @endif
                <div class="b-genre">{{ strtoupper($pelicula->genero->nombre ?? 'N/A') }}</div>
                @if($disponibles === 0)
                  <div class="b-rented">NO DISPONIBLE</div>
                @endif
                <div class="tw">
                  <img src="{{ asset($pelicula->foto_caratula) }}"
                       alt="{{ $pelicula->titulo }}" class="thumb" loading="lazy">
                </div>
                <div class="strip">
                  <h3>{{ strtoupper($pelicula->titulo) }}</h3>
                  <div class="yr">{{ $pelicula->anio_lanzamiento }}</div>
                </div>
                <div class="hpanel">
                  <h3>{{ strtoupper($pelicula->titulo) }}</h3>
                  <p>{{ strtoupper($pelicula->genero->nombre ?? 'N/A') }} · {{ $pelicula->anio_lanzamiento }}</p>
                  <div class="acts">
                    <button class="btn-info" onclick="event.stopPropagation(); openDetail({{ json_encode($pelicula) }})">VER MÁS</button>
                    <button class="btn-wish" onclick="event.stopPropagation()">♡</button>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    @endforeach

  </div><!-- /moviesMain -->

  <!-- ══ GRID FILTRADO ══ -->
  <div class="grid-section" id="gridSection">
    <div class="grid-head">
      <h2 id="gridTitle">TODOS LOS TÍTULOS</h2>
      <span id="gridCnt"></span>
    </div>
    <div class="grid" id="filteredGrid"></div>
  </div>

  <footer>
    <p>// BEBOP VIDEO &nbsp;·&nbsp; EST. 1985 &nbsp;·&nbsp; TODOS LOS DERECHOS RESERVADOS</p>
    <div class="foot-logo">BEBOP VIDEO ◈</div>
  </footer>

</div><!-- /mainView -->

<!-- ══ VHS SLOT ══ -->
<div class="vhs-slot" id="vhsSlot"><div class="vhs-slot-inner"></div></div>

<!-- ══ VHS CASSETTE ══ -->
<div class="vhs-loader" id="vhsLoader">
  <div class="vhs-body">
    <div class="vhs-label">
      <div class="vhs-label-title" id="vhsTitle">TÍTULO</div>
      <div class="vhs-label-year" id="vhsYear">2024</div>
    </div>
    <div class="vhs-reels">
      <div class="vhs-reel reel-spin"></div>
      <div class="vhs-reel reel-spin"></div>
    </div>
  </div>
</div>

<!-- ══ DETAIL OVERLAY ══ -->
<div class="detail-overlay" id="detailOverlay"></div>

<!-- ══ DETAIL PANEL ══ -->
<div class="detail-panel" id="detailPanel">
  <div class="detail-backdrop" id="detailBackdrop"></div>
  <div class="detail-content">

    <div class="detail-topbar">
      <button class="back-btn" onclick="closeDetail()">VOLVER</button>
      <div class="detail-logo">BEBOP VIDEO ◈</div>
    </div>

    <div class="detail-body">
      <div class="detail-poster">
        <img id="detailImg" src="" alt="Poster">
        <div class="detail-rented-banner" id="detailRented" style="display:none">RENTADA</div>
      </div>

      <div class="detail-info">
        <div class="detail-genre-tag" id="detailGenre">GÉNERO</div>
        <h1 class="detail-title" id="detailTitle">TÍTULO</h1>

        <div class="detail-meta">
          <span id="detailDir"></span>
          <span class="dot">·</span>
          <span id="detailYear2"></span>
          <span class="dot">·</span>
          <span id="detailDur"></span>
          <span class="rating-pill" id="detailRat"></span>
        </div>

        <div class="detail-divider"></div>

        <div class="detail-synopsis-label">SINOPSIS</div>
        <p class="detail-synopsis" id="detailSyn"></p>

        <div class="detail-stats" id="detailStats"></div>

        <div class="review-block" id="reviewBlock">
          <div class="stars-row">
            <div class="stars" id="detailStars"></div>
            <span class="score-num" id="detailScore"></span>
            <span class="verdict-pill" id="detailVerdict"></span>
          </div>
          <p class="review-quote" id="detailQuote"></p>
          <div class="review-critic" id="detailCritic"></div>
        </div>

        <div class="detail-actions">
          <button class="btn-primary" id="detailRentBtn" onclick="handleRent(event)">+ RENTAR</button>
          <button class="btn-secondary">♡ GUARDAR</button>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
  let currentMovie  = null;
  let activeGenreId = 'all';
  let filterMode    = false;

  /* ══ USER MENU ══ */
  function toggleUserMenu() {
    document.getElementById('userDropdown').classList.toggle('active');
  }
  document.addEventListener('click', (e) => {
    const uc = document.querySelector('.user-menu-container');
    if (uc && !uc.contains(e.target)) {
      document.getElementById('userDropdown').classList.remove('active');
    }
  });

  /* ══ SEARCH ══ */
  function toggleSearch() {
    const p    = document.getElementById('sPanel');
    const b    = document.getElementById('sBtn');
    const i    = document.getElementById('sInput');
    const open = p.classList.toggle('open');
    b.classList.toggle('on', open);
    if (open) {
      setTimeout(() => i.focus(), 340);
    } else {
      i.value = '';
      document.getElementById('searchResults').classList.remove('active');
      if (filterMode && activeGenreId === 'all') exitFilterMode();
    }
  }

  /* ══ FILTRO COMBINADO (género + texto) ══ */
  function applyFilters() {
    const q = document.getElementById('sInput').value.toLowerCase().trim();

    if (!q && activeGenreId === 'all') {
      exitFilterMode();
      document.getElementById('searchResults').classList.remove('active');
      return;
    }

    const results = Object.values(window.MOVIE_MAP).filter(m => {
      const genreMatch = activeGenreId === 'all' ||
                         String(m.genero?.id_genero) === String(activeGenreId);
      const textMatch  = !q ||
                         m.titulo.toLowerCase().includes(q) ||
                         (m.director?.nombre || '').toLowerCase().includes(q) ||
                         String(m.anio_lanzamiento).includes(q);
      return genreMatch && textMatch;
    });

    enterFilterMode(results, q);
  }

  function enterFilterMode(results, query) {
    filterMode = true;
    document.getElementById('moviesMain').style.display  = 'none';
    document.getElementById('gridSection').style.display = 'block';
    document.getElementById('searchResults').classList.remove('active');

    const n = results.length;
    const label = activeGenreId !== 'all'
      ? document.querySelector(`.tag.on`)?.textContent?.trim() || 'FILTRADO'
      : (query ? `"${query.toUpperCase()}"` : 'TODOS LOS TÍTULOS');

    document.getElementById('gridTitle').textContent = label;
    document.getElementById('gridCnt').textContent   =
      `// ${String(n).padStart(2,'0')} TÍTULO${n !== 1 ? 'S' : ''}`;

    document.getElementById('filteredGrid').innerHTML = results.length
      ? results.map(m => buildCardFromData(m)).join('')
      : `<div class="empty-state" style="grid-column:1/-1">SIN RESULTADOS</div>`;
  }

  function exitFilterMode() {
    filterMode    = false;
    activeGenreId = 'all';
    document.getElementById('moviesMain').style.display  = 'block';
    document.getElementById('gridSection').style.display = 'none';
    document.getElementById('sInput').value = '';
    document.getElementById('searchResults').classList.remove('active');
    document.querySelectorAll('.tag').forEach(t => t.classList.remove('on'));
    const first = document.querySelector('.tag');
    if (first) first.classList.add('on');
  }

  function buildCardFromData(m) {
    const disponibles = (m.cintas || []).filter(c => !c.rentada || c.rentada == 0).length;
    const rented      = disponibles === 0;
    const rentedHtml  = rented ? `<div class="b-rented">NO DISPONIBLE</div>` : '';
    const ratingHtml  = m.clasificacion ? `<div class="b-rating">${m.clasificacion}</div>` : '';
    const img         = m.foto_portada || m.foto_caratula || '';
    const genero      = (m.genero?.nombre || 'N/A').toUpperCase();
    const titulo      = m.titulo.toUpperCase();
    const anio        = m.anio_lanzamiento;
    const dataStr     = JSON.stringify(m).replace(/"/g, '&quot;');

    return `
      <div class="card"
           data-genre="${m.genero?.id_genero ?? ''}"
           data-title="${m.titulo.toLowerCase()}"
           onclick="openDetail(${dataStr})">
        ${ratingHtml}
        <div class="b-genre">${genero}</div>
        ${rentedHtml}
        <div class="tw">
          <img src="${img}" alt="${m.titulo}" class="thumb" loading="lazy">
        </div>
        <div class="strip">
          <h3>${titulo}</h3>
          <div class="yr">${anio}</div>
        </div>
        <div class="hpanel">
          <h3>${titulo}</h3>
          <p>${genero} · ${anio}</p>
          <div class="acts">
            <button class="btn-info" onclick="event.stopPropagation(); openDetail(${dataStr})">VER MÁS</button>
            <button class="btn-wish" onclick="event.stopPropagation()">♡</button>
          </div>
        </div>
      </div>`;
  }

  /* ══ BROWSE ══ */
  function toggleBrowse() {
    document.getElementById('gPanel').classList.toggle('open');
    document.getElementById('chev').classList.toggle('open');
  }

  /* ══ FILTRO POR GÉNERO ══ */
  function setGenre(el, g) {
    document.querySelectorAll('.tag').forEach(t => t.classList.remove('on'));
    el.classList.add('on');
    activeGenreId = g;

    const q = document.getElementById('sInput').value.toLowerCase().trim();

    if (g === 'all' && !q) {
      exitFilterMode();
      return;
    }
    applyFilters();
  }

  /* ══ VER TODO DE UNA SHELF ══ */
  function showAllGrid(label, genreIdOrKey) {
    document.querySelectorAll('.tag').forEach(t => t.classList.remove('on'));
    if (genreIdOrKey !== 'destacadas' && genreIdOrKey !== 'recientes') {
      activeGenreId = genreIdOrKey;
      const matchTag = [...document.querySelectorAll('.tag')].find(
        t => t.getAttribute('onclick')?.includes(`'${genreIdOrKey}'`) ||
             t.getAttribute('onclick')?.includes(`,${genreIdOrKey})`)
      );
      if (matchTag) matchTag.classList.add('on');
    } else {
      activeGenreId = 'all';
      const first = document.querySelector('.tag');
      if (first) first.classList.add('on');
    }
    applyFilters();
    document.getElementById('gridTitle').textContent = label;
  }

  /* ══ OPEN DETAIL ══ */
  function openDetail(pelicula) {
    currentMovie = pelicula;

    document.getElementById('vhsTitle').textContent =
      pelicula.titulo.length > 16 ? pelicula.titulo.slice(0,16)+'…' : pelicula.titulo;
    document.getElementById('vhsYear').textContent = pelicula.anio_lanzamiento;

    const imgSrc = pelicula.foto_portada || pelicula.foto_caratula || '';
    document.getElementById('detailImg').src = imgSrc;
    document.getElementById('detailBackdrop').style.backgroundImage = `url('${imgSrc}')`;

    document.getElementById('detailTitle').textContent  = pelicula.titulo;
    document.getElementById('detailGenre').textContent  = pelicula.genero?.nombre || 'N/A';
    document.getElementById('detailDir').textContent    = (pelicula.director?.nombre || 'N/A').toUpperCase();
    document.getElementById('detailYear2').textContent  = pelicula.anio_lanzamiento;
    document.getElementById('detailDur').textContent    = pelicula.duracion ? pelicula.duracion + ' MIN' : 'N/A';
    document.getElementById('detailRat').textContent    = pelicula.clasificacion || 'N/A';
    document.getElementById('detailSyn').textContent    = pelicula.resumen || 'Descripción no disponible.';

    const stats = [
      { l:'AÑO',      v: pelicula.anio_lanzamiento },
      { l:'DURACIÓN', v: pelicula.duracion ? pelicula.duracion+' MIN' : 'N/A' },
      { l:'DIRECTOR', v: (pelicula.director?.nombre || 'N/A').toUpperCase() },
      { l:'GÉNERO',   v: (pelicula.genero?.nombre || 'N/A').toUpperCase() },
      { l:'PRECIO',   v: pelicula.precio_alquiler ? '$'+pelicula.precio_alquiler : 'N/A' },
      { l:'CINTAS',   v: pelicula.cintas ? pelicula.cintas.length : '0' }
    ];
    document.getElementById('detailStats').innerHTML =
      stats.map(s => `<div class="stat-cell"><div class="label">${s.l}</div><div class="value">${s.v}</div></div>`).join('');

    const cintas      = pelicula.cintas || [];
    const disponibles = cintas.filter(c => !c.rentada || c.rentada == 0).length;
    const total       = cintas.length;
    const score       = pelicula.puntuacion != null
      ? pelicula.puntuacion
      : (total > 0 ? +(disponibles / total * 5).toFixed(1) : 0);
    const stars   = Math.round(score);
    const verdict = score >= 4.5 ? 'IMPRESCINDIBLE'
                  : score >= 4   ? 'OBRA MAESTRA'
                  : score >= 3   ? 'RECOMENDADA'
                  : score >= 2   ? 'REGULAR'
                  : 'SIN DATOS';

    document.getElementById('detailStars').innerHTML =
      [1,2,3,4,5].map(i => `<span class="star${i<=stars?' on':''}"">★</span>`).join('');
    document.getElementById('detailScore').textContent   = score.toFixed(1)+' / 5.0';
    document.getElementById('detailVerdict').textContent = verdict;
    document.getElementById('detailQuote').textContent   = pelicula.resumen
      ? pelicula.resumen.slice(0,120) + (pelicula.resumen.length > 120 ? '…' : '')
      : 'Sin reseña disponible.';
    document.getElementById('detailCritic').textContent  =
      pelicula.director?.nombre
        ? 'DIR. '+(pelicula.director.nombre).toUpperCase()+' · BEBOP VIDEO'
        : 'BEBOP VIDEO · EST. 1985';

    const rentBtn      = document.getElementById('detailRentBtn');
    const rentedBanner = document.getElementById('detailRented');
    if (disponibles === 0) {
      rentBtn.textContent = 'NO DISPONIBLE';
      rentBtn.classList.add('disabled');
      rentedBanner.style.display = 'block';
    } else {
      rentBtn.textContent = '+ RENTAR';
      rentBtn.classList.remove('disabled');
      rentedBanner.style.display = 'none';
    }

    /* Animación VHS — CORREGIDO: duración 1.4s igual que v2 */
    const loader  = document.getElementById('vhsLoader');
    const slot    = document.getElementById('vhsSlot');
    const overlay = document.getElementById('detailOverlay');
    const panel   = document.getElementById('detailPanel');

    slot.style.display    = 'block';
    slot.style.animation  = 'slot-glow 1s ease-in-out infinite';
    loader.style.display  = 'flex';
    loader.style.animation= 'cassette-insert 1.4s cubic-bezier(.4,0,.2,1) forwards';
    overlay.style.display = 'block';
    requestAnimationFrame(() => overlay.classList.add('visible'));

    /* CORREGIDO: timeout 1350ms alineado con v2 */
    setTimeout(() => {
      loader.style.display = slot.style.display = 'none';
      loader.style.animation = '';
      panel.style.display = 'block';
      document.body.style.overflow = 'hidden';
      requestAnimationFrame(() => panel.classList.add('show'));
    }, 1350);
  }

  /* ══ CLOSE DETAIL ══ */
  function closeDetail() {
    const panel   = document.getElementById('detailPanel');
    const overlay = document.getElementById('detailOverlay');
    panel.classList.remove('show');
    overlay.classList.remove('visible');
    setTimeout(() => {
      panel.style.display = overlay.style.display = 'none';
      document.body.style.overflow = '';
    }, 500);
  }

  /* ══ RENTAR ══ */
  function handleRent(event) {
    event.preventDefault();
    if (!currentMovie) return;
    alert('Funcionalidad de renta será implementada en el controlador');
  }

  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDetail(); });
</script>
</body>
</html>