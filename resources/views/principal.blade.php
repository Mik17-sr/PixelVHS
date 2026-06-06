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
  'cintas' => $pelicula->cintas->map(fn($c) => [
  'id_cinta' => $c->id_cinta,
  'rentada' => $c->rentada,
  'estado' => $c->estado,
  'id_formato' => $c->id_formato,
  'formato' => [
  'nombre' => $c->formato?->nombre,
  'multiplicador' => (float) ($c->formato?->multiplicador ?? 1),
  ],
  ]),
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
  'cintas' => $pelicula->cintas->map(fn($c) => [
  'id_cinta' => $c->id_cinta,
  'rentada' => $c->rentada,
  'estado' => $c->estado,
  'id_formato' => $c->id_formato,
  'formato' => [
  'nombre' => $c->formato?->nombre,
  'multiplicador' => (float) ($c->formato?->multiplicador ?? 1),
  ],
  ]),
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
    window.ROUTES = {
      socioDatos: @json(route('socio.datos')),
      rentasCrear: @json(route('rentas.crear')),
      rentasMis: @json(route('rentas.mis')),
      listaEsperaUnirse: @json(route('lista-espera.unirse')),
      valoracionesGuardar: @json(route('valoraciones.guardar')),
      valoracionesPelicula: @json(route('valoraciones.pelicula', ['id' => '__ID__'])),
      valoracionesMia: @json(route('valoraciones.mia', ['id' => '__ID__'])),
      recomendaciones: @json(route('recomendaciones')),
    };
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
        <div style="position:relative;">
          <button class="ico-btn" id="notifBtn" onclick="toggleNotifs()">
            NOTIFICACIONES
            @php $unread = auth()->user()->unreadNotifications->count(); @endphp
            @if($unread > 0)
            <span id="notifBadge" style="
                      position:absolute; top:-4px; right:-4px;
                      background:var(--v); color:var(--w);
                      font-family:var(--fo); font-size:7px;
                      width:16px; height:16px; border-radius:50%;
                      display:flex; align-items:center; justify-content:center;
                      letter-spacing:0;">{{ $unread }}</span>
            @endif
          </button>

          <div id="notifDropdown" style="
                  display:none; position:absolute; top:100%; right:0; margin-top:8px;
                  background:var(--ink2); border:1px solid rgba(123,94,167,.3);
                  width:320px; max-height:400px; overflow-y:auto;
                  box-shadow:0 10px 40px rgba(0,0,0,.8); z-index:300;">

            <div style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,.05);
                              display:flex; justify-content:space-between; align-items:center;">
              <span style="font-family:var(--fm);font-size:9px;letter-spacing:2px;color:var(--g);">
                NOTIFICACIONES
              </span>
              <button onclick="marcarTodasLeidas()" style="
                          font-family:var(--fm);font-size:8px;letter-spacing:1px;
                          color:var(--v-dim);background:transparent;border:none;cursor:pointer;">
                ✓ MARCAR LEÍDAS
              </button>
            </div>

            @forelse(auth()->user()->notifications->take(10) as $notif)
            <div style="
                      padding:14px 16px;
                      border-bottom:1px solid rgba(255,255,255,.03);
                      background:{{ $notif->read_at ? 'transparent' : 'rgba(123,94,167,.06)' }};
                      border-left:2px solid {{ $notif->read_at ? 'transparent' : 'var(--v)' }};
                      cursor:pointer;"
              onclick="irAPelicula('{{ $notif->id }}')">
              <div style="font-family:var(--fh);font-size:13px;letter-spacing:2px;color:var(--w);">
                {{ strtoupper($notif->data['titulo'] ?? '—') }}
              </div>
              <div style="font-family:var(--fm);font-size:8px;letter-spacing:1px;color:var(--g);margin-top:4px;">
                {{ strtoupper($notif->data['formato'] ?? '') }} · DISPONIBLE AHORA
              </div>
              <div style="font-family:var(--fm);font-size:7px;color:var(--v-dim);margin-top:4px;">
                {{ $notif->created_at->diffForHumans() }}
              </div>
            </div>
            @empty
            <div style="padding:24px;text-align:center;font-family:var(--fm);
                              font-size:9px;letter-spacing:2px;color:var(--g);">
              SIN NOTIFICACIONES
            </div>
            @endforelse

          </div>
        </div>
        <div class="user-menu-container">
          <button class="ico-btn" id="userBtn" onclick="toggleUserMenu()">👤 PERFIL</button>
          <div class="user-dropdown" id="userDropdown">
            <div class="dropdown-item" onclick="navigatePerfil()">◈ MI PERFIL</div>
            <div class="dropdown-item" onclick="navigateMisRentas()">⬡ MIS RENTAS</div>
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
    <div class="movies-main" id="moviesMain">
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
                <button class="btn-info"
                  onclick="event.stopPropagation(); openDetail(window.MOVIE_MAP[{{ $pelicula->id_pelicula }}])">
                  VER MÁS
                </button>
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
          @php $disponibles = $pelicula->cintas->where('rentada', 0)->count(); @endphp
          <div class="card"
            data-genre="{{ $pelicula->genero->id_genero ?? 'n/a' }}"
            data-title="{{ strtolower($pelicula->titulo) }}"
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
                <button class="btn-info"
                  onclick="event.stopPropagation(); openDetail(window.MOVIE_MAP[{{ $pelicula->id_pelicula }}])">
                  VER MÁS
                </button>
                <button class="btn-wish" onclick="event.stopPropagation()">♡</button>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="shelf" id="shelfRecomendadas" style="display:none;">
        <div class="shelf-head">
          <h2>RECOMENDADAS PARA TI</h2>
          <span id="recoSubtitle" style="color:var(--v-dim);">// BASADO EN TUS GUSTOS</span>
        </div>
        <div class="scroll-row" id="rowRecomendadas"></div>
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
          @php $disponibles = $pelicula->cintas->where('rentada', 0)->count(); @endphp
          <div class="card"
            data-genre="{{ $pelicula->genero->id_genero ?? 'n/a' }}"
            data-title="{{ strtolower($pelicula->titulo) }}"
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
                <button class="btn-info"
                  onclick="event.stopPropagation(); openDetail(window.MOVIE_MAP[{{ $pelicula->id_pelicula }}])">
                  VER MÁS
                </button>
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
        <div id="foto-loading" style="display:none;">
          <span class="spinner"></span>
        </div>

        <div style="text-align:center;">
          <div id="perfil-nombre-display" style="font-family:var(--fh); font-size:20px; letter-spacing:4px; color:var(--w);">
            {{ strtoupper(auth()->user()->nombre) }}
          </div>
          <div style="font-family:var(--fm); font-size:9px; letter-spacing:2px; margin-top:4px;
                    color:{{ auth()->user()->rol === 'admin' ? 'var(--v)' : 'var(--amber)' }}">
            {{ strtoupper(auth()->user()->rol) }}
          </div>
        </div>

        <span class="status-pill activo" style="font-size:8px;">◉ ACTIVO</span>
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
  <div class="view" id="view-mis-rentas" style="display:none; padding:40px 52px;">
    <div class="page-header" style="display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:32px; padding-bottom:18px; border-bottom:1px solid rgba(255,255,255,0.05);">
      <div>
        <h2 style="font-family:var(--fh); font-size:34px; letter-spacing:6px; color:var(--w); line-height:1;">MIS RENTAS</h2>
        <small style="font-family:var(--fm); font-size:9px; color:var(--g); letter-spacing:2px; display:block; margin-top:5px;">// HISTORIAL Y DEVOLUCIONES</small>
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
    <div id="misRentasContent" style="display:grid; grid-template-columns:1fr; gap:18px;">
      <div style="font-family:var(--fm); font-size:9px; letter-spacing:2px; color:var(--g);">Cargando tus rentas...</div>
    </div>
  </div>
  <div class="vhs-slot" id="vhsSlot">
    <div class="vhs-slot-inner"></div>
  </div>

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
  <div class="detail-overlay" id="detailOverlay"></div>
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
          <div class="detail-actions">
            <button class="btn-primary" id="detailRentBtn" onclick="handleRent(event)">+ RENTAR</button>
            <button class="btn-secondary">♡ GUARDAR</button>
          </div>
          <div id="valoraciones-panel"></div>
        </div>
      </div>
    </div>
    <div id="carritoFlotante" style="
  display: none;
  position: fixed;
  bottom: 28px;
  right: 28px;
  z-index: 5000;
">
      <button onclick="abrirModalCarrito()" style="
    font-family: var(--fo);
    font-size: 9px;
    letter-spacing: 2px;
    background: var(--v);
    color: var(--w);
    border: none;
    padding: 13px 22px;
    cursor: pointer;
    box-shadow: 0 8px 32px rgba(123,94,167,.45);
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all .2s;
  "
        onmouseover="this.style.background='#9370C8'"
        onmouseout="this.style.background='var(--v)'">
        <span style="font-size:15px; line-height:1;"></span>
        VER CARRITO
        <span id="carritoFlotanteCnt" style="
      background: var(--w);
      color: var(--v);
      font-family: var(--fo);
      font-size: 8px;
      letter-spacing: 1px;
      padding: 2px 7px;
      border-radius: 2px;
      font-weight: 700;
    ">0</span>
      </button>
    </div>
  </div>

  <script>
    const BASE_URL = "http://localhost/PixelVHS/public";
    window.currentMovie = null;
    let activeGenreId = 'all';
    let filterMode = false;
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content;


    /* ══ USER MENU ══ */
    function toggleUserMenu() {
      document.getElementById('userDropdown').classList.toggle('active');
    }

    function navigatePerfil() {
      document.getElementById('userDropdown').classList.remove('active');
      document.getElementById('mainView').style.display = 'none';
      document.getElementById('view-mis-rentas').style.display = 'none';
      document.getElementById('view-perfil').style.display = 'block';
    }

    function navigateMisRentas() {
      document.getElementById('userDropdown').classList.remove('active');
      document.getElementById('mainView').style.display = 'none';
      document.getElementById('view-perfil').style.display = 'none';
      document.getElementById('view-mis-rentas').style.display = 'block';
      cargarMisRentas();
    }

    function navigateHome() {
      document.getElementById('view-perfil').style.display = 'none';
      document.getElementById('view-mis-rentas').style.display = 'none';
      document.getElementById('mainView').style.display = 'block';
    }

    async function cargarMisRentas() {
      const container = document.getElementById('misRentasContent');
      container.innerHTML = `<div style="font-family:var(--fm);font-size:9px;letter-spacing:2px;color:var(--g);">Cargando tus rentas...</div>`;

      try {
        const res = await fetch(window.ROUTES?.rentasMis || '/mis-rentas', {
          method: 'GET',
          credentials: 'same-origin',
          headers: {
            'Accept': 'application/json'
          }
        });

        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        renderMisRentas(data.prestamos || [], data.lista_espera || []);
      } catch (err) {
        container.innerHTML = `<div style="font-family:var(--fm);font-size:9px;color:var(--red);">Error al cargar rentas.</div>`;
      }
    }

    function formatDateTime(value) {
      if (!value) return '—';
      const date = new Date(value);
      if (isNaN(date)) return value;
      const day = String(date.getDate()).padStart(2, '0');
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const year = date.getFullYear();
      const hours = String(date.getHours()).padStart(2, '0');
      const minutes = String(date.getMinutes()).padStart(2, '0');
      return `${day}/${month}/${year} ${hours}:${minutes}`;
    }

    function renderMisRentas(prestamos, listaEspera = []) {
      const container = document.getElementById('misRentasContent');

      // ── Sección lista de espera ──
      const listaHtml = listaEspera.length ? `
          <div style="margin-bottom:28px;">
              <div style="font-family:var(--fh);font-size:18px;letter-spacing:4px;color:var(--w);margin-bottom:14px;">
                  LISTA DE ESPERA
              </div>
              ${listaEspera.map(e => `
                  <div style="background:var(--ink2);border:1px solid rgba(212,160,23,.2);border-left:3px solid var(--amber);
                              padding:16px 20px;margin-bottom:8px;display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;">
                      <div>
                          <div style="font-family:var(--fh);font-size:16px;letter-spacing:2px;color:var(--w);">
                              ${e.pelicula}
                          </div>
                          <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-top:4px;">
                              ${e.formato} · POSICIÓN #${e.posicion}
                              ${e.notificado ? ' · <span style="color:#4CAF6A;">◉ DISPONIBLE</span>' : ''}
                          </div>
                          <div style="font-family:var(--fm);font-size:8px;letter-spacing:1px;color:var(--g);margin-top:2px;">
                              En espera desde: ${formatDateTime(e.fecha_solicitud)}
                          </div>
                      </div>
                      <button onclick="salirListaEspera(${e.id_lista_espera})"
                          style="font-family:var(--fo);font-size:8px;letter-spacing:2px;background:transparent;
                                color:var(--g);border:1px solid var(--g-dark);padding:8px 16px;cursor:pointer;transition:all .18s;white-space:nowrap;"
                          onmouseover="this.style.borderColor='#c0392b';this.style.color='#c0392b'"
                          onmouseout="this.style.borderColor='var(--g-dark)';this.style.color='var(--g)'">
                          ✕ SALIR DE FILA
                      </button>
                  </div>
              `).join('')}
          </div>
      ` : '';

      // ── Sección préstamos ──
      const prestamosHtml = !prestamos.length ?
        `<div style="font-family:var(--fm);font-size:9px;letter-spacing:2px;color:var(--g);">No tienes préstamos registrados.</div>` :
        prestamos.map(p => {
          // ...tu código existente de renderMisRentas para cada préstamo...
          const isActive = String(p.estado).toLowerCase() === 'activo';
          const isPendiente = String(p.estado).toLowerCase() === 'pendiente';
          const statusColor = isActive ? 'var(--v)' : isPendiente ? '#ffd700' : 'var(--g)';
          const diasRestantes = p.dias_restantes != null ?
            `${p.dias_restantes} día${Math.abs(p.dias_restantes) !== 1 ? 's' : ''}` :
            '—';
          const vencidoLabel = p.vencido ? ' (VENCIDO)' : '';

          const cintasHtml = (p.cintas || []).map(c => `
                  <div style="font-family:var(--fm);font-size:8px;letter-spacing:1px;color:var(--w);margin-bottom:3px;">
                      • ${c.pelicula} · ${c.formato} · $${Number(c.precio).toLocaleString('es-CO')}
                  </div>
              `).join('');

          const multasHtml = (p.multas || []).length ? `
                  <div style="margin-top:10px;font-family:var(--fm);font-size:8px;letter-spacing:1px;color:var(--g);">
                      MULTAS:
                      ${(p.multas || []).map(m =>
                          `<div>• ${m.concepto}: $${Number(m.valor).toLocaleString('es-CO')} ${m.pagada ? '(PAGADA)' : '(PENDIENTE)'}</div>`
                      ).join('')}
                  </div>
              ` : '';

          const botonPagoHtml = isPendiente ? `
                  <div style="margin-top:16px;padding:14px 18px;border-top:1px solid rgba(255,255,255,.05);background:rgba(42,111,70,.06);">
                      <div style="font-family:var(--fm);font-size:8px;letter-spacing:1px;color:var(--g);margin-bottom:10px;">
                          Tu renta está pendiente de pago para activarse.
                      </div>
                      <div style="display:flex;gap:10px;flex-wrap:wrap;">
                          <button onclick="abrirModalPagoPSE(${p.id_prestamo}, ${p.dias_totales || 3}, ${p.monto_total || 0})"
                              style="font-family:var(--fo);font-size:9px;letter-spacing:2px;background:#2a6f46;color:#fff;
                                    border:none;padding:10px 22px;cursor:pointer;transition:all .2s;"
                              onmouseover="this.style.background='#1f4d32'"
                              onmouseout="this.style.background='#2a6f46'">
                              ✓ PAGAR AHORA
                          </button>
                          <button onclick="cancelarPrestamo(${p.id_prestamo})"
                              style="font-family:var(--fo);font-size:9px;letter-spacing:2px;background:#8b1e1e;color:#fff;
                                    border:none;padding:10px 22px;cursor:pointer;transition:all .2s;"
                              onmouseover="this.style.background='#651515'"
                              onmouseout="this.style.background='#8b1e1e'">
                              ✕ CANCELAR RENTA
                          </button>
                      </div>
                  </div>
              ` : '';

          const infoConsulta = isActive ? `
                  <div style="margin-top:16px;padding:14px 18px;border-top:1px solid rgba(255,255,255,.05);background:rgba(79,46,140,.08);">
                      <div style="font-family:var(--fm);font-size:9px;letter-spacing:1px;color:var(--g);">
                          Para devolver o cancelar este préstamo, contacta al empleado.
                      </div>
                  </div>
              ` : '';

          return `
                  <div style="background:var(--ink2);border:1px solid rgba(123,94,167,.2);border-radius:6px;overflow:hidden;">
                      <div style="padding:22px;">
                          <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:10px;flex-wrap:wrap;">
                              <div>
                                  <div style="font-family:var(--fm);font-size:10px;letter-spacing:2px;color:var(--g);margin-bottom:6px;">
                                      PRÉSTAMO #${String(p.id_prestamo).padStart(4,'0')}
                                  </div>
                                  <div style="font-family:var(--fh);font-size:18px;letter-spacing:2px;color:var(--w);">
                                      ${p.estado.toUpperCase()}
                                  </div>
                              </div>
                              <div style="text-align:right;min-width:160px;">
                                  <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:${statusColor};">
                                      ${diasRestantes}${vencidoLabel}
                                  </div>
                                  <div style="font-family:var(--fm);font-size:8px;letter-spacing:1px;color:var(--g);margin-top:6px;">
                                      Inicio: ${formatDateTime(p.fecha_inicio)}
                                  </div>
                                  <div style="font-family:var(--fm);font-size:8px;letter-spacing:1px;color:var(--g);">
                                      Límite: ${formatDateTime(p.fecha_limite)}
                                  </div>
                              </div>
                          </div>
                          <div style="margin-top:16px;border-top:1px solid rgba(255,255,255,.05);padding-top:14px;">
                              ${cintasHtml}
                              ${multasHtml}
                              ${p.observaciones
                                  ? `<div style="margin-top:10px;font-family:var(--fm);font-size:8px;letter-spacing:1px;color:var(--g);">OBS: ${p.observaciones}</div>`
                                  : ''}
                          </div>
                      </div>
                      ${botonPagoHtml}
                      ${infoConsulta}
                  </div>
              `;
        }).join('');

      container.innerHTML = listaHtml + prestamosHtml;
    }
    async function salirListaEspera(id) {
      const confirmado = await alertaConfirmar({
        titulo: 'SALIR DE LA FILA',
        texto: '<p>¿Deseas salir de la lista de espera para esta película?</p>',
        icono: 'warning',
        boton: 'SALIR',
        cancelar: true
      });

      if (!confirmado.isConfirmed) return;

      try {
        const res = await fetch(`${BASE_URL}/lista-espera/${id}`, {
          method: 'DELETE',
          credentials: 'same-origin',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          }
        });

        if (!res.ok) throw new Error(`HTTP ${res.status}`);

        await alertaRetro({
          titulo: 'LISTO',
          texto: '<p>Saliste de la lista de espera.</p>',
          icono: 'success'
        });

        cargarMisRentas();
      } catch (err) {
        alertaRetro({
          titulo: 'ERROR',
          texto: '<p>No se pudo procesar la solicitud.</p>',
          icono: 'error'
        });
      }
    }

    async function devolverPrestamo(id) {
      const confirm = await alertaConfirmar({
        titulo: 'CONFIRMAR DEVOLUCIÓN',
        texto: '<p>¿Deseas devolver este préstamo ahora?</p>',
        icono: 'warning',
        boton: 'DEVOLVER',
        cancelar: true
      });

      if (!confirm.isConfirmed) return;

      try {
        const url = `/prestamos/${id}/devolver`;
        const res = await fetch(url, {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          }
        });

        if (!res.ok) {
          const errorData = await res.json().catch(() => null);
          throw new Error(errorData?.message || `HTTP ${res.status}`);
        }

        alertaRetro({
          titulo: 'DEVOLUCIÓN COMPLETADA',
          texto: '<p>Tu préstamo fue devuelto correctamente.</p>',
          icono: 'success'
        });
        cargarMisRentas();
      } catch (err) {
        console.error('Error al devolver préstamo:', err);
        alertaRetro({
          titulo: 'ERROR EN DEVOLUCIÓN',
          texto: `<p>${err.message}</p>`,
          icono: 'error'
        });
      }
    }

    async function cancelarPrestamo(id) {
      const confirm = await alertaConfirmar({
        titulo: 'CONFIRMAR CANCELACIÓN',
        texto: '<p>¿Deseas cancelar este préstamo?</p>',
        icono: 'warning',
        boton: 'CANCELAR',
        cancelar: true
      });

      if (!confirm.isConfirmed) return;

      try {
        const url = `${BASE_URL}/prestamos/${id}/cancelar`;
        console.log(url);
        console.log(window.location.origin);
        console.log(window.location.href);
        const res = await fetch(url, {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          }
        });

        if (!res.ok) {
          const errorData = await res.json().catch(() => null);
          throw new Error(errorData?.message || `HTTP ${res.status}`);
        }

        alertaRetro({
          titulo: 'PRÉSTAMO CANCELADO',
          texto: '<p>El préstamo fue cancelado correctamente.</p>',
          icono: 'success'
        });
        cargarMisRentas();
      } catch (err) {
        console.error('Error al cancelar préstamo:', err);
        alertaRetro({
          titulo: 'ERROR EN CANCELACIÓN',
          texto: `<p>${err.message}</p>`,
          icono: 'error'
        });
      }
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
          String(m.genero?.id_genero ?? m.genero ?? '') === String(activeGenreId);
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
      activeGenreId = g === 'all' ? 'all' : String(g);

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
      const disponibles = cintas.filter(c => {
        const estado = (c.estado || '').toLowerCase().trim();
        return estado === 'disponible' || c.rentada === 0 || c.rentada === '0' || c.rentada === false;
      }).length;
      const total = cintas.length;

      const rentBtn = document.getElementById('detailRentBtn');
      const rentedBanner = document.getElementById('detailRented');
      if (disponibles === 0) {
        rentBtn.textContent = 'UNIRME A LISTA DE ESPERA';
        rentBtn.classList.remove('disabled');
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
        cargarValoraciones(pelicula.id_pelicula);
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
    let carritoRentas = [];
    let datosFormatoModal = null;
    let datosSocioActual = null;

    async function cargarDatosSocio() {
      try {
        const url = window.ROUTES?.socioDatos || '/socio/datos';
        const res = await fetch(url, {
          method: 'GET',
          credentials: 'same-origin',
          headers: {
            'Accept': 'application/json',
          }
        });

        const contentType = res.headers.get('content-type') || '';
        if (!res.ok) {
          let message = `HTTP ${res.status} ${res.statusText}`;
          if (contentType.includes('application/json')) {
            const errorData = await res.json();
            message = errorData?.message || errorData?.error || message;
          }
          throw new Error(message);
        }

        if (!contentType.includes('application/json')) {
          throw new Error('Respuesta inesperada del servidor');
        }

        datosSocioActual = await res.json();
      } catch (err) {
        console.error('Error al cargar datos del socio:', err);
        alertaRetro({
          titulo: 'ERROR AL CARGAR DATOS',
          texto: `<p>No se pudieron obtener los datos del socio. ${err.message}</p>`,
          icono: 'error'
        });
      }
    }

    async function handleRent(event) {
      event.preventDefault();
      if (!currentMovie) return;

      if (!datosSocioActual) await cargarDatosSocio();

      const cintas = (currentMovie.cintas || []).filter(c => {
        const estado = (c.estado || '').toLowerCase().trim();
        return estado === 'disponible' || c.rentada === 0 || c.rentada === '0' || c.rentada === false;
      });

      if (!cintas.length) {
        abrirModalListaEsperaGeneral(currentMovie);
        return;
      }

      datosFormatoModal = {
        pelicula: currentMovie,
        cintas: cintas
      };

      abrirModalSeleccionarCinta(currentMovie, cintas);
    }

    function abrirModalSeleccionarCinta(pelicula, cintas) {
      const porFormato = {};
      cintas.forEach(c => {
        const fmt = c.formato?.nombre ?? `Formato ${c.id_formato}`;
        const mult = parseFloat(c.formato?.multiplicador) || 1;
        if (!porFormato[fmt]) porFormato[fmt] = {
          cintas: [],
          multiplicador: mult
        };
        porFormato[fmt].cintas.push(c);
      });

      const todasCintas = pelicula.cintas || [];
      const formatosNoDisponibles = new Map();
      todasCintas.forEach(c => {
        const estado = (c.estado || '').toLowerCase().trim();
        const disponible = estado === 'disponible' || c.rentada === 0;
        const fmt = c.formato?.nombre ?? `Formato ${c.id_formato}`;
        if (!disponible && c.id_formato && !porFormato[fmt]) {
          if (!formatosNoDisponibles.has(c.id_formato)) {
            formatosNoDisponibles.set(c.id_formato, fmt);
          }
        }
      });

      const precioBase = parseFloat(pelicula.precio_alquiler || 0);
      const fmtHtml = Object.entries(porFormato).map(([fmt, grupo]) => {
        const precioDia1 = precioBase * grupo.multiplicador;

        return `
            <div style="margin-bottom:12px;">
                <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--v);margin-bottom:8px;">
                    ${fmt} · ${grupo.cintas.length} DISPONIBLE${grupo.cintas.length > 1 ? 'S' : ''}
                    <span style="margin-left:8px;color:var(--g);">
                        $${Number(precioDia1).toLocaleString('es-CO')} primer día
                    </span>
                </div>
                ${grupo.cintas.map(c => `
                    <label style="display:flex;align-items:center;gap:10px;padding:8px 12px;
                                  background:var(--ink3);border:1px solid var(--g-dark);
                                  margin-bottom:4px;cursor:pointer;transition:border-color .15s;"
                        onmouseover="this.style.borderColor='var(--v-dim)'"
                        onmouseout="this.style.borderColor='var(--g-dark)'">
                        <input type="radio" name="cinta_seleccionar" value="${c.id_cinta}"
                            data-precio-base="${precioBase}"
                            data-multiplicador="${grupo.multiplicador}"
                            data-pelicula-id="${pelicula.id_pelicula}"
                            data-pelicula-titulo="${pelicula.titulo.toUpperCase()}"
                            style="accent-color:var(--v);width:14px;height:14px;">
                        <span style="font-family:var(--fm);font-size:9px;letter-spacing:1px;color:var(--w);">
                            #${String(c.id_cinta).padStart(5,'0')} - ${fmt}
                        </span>
                        <span style="font-family:var(--fo);font-size:9px;color:var(--v);margin-left:auto;">
                            $${Number(precioDia1).toLocaleString('es-CO')}
                        </span>
                    </label>
                `).join('')}
            </div>`;
      }).join('');
      const esperaHtml = formatosNoDisponibles.size ? `
          <div style="margin-top:16px;padding-top:14px;border-top:1px solid rgba(255,255,255,.05);">
              <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-bottom:10px;">
                  FORMATOS NO DISPONIBLES · UNIRSE A LISTA DE ESPERA
              </div>
              ${[...formatosNoDisponibles.entries()].map(([id, nombre]) => `
                  <div style="display:flex;align-items:center;justify-content:space-between;
                              padding:8px 12px;background:var(--ink3);border:1px solid var(--g-dark);
                              margin-bottom:4px;">
                      <span style="font-family:var(--fm);font-size:9px;letter-spacing:1px;color:var(--g);">
                          ${nombre} · NO DISPONIBLE
                      </span>
                      <button onclick="cerrarModalSelCinta(); abrirModalListaEsperaFormato(${pelicula.id_pelicula}, '${pelicula.titulo}', ${id}, '${nombre}')"
                          style="font-family:var(--fo);font-size:7px;letter-spacing:1px;background:transparent;
                                color:var(--amber);border:1px solid rgba(212,160,23,.4);padding:5px 10px;
                                cursor:pointer;transition:all .18s;white-space:nowrap;"
                          onmouseover="this.style.background='rgba(212,160,23,.1)'"
                          onmouseout="this.style.background='transparent'">
                          ⌛ ESPERAR
                      </button>
                  </div>
              `).join('')}
          </div>
      ` : '';

      const modalHtml = `
        <div id="modal-sel-cinta" style="position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:20000;display:flex;align-items:center;justify-content:center;padding:20px;">
            <div style="background:var(--ink2);border:1px solid rgba(123,94,167,.35);width:100%;max-width:480px;">
                <div style="padding:18px 24px;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;background:var(--ink2);z-index:10;">
                    <div>
                        <div style="font-family:var(--fh);font-size:18px;letter-spacing:4px;color:var(--w);">SELECCIONAR FORMATO</div>
                        <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-top:3px;">${pelicula.titulo.toUpperCase()}</div>
                    </div>
                    <span onclick="cerrarModalSelCinta()" style="cursor:pointer;color:var(--g);font-size:20px;"
                        onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--g)'">✕</span>
                </div>
                <div style="padding:24px;">
                    <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-bottom:14px;">ELIGE UNA CINTA</div>
                    ${fmtHtml}
                    
                    <div style="display:flex;gap:10px;margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,.04);">
                        <button onclick="agregarAlCarrito()"
                            style="font-family:var(--fo);font-size:9px;letter-spacing:2px;background:var(--v);color:var(--w);border:none;padding:11px 24px;cursor:pointer;flex:1;transition:all .2s;"
                            onmouseover="this.style.background='#9370C8'" onmouseout="this.style.background='var(--v)'">
                            + AGREGAR AL CARRITO
                        </button>
                        <button onclick="cerrarModalSelCinta()"
                            style="font-family:var(--fm);font-size:9px;letter-spacing:2px;background:transparent;color:var(--g);border:1px solid var(--g-dark);padding:10px 18px;cursor:pointer;">
                            CANCELAR
                        </button>
                    </div>
                </div>
            </div>
        </div>`;

      document.body.insertAdjacentHTML('beforeend', modalHtml);
      document.body.style.overflow = 'hidden';
    }

    function agregarAlCarrito() {
      const selected = document.querySelector('[name="cinta_seleccionar"]:checked');
      if (!selected) {
        alertaRetro({
          titulo: 'SELECCIONA UNA CINTA',
          texto: '<p>Debes elegir un formato de película antes de agregar al carrito.</p>',
          icono: 'warning'
        });
        return;
      }

      const cintaId = parseInt(selected.value);

      // Verificar si la película ya está en el carrito
      if (carritoRentas.find(r => r.id_cinta === cintaId)) {
        alertaRetro({
          titulo: 'PELÍCULA EN CARRITO',
          texto: '<p>Esta película ya está en el carrito. Selecciona otro formato o agrega otra película.</p>',
          icono: 'info'
        });
        return;
      }

      // Verificar límite de películas
      if (datosSocioActual && carritoRentas.length >= datosSocioActual.disponibles) {
        alertaRetro({
          titulo: 'LÍMITE ALCANZADO',
          texto: `<p>No puedes rentar más películas.<br/>Máximo permitido: <strong>${datosSocioActual.max_peliculas_simultaneas}</strong><br/>Activas: <strong>${datosSocioActual.rentas_activas}</strong><br/>Disponibles: <strong>${datosSocioActual.disponibles}</strong></p>`,
          icono: 'error'
        });
        return;
      }

      const item = {
        id_cinta: cintaId,
        precio_base: parseFloat(selected.dataset.precioBase),
        multiplicador: parseFloat(selected.dataset.multiplicador),
        pelicula_id: parseInt(selected.dataset.peliculaId),
        pelicula_titulo: selected.dataset.peliculaTitulo
      };

      carritoRentas.push(item);
      cerrarModalSelCinta();
      actualizarFlotante();
      abrirModalCarrito();
    }

    function abrirModalCarrito() {
      const carritoHtml = carritoRentas.map((item, idx) => {
        const costoPrimerDia = item.precio_base * item.multiplicador;
        return `
            <div style="display:flex;align-items:center;justify-content:space-between;background:var(--ink3);padding:12px;border:1px solid var(--g-dark);margin-bottom:8px;border-radius:2px;">
                <div style="flex:1;">
                    <div style="font-family:var(--fm);font-size:9px;letter-spacing:1px;color:var(--w);">
                        #${item.pelicula_id} · ${item.pelicula_titulo}
                    </div>
                    <div style="font-family:var(--fm);font-size:8px;letter-spacing:1px;color:var(--g);margin-top:2px;">
                        Cinta #${String(item.id_cinta).padStart(5,'0')} · $${Number(costoPrimerDia).toLocaleString('es-CO')}/día
                    </div>
                </div>
                <button onclick="eliminarDelCarrito(${idx})" style="font-family:var(--fm);font-size:10px;color:var(--red);background:transparent;border:1px solid var(--red);padding:5px 12px;cursor:pointer;transition:all .18s;"
                    onmouseover="this.style.background='rgba(192,57,43,.1)'" onmouseout="this.style.background='transparent'">
                    ✕ QUITAR
                </button>
            </div>`;
      }).join('');

      let contenido = '';
      if (carritoRentas.length === 0) {
        contenido = `<div style="text-align:center;padding:20px;color:var(--g);font-family:var(--fm);font-size:9px;">
                CARRITO VACÍO
            </div>`;
      } else {
        contenido = `
            <div style="margin-bottom:20px;">
                <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-bottom:10px;">
                    PELÍCULAS EN CARRITO (${carritoRentas.length}/${datosSocioActual?.max_peliculas_simultaneas || '?'})
                </div>
                ${carritoHtml}
            </div>

            <div style="margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,.05);">
                <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-bottom:14px;">DÍAS DE PRÉSTAMO</div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    ${[1,3,5,7,14].map(d => `
                        <button onclick="selDiasCarrito(this,${d})" data-dias="${d}" class="btn-dia-selector"
                            style="font-family:var(--fo);font-size:8px;letter-spacing:1px;padding:8px 16px;background:transparent;border:1px solid var(--g-dark);color:var(--g);cursor:pointer;transition:all .18s;"
                            onmouseover="this.style.borderColor='var(--v-dim)'"
                            onmouseout="if(!this.classList.contains('sel-dia'))this.style.borderColor='var(--g-dark)'">
                            ${d} DÍA${d > 1 ? 'S' : ''}
                        </button>
                    `).join('')}
                </div>
                <input type="hidden" id="carrito-dias" value="3">
            </div>

            <div style="margin-top:16px;">
                <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-bottom:10px;">MÉTODO DE PAGO</div>
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;">
                    <button onclick="selMetodoPago(this,'PSE')" data-metodo="PSE"
                        style="font-family:var(--fm);font-size:8px;letter-spacing:1px;padding:10px;background:transparent;border:1px solid var(--g-dark);color:var(--g);cursor:pointer;transition:all .18s;"
                        onmouseover="this.style.borderColor='var(--v-dim)'" onmouseout="if(!this.classList.contains('sel-metodo'))this.style.borderColor='var(--g-dark)'">
                        PSE
                    </button>
                </div>
                <input type="hidden" id="carrito-metodo" value="Efectivo">
            </div>

            <div style="margin-top:16px;background:rgba(123,94,167,.06);border:1px solid rgba(123,94,167,.15);padding:12px 16px;">
                <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-bottom:6px;">TOTAL</div>
                <div style="font-family:var(--fo);font-size:18px;letter-spacing:2px;color:var(--v);" id="carrito-total">
                    $0
                </div>
                <div style="font-family:var(--fm);font-size:8px;letter-spacing:1px;color:var(--g);margin-top:4px;" id="carrito-fecha">
                    Devolución: -
                </div>
            </div>`;
      }

      const modalHtml = `
        <div id="modal-carrito" style="position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:20000;display:flex;align-items:center;justify-content:center;padding:20px;overflow-y:auto;">
            <div style="background:var(--ink2);border:1px solid rgba(123,94,167,.35);width:100%;max-width:500px;max-height:90vh;overflow-y:auto;">
                <div style="padding:18px 24px;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;background:var(--ink2);z-index:10;">
                    <div>
                        <div style="font-family:var(--fh);font-size:20px;letter-spacing:4px;color:var(--w);">CARRITO DE RENTAS</div>
                        <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-top:3px;">MÚLTIPLES PELÍCULAS</div>
                    </div>
                    <span onclick="cerrarModalCarrito()" style="cursor:pointer;color:var(--g);font-size:20px;"
                        onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--g)'">✕</span>
                </div>
                <div style="padding:24px;">
                    ${contenido}
                    
                    ${carritoRentas.length > 0 ? `
                    <div style="display:flex;gap:10px;margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,.04);">
                        <button onclick="confirmarCarrito()" id="btn-confirmar-carrito"
                            style="font-family:var(--fo);font-size:9px;letter-spacing:2px;background:var(--v);color:var(--w);border:none;padding:11px 24px;cursor:pointer;flex:1;transition:all .2s;"
                            onmouseover="this.style.background='#9370C8'" onmouseout="this.style.background='var(--v)'">
                            ✓ CONFIRMAR RENTA
                        </button>
                        <button onclick="cerrarModalCarrito()"
                            style="font-family:var(--fm);font-size:9px;letter-spacing:2px;background:transparent;color:var(--g);border:1px solid var(--g-dark);padding:10px 18px;cursor:pointer;">
                            CANCELAR
                        </button>
                    </div>
                    ` : ''}
                </div>
            </div>
        </div>`;

      document.body.insertAdjacentHTML('beforeend', modalHtml);
      document.querySelector('[data-dias="3"]')?.click();
      actualizarTotalCarrito();
    }

    function selDiasCarrito(btn, dias) {
      document.querySelectorAll('[data-dias]').forEach(b => {
        b.classList.remove('sel-dia');
        b.style.background = 'transparent';
        b.style.borderColor = 'var(--g-dark)';
        b.style.color = 'var(--g)';
      });
      btn.classList.add('sel-dia');
      btn.style.background = 'var(--v-soft)';
      btn.style.borderColor = 'var(--v)';
      btn.style.color = 'var(--w)';
      document.getElementById('carrito-dias').value = dias;
      actualizarTotalCarrito();
    }

    function actualizarFlotante() {
      const btn = document.getElementById('carritoFlotante');
      const cnt = document.getElementById('carritoFlotanteCnt');
      if (!btn) return;
      if (carritoRentas.length > 0) {
        btn.style.display = 'block';
        cnt.textContent = carritoRentas.length;
      } else {
        btn.style.display = 'none';
      }
    }

    function selMetodoPago(btn, metodo) {
      document.querySelectorAll('[data-metodo]').forEach(b => {
        b.classList.remove('sel-metodo');
        b.style.background = 'transparent';
        b.style.borderColor = 'var(--g-dark)';
        b.style.color = 'var(--g)';
      });
      btn.classList.add('sel-metodo');
      btn.style.background = 'var(--v-soft)';
      btn.style.borderColor = 'var(--v)';
      btn.style.color = 'var(--w)';
      document.getElementById('carrito-metodo').value = metodo;
    }

    function actualizarTotalCarrito() {
      const dias = parseInt(document.getElementById('carrito-dias').value) || 3;
      let total = 0;

      carritoRentas.forEach(item => {
        const primerDia = item.precio_base * item.multiplicador;
        const diasExtra = Math.max(0, dias - 1) * 5000;
        total += primerDia + diasExtra;
      });

      const fechaDevolucion = new Date(Date.now() + dias * 86400000)
        .toLocaleDateString('es-CO', {
          day: '2-digit',
          month: 'short',
          year: 'numeric'
        });

      const totalEl = document.getElementById('carrito-total');
      const fechaEl = document.getElementById('carrito-fecha');
      if (totalEl) totalEl.textContent = `$${Number(total).toLocaleString('es-CO')}`;
      if (fechaEl) fechaEl.textContent = `Devolución: ${fechaDevolucion}`;
    }

    function eliminarDelCarrito(idx) {
      carritoRentas.splice(idx, 1);
      actualizarFlotante();
      if (carritoRentas.length === 0) {
        cerrarModalCarrito();
      } else {
        document.getElementById('modal-carrito')?.remove();
        abrirModalCarrito();
      }
    }

    function cerrarModalSelCinta() {
      document.getElementById('modal-sel-cinta')?.remove();
      document.body.style.overflow = '';
    }

    function cerrarModalCarrito() {
      document.getElementById('modal-carrito')?.remove();
      document.body.style.overflow = '';
    }

    async function confirmarCarrito() {
      if (carritoRentas.length === 0) {
        alertaRetro({
          titulo: 'CARRITO VACÍO',
          texto: '<p>Debes agregar películas al carrito antes de confirmar.</p>',
          icono: 'warning'
        });
        return;
      }

      const dias = parseInt(document.getElementById('carrito-dias').value);
      const totalReal = carritoRentas.reduce((total, item) => {
        const primerDia = item.precio_base * item.multiplicador;
        const diasExtra = Math.max(0, dias - 1) * 5000;
        return total + primerDia + diasExtra;
      }, 0);
      const cintasIds = carritoRentas.map(r => r.id_cinta);
      const metodoPago = 'PSE';


      console.log('totalReal:', totalReal);

      const btn = document.getElementById('btn-confirmar-carrito');
      btn.disabled = true;
      btn.textContent = '...';
      try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) throw new Error('Token CSRF no encontrado');

        const url = window.ROUTES?.rentasCrear || '/rentas';
        const res = await fetch(url, {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
          },
          body: JSON.stringify({
            cintas: cintasIds,
            dias: dias,
            metodo_pago: metodoPago,
            monto: totalReal,
          }),
        });

        let data = null;
        const contentType = res.headers.get('content-type') || '';
        if (contentType.includes('application/json')) {
          try {
            data = await res.json();
          } catch (e) {
            console.warn('Error parsing JSON:', e);
          }
        }

        if (!res.ok) {
          alertaRetro({
            titulo: 'ERROR EN LA RENTA',
            texto: `<p>${data?.message || data?.error || `Error ${res.status}: ${res.statusText}`}</p>`,
            icono: 'error'
          });
          btn.disabled = false;
          btn.textContent = '✓ CONFIRMAR RENTA';
          return;
        }

        cerrarModalCarrito();
        carritoRentas = [];
        actualizarFlotante();
        await cargarDatosSocio();
        closeDetail();

        if (data?.estado === 'Pendiente' && data?.id_prestamo && metodoPago === 'PSE') {
          const monto = (data.monto_total && data.monto_total > 0) ? data.monto_total : totalReal;
          setTimeout(() => abrirModalPagoPSE(data.id_prestamo, data.dias ?? dias, monto), 300);
        } else {
          alertaRetro({
            titulo: '¡RENTA CONFIRMADA!',
            texto: `<p>Tu préstamo fue registrado correctamente.<br/>Tienes <strong>${dias} día${dias > 1 ? 's' : ''}</strong> para devolver las cintas.</p>`,
            icono: 'success'
          });
        }

      } catch (err) {
        console.error('Error en confirmarCarrito:', err);
        alertaRetro({
          titulo: 'ERROR DE CONEXIÓN',
          texto: '<p>No se pudo conectar con el servidor. Por favor recarga la página e intenta de nuevo.</p>',
          icono: 'error'
        });
        btn.disabled = false;
        btn.textContent = '✓ CONFIRMAR RENTA';
      }
    }

    document.addEventListener('DOMContentLoaded', cargarDatosSocio);

    function abrirModalListaEsperaGeneral(pelicula) {
      const formatos = new Map();
      (pelicula.cintas || []).forEach(c => {
        if (c.id_formato && !formatos.has(c.id_formato)) {
          formatos.set(c.id_formato, c.formato?.nombre ?? `Formato ${c.id_formato}`);
        }
      });

      const formatosHtml = formatos.size ? [...formatos.entries()].map(([id, nombre]) => `
            <label style="display:flex;align-items:center;gap:10px;padding:8px 12px;
                          background:var(--ink3);border:1px solid var(--g-dark);
                          margin-bottom:4px;cursor:pointer;transition:border-color .15s;"
                onmouseover="this.style.borderColor='var(--v-dim)'"
                onmouseout="this.style.borderColor='var(--g-dark)'">
                <input type="radio" name="espera_formato" value="${id}"
                    style="accent-color:var(--v);width:14px;height:14px;">
                <span style="font-family:var(--fm);font-size:9px;letter-spacing:1px;color:var(--w);">
                    ${nombre}
                </span>
            </label>`).join('') :
        `<div style="font-family:var(--fm);font-size:9px;color:var(--g);padding:8px 0;">
               Sin formatos registrados.
           </div>`;

      const html = `
    <div id="modal-espera" style="position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:20000;
                                   display:flex;align-items:center;justify-content:center;padding:20px;">
        <div style="background:var(--ink2);border:1px solid rgba(123,94,167,.35);width:100%;max-width:420px;">
            <div style="padding:18px 24px;border-bottom:1px solid rgba(255,255,255,.05);
                        display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <div style="font-family:var(--fh);font-size:18px;letter-spacing:4px;color:var(--w);">
                        LISTA DE ESPERA
                    </div>
                    <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-top:3px;">
                        ${pelicula.titulo.toUpperCase()}
                    </div>
                </div>
                <span onclick="cerrarModalEspera()" style="cursor:pointer;color:var(--g);font-size:20px;"
                    onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--g)'">✕</span>
            </div>
            <div style="padding:24px;">
                <div style="background:rgba(212,160,23,.06);border:1px solid rgba(212,160,23,.2);
                            border-left:3px solid var(--amber);padding:10px 16px;margin-bottom:20px;
                            font-family:var(--fm);font-size:9px;color:var(--g);letter-spacing:1px;">
                    ⌦ &nbsp;Todas las cintas están rentadas. Elige el formato que prefieras
                    y te avisaremos cuando esté disponible.
                </div>
                <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-bottom:10px;">
                    FORMATO PREFERIDO
                </div>
                ${formatosHtml}
                <div style="display:flex;gap:10px;margin-top:20px;">
                    <button onclick="confirmarEspera(${pelicula.id_pelicula})"
                        style="font-family:var(--fo);font-size:9px;letter-spacing:2px;background:var(--v);
                               color:var(--w);border:none;padding:11px 24px;cursor:pointer;flex:1;"
                        onmouseover="this.style.background='#9370C8'"
                        onmouseout="this.style.background='var(--v)'">
                        ◎ UNIRME A LISTA
                    </button>
                    <button onclick="cerrarModalEspera()"
                        style="font-family:var(--fm);font-size:9px;letter-spacing:2px;background:transparent;
                               color:var(--g);border:1px solid var(--g-dark);padding:10px 18px;cursor:pointer;">
                        CANCELAR
                    </button>
                </div>
            </div>
        </div>
    </div>`;

      document.body.insertAdjacentHTML('beforeend', html);
      document.body.style.overflow = 'hidden';
    }

    function abrirModalListaEsperaFormato(idPelicula, tituloPelicula, idFormato, nombreFormato) {
      const html = `
        <div id="modal-espera" style="position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:20000;display:flex;align-items:center;justify-content:center;padding:20px;">
            <div style="background:var(--ink2);border:1px solid rgba(123,94,167,.35);width:100%;max-width:420px;">
                <div style="padding:18px 24px;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div style="font-family:var(--fh);font-size:18px;letter-spacing:4px;color:var(--w);">LISTA DE ESPERA</div>
                        <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-top:3px;">${tituloPelicula.toUpperCase()}</div>
                    </div>
                    <span onclick="cerrarModalEspera()" style="cursor:pointer;color:var(--g);font-size:20px;"
                        onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--g)'">✕</span>
                </div>
                <div style="padding:24px;">
                    <div style="background:rgba(212,160,23,.06);border:1px solid rgba(212,160,23,.2);border-left:3px solid var(--amber);
                                padding:10px 16px;margin-bottom:20px;font-family:var(--fm);font-size:9px;color:var(--g);letter-spacing:1px;">
                        ⌦ &nbsp;El formato <strong style="color:var(--amber);">${nombreFormato}</strong> no está disponible. 
                        Te avisaremos cuando haya una cinta libre.
                    </div>

                    <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-bottom:10px;">FORMATO SELECCIONADO</div>
                    <div style="padding:12px 14px;background:var(--ink3);border:1px solid var(--v-dim);margin-bottom:20px;">
                        <span style="font-family:var(--fm);font-size:9px;letter-spacing:1px;color:var(--w);">◈ ${nombreFormato}</span>
                    </div>

                    <div style="display:flex;gap:10px;">
                        <button onclick="confirmarEsperaFormato(${idPelicula}, ${idFormato})"
                            style="font-family:var(--fo);font-size:9px;letter-spacing:2px;background:var(--v);color:var(--w);border:none;padding:11px 24px;cursor:pointer;flex:1;"
                            onmouseover="this.style.background='#9370C8'" onmouseout="this.style.background='var(--v)'">
                            ◎ UNIRME A LISTA
                        </button>
                        <button onclick="cerrarModalEspera()"
                            style="font-family:var(--fm);font-size:9px;letter-spacing:2px;background:transparent;color:var(--g);border:1px solid var(--g-dark);padding:10px 18px;cursor:pointer;">
                            CANCELAR
                        </button>
                    </div>
                </div>
            </div>
        </div>`;

      document.body.insertAdjacentHTML('beforeend', html);
      document.body.style.overflow = 'hidden';
    }

    async function confirmarEsperaFormato(idPelicula, idFormato) {
      try {
        const res = await fetch(window.ROUTES.listaEsperaUnirse || '/lista-espera', {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify({
            id_pelicula: idPelicula,
            id_formato: idFormato,
          }),
        });
        const data = await res.json();
        cerrarModalEspera();

        if (!res.ok) {
          alertaRetro({
            titulo: 'AVISO',
            texto: `<p>${data.message}</p>`,
            icono: 'warning'
          });
          return;
        }

        await alertaRetro({
          titulo: 'EN LISTA DE ESPERA',
          texto: `<p>Eres el número <strong>${data.posicion}</strong> en la fila para ese formato.<br/>Te avisaremos cuando esté disponible.</p>`,
          icono: 'success'
        });

        navigateMisRentas();
      } catch (err) {
        alertaRetro({
          titulo: 'ERROR',
          texto: '<p>No se pudo conectar.</p>',
          icono: 'error'
        });
      }
    }

    function cerrarModalEspera() {
      document.getElementById('modal-espera')?.remove();
      document.body.style.overflow = '';
    }

    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') closeDetail();
    });

    async function confirmarEspera(idPelicula) {
      const selected = document.querySelector('[name="espera_formato"]:checked');
      const idFormato = selected?.value || null; // null = cualquier formato

      try {
        const res = await fetch(window.ROUTES.listaEsperaUnirse || '/lista-espera', {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify({
            id_pelicula: idPelicula,
            id_formato: idFormato
          }),
        });
        const data = await res.json();
        cerrarModalEspera();

        if (!res.ok) {
          alertaRetro({
            titulo: 'AVISO',
            texto: `<p>${data.message}</p>`,
            icono: 'warning'
          });
          return;
        }

        await alertaRetro({
          titulo: 'EN LISTA DE ESPERA',
          texto: `<p>Eres el número <strong>${data.posicion}</strong> en la fila.<br/>Te avisaremos cuando haya disponibilidad.</p>`,
          icono: 'success'
        });
        navigateMisRentas();
      } catch (err) {
        alertaRetro({
          titulo: 'ERROR',
          texto: '<p>No se pudo conectar.</p>',
          icono: 'error'
        });
      }
    }

    async function abrirModalPagoPSE(idPrestamo, dias, monto) {
      const referencia = 'PSE-' + Math.random().toString(36).substr(2, 12).toUpperCase();

      const html = `
        <div id="modal-pago-pse" style="position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:20000;display:flex;align-items:center;justify-content:center;padding:20px;">
            <div style="background:var(--ink2);border:1px solid rgba(123,94,167,.35);width:100%;max-width:480px;">
                <div style="padding:18px 24px;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div style="font-family:var(--fh);font-size:18px;letter-spacing:4px;color:var(--w);">PAGO PSE</div>
                        <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-top:3px;">SIMULACIÓN DE PAGO SEGURO</div>
                    </div>
                    <span onclick="cerrarModalPagoPSE()" style="cursor:pointer;color:var(--g);font-size:20px;"
                        onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--g)'">✕</span>
                </div>
                <div style="padding:24px;">
                    <div style="background:rgba(42,111,70,.1);border:1px solid rgba(42,111,70,.3);border-left:3px solid #2a6f46;padding:12px 16px;margin-bottom:20px;font-family:var(--fm);font-size:8px;color:var(--g);letter-spacing:1px;">
                        ⓘ &nbsp;Completa el pago para activar tu préstamo.
                    </div>

                    <div style="margin-bottom:16px;">
                        <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-bottom:6px;">MONTO A PAGAR</div>
                        <div style="font-family:var(--fo);font-size:24px;letter-spacing:2px;color:var(--v);">
                            $${Number(monto).toLocaleString('es-CO')}
                        </div>
                    </div>

                    <div style="margin-bottom:16px;padding:14px;background:var(--ink3);border:1px solid rgba(123,94,167,.2);">
                        <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-bottom:8px;">DETALLES DE LA TRANSACCIÓN</div>
                        <div style="font-family:var(--fm);font-size:8px;color:var(--g);line-height:1.8;">
                            <div>Préstamo: <span style="color:var(--w);">#${String(idPrestamo).padStart(4,'0')}</span></div>
                            <div>Referencia: <span style="color:var(--w);">${referencia}</span></div>
                            <div>Duración: <span style="color:var(--w);">${dias} día${dias > 1 ? 's' : ''}</span></div>
                            <div>Estado: <span style="color:#ffd700;">PENDIENTE</span></div>
                        </div>
                    </div>

                    <div style="margin-bottom:20px;padding:14px;background:rgba(79,46,140,.08);border:1px solid rgba(79,46,140,.2);">
                        <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-bottom:8px;">BANCO DE DESTINO</div>
                        <div style="font-family:var(--fm);font-size:9px;color:var(--w);">BANCO PIXELVHS</div>
                        <div style="font-family:var(--fm);font-size:8px;color:var(--g);margin-top:4px;">Cuenta: VHS-12345678</div>
                    </div>

                    <div style="display:flex;gap:10px;">
                        <button onclick="confirmarPagoPSE(${idPrestamo}, '${referencia}', ${monto})"
                            style="font-family:var(--fo);font-size:9px;letter-spacing:2px;background:#2a6f46;color:var(--w);border:none;padding:12px 24px;cursor:pointer;flex:1;transition:all .2s;"
                            onmouseover="this.style.background='#1f4d32'" onmouseout="this.style.background='#2a6f46'">
                            ✓ CONFIRMAR PAGO
                        </button>
                        <button onclick="cerrarModalPagoPSE()"
                            style="font-family:var(--fm);font-size:9px;letter-spacing:2px;background:transparent;color:var(--g);border:1px solid var(--g-dark);padding:11px 18px;cursor:pointer;transition:all .2s;"
                            onmouseover="this.style.borderColor='var(--v-dim)'" onmouseout="this.style.borderColor='var(--g-dark)'">
                            CANCELAR
                        </button>
                    </div>
                </div>
            </div>
        </div>`;

      document.body.insertAdjacentHTML('beforeend', html);
      document.body.style.overflow = 'hidden';
    }

    function cerrarModalPagoPSE() {
      document.getElementById('modal-pago-pse')?.remove();
      document.body.style.overflow = '';
    }

    async function confirmarPagoPSE(idPrestamo, referencia, monto) {
      const btn = document.querySelector('#modal-pago-pse button'); // más seguro
      if (btn) {
        btn.disabled = true;
        btn.textContent = 'Procesando...';
      }

      try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        const res = await fetch('{{ route("pago.pse.confirmar") }}', {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
          },
          body: JSON.stringify({
            id_prestamo: idPrestamo,
            referencia: referencia,
            monto: monto,
          }),
        });

        const data = await res.json();

        if (!res.ok) {
          alertaRetro({
            titulo: 'ERROR EN EL PAGO',
            texto: `<p>${data.error || data.message || 'No se pudo procesar el pago'}</p>`,
            icono: 'error'
          });
          if (btn) {
            btn.disabled = false;
            btn.textContent = '✓ CONFIRMAR PAGO';
          }
          return;
        }

        // ── Éxito ──────────────────────────────────────────────
        cerrarModalPagoPSE();
        await cargarDatosSocio();

        // Sin .then() — await directo
        await alertaRetro({
          titulo: '¡PAGO CONFIRMADO!',
          texto: `<p>Tu pago ha sido procesado.<br/>Referencia: <strong>${referencia}</strong><br/>Tu renta ya está activa.</p>`,
          icono: 'success'
        });

        navigateMisRentas();

      } catch (err) {
        console.error('Error en confirmarPagoPSE:', err);
        alertaRetro({
          titulo: 'ERROR',
          texto: '<p>No se pudo procesar el pago. Por favor intenta de nuevo.</p>',
          icono: 'error'
        });
        if (btn) {
          btn.disabled = false;
          btn.textContent = '✓ CONFIRMAR PAGO';
        }
      }
    }

    function calcularTotalCarrito(dias) {
      return carritoRentas.reduce((total, item) => {
        return total + (item.precio_base * item.multiplicador * dias);
      }, 0);
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

    function toggleNotifs() {
      const d = document.getElementById('notifDropdown');
      d.style.display = d.style.display === 'none' ? 'block' : 'none';
    }

    async function marcarTodasLeidas() {
      await fetch('{{ route("notificaciones.leer") }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': CSRF,
          'Accept': 'application/json'
        }
      });
      document.getElementById('notifBadge')?.remove();
      document.querySelectorAll('#notifDropdown > div[style*="rgba(123,94,167"]')
        .forEach(el => el.style.borderLeft = '2px solid transparent');
    }

    function irAPelicula(notifId) {
      fetch(`/notificaciones/${notifId}/leer`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': CSRF
        }
      });
      toggleNotifs();
    }

    // Cerrar al click fuera
    document.addEventListener('click', e => {
      const wrap = document.getElementById('notifBtn')?.parentElement;
      if (wrap && !wrap.contains(e.target))
        document.getElementById('notifDropdown').style.display = 'none';
    });
    let _valoracionActual = null;

    async function cargarValoraciones(idPelicula) {
      try {
        const [resPel, resMia] = await Promise.all([
          fetch(window.ROUTES.valoracionesPelicula.replace('__ID__', idPelicula), {
            credentials: 'same-origin',
            headers: {
              'Accept': 'application/json'
            }
          }),
          fetch(window.ROUTES.valoracionesMia.replace('__ID__', idPelicula), {
            credentials: 'same-origin',
            headers: {
              'Accept': 'application/json'
            }
          }),
        ]);

        const dataPel = await resPel.json();
        const dataMia = await resMia.json();

        _valoracionActual = dataMia.valoracion;
        renderValoraciones(dataPel, dataMia.valoracion);
      } catch (e) {
        console.error('Error cargando valoraciones:', e);
      }
    }

    function renderValoraciones(data, mia) {
      const cont = document.getElementById('valoraciones-panel');
      if (!cont) return;
      // ── Actualizar review-block con datos reales ──────────────
      const promedio = data.promedio ?? 0;
      const stars = Math.round(promedio);
      const verdict = promedio >= 4.5 ? 'IMPRESCINDIBLE' :
        promedio >= 4 ? 'OBRA MAESTRA' :
        promedio >= 3 ? 'RECOMENDADA' :
        promedio >= 2 ? 'REGULAR' :
        promedio > 0 ? 'POLÉMICA' : 'SIN VALORAR';

      // Última reseña con comentario como quote
      const conComentario = (data.valoraciones || []).find(v => v.comentario);

      // ── resto del panel igual que antes ──────────────────────
      const estrellasFn = (n) => [1, 2, 3, 4, 5].map(i =>
        `<span style="color:${i <= Math.round(n) ? 'var(--v)' : 'var(--g-dark)'};font-size:14px;">★</span>`
      ).join('');

      const miPuntuacion = mia?.puntuacion ?? 0;
      const selectorEstrellas = [1, 2, 3, 4, 5].map(i => `
          <span data-val="${i}" onclick="seleccionarEstrella(${i})"
              style="font-size:22px;cursor:pointer;transition:color .15s;
                    color:${i <= miPuntuacion ? 'var(--v)' : 'var(--g-dark)'};"
              onmouseover="hoverEstrella(${i})"
              onmouseout="resetEstrellas(${miPuntuacion})">★</span>
      `).join('');

      cont.innerHTML = `
          <div style="border-top:1px solid rgba(255,255,255,.05);margin-top:28px;padding-top:24px;">
              <div style="font-family:var(--fm);font-size:9px;letter-spacing:3px;color:var(--v-dim);margin-bottom:16px;">
                  VALORACIONES · ${data.total} RESEÑA${data.total !== 1 ? 'S' : ''}
              </div>
              ${data.total > 0 ? `
              <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;
                          padding:12px 16px;background:rgba(123,94,167,.06);border:1px solid rgba(123,94,167,.15);">
                  <div style="font-family:var(--fo);font-size:28px;color:var(--v);">${promedio.toFixed(1)}</div>
                  <div>
                      <div style="display:flex;gap:2px;">${estrellasFn(promedio)}</div>
                      <div style="font-family:var(--fm);font-size:8px;color:var(--g);margin-top:3px;letter-spacing:1px;">
                          PROMEDIO DE ${data.total} VALORACIÓN${data.total !== 1 ? 'ES' : ''}
                      </div>
                  </div>
              </div>` : ''}
              <div style="margin-bottom:20px;padding:16px;background:var(--ink3);border:1px solid rgba(123,94,167,.2);">
                  <div style="font-family:var(--fm);font-size:8px;letter-spacing:2px;color:var(--g);margin-bottom:10px;">
                      ${mia ? 'TU VALORACIÓN' : 'CALIFICA ESTA PELÍCULA'}
                  </div>
                  <div style="display:flex;gap:4px;margin-bottom:12px;" id="estrellas-selector">
                      ${selectorEstrellas}
                  </div>
                  <textarea id="comentario-val" placeholder="Escribe tu reseña (opcional)..."
                      style="width:100%;background:var(--ink2);border:1px solid var(--g-dark);
                            border-left:2px solid var(--v-dim);color:var(--w);font-family:var(--fm);
                            font-size:10px;padding:10px 12px;outline:none;resize:vertical;
                            min-height:60px;letter-spacing:.5px;transition:border-color .18s;"
                      onfocus="this.style.borderColor='var(--v)'"
                      onblur="this.style.borderColor='var(--g-dark)'"
                  >${mia?.comentario ?? ''}</textarea>
                  <button onclick="enviarValoracion(${currentMovie.id_pelicula})"
                      style="margin-top:10px;font-family:var(--fo);font-size:8px;letter-spacing:2px;
                            background:var(--v);color:var(--w);border:none;padding:9px 22px;cursor:pointer;transition:all .2s;"
                      onmouseover="this.style.background='#9370C8'" onmouseout="this.style.background='var(--v)'">
                      ${mia ? '✓ ACTUALIZAR' : '✓ ENVIAR VALORACIÓN'}
                  </button>
              </div>
              ${data.valoraciones.length ? data.valoraciones.slice(0, 5).map(v => `
              <div style="padding:14px 0;border-bottom:1px solid rgba(255,255,255,.04);">
                  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                      <div style="font-family:var(--fm);font-size:9px;letter-spacing:1px;color:var(--w);">
                          ${v.nombre.toUpperCase()}
                      </div>
                      <div style="display:flex;gap:2px;">${estrellasFn(v.puntuacion)}</div>
                  </div>
                  ${v.comentario ? `<div style="font-family:var(--fu);font-size:12px;color:#999;line-height:1.6;font-style:italic;">"${v.comentario}"</div>` : ''}
                  <div style="font-family:var(--fm);font-size:7px;color:var(--g);letter-spacing:1px;margin-top:6px;">
                      ${new Date(v.fecha).toLocaleDateString('es-CO')}
                  </div>
              </div>`).join('') : `
              <div style="font-family:var(--fm);font-size:9px;color:var(--g);letter-spacing:2px;padding:10px 0;">
                  SIN RESEÑAS AÚN
              </div>`}
          </div>`;
    }

    let _estrellaTemp = 0;

    function hoverEstrella(n) {
      document.querySelectorAll('#estrellas-selector span').forEach((s, i) => {
        s.style.color = i < n ? 'var(--v)' : 'var(--g-dark)';
      });
    }


    function resetEstrellas(actual) {
      const val = _estrellaTemp > 0 ? _estrellaTemp : actual;
      document.querySelectorAll('#estrellas-selector span').forEach((s, i) => {
        s.style.color = i < val ? 'var(--v)' : 'var(--g-dark)';
      });
    }

    function seleccionarEstrella(n) {
      _estrellaTemp = n;
      document.querySelectorAll('#estrellas-selector span').forEach((s, i) => {
        s.style.color = i < n ? 'var(--v)' : 'var(--g-dark)';
      });
    }

    async function enviarValoracion(idPelicula) {
      const puntuacion = _estrellaTemp > 0 ? _estrellaTemp : (_valoracionActual?.puntuacion ?? 0);
      if (!puntuacion) {
        alertaRetro({
          titulo: 'SELECCIONA UNA PUNTUACIÓN',
          texto: '<p>Haz clic en las estrellas para calificar.</p>',
          icono: 'warning'
        });
        return;
      }

      const comentario = document.getElementById('comentario-val')?.value?.trim() || null;

      try {
        const res = await fetch(window.ROUTES.valoracionesGuardar, {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': CSRF,
          },
          body: JSON.stringify({
            id_pelicula: idPelicula,
            puntuacion,
            comentario
          }),
        });

        const data = await res.json();

        if (!res.ok) {
          alertaRetro({
            titulo: 'ERROR',
            texto: `<p>${data.message}</p>`,
            icono: 'error'
          });
          return;
        }

        alertaRetro({
          titulo: '¡VALORACIÓN GUARDADA!',
          texto: '<p>Gracias por tu reseña.</p>',
          icono: 'success'
        });
        cargarValoraciones(idPelicula);
      } catch (e) {
        alertaRetro({
          titulo: 'ERROR',
          texto: '<p>No se pudo conectar.</p>',
          icono: 'error'
        });
      }

    }
    async function cargarRecomendaciones() {
      try {
        const res = await fetch(window.ROUTES.recomendaciones, {
          credentials: 'same-origin',
          headers: {
            'Accept': 'application/json'
          }
        });
        if (!res.ok) return;
        const data = await res.json();
        const peliculas = data.peliculas || [];
        if (!peliculas.length) return;

        const row = document.getElementById('rowRecomendadas');
        const shelf = document.getElementById('shelfRecomendadas');

        row.innerHTML = peliculas.map(m => {
          const img = m.foto_portada || '';
          const titulo = (m.titulo || '').toUpperCase();
          const genero = (m.genero?.nombre || 'N/A').toUpperCase();
          const anio = m.anio_lanzamiento || '';
          const movieData = window.MOVIE_MAP[m.id_pelicula];
          const dataAttr = movieData ?
            JSON.stringify(movieData).replace(/"/g, '&quot;') :
            null;
          const onclick = dataAttr ?
            `openDetail(${dataAttr})` :
            `console.warn('Película ${m.id_pelicula} no en MOVIE_MAP')`;

          return `
        <div class="card" data-genre="" data-title="${m.titulo.toLowerCase()}" onclick="${onclick}">
          <div class="b-genre">${genero}</div>
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
              <button class="btn-info" onclick="event.stopPropagation(); ${onclick}">VER MÁS</button>
              <button class="btn-wish" onclick="event.stopPropagation()">♡</button>
            </div>
          </div>
        </div>`;
        }).join('');

        shelf.style.display = 'block';
      } catch (e) {
        console.error('Error cargando recomendaciones:', e);
      }
    }

    document.addEventListener('DOMContentLoaded', cargarRecomendaciones);
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

      var _orig = window.openDetail;
      window.openDetail = function(pelicula) {
        _activeFmt = null;
        _estrellaTemp = 0;
        document.querySelectorAll('.fmt-scene').forEach(s => s.style.display = 'none');
        document.querySelectorAll('.fmt-btn').forEach(b => b.classList.remove('active'));
        document.getElementById('formatViewer').style.display = 'none';
        document.getElementById('posterDefault').style.display = 'block';

        _orig(pelicula);
      };

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