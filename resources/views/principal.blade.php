<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PIXELVHS - Renta de Películas</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Share+Tech+Mono&family=Bebas+Neue&family=Rajdhani:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="{{ asset('css/alertas.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
    #detailPosterWrap {
      flex-shrink: 0;
      width: 300px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0;
    }

    /* poster default sin cambios de tamaño */
    #posterDefault {
      width: 100%;
      position: relative;
    }

    #posterDefault img {
      width: 100%;
      aspect-ratio: 2/3;
      object-fit: cover;
      display: block;
      filter: sepia(10%) contrast(1.05);
      box-shadow: 0 20px 60px rgba(0, 0, 0, .8), 0 0 0 1px rgba(123, 94, 167, .2);
    }

    #posterDefault::after {
      content: '';
      position: absolute;
      inset: 0;
      background: repeating-linear-gradient(0deg, transparent, transparent 3px, rgba(0, 0, 0, .06) 3px, rgba(0, 0, 0, .06) 4px);
      pointer-events: none;
    }

    /* ─────────────────────────────────────────
   VISOR (reemplaza el poster, mismo ancho)
───────────────────────────────────────── */
    #formatViewer {
      width: 100%;
      min-height: 300px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(6, 6, 6, .7);
      border: 1px solid rgba(123, 94, 167, .15);
      position: relative;
      overflow: hidden;
    }

    .fmt-scene {
      width: 100%;
      height: 100%;
      min-height: 300px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* ─────────────────────────────────────────
   BOTONES DE FORMATO
───────────────────────────────────────── */
    .fmt-btns-row {
      width: 100%;
      display: grid;
      grid-template-columns: 1fr 1fr 1fr 1fr;
      gap: 4px;
      margin-top: 10px;
    }

    .fmt-btn {
      background: transparent;
      border: 1px solid var(--g-dark);
      color: var(--g);
      font-family: var(--fm);
      font-size: 8px;
      letter-spacing: 1.5px;
      padding: 8px 4px;
      cursor: pointer;
      transition: all .18s;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 4px;
      text-transform: uppercase;
    }

    .fmt-btn span {
      font-size: 12px;
      color: var(--v-dim);
      line-height: 1;
      transition: color .18s;
    }

    .fmt-btn:hover {
      border-color: var(--v);
      color: var(--w);
    }

    .fmt-btn:hover span {
      color: var(--v);
    }

    .fmt-btn.active {
      background: var(--v-soft);
      color: var(--w);
      border-color: var(--v);
      box-shadow: 0 0 8px rgba(123, 94, 167, .2);
    }

    .fmt-btn.active span {
      color: var(--v);
    }

    /* ─────────────────────────────────────────
   ESCENAS 3D
  ───────────────────────────────────────── */
    .fv-scene {
      perspective: 1800px;
    }

    /* ══ DVD ══ */
    .dvd-scene {
      perspective: 1800px;
    }

    .fv-dvd {
      position: relative;
      width: 180px;
      height: 262px;
      transform-style: preserve-3d;
      animation: fvDvdSpin 12s linear infinite;
    }

    .fv-dvd:hover {
      animation-play-state: paused;
    }

    .fv-dvd-front,
    .fv-dvd-back,
    .fv-dvd-left,
    .fv-dvd-right,
    .fv-dvd-top,
    .fv-dvd-bottom {
      position: absolute;
      box-shadow: 0 0 20px rgba(0, 0, 0, .5);
      backface-visibility: visible;
    }

    .fv-dvd-front {
      width: 180px;
      height: 262px;
      background-size: cover;
      background-position: center;
      transform: translateZ(14px);
      border-radius: 3px;
    }

    .fv-dvd-back {
      width: 180px;
      height: 262px;
      background-size: cover;
      background-position: center;
      transform: rotateY(180deg) translateZ(14px);
      border-radius: 3px;
      filter: brightness(.7) sepia(.3);
    }

    .fv-dvd-left {
      width: 28px;
      height: 262px;
      background-size: cover;
      background-position: center;
      transform: rotateY(-90deg) translateZ(14px);
    }

    .fv-dvd-right {
      width: 28px;
      height: 262px;
      background: #1a1a1a;
      transform: rotateY(90deg) translateZ(166px);
    }

    .fv-dvd-top {
      width: 180px;
      height: 28px;
      background: #2b2b2b;
      transform: rotateX(90deg) translateZ(14px);
    }

    .fv-dvd-bottom {
      width: 180px;
      height: 28px;
      background: #111;
      transform: rotateX(-90deg) translateZ(248px);
    }

    @keyframes fvDvdSpin {
      from {
        transform: rotateX(-8deg) rotateY(-15deg);
        /* ángulo ligero, portada visible */
      }

      to {
        transform: rotateX(-8deg) rotateY(345deg);
      }
    }

    /* ══ DISCO (Blu-ray / UHD) ══ */
    .disc-scene {
      perspective: 1600px;
    }

    .fv-disc-glow {
      position: absolute;
      width: 300px;
      height: 300px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(150, 150, 160, .04), transparent 70%);
      filter: blur(30px);
      z-index: -1;
      opacity: .5;
      pointer-events: none;
    }

    .fv-disc {
      position: relative;
      width: 230px;
      height: 230px;
      border-radius: 50%;
      transform-style: preserve-3d;
      animation: fvDiscSpin 16s ease-in-out infinite;
      box-shadow: 0 4px 20px rgba(0, 0, 0, .2);
    }

    @keyframes fvDiscSpin {
      from {
        transform: rotateX(16deg) rotateY(0deg);
      }

      to {
        transform: rotateX(16deg) rotateY(360deg);
      }
    }

    .fv-disc::before {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: 50%;
      background: linear-gradient(90deg, #aaa, #ccc, #e0e0e0, #ccc, #aaa);
      transform: translateZ(-2px) scale(1.01);
      filter: blur(1px);
      opacity: .7;
    }

    .fv-disc::after {
      content: "";
      position: absolute;
      inset: -1px;
      border-radius: 50%;
      background: linear-gradient(90deg, #999, #bbb, #d5d5d5, #bbb, #999);
      transform: translateZ(-3px);
      filter: blur(1px);
      z-index: 0;
      opacity: .5;
    }

    .fv-disc-front,
    .fv-disc-back {
      position: absolute;
      inset: 0;
      border-radius: 50%;
      backface-visibility: hidden;
    }

    .fv-disc-front {
      background-size: cover;
      background-position: center;
      transform: translateZ(4px);
      overflow: hidden;
      box-shadow: inset 0 0 24px rgba(0, 0, 0, .08), inset 0 0 5px rgba(255, 255, 255, .3);
      z-index: 3;
    }

    .fv-disc-front::before {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: 50%;
      background: linear-gradient(130deg, rgba(255, 255, 255, .15), transparent 30%);
    }

    .fv-disc-front::after {
      content: "";
      position: absolute;
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: radial-gradient(circle, #444 0%, #2a2a2a 70%, #111 100%);
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 5;
      box-shadow: inset 0 1px 2px rgba(255, 255, 255, .2), 0 1px 2px rgba(0, 0, 0, .2);
    }

    /* back base */
    .fv-disc-back {
      overflow: hidden;
      transform: rotateY(180deg) translateZ(4px);
      z-index: 1;
      background: radial-gradient(circle at 35% 45%, #f5f5f5 0%, #eaeaea 25%, #dedede 50%, #d2d2d2 75%, #c8c8c8 100%);
      background-image: repeating-linear-gradient(110deg, transparent, transparent 8px, rgba(160, 160, 170, .08) 8px, rgba(160, 160, 170, .08) 9px, transparent 9px, transparent 18px);
      box-shadow: inset 0 0 30px rgba(0, 0, 0, .06), inset 0 0 12px rgba(255, 255, 255, .5), 0 2px 6px rgba(0, 0, 0, .08);
    }

    /* capas del back */
    .fv-iridescent {
      position: absolute;
      inset: 0;
      border-radius: 50%;
      background: conic-gradient(from 0deg at 30% 45%, rgba(255, 235, 180, .03) 0deg, rgba(210, 235, 255, .025) 60deg, rgba(255, 220, 235, .02) 120deg, rgba(190, 230, 255, .025) 180deg, rgba(255, 235, 210, .02) 240deg, rgba(210, 220, 255, .025) 300deg, rgba(255, 235, 180, .03) 360deg);
      mix-blend-mode: soft-light;
      filter: blur(25px);
      opacity: .35;
      pointer-events: none;
      animation: fvOpticalShift 22s ease-in-out infinite;
    }

    @keyframes fvOpticalShift {

      0%,
      100% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.01);
      }
    }

    .fv-reflection-diagonal {
      position: absolute;
      inset: 0;
      border-radius: 50%;
      background: linear-gradient(135deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .08) 18%, transparent 38%, transparent 75%, rgba(255, 255, 255, .04) 88%, transparent 100%);
      filter: blur(6px);
      pointer-events: none;
      z-index: 2;
    }

    .fv-reflection-bottom {
      position: absolute;
      inset: 0;
      border-radius: 50%;
      background: linear-gradient(215deg, transparent 65%, rgba(180, 185, 195, .06) 80%, rgba(255, 255, 255, .04) 90%, transparent 98%);
      filter: blur(4px);
      pointer-events: none;
      z-index: 2;
    }

    .fv-metal-rings {
      position: absolute;
      inset: 0;
      border-radius: 50%;
      background: radial-gradient(circle at 32% 48%, transparent 0px, transparent 26px, rgba(100, 100, 110, .05) 27px, transparent 28px, transparent 46px, rgba(90, 90, 100, .04) 47px, transparent 48px, transparent 66px, rgba(80, 80, 90, .03) 67px, transparent 68px, transparent 88px, rgba(70, 70, 80, .025) 89px, transparent 90px);
      pointer-events: none;
      z-index: 3;
    }

    .fv-brushed-metal {
      position: absolute;
      inset: 0;
      border-radius: 50%;
      background: repeating-linear-gradient(105deg, transparent, transparent 7px, rgba(140, 140, 150, .05) 7px, rgba(140, 140, 150, .05) 8px, transparent 8px, transparent 16px);
      pointer-events: none;
      z-index: 2;
      opacity: .4;
    }

    .fv-dynamic-sheen {
      position: absolute;
      inset: -10px;
      border-radius: 50%;
      background: radial-gradient(circle at var(--sheen-x, 50%) var(--sheen-y, 50%), rgba(255, 255, 255, .05) 0%, rgba(255, 255, 255, .025) 20%, transparent 55%);
      mix-blend-mode: screen;
      filter: blur(18px);
      opacity: .6;
      pointer-events: none;
      z-index: 4;
      transition: background .06s linear;
    }

    .fv-center-hole {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 38px;
      height: 38px;
      transform: translate(-50%, -50%);
      border-radius: 50%;
      z-index: 5;
      background: radial-gradient(circle at 35% 40%, #6a6a6a 0%, #4a4a4a 40%, #353535 70%, #2a2a2a 100%);
      box-shadow: 0 0 0 1px rgba(255, 255, 255, .25), 0 0 0 2px rgba(100, 100, 110, .3), inset 0 0 4px rgba(0, 0, 0, .3);
    }

    /* UHD extras */
    .fv-rainbow-ring {
      position: absolute;
      inset: 10px;
      border-radius: 50%;
      z-index: 4;
      pointer-events: none;
      background: conic-gradient(from 0deg, #ff6b6b 0deg, #ffd93d 45deg, #6bcb77 90deg, #4d96ff 135deg, #9b59b6 180deg, #ff6b6b 225deg, #ffd93d 270deg, #6bcb77 315deg, #4d96ff 360deg);
      opacity: 0;
      mix-blend-mode: screen;
      filter: blur(1px);
      animation: fvRainbowShine 3s ease-in-out infinite;
    }

    .fv-rainbow-ring-subtle {
      position: absolute;
      inset: 16px;
      border-radius: 50%;
      z-index: 4;
      pointer-events: none;
      background: conic-gradient(from 0deg, rgba(255, 107, 107, .15) 0deg, rgba(255, 217, 61, .15) 60deg, rgba(107, 203, 119, .15) 120deg, rgba(77, 150, 255, .15) 180deg, rgba(155, 89, 182, .15) 240deg, rgba(255, 107, 107, .15) 300deg, rgba(255, 217, 61, .15) 360deg);
      mix-blend-mode: screen;
      filter: blur(3px);
      animation: fvSubtleRainbow 4s ease-in-out infinite;
    }

    .fv-specular-highlight {
      position: absolute;
      inset: 26px;
      border-radius: 50%;
      z-index: 4;
      pointer-events: none;
      background: radial-gradient(ellipse at 30% 40%, rgba(255, 255, 255, .35) 0%, rgba(255, 255, 255, .1) 30%, transparent 70%);
      filter: blur(2px);
      animation: fvSpecularMove 6s ease-in-out infinite;
    }

    .fv-diffraction {
      position: absolute;
      inset: 6px;
      border-radius: 50%;
      z-index: 4;
      pointer-events: none;
      background: repeating-conic-gradient(from 0deg, rgba(255, 100, 100, .08) 0deg 10deg, rgba(255, 200, 100, .08) 10deg 20deg, rgba(100, 255, 100, .08) 20deg 30deg, rgba(100, 100, 255, .08) 30deg 40deg, rgba(255, 100, 255, .08) 40deg 50deg, transparent 50deg 60deg);
      mix-blend-mode: screen;
      animation: fvDiffractionRotate 8s linear infinite;
    }

    /* UHD sheen más intenso */
    #fmt-uhd .fv-dynamic-sheen {
      background: radial-gradient(circle at var(--sheen-x, 50%) var(--sheen-y, 50%), rgba(255, 255, 255, .12) 0%, rgba(255, 255, 255, .06) 20%, transparent 60%);
      filter: blur(12px);
      opacity: .8;
    }

    @keyframes fvRainbowShine {

      0%,
      100% {
        opacity: 0;
        transform: scale(.95);
      }

      50% {
        opacity: .25;
        transform: scale(1);
        filter: blur(1px);
      }
    }

    @keyframes fvSubtleRainbow {

      0%,
      100% {
        opacity: .08;
        transform: rotate(0deg);
      }

      50% {
        opacity: .2;
        transform: rotate(180deg);
      }
    }

    @keyframes fvSpecularMove {

      0%,
      100% {
        background: radial-gradient(ellipse at 30% 40%, rgba(255, 255, 255, .35) 0%, rgba(255, 255, 255, .1) 30%, transparent 70%);
      }

      50% {
        background: radial-gradient(ellipse at 70% 60%, rgba(255, 255, 255, .4) 0%, rgba(255, 255, 255, .12) 30%, transparent 70%);
      }
    }

    @keyframes fvDiffractionRotate {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(360deg);
      }
    }

    /* ══ VHS ══ */
    .vhs-scene {
      perspective: 2200px;
    }

    .fv-vhs {
      position: relative;
      width: 260px;
      height: 150px;
      transform-style: preserve-3d;
      animation: fvVhsSpin 14s linear infinite;
    }

    .fv-vhs:hover {
      animation-play-state: paused;
    }

    .fv-vhs-front,
    .fv-vhs-back,
    .fv-vhs-left,
    .fv-vhs-right,
    .fv-vhs-top,
    .fv-vhs-bottom {
      position: absolute;
      border-radius: 5px;
      box-shadow: 0 0 22px rgba(0, 0, 0, .6), inset 0 0 14px rgba(255, 255, 255, .03);
      backface-visibility: visible;
    }

    .fv-vhs-front {
      width: 260px;
      height: 150px;
      background: linear-gradient(145deg, #343434, #121212 40%, #1c1c1c 100%);
      transform: translateZ(15px);
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, .04);
    }

    .fv-vhs-front::before {
      content: "";
      position: absolute;
      inset: 0;
      background: repeating-linear-gradient(0deg, rgba(255, 255, 255, .025) 0px, rgba(255, 255, 255, .025) 1px, transparent 1px, transparent 4px);
      opacity: .45;
      mix-blend-mode: screen;
    }

    .fv-vhs-front::after {
      content: "";
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at top left, rgba(255, 255, 255, .08), transparent 30%), radial-gradient(circle at bottom right, rgba(0, 0, 0, .35), transparent 40%);
      pointer-events: none;
    }

    /* label VHS */
    .fv-label {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      width: 118px;
      height: 68px;
      overflow: hidden;
      z-index: 2;
      border-radius: 5px;
      background: #050505;
      border: 2px solid rgba(255, 210, 90, .75);
      box-shadow: inset 0 0 14px rgba(0, 0, 0, .85), 0 0 12px rgba(0, 0, 0, .45);
    }

    .fv-movie-cover {
      position: absolute;
      inset: 0;
      background-image: var(--cover);
      background-size: cover;
      background-position: center;
      transform: scale(1.05);
    }

    .fv-movie-cover::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(to bottom, rgba(0, 0, 0, .1), rgba(0, 0, 0, .5));
      mix-blend-mode: multiply;
    }

    .fv-vhs-title {
      position: absolute;
      width: 100%;
      bottom: 5px;
      left: 0;
      text-align: center;
      color: #f3e7c2;
      font-family: Impact, Arial Black, sans-serif;
      font-size: 9px;
      font-weight: bold;
      letter-spacing: 3px;
      z-index: 10;
      text-shadow: 0 0 4px rgba(255, 220, 120, .4), 1px 1px 0 rgba(0, 0, 0, .8);
      white-space: nowrap;
      overflow: hidden;
    }

    /* ventanas VHS */
    .fv-window {
      position: absolute;
      width: 62px;
      height: 62px;
      top: 44px;
      background: radial-gradient(circle, rgba(255, 255, 255, .15), rgba(0, 0, 0, .8));
      border-radius: 8px;
      overflow: hidden;
      border: 2px solid rgba(255, 255, 255, .08);
      z-index: 1;
    }

    .fv-left-window {
      left: 16px;
    }

    .fv-right-window {
      right: 16px;
    }

    .fv-reel {
      position: absolute;
      width: 46px;
      height: 46px;
      border-radius: 50%;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      background: radial-gradient(circle, #fff 0%, #ddd 30%, #999 100%);
      animation: fvReelSpin 3s linear infinite;
    }

    .fv-reel::before {
      content: "";
      position: absolute;
      inset: 10px;
      border-radius: 50%;
      border: 5px solid rgba(0, 0, 0, .15);
    }

    /* trasera VHS */
    .fv-vhs-back {
      width: 260px;
      height: 150px;
      background: linear-gradient(145deg, #2c2c2c, #141414);
      transform: rotateY(180deg) translateZ(15px);
      overflow: hidden;
    }

    .fv-vhs-back::before {
      content: "";
      position: absolute;
      inset: 0;
      background: repeating-linear-gradient(0deg, rgba(255, 255, 255, .03) 0px, rgba(255, 255, 255, .03) 2px, transparent 2px, transparent 6px);
      opacity: .25;
    }

    .fv-back-reel {
      position: absolute;
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: radial-gradient(circle, #f5f5f5 0%, #d7d7d7 45%, #8e8e8e 100%);
      top: 78px;
    }

    .fv-left-reel {
      left: 50px;
    }

    .fv-right-reel {
      right: 50px;
    }

    .fv-back-reel::before {
      content: "";
      position: absolute;
      inset: 9px;
      border-radius: 50%;
      border: 4px solid rgba(0, 0, 0, .15);
    }

    .fv-screw {
      position: absolute;
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: #111;
      box-shadow: inset 0 0 2px rgba(255, 255, 255, .2);
    }

    .fv-s1 {
      top: 10px;
      left: 10px;
    }

    .fv-s2 {
      top: 10px;
      right: 10px;
    }

    .fv-s3 {
      bottom: 10px;
      left: 10px;
    }

    .fv-s4 {
      bottom: 10px;
      right: 10px;
    }

    .fv-line-detail {
      position: absolute;
      width: 100%;
      height: 1px;
      background: rgba(255, 255, 255, .08);
      top: 70px;
    }

    /* laterales / tapa VHS */
    .fv-vhs-left,
    .fv-vhs-right {
      width: 30px;
      height: 150px;
      background: #151515;
    }

    .fv-vhs-left {
      transform: rotateY(-90deg) translateZ(15px);
    }

    .fv-vhs-right {
      transform: rotateY(90deg) translateZ(245px);
    }

    .fv-vhs-top,
    .fv-vhs-bottom {
      width: 260px;
      height: 30px;
      background: #222;
    }

    .fv-vhs-top {
      transform: rotateX(90deg) translateZ(15px);
    }

    .fv-vhs-bottom {
      transform: rotateX(-90deg) translateZ(135px);
    }

    @keyframes fvVhsSpin {
      from {
        transform: rotateX(-10deg) rotateY(-30deg);
      }

      to {
        transform: rotateX(-10deg) rotateY(330deg);
      }
    }

    @keyframes fvReelSpin {
      from {
        transform: translate(-50%, -50%) rotate(0deg);
      }

      to {
        transform: translate(-50%, -50%) rotate(360deg);
      }
    }
  </style>
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

    .nav-right {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .ico-btn {
      background: transparent;
      border: 1px solid var(--g-dark);
      color: var(--g);
      font-family: var(--fm);
      font-size: 10px;
      padding: 6px 14px;
      letter-spacing: 2px;
      cursor: pointer;
      transition: all .18s;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .ico-btn:hover,
    .ico-btn.on {
      border-color: var(--v);
      color: var(--w);
      box-shadow: 0 0 10px rgba(123, 94, 167, 0.2);
    }

    /* ── USER DROPDOWN ── */
    .user-menu-container {
      position: relative;
    }

    .user-dropdown {
      position: absolute;
      top: 100%;
      right: 0;
      margin-top: 8px;
      background: var(--ink2);
      border: 1px solid rgba(123, 94, 167, 0.3);
      border-radius: 3px;
      min-width: 180px;
      display: none;
      flex-direction: column;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.8);
      z-index: 300;
    }

    .user-dropdown.active {
      display: flex;
    }

    .dropdown-item {
      padding: 12px 16px;
      color: var(--w);
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      cursor: pointer;
      font-family: var(--fu);
      font-size: 11px;
      transition: all .15s;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .dropdown-item:last-child {
      border-bottom: none;
    }

    .dropdown-item:hover {
      background: var(--v-soft);
      color: var(--v);
    }

    .dropdown-item.logout:hover {
      background: rgba(200, 50, 50, 0.2);
      color: #ff6b6b;
    }

    /* ── SEARCH PANEL ── */
    .search-panel {
      overflow: hidden;
      max-height: 0;
      background: var(--ink2);
      border-bottom: 1px solid transparent;
      transition: max-height .32s cubic-bezier(.4, 0, .2, 1), border-color .32s, padding .32s;
      padding: 0 52px;
    }

    .search-panel.open {
      max-height: 68px;
      padding: 13px 52px;
      border-color: rgba(123, 94, 167, 0.12);
    }

    .s-wrap {
      position: relative;
      max-width: 520px;
    }

    .s-wrap::before {
      content: '⌕';
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 14px;
      color: var(--v-dim);
      pointer-events: none;
    }

    .s-input {
      width: 100%;
      background: var(--ink3);
      border: 1px solid var(--g-dark);
      border-left: 2px solid var(--v);
      color: var(--w);
      font-family: var(--fm);
      font-size: 12px;
      padding: 9px 14px 9px 34px;
      outline: none;
      letter-spacing: 1px;
      transition: all .2s;
    }

    .s-input:focus {
      border-color: var(--v);
      box-shadow: 0 0 0 1px rgba(123, 94, 167, 0.2);
    }

    .s-input::placeholder {
      color: #2a2a2a;
    }

    /* ── SEARCH RESULTS DROPDOWN ── */
    .search-results {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: var(--ink2);
      border: 1px solid rgba(123, 94, 167, 0.3);
      border-top: none;
      max-height: 400px;
      overflow-y: auto;
      display: none;
      z-index: 250;
    }

    .search-results.active {
      display: block;
    }

    .search-result-item {
      padding: 10px 16px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.03);
      cursor: pointer;
      transition: all .15s;
    }

    .search-result-item:hover {
      background: var(--v-soft);
    }

    .result-title {
      color: var(--w);
      font-weight: 600;
      font-size: 12px;
    }

    .result-genre {
      color: var(--g);
      font-size: 10px;
      margin-top: 3px;
    }

    /* ── BROWSE ── */
    .browse {
      background: var(--ink2);
      border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }

    .browse-trigger {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 52px;
      height: 42px;
      cursor: pointer;
      user-select: none;
      transition: background .18s;
    }

    .browse-trigger:hover {
      background: var(--v-soft);
    }

    .browse-lbl {
      font-family: var(--fm);
      font-size: 10px;
      color: var(--g);
      letter-spacing: 3px;
      display: flex;
      align-items: center;
      gap: 9px;
    }

    .browse-lbl::before {
      content: '';
      width: 10px;
      height: 1px;
      background: var(--v-dim);
    }

    .chev {
      font-size: 9px;
      color: var(--v-dim);
      transition: transform .28s ease;
    }

    .chev.open {
      transform: rotate(180deg);
    }

    .genre-panel {
      overflow: hidden;
      max-height: 0;
      background: var(--ink3);
      border-top: 1px solid rgba(255, 255, 255, 0.03);
      transition: max-height .3s cubic-bezier(.4, 0, .2, 1), padding .3s;
      padding: 0 52px;
    }

    /* CORREGIDO: max-height alineado con v2 (64px) */
    .genre-panel.open {
      max-height: 64px;
      padding: 11px 52px;
    }

    .tags {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
    }

    .tag {
      font-family: var(--fu);
      font-size: 10px;
      font-weight: 600;
      letter-spacing: 2px;
      padding: 4px 13px;
      border: 1px solid var(--g-dark);
      background: transparent;
      color: var(--g);
      cursor: pointer;
      transition: all .15s;
      text-transform: uppercase;
    }

    .tag:hover {
      color: var(--w);
      border-color: #444;
    }

    .tag.on {
      background: var(--v);
      color: var(--w);
      border-color: var(--v);
    }

    /* ── SHELVES ── */
    /* CORREGIDO: padding-bottom alineado con v2 (64px) */
    .movies-main {
      padding: 30px 0 64px;
    }

    .shelf {
      margin-bottom: 44px;
    }

    .shelf-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 52px;
      margin-bottom: 14px;
    }

    .shelf-head h2 {
      font-family: var(--fh);
      font-size: 20px;
      letter-spacing: 5px;
      color: var(--w);
    }

    .shelf-head span {
      font-family: var(--fm);
      font-size: 9px;
      color: var(--v-dim);
      letter-spacing: 1px;
      cursor: pointer;
      transition: color .15s;
    }

    .shelf-head span:hover {
      color: var(--v);
    }

    /* CORREGIDO: popular-grid con width y box-sizing alineados a v2 */
    .popular-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 5px;
      padding: 10px 52px 18px;
      width: 100%;
      box-sizing: border-box;
    }

    .popular-grid .card {
      width: 100%;
      flex: none;
    }

    /* Scroll horizontal para otras shelves */
    .scroll-row {
      display: flex;
      gap: 5px;
      overflow-x: auto;
      overflow-y: visible;
      padding: 10px 52px 18px;
      scroll-snap-type: x mandatory;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none;
    }

    .scroll-row::-webkit-scrollbar {
      display: none;
    }

    .scroll-row .card {
      flex: 0 0 160px;
      scroll-snap-align: start;
    }

    /* ── GRID FILTRADO ── */
    .grid-section {
      padding: 0 52px 60px;
      display: none;
    }

    .grid-head {
      display: flex;
      align-items: baseline;
      gap: 10px;
      margin-bottom: 16px;
      padding-top: 8px;
    }

    .grid-head h2 {
      font-family: var(--fh);
      font-size: 20px;
      letter-spacing: 5px;
      color: var(--w);
    }

    .grid-head span {
      font-family: var(--fm);
      font-size: 9px;
      color: var(--g);
      letter-spacing: 1px;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 5px;
    }

    /* ── CARD ── */
    .card {
      position: relative;
      background: var(--ink3);
      cursor: pointer;
      overflow: visible;
      transition: transform .3s cubic-bezier(.25, .46, .45, .94), box-shadow .3s ease, z-index 0s .3s;
      z-index: 1;
    }

    .card:hover {
      transform: scale(1.09);
      box-shadow: 0 28px 60px rgba(0, 0, 0, 0.95), 0 0 0 1px rgba(123, 94, 167, 0.3), 0 0 36px rgba(123, 94, 167, 0.1);
      z-index: 20;
      transition: transform .3s cubic-bezier(.25, .46, .45, .94), box-shadow .3s ease, z-index 0s;
    }

    .card:hover .thumb {
      transform: scale(1.07);
      filter: sepia(12%) contrast(1.06) brightness(0.65);
    }

    .card:hover .strip {
      opacity: 0;
    }

    .card:hover .hpanel {
      opacity: 1;
      transform: translateY(0);
    }

    .tw {
      position: relative;
      overflow: hidden;
    }

    .thumb {
      width: 100%;
      aspect-ratio: 2/3;
      object-fit: cover;
      display: block;
      filter: sepia(16%) contrast(1.04) brightness(0.82);
      transition: transform .45s ease, filter .4s ease;
    }

    .tw::after {
      content: '';
      position: absolute;
      inset: 0;
      background: repeating-linear-gradient(0deg, transparent, transparent 3px, rgba(0, 0, 0, 0.07) 3px, rgba(0, 0, 0, 0.07) 4px);
      pointer-events: none;
      z-index: 1;
    }

    .strip {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      background: linear-gradient(to top, rgba(6, 6, 6, 1) 0%, rgba(6, 6, 6, .65) 38%, transparent 100%);
      padding: 32px 11px 11px;
      z-index: 2;
      transition: opacity .18s;
    }

    .strip h3 {
      font-family: var(--fh);
      font-size: 13px;
      letter-spacing: 2px;
      color: var(--w);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .strip .yr {
      font-family: var(--fm);
      font-size: 8px;
      color: var(--g);
      margin-top: 1px;
    }

    .hpanel {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      background: linear-gradient(to top, rgba(6, 6, 6, 1) 0%, rgba(8, 6, 12, .97) 50%, rgba(14, 8, 22, .5) 78%, transparent 100%);
      padding: 46px 11px 13px;
      opacity: 0;
      transform: translateY(6px);
      transition: opacity .28s ease, transform .28s ease;
      z-index: 3;
    }

    .hpanel h3 {
      font-family: var(--fh);
      font-size: 16px;
      letter-spacing: 2px;
      color: var(--w);
      margin-bottom: 2px;
    }

    .hpanel p {
      font-family: var(--fm);
      font-size: 9px;
      color: var(--g);
      letter-spacing: 1px;
      margin-bottom: 10px;
    }

    .acts {
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .btn-info {
      font-family: var(--fo);
      font-size: 7px;
      letter-spacing: 2px;
      color: var(--w);
      background: var(--v);
      border: none;
      padding: 7px 12px;
      cursor: pointer;
      transition: all .18s;
    }

    .btn-info:hover {
      background: #9370C8;
      box-shadow: 0 0 14px var(--v-glow);
    }

    .btn-wish {
      font-size: 12px;
      color: var(--g);
      background: transparent;
      border: 1px solid var(--g-dark);
      padding: 5px 8px;
      cursor: pointer;
      transition: all .18s;
      line-height: 1;
    }

    .btn-wish:hover {
      border-color: var(--v);
      color: var(--v);
    }

    /* ── BADGES ── */
    .b-rating {
      position: absolute;
      top: 8px;
      right: 8px;
      background: rgba(6, 6, 6, 0.85);
      border: 1px solid rgba(123, 94, 167, 0.4);
      font-family: var(--fo);
      font-size: 7px;
      color: var(--v);
      padding: 2px 6px;
      letter-spacing: 1px;
      z-index: 4;
    }

    .b-genre {
      position: absolute;
      top: 8px;
      left: 8px;
      background: rgba(6, 6, 6, 0.78);
      border-left: 2px solid var(--v-dim);
      font-family: var(--fm);
      font-size: 7px;
      color: var(--g);
      padding: 2px 7px;
      letter-spacing: 2px;
      text-transform: uppercase;
      z-index: 4;
    }

    .b-rented {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) rotate(-15deg);
      font-family: var(--fh);
      font-size: 20px;
      letter-spacing: 4px;
      color: var(--v);
      border: 2px solid var(--v);
      padding: 4px 10px;
      opacity: .85;
      text-shadow: 0 0 14px var(--v-glow);
      box-shadow: 0 0 16px var(--v-glow);
      z-index: 5;
      pointer-events: none;
    }

    /* ── VINTAGE REVIEW BLOCK ── */
    .review-block {
      margin-bottom: 28px;
      border-left: 2px solid var(--v-dim);
      padding: 14px 18px;
      background: rgba(123, 94, 167, 0.05);
    }

    .review-block::before {
      content: 'RESEÑA CRÍTICA';
      font-family: var(--fm);
      font-size: 8px;
      letter-spacing: 3px;
      color: var(--v-dim);
      display: block;
      margin-bottom: 10px;
    }

    .stars-row {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 10px;
    }

    .stars {
      display: flex;
      gap: 3px;
    }

    .star {
      font-size: 13px;
      color: var(--g-dark);
    }

    .star.on {
      color: var(--v);
      text-shadow: 0 0 8px var(--v-glow);
    }

    .score-num {
      font-family: var(--fo);
      font-size: 11px;
      color: var(--v);
      letter-spacing: 1px;
    }

    .verdict-pill {
      font-family: var(--fm);
      font-size: 8px;
      letter-spacing: 2px;
      color: var(--w);
      border: 1px solid var(--v-dim);
      padding: 2px 8px;
      margin-left: 4px;
      background: rgba(123, 94, 167, 0.12);
    }

    .review-quote {
      font-family: var(--fm);
      font-size: 11px;
      color: #aaa;
      line-height: 1.65;
      font-style: italic;
      letter-spacing: .3px;
      margin-bottom: 8px;
    }

    .review-quote::before {
      content: '" ';
      color: var(--v);
    }

    .review-quote::after {
      content: ' "';
      color: var(--v);
    }

    .review-critic {
      font-family: var(--fm);
      font-size: 8px;
      color: var(--g);
      letter-spacing: 2px;
    }

    /* ── EMPTY STATE ── */
    .empty-state {
      text-align: center;
      padding: 40px 20px;
      color: var(--g);
      font-family: var(--fm);
      font-size: 12px;
      letter-spacing: 2px;
    }

    /* ── FOOTER ── */
    footer {
      background: var(--ink2);
      border-top: 1px solid rgba(123, 94, 167, 0.1);
      padding: 18px 52px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    footer p {
      font-family: var(--fm);
      font-size: 9px;
      color: #2a2a2a;
      letter-spacing: 2px;
    }

    .foot-logo {
      font-family: var(--fo);
      font-size: 9px;
      letter-spacing: 3px;
      color: var(--v-dim);
    }

    /* ══ VHS INSERT ANIMATION ══ */
    .detail-overlay {
      position: fixed;
      inset: 0;
      z-index: 1000;
      background: rgba(4, 3, 8, 0.0);
      display: none;
      transition: background .4s ease;
    }

    .detail-overlay.visible {
      background: rgba(4, 3, 8, 0.92);
    }

    .vhs-loader {
      position: fixed;
      top: 0;
      left: 50%;
      transform: translateX(-50%) translateY(-220px);
      z-index: 1100;
      width: 300px;
      display: none;
      flex-direction: column;
      align-items: center;
      animation: none;
    }

    .vhs-body {
      width: 300px;
      height: 96px;
      background: linear-gradient(180deg, #1a1422 0%, #0e0c18 100%);
      border: 1.5px solid var(--v-dim);
      border-radius: 4px 4px 8px 8px;
      position: relative;
      box-shadow: 0 0 24px rgba(123, 94, 167, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.05);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .vhs-label {
      position: absolute;
      top: 10px;
      left: 16px;
      right: 16px;
      height: 38px;
      background: linear-gradient(135deg, #1e1630, #281e42);
      border: 1px solid var(--v-dim);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 12px;
    }

    .vhs-label-title {
      font-family: var(--fo);
      font-size: 9px;
      letter-spacing: 2px;
      color: var(--v);
      white-space: nowrap;
      overflow: hidden;
    }

    .vhs-label-year {
      font-family: var(--fm);
      font-size: 10px;
      color: var(--g);
    }

    .vhs-reels {
      position: absolute;
      bottom: 10px;
      left: 0;
      right: 0;
      display: flex;
      justify-content: space-around;
      padding: 0 28px;
    }

    .vhs-reel {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      border: 1.5px solid var(--v-dim);
      background: radial-gradient(circle, #0a0814 40%, #1a1428 100%);
      position: relative;
    }

    .vhs-reel::after {
      content: '';
      position: absolute;
      inset: 6px;
      border-radius: 50%;
      background: var(--v-dim);
      opacity: .3;
    }

    .reel-spin {
      animation: spin 1.2s linear infinite;
    }

    .vhs-slot {
      position: fixed;
      top: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 320px;
      height: 10px;
      z-index: 1050;
      display: none;
    }

    @keyframes cassette-insert {
      0% {
        transform: translateX(-50%) translateY(-220px);
        opacity: 0;
      }

      15% {
        opacity: 1;
      }

      60% {
        transform: translateX(-50%) translateY(0px);
      }

      75% {
        transform: translateX(-50%) translateY(-8px);
      }

      85% {
        transform: translateX(-50%) translateY(-2px);
      }

      100% {
        transform: translateX(-50%) translateY(-110px);
        opacity: 0;
      }
    }

    .vhs-slot-inner {
      width: 100%;
      height: 100%;
      background: linear-gradient(180deg, #0a0814, #060608);
      border: 1px solid var(--v-dim);
      border-top: none;
      border-radius: 0 0 3px 3px;
      box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.8);
    }

    /* CORREGIDO: keyframes de cassette-insert alineados con v2 */
    @keyframes cassette-insert {
      0% {
        transform: translateX(-50%) translateY(-160px);
        opacity: 0;
      }

      15% {
        opacity: 1;
      }

      60% {
        transform: translateX(-50%) translateY(0px);
      }

      75% {
        transform: translateX(-50%) translateY(-6px);
      }

      85% {
        transform: translateX(-50%) translateY(-1px);
      }

      100% {
        transform: translateX(-50%) translateY(-80px);
        opacity: 0;
      }
    }

    /* CORREGIDO: slot-glow intensidad alineada con v2 (12px / 4px) */
    @keyframes slot-glow {

      0%,
      100% {
        box-shadow: none;
      }

      50% {
        box-shadow: 0 0 12px var(--v-glow), 0 0 4px var(--v);
      }
    }

    /* ── DETAIL PANEL ── */
    .detail-panel {
      position: fixed;
      inset: 0;
      z-index: 1001;
      display: none;
      overflow-y: auto;
      opacity: 0;
      transform: scale(.97);
      transition: opacity .5s ease, transform .5s ease;
    }

    .detail-panel.show {
      opacity: 1;
      transform: scale(1);
    }

    .detail-backdrop {
      position: fixed;
      inset: 0;
      z-index: 0;
      background-size: cover;
      background-position: center;
      filter: blur(40px) brightness(0.18) saturate(1.4);
      transform: scale(1.08);
      transition: background-image .3s;
    }

    .detail-backdrop::after {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse at center, transparent 20%, rgba(6, 6, 6, 0.85) 100%);
    }

    .detail-content {
      position: relative;
      z-index: 1;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .detail-topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 20px 52px 0;
      flex-shrink: 0;
    }

    .back-btn {
      font-family: var(--fm);
      font-size: 11px;
      color: var(--g);
      letter-spacing: 2px;
      background: transparent;
      border: 1px solid var(--g-dark);
      padding: 7px 16px;
      cursor: pointer;
      transition: all .18s;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .back-btn:hover {
      border-color: var(--v);
      color: var(--w);
    }

    .back-btn::before {
      content: '←';
      font-size: 13px;
    }

    .detail-logo {
      font-family: var(--fo);
      font-size: 11px;
      letter-spacing: 3px;
      color: var(--v-dim);
    }

    .detail-body {
      display: flex;
      gap: 52px;
      padding: 40px 52px 60px;
      flex: 1;
      align-items: flex-start;
    }

    .detail-poster {
      flex-shrink: 0;
      width: 240px;
      position: relative;
    }

    .detail-poster img {
      width: 100%;
      aspect-ratio: 2/3;
      object-fit: cover;
      display: block;
      filter: sepia(10%) contrast(1.05);
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(123, 94, 167, 0.2);
    }

    .detail-poster::after {
      content: '';
      position: absolute;
      inset: 0;
      background: repeating-linear-gradient(0deg, transparent, transparent 3px, rgba(0, 0, 0, 0.06) 3px, rgba(0, 0, 0, 0.06) 4px);
      pointer-events: none;
    }

    .detail-rented-banner {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) rotate(-15deg);
      font-family: var(--fh);
      font-size: 28px;
      letter-spacing: 5px;
      color: var(--v);
      border: 2px solid var(--v);
      padding: 6px 14px;
      opacity: .9;
      text-shadow: 0 0 20px var(--v-glow);
      box-shadow: 0 0 24px var(--v-glow);
      pointer-events: none;
      z-index: 2;
    }

    .detail-info {
      flex: 1;
      padding-top: 8px;
    }

    .detail-genre-tag {
      font-family: var(--fm);
      font-size: 9px;
      letter-spacing: 3px;
      color: var(--v);
      border: 1px solid var(--v-dim);
      padding: 3px 10px;
      display: inline-block;
      margin-bottom: 16px;
    }

    .detail-title {
      font-family: var(--fh);
      font-size: 62px;
      letter-spacing: 5px;
      color: var(--w);
      line-height: .95;
      margin-bottom: 14px;
    }

    .detail-meta {
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 24px;
      flex-wrap: wrap;
    }

    .detail-meta span {
      font-family: var(--fm);
      font-size: 10px;
      color: var(--g);
      letter-spacing: 1px;
    }

    .detail-meta .dot {
      color: var(--v-dim);
    }

    .detail-meta .rating-pill {
      border: 1px solid rgba(123, 94, 167, 0.4);
      color: var(--v);
      padding: 2px 8px;
      font-size: 9px;
    }

    .detail-divider {
      width: 48px;
      height: 1px;
      background: var(--v-dim);
      margin-bottom: 20px;
    }

    .detail-synopsis-label {
      font-family: var(--fm);
      font-size: 9px;
      color: var(--v-dim);
      letter-spacing: 3px;
      margin-bottom: 8px;
    }

    .detail-synopsis {
      font-family: var(--fu);
      font-size: 15px;
      font-weight: 400;
      color: #b0b0b0;
      line-height: 1.7;
      max-width: 540px;
      margin-bottom: 28px;
    }

    .detail-stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1px;
      background: var(--g-dark);
      margin-bottom: 28px;
      max-width: 440px;
    }

    .stat-cell {
      background: var(--ink2);
      padding: 14px 16px;
    }

    .stat-cell .label {
      font-family: var(--fm);
      font-size: 8px;
      color: var(--g);
      letter-spacing: 2px;
      margin-bottom: 4px;
    }

    .stat-cell .value {
      font-family: var(--fh);
      font-size: 18px;
      letter-spacing: 1px;
      color: var(--w);
    }

    .detail-actions {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .btn-primary {
      font-family: var(--fo);
      font-size: 9px;
      letter-spacing: 2px;
      color: var(--w);
      background: var(--v);
      border: none;
      padding: 12px 28px;
      cursor: pointer;
      transition: all .2s;
    }

    .btn-primary:hover {
      background: #9370C8;
      box-shadow: 0 0 20px var(--v-glow);
    }

    .btn-primary.disabled {
      background: var(--g-dark);
      color: var(--g);
      cursor: not-allowed;
      box-shadow: none;
    }

    .btn-secondary {
      font-family: var(--fo);
      font-size: 9px;
      letter-spacing: 2px;
      color: var(--g);
      background: transparent;
      border: 1px solid var(--g-dark);
      padding: 11px 20px;
      cursor: pointer;
      transition: all .2s;
    }

    .btn-secondary:hover {
      border-color: var(--v);
      color: var(--w);
    }

    .detail-panel::before {
      content: '';
      position: fixed;
      inset: 0;
      z-index: 2;
      background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0, 0, 0, 0.07) 2px, rgba(0, 0, 0, 0.07) 4px);
      pointer-events: none;
    }

    /* ── RESPONSIVE ── */

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

    /* ── STATUS PILL ── */
    .status-pill {
      font-family: var(--fm);
      font-size: 8px;
      letter-spacing: 2px;
      padding: 3px 9px;
      border: 1px solid;
    }

    .status-pill.activo {
      color: #4CAF6A;
      border-color: rgba(76, 175, 106, 0.3);
      background: rgba(76, 175, 106, 0.07);
    }

    .status-pill.inactivo {
      color: var(--g);
      border-color: var(--g-dark);
      background: transparent;
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
  </style>
</head>

<body>
  @php
  $base = config('app.url');
  function mapearPortadas($portadas, $fallback, $base): array
  {
  $map = [];
  foreach ($portadas as $portada) {
  $clave = strtolower(preg_replace('/[\s\-_]+/', '', $portada->formato->nombre ?? ''));
  $map[$clave] = $portada->imagen
  ? $base . '/storage/' . ltrim($portada->imagen, '/')
  : $fallback;
  }
  $alias = [
  'bluray' => ['bluray', 'blu-ray', 'blueray'],
  'uhd' => ['uhd', 'uhd4k', 'uhd 4k', '4k', 'uhdbd', 'blurayuhd', 'ultrahd'],
  'dvd' => ['dvd'],
  'vhs' => ['vhs'],
  ];
  $resultado = [];
  foreach ($alias as $clave => $variantes) {
  $resultado[$clave] = $fallback;
  foreach ($variantes as $v) {
  $v = strtolower(preg_replace('/[\s\-_]+/', '', $v));
  if (isset($map[$v])) {
  $resultado[$clave] = $map[$v];
  break;
  }
  }
  }
  return $resultado;
  }
  $movieMap = [];
  foreach ($peliculasDestacadas as $pelicula) {
  $fallback = $pelicula->foto_portada
  ? $base . '/storage/' . ltrim($pelicula->foto_portada, '/')
  : null;
  $portadas = mapearPortadas($pelicula->portadas, $fallback, $base);
  $movieMap[$pelicula->id_pelicula] = [
  'id_pelicula' => $pelicula->id_pelicula,
  'titulo' => $pelicula->titulo,
  'resumen' => $pelicula->resumen,
  'anio_lanzamiento' => $pelicula->anio_lanzamiento,
  'precio_alquiler' => $pelicula->precio_alquiler,
  'duracion' => $pelicula->duracion_minutos,
  'foto_portada' => $fallback,
  'foto_caratula' => $fallback,
  'banner' => $pelicula->banner ? asset($pelicula->banner) : null,
  'genero' => $pelicula->genero,
  'director' => $pelicula->director,
  'actores' => $pelicula->actores,
  'cintas' => $pelicula->cintas,
  'imagen_dvd' => $portadas['dvd'],
  'imagen_bluray' => $portadas['bluray'],
  'imagen_uhd' => $portadas['uhd'],
  'imagen_vhs' => $portadas['vhs'],
  ];
  }
  foreach ($peliculasPorGenero as $grupoPeliculas) {
  foreach ($grupoPeliculas as $pelicula) {
  if (isset($movieMap[$pelicula->id_pelicula])) continue; // ya está, no duplicar
  $fallback = $pelicula->foto_portada
  ? $base . '/storage/' . ltrim($pelicula->foto_portada, '/')
  : null;
  $portadas = mapearPortadas($pelicula->portadas, $fallback, $base);
  $movieMap[$pelicula->id_pelicula] = [
  'id_pelicula' => $pelicula->id_pelicula,
  'titulo' => $pelicula->titulo,
  'resumen' => $pelicula->resumen,
  'anio_lanzamiento' => $pelicula->anio_lanzamiento,
  'precio_alquiler' => $pelicula->precio_alquiler,
  'duracion' => $pelicula->duracion_minutos,
  'foto_portada' => $fallback,
  'foto_caratula' => $fallback,
  'banner' => $pelicula->banner ? asset($pelicula->banner) : null,
  'genero' => $pelicula->genero,
  'director' => $pelicula->director,
  'actores' => $pelicula->actores,
  'cintas' => $pelicula->cintas,
  'imagen_dvd' => $portadas['dvd'],
  'imagen_bluray' => $portadas['bluray'],
  'imagen_uhd' => $portadas['uhd'],
  'imagen_vhs' => $portadas['vhs'],
  ];
  }
  }
  @endphp
  <script>
    window.MOVIE_MAP = @json($movieMap);
  </script>

  <!-- ══ MAIN VIEW ══ -->
  <div id="mainView">

    <header>
      <div class="logo">
        <div class="logo-mark"></div>
        <div class="logo-words">
          <h1><em>PIXEL</em>VHS</h1>
          <small>VIDEO STORE</small>
        </div>
      </div>
      <div class="nav-right">
        <button class="ico-btn" id="sBtn" onclick="toggleSearch()">⌕ &nbsp;BUSCAR</button>
        <div class="user-menu-container">
          <button class="ico-btn" id="userBtn" onclick="toggleUserMenu()">👤 PERFIL</button>
          <div class="user-dropdown" id="userDropdown">
            <div class="dropdown-item" onclick="navigatePerfil()">◈ MI PERFIL</div>
            <div class="dropdown-item">⬡ MIS RENTAS</div>
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
              @csrf
              <div class="dropdown-item logout" onclick="document.getElementById('logoutForm').submit()">
                ⎋ CERRAR SESIÓN
              </div>
            </form>
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
            onclick="openDetail(window.MOVIE_MAP[{{ $pelicula->id_pelicula }}])">
            @if($pelicula->clasificacion)
            <div class="b-rating">{{ $pelicula->clasificacion }}</div>
            @endif
            <div class="b-genre">{{ strtoupper($pelicula->genero->nombre ?? 'N/A') }}</div>
            @if($disponibles === 0)
            <div class="b-rented">NO DISPONIBLE</div>
            @endif
            <div class="tw">
              <img src="{{ $base . '/storage/' . ltrim($pelicula->foto_portada, '/') }}"
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
              <img src="{{ $base . '/storage/' . ltrim($pelicula->foto_portada, '/') }}"
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
              <img src="{{ $base . '/storage/' . ltrim($pelicula->foto_portada, '/') }}"
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
      <p>// PIXELVHS &nbsp;·&nbsp; EST. 1985 &nbsp;·&nbsp; TODOS LOS DERECHOS RESERVADOS</p>
      <div class="foot-logo">PIXELVHS ◈</div>
    </footer>

  </div>
  <div class="view" id="view-perfil" style="display:none; padding:40px 52px;">
    <div class="page-header" style="display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:32px; padding-bottom:18px; border-bottom:1px solid rgba(255,255,255,0.05);">
      <div>
        <h2 style="font-family:var(--fh); font-size:34px; letter-spacing:6px; color:var(--w); line-height:1;">MI PERFIL</h2>
        <small style="font-family:var(--fm); font-size:9px; color:var(--g); letter-spacing:2px; display:block; margin-top:5px;">// DATOS DE TU CUENTA</small>
      </div>
      <button onclick="navigateHome()" style="
    font-family:var(--fm);
    font-size:10px;
    letter-spacing:2px;
    color:var(--g);
    background:transparent;
    border:1px solid var(--g-dark);
    padding:8px 18px;
    cursor:pointer;
    transition:all .18s;
    display:flex;
    align-items:center;
    gap:8px;"
        onmouseover="this.style.borderColor='var(--v)'; this.style.color='var(--w)'"
        onmouseout="this.style.borderColor='var(--g-dark)'; this.style.color='var(--g)'">
        ← VOLVER AL CATÁLOGO
      </button>
    </div>
    <div style="display:grid; grid-template-columns:280px 1fr; gap:20px; align-items:start;">
      <div class="form-card" style="display:flex; flex-direction:column; align-items:center; gap:20px; padding:32px 24px;">
        <div id="avatar-wrap" style="position:relative; width:120px; height:120px;">
          <div style="width:120px; height:120px; border:2px solid var(--v-dim); overflow:hidden; background:var(--ink3); display:flex; align-items:center; justify-content:center;">
            @if(auth()->user()->foto)
            <img id="avatar-img" src="{{ asset('storage/' . auth()->user()->foto) }}"
              style="width:100%; height:100%; object-fit:cover;">
            @else
            <img id="avatar-img" src="" style="width:100%; height:100%; object-fit:cover; display:none;">
            <span id="avatar-initials" style="font-family:var(--fo); font-size:32px; color:var(--v); letter-spacing:2px;">
              {{ strtoupper(substr(auth()->user()->nombre, 0, 2)) }}
            </span>
            @endif
          </div>
          <!-- Overlay upload -->
          <label for="fotoInput" style="position:absolute; inset:0; background:rgba(0,0,0,0); display:flex; align-items:center; justify-content:center; cursor:pointer; transition:background .2s;"
            onmouseover="this.style.background='rgba(123,94,167,0.45)'; this.querySelector('span').style.opacity='1'"
            onmouseout="this.style.background='rgba(0,0,0,0)'; this.querySelector('span').style.opacity='0'">
            <span style="font-family:var(--fm); font-size:8px; letter-spacing:2px; color:var(--w); opacity:0; transition:opacity .2s;">CAMBIAR</span>
          </label>
          <input type="file" id="fotoInput" accept="image/*" style="display:none" onchange="uploadFoto(this)">
        </div>

        <!-- Spinner de carga foto -->
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
  <!-- ══ VHS SLOT ══ -->
  <div class="vhs-slot" id="vhsSlot">
    <div class="vhs-slot-inner"></div>
  </div>

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
        <div class="detail-logo">PIXELVHS ◈</div>
      </div>

      <div class="detail-body">
        <div class="detail-poster" id="detailPosterWrap">

          {{-- VISTA POSTER (default) --}}
          <div id="posterDefault">
            <img id="detailImg" src="" alt="Poster">
            <div class="detail-rented-banner" id="detailRented" style="display:none">RENTADA</div>
          </div>

          {{-- ══ VISOR DE FORMATO (reemplaza el poster) ══ --}}
          <div id="formatViewer" style="display:none;">

            {{-- DVD --}}
            <div class="fmt-scene" id="fmt-dvd" style="display:none;">
              <div class="fv-scene dvd-scene">
                <div class="fv-dvd" id="fvDvd">
                  <div class="fv-dvd-front" id="fvDvdFront"></div>
                  <div class="fv-dvd-back" id="fvDvdBack"></div>
                  <div class="fv-dvd-left" id="fvDvdLeft"></div>
                  <div class="fv-dvd-right"></div>
                  <div class="fv-dvd-top"></div>
                  <div class="fv-dvd-bottom"></div>
                </div>
              </div>
            </div>

            {{-- BLU-RAY --}}
            <div class="fmt-scene" id="fmt-bluray" style="display:none;">
              <div class="fv-scene disc-scene">
                <div class="fv-disc-glow"></div>
                <div class="fv-disc" id="fvBluray">
                  <div class="fv-disc-front" id="fvBlurayFront"></div>
                  <div class="fv-disc-back">
                    <div class="fv-iridescent"></div>
                    <div class="fv-reflection-diagonal"></div>
                    <div class="fv-reflection-bottom"></div>
                    <div class="fv-metal-rings"></div>
                    <div class="fv-brushed-metal"></div>
                    <div class="fv-dynamic-sheen" id="fvBluraySheen"></div>
                    <div class="fv-center-hole"></div>
                  </div>
                </div>
              </div>
            </div>

            {{-- UHD 4K --}}
            <div class="fmt-scene" id="fmt-uhd" style="display:none;">
              <div class="fv-scene disc-scene">
                <div class="fv-disc-glow"></div>
                <div class="fv-disc" id="fvUhd">
                  <div class="fv-disc-front" id="fvUhdFront"></div>
                  <div class="fv-disc-back">
                    <div class="fv-iridescent"></div>
                    <div class="fv-reflection-diagonal"></div>
                    <div class="fv-reflection-bottom"></div>
                    <div class="fv-metal-rings"></div>
                    <div class="fv-brushed-metal"></div>
                    <div class="fv-rainbow-ring"></div>
                    <div class="fv-rainbow-ring-subtle"></div>
                    <div class="fv-specular-highlight"></div>
                    <div class="fv-diffraction"></div>
                    <div class="fv-dynamic-sheen" id="fvUhdSheen"></div>
                    <div class="fv-center-hole"></div>
                  </div>
                </div>
              </div>
            </div>

            {{-- VHS --}}
            <div class="fmt-scene" id="fmt-vhs" style="display:none;">
              <div class="fv-scene vhs-scene">
                <div class="fv-vhs" id="fvVhs">
                  <div class="fv-vhs-front">
                    <div class="fv-window fv-left-window">
                      <div class="fv-reel"></div>
                    </div>
                    <div class="fv-window fv-right-window">
                      <div class="fv-reel"></div>
                    </div>
                    <div class="fv-label">
                      <div class="fv-movie-cover" id="fvVhsCover"></div>
                      <div class="fv-vhs-title" id="fvVhsTitle"></div>
                    </div>
                  </div>
                  <div class="fv-vhs-back">
                    <div class="fv-back-reel fv-left-reel"></div>
                    <div class="fv-back-reel fv-right-reel"></div>
                    <div class="fv-screw fv-s1"></div>
                    <div class="fv-screw fv-s2"></div>
                    <div class="fv-screw fv-s3"></div>
                    <div class="fv-screw fv-s4"></div>
                    <div class="fv-line-detail"></div>
                  </div>
                  <div class="fv-vhs-left"></div>
                  <div class="fv-vhs-right"></div>
                  <div class="fv-vhs-top"></div>
                  <div class="fv-vhs-bottom"></div>
                </div>
              </div>
            </div>

          </div>{{-- /formatViewer --}}

          {{-- ══ BOTONES DE FORMATO (siempre visibles abajo del poster/visor) ══ --}}
          <div class="fmt-btns-row">
            <button class="fmt-btn" data-fmt="dvd" onclick="switchFormat('dvd')">
              <span>▣</span> DVD
            </button>
            <button class="fmt-btn" data-fmt="bluray" onclick="switchFormat('bluray')">
              <span>◉</span> BLU-RAY
            </button>
            <button class="fmt-btn" data-fmt="uhd" onclick="switchFormat('uhd')">
              <span>◈</span> UHD 4K
            </button>
            <button class="fmt-btn" data-fmt="vhs" onclick="switchFormat('vhs')">
              <span>▶</span> VHS
            </button>
          </div>
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
    window.currentMovie = pelicula;
    let activeGenreId = 'all';
    let filterMode = false;
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content;


    /* ══ USER MENU ══ */
    function toggleUserMenu() {
      document.getElementById('userDropdown').classList.toggle('active');
    }

    function navigatePerfil() {
      document.getElementById('mainView').style.display = 'none';
      document.getElementById('view-perfil').style.display = 'block';
    }

    function navigateHome() {
      document.getElementById('view-perfil').style.display = 'none';
      document.getElementById('mainView').style.display = 'block';
    }
    document.addEventListener('click', (e) => {
      const uc = document.querySelector('.user-menu-container');
      if (uc && !uc.contains(e.target)) {
        document.getElementById('userDropdown').classList.remove('active');
      }
    });

    /* ══ SEARCH ══ */
    function toggleSearch() {
      const p = document.getElementById('sPanel');
      const b = document.getElementById('sBtn');
      const i = document.getElementById('sInput');
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
        const textMatch = !q ||
          m.titulo.toLowerCase().includes(q) ||
          (m.director?.nombre || '').toLowerCase().includes(q) ||
          String(m.anio_lanzamiento).includes(q);
        return genreMatch && textMatch;
      });

      enterFilterMode(results, q);
    }

    function enterFilterMode(results, query) {
      filterMode = true;
      document.getElementById('moviesMain').style.display = 'none';
      document.getElementById('gridSection').style.display = 'block';
      document.getElementById('searchResults').classList.remove('active');

      const n = results.length;
      const label = activeGenreId !== 'all' ?
        document.querySelector(`.tag.on`)?.textContent?.trim() || 'FILTRADO' :
        (query ? `"${query.toUpperCase()}"` : 'TODOS LOS TÍTULOS');

      document.getElementById('gridTitle').textContent = label;
      document.getElementById('gridCnt').textContent =
        `// ${String(n).padStart(2,'0')} TÍTULO${n !== 1 ? 'S' : ''}`;

      document.getElementById('filteredGrid').innerHTML = results.length ?
        results.map(m => buildCardFromData(m)).join('') :
        `<div class="empty-state" style="grid-column:1/-1">SIN RESULTADOS</div>`;
    }

    function exitFilterMode() {
      filterMode = false;
      activeGenreId = 'all';
      document.getElementById('moviesMain').style.display = 'block';
      document.getElementById('gridSection').style.display = 'none';
      document.getElementById('sInput').value = '';
      document.getElementById('searchResults').classList.remove('active');
      document.querySelectorAll('.tag').forEach(t => t.classList.remove('on'));
      const first = document.querySelector('.tag');
      if (first) first.classList.add('on');
    }

    function buildCardFromData(m) {
      const disponibles = (m.cintas || []).filter(c => !c.rentada || c.rentada == 0).length;
      const rented = disponibles === 0;
      const rentedHtml = rented ? `<div class="b-rented">NO DISPONIBLE</div>` : '';
      const ratingHtml = m.clasificacion ? `<div class="b-rating">${m.clasificacion}</div>` : '';
      const img = m.foto_portada || m.foto_caratula || '';
      const genero = (m.genero?.nombre || 'N/A').toUpperCase();
      const titulo = m.titulo.toUpperCase();
      const anio = m.anio_lanzamiento;
      const dataStr = JSON.stringify(m).replace(/"/g, '&quot;');

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

    function openDetail(pelicula) {
      currentMovie = pelicula;

      document.getElementById('vhsTitle').textContent =
        pelicula.titulo.length > 16 ? pelicula.titulo.slice(0, 16) + '…' : pelicula.titulo;
      document.getElementById('vhsYear').textContent = pelicula.anio_lanzamiento;

      const imgSrc = pelicula.foto_portada || pelicula.foto_caratula || '';
      document.getElementById('detailImg').src = imgSrc;
      document.getElementById('detailBackdrop').style.backgroundImage = `url('${imgSrc}')`;

      document.getElementById('detailTitle').textContent = pelicula.titulo;
      document.getElementById('detailGenre').textContent = pelicula.genero?.nombre || 'N/A';
      document.getElementById('detailDir').textContent = (pelicula.director?.nombre || 'N/A').toUpperCase();
      document.getElementById('detailYear2').textContent = pelicula.anio_lanzamiento;
      document.getElementById('detailDur').textContent = pelicula.duracion ? pelicula.duracion + ' MIN' : 'N/A';
      document.getElementById('detailRat').textContent = pelicula.clasificacion || 'N/A';
      document.getElementById('detailSyn').textContent = pelicula.resumen || 'Descripción no disponible.';

      const stats = [{
          l: 'AÑO',
          v: pelicula.anio_lanzamiento
        },
        {
          l: 'DURACIÓN',
          v: pelicula.duracion ? pelicula.duracion + ' MIN' : 'N/A'
        },
        {
          l: 'DIRECTOR',
          v: (pelicula.director?.nombre || 'N/A').toUpperCase()
        },
        {
          l: 'GÉNERO',
          v: (pelicula.genero?.nombre || 'N/A').toUpperCase()
        },
        {
          l: 'PRECIO',
          v: pelicula.precio_alquiler ? '$' + pelicula.precio_alquiler : 'N/A'
        },
        {
          l: 'CINTAS',
          v: pelicula.cintas ? pelicula.cintas.length : '0'
        }
      ];
      document.getElementById('detailStats').innerHTML =
        stats.map(s => `<div class="stat-cell"><div class="label">${s.l}</div><div class="value">${s.v}</div></div>`).join('');

      const cintas = pelicula.cintas || [];
      const disponibles = cintas.filter(c => !c.rentada || c.rentada == 0).length;
      const total = cintas.length;
      const score = pelicula.puntuacion != null ?
        pelicula.puntuacion :
        (total > 0 ? +(disponibles / total * 5).toFixed(1) : 0);
      const stars = Math.round(score);
      const verdict = score >= 4.5 ? 'IMPRESCINDIBLE' :
        score >= 4 ? 'OBRA MAESTRA' :
        score >= 3 ? 'RECOMENDADA' :
        score >= 2 ? 'REGULAR' :
        'SIN DATOS';

      document.getElementById('detailStars').innerHTML = [1, 2, 3, 4, 5].map(i => `<span class="star${i<=stars?' on':''}"">★</span>`).join('');
      document.getElementById('detailScore').textContent = score.toFixed(1) + ' / 5.0';
      document.getElementById('detailVerdict').textContent = verdict;
      document.getElementById('detailQuote').textContent = pelicula.resumen ?
        pelicula.resumen.slice(0, 120) + (pelicula.resumen.length > 120 ? '…' : '') :
        'Sin reseña disponible.';
      document.getElementById('detailCritic').textContent =
        pelicula.director?.nombre ?
        'DIR. ' + (pelicula.director.nombre).toUpperCase() + ' · PIXELVHS' :
        'PIXELVHS · EST. 1985';

      const rentBtn = document.getElementById('detailRentBtn');
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
      const loader = document.getElementById('vhsLoader');
      const slot = document.getElementById('vhsSlot');
      const overlay = document.getElementById('detailOverlay');
      const panel = document.getElementById('detailPanel');

      slot.style.display = 'block';
      slot.style.animation = 'slot-glow 1s ease-in-out infinite';
      loader.style.display = 'flex';
      loader.style.animation = 'cassette-insert 2.2s cubic-bezier(.4,0,.2,1) forwards';
      overlay.style.display = 'block';
      requestAnimationFrame(() => overlay.classList.add('visible'));

      setTimeout(() => {
        loader.style.display = slot.style.display = 'none';
        loader.style.animation = '';
        panel.style.display = 'block';
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(() => panel.classList.add('show'));
      }, 2100);
    }

    /* ══ CLOSE DETAIL ══ */
    function closeDetail() {
      const panel = document.getElementById('detailPanel');
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

    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') closeDetail();
    });

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
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/alertas.js') }}"></script>
  <script>
    (function() {

      /* ─── estado ─── */
      let _activeFmt = null;

      /* ─── switchFormat: toggle por formato ─── */
      window.switchFormat = function(fmt) {

        document.querySelectorAll('.fmt-scene').forEach(s => s.style.display = 'none');
        document.querySelectorAll('.fmt-btn').forEach(b => b.classList.remove('active'));

        if (_activeFmt === fmt) {
          /* deactivate: volver al poster */
          _activeFmt = null;
          document.getElementById('formatViewer').style.display = 'none';
          document.getElementById('posterDefault').style.display = 'block';
          return;
        }

        _activeFmt = fmt;

        /* mostrar visor, ocultar poster */
        document.getElementById('posterDefault').style.display = 'none';
        document.getElementById('formatViewer').style.display = 'flex';

        const panel = document.getElementById('fmt-' + fmt);
        if (panel) panel.style.display = 'flex';

        const btn = document.querySelector('.fmt-btn[data-fmt="' + fmt + '"]');
        if (btn) btn.classList.add('active');

        /* aplicar imágenes */
        if (window.currentMovie) _applyImages(fmt, window.currentMovie);
      };

      function _applyImages(fmt, m) {
        var imgs = {
          dvd: m.imagen_dvd || m.foto_portada || m.foto_caratula || '',
          bluray: m.imagen_bluray || m.foto_portada || m.foto_caratula || '',
          uhd: m.imagen_uhd || m.foto_portada || m.foto_caratula || '',
          vhs: m.imagen_vhs || m.foto_portada || m.foto_caratula || ''
        };

        if (fmt === 'dvd') {
          // Frente: mostrar solo la parte derecha de la imagen (portada)
          var front = document.getElementById('fvDvdFront');
          if (front && imgs.dvd) {
            front.style.backgroundImage = 'url("' + imgs.dvd + '")';
            front.style.backgroundSize = 'auto 100%'; 
            front.style.backgroundPosition = 'right center'; 
            front.style.backgroundRepeat = 'no-repeat';
          }

          var back = document.getElementById('fvDvdBack');
          if (back && imgs.dvd) {
            back.style.backgroundImage = 'url("' + imgs.dvd + '")';
            back.style.backgroundSize = 'auto 100%';
            back.style.backgroundPosition = 'left center'; 
            back.style.backgroundRepeat = 'no-repeat';
          }

          // Lomo: parte central
          var left = document.getElementById('fvDvdLeft');
          if (left && imgs.dvd) {
            left.style.backgroundImage = 'url("' + imgs.dvd + '")';
            left.style.backgroundSize = 'auto 100%';
            left.style.backgroundPosition = 'center center';
            left.style.backgroundRepeat = 'no-repeat';
          }
        }

        if (fmt === 'bluray') {
          _bg('fvBlurayFront', imgs.bluray);
        }

        if (fmt === 'uhd') {
          _bg('fvUhdFront', imgs.uhd);
        }

        if (fmt === 'vhs') {
          var cover = document.getElementById('fvVhsCover');
          if (cover) cover.style.setProperty('--cover', 'url("' + imgs.vhs + '")');
          var title = document.getElementById('fvVhsTitle');
          if (title) title.textContent = (m.titulo || '').substring(0, 14).toUpperCase();
        }
      }

      function _bg(id, url) {
        var el = document.getElementById(id);
        if (el && url) el.style.backgroundImage = 'url("' + url + '")';
      }

      /* ─── Hook openDetail: resetear al abrir nueva película ─── */
      var _orig = window.openDetail;
      window.openDetail = function(pelicula) {
        /* reset formato activo */
        _activeFmt = null;
        document.querySelectorAll('.fmt-scene').forEach(s => s.style.display = 'none');
        document.querySelectorAll('.fmt-btn').forEach(b => b.classList.remove('active'));
        document.getElementById('formatViewer').style.display = 'none';
        document.getElementById('posterDefault').style.display = 'block';

        _orig(pelicula);
      };

      /* ─── Mouse sheen en discos ─── */
      document.addEventListener('mousemove', function(e) {
        ['fvBluraySheen', 'fvUhdSheen'].forEach(function(id) {
          var el = document.getElementById(id);
          if (!el) return;
          var disc = el.closest('.fv-disc');
          if (!disc) return;
          var r = disc.getBoundingClientRect();
          var x = Math.min(100, Math.max(0, ((e.clientX - r.left) / r.width) * 100));
          var y = Math.min(100, Math.max(0, ((e.clientY - r.top) / r.height) * 100));
          el.style.setProperty('--sheen-x', ((x - 50) * 0.5 + 50) + '%');
          el.style.setProperty('--sheen-y', ((y - 50) * 0.5 + 50) + '%');
        });
      });

      /* ─── UHD hover: acelerar efectos ─── */
      document.addEventListener('DOMContentLoaded', function() {
        var uhdDisc = document.getElementById('fvUhd');
        if (!uhdDisc) return;
        uhdDisc.addEventListener('mouseenter', function() {
          ['fv-rainbow-ring', 'fv-diffraction'].forEach(function(cls) {
            var el = uhdDisc.querySelector('.' + cls);
            if (el) el.style.animationDuration = '1.5s';
          });
        });
        uhdDisc.addEventListener('mouseleave', function() {
          ['fv-rainbow-ring', 'fv-diffraction'].forEach(function(cls) {
            var el = uhdDisc.querySelector('.' + cls);
            if (el) el.style.animationDuration = '';
          });
        });
      });

    })();
  </script>

</body>

</html>