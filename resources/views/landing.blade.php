<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>إنتاجي – منتِج | ابدأ يومك بهدف</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --olive:       #4a5e2a;
            --olive-light: #6b8a3a;
            --olive-pale:  #e8edd8;
            --olive-mid:   #b5c98a;
            --gold:        #c9a84c;
            --gold-light:  #e8c96a;
            --gold-pale:   #fdf6e3;
            --gold-dark:   #8a6f28;
            --cream:       #faf7f0;
            --ink:         #1a1f0e;
            --ink-soft:    #3d4a22;
            --muted:       #6b7a4a;
            --white:       #ffffff;
            --section-gap: 80px;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Tajawal', sans-serif;
            background: var(--cream);
            color: var(--ink);
            overflow-x: hidden;
            direction: rtl;
        }

        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: 0.4;
        }

        nav {
            position: fixed; top: 0; right: 0; left: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 5%;
            height: 72px;
            background: rgba(250, 247, 240, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(74, 94, 42, 0.12);
            transition: all 0.3s;
        }
        .nav-logo {
            font-family: 'Amiri', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--olive);
            letter-spacing: 0.02em;
            display: flex; align-items: center; gap: 10px;
        }
        .nav-logo .dot {
            width: 8px; height: 8px;
            background: var(--gold);
            border-radius: 50%;
            display: inline-block;
            animation: pulse 2s ease-in-out infinite;
        }
        .nav-links {
            display: flex; align-items: center; gap: 32px;
            list-style: none;
        }
        .nav-links a {
            color: var(--muted);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--olive); }
        .nav-cta {
            background: var(--olive);
            color: var(--cream) !important;
            padding: 9px 24px;
            border-radius: 100px;
            font-size: 14px !important;
            transition: background 0.2s, transform 0.15s !important;
        }
        .nav-cta:hover { background: var(--olive-light) !important; transform: translateY(-1px); }

        .hero {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 120px 5% 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 50% 0%, rgba(74,94,42,0.08) 0%, transparent 70%),
                radial-gradient(ellipse 40% 40% at 90% 80%, rgba(201,168,76,0.1) 0%, transparent 60%);
            pointer-events: none;
        }
        .hero-pattern {
            position: absolute; inset: 0;
            background-image:
                radial-gradient(circle, rgba(74,94,42,0.08) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            mask-image: radial-gradient(ellipse 70% 70% at 50% 50%, black 30%, transparent 80%);
        }

        .hero-inner {
            position: relative; z-index: 1;
            max-width: 900px;
            text-align: center;
        }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(74, 94, 42, 0.08);
            border: 1px solid rgba(74, 94, 42, 0.2);
            color: var(--olive);
            padding: 6px 16px 6px 12px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 32px;
            animation: fadeInDown 0.8s ease both;
        }
        .hero-badge svg { width: 16px; height: 16px; }

        .hero-title {
            font-family: 'Amiri', serif;
            font-size: clamp(40px, 8vw, 92px);
            font-weight: 700;
            line-height: 1.1;
            color: var(--ink);
            margin-bottom: 12px;
            animation: fadeInUp 0.9s ease 0.1s both;
        }
        .hero-title .accent {
            color: var(--olive);
            position: relative;
        }
        .hero-title .accent::after {
            content: '';
            position: absolute;
            bottom: 4px; right: 0; left: 0;
            height: 3px;
            background: var(--gold);
            border-radius: 2px;
            transform: scaleX(0);
            transform-origin: right;
            animation: underline 0.8s ease 1s both;
        }
        .hero-sub {
            font-family: 'Amiri', serif;
            font-size: clamp(18px, 3vw, 28px);
            color: var(--gold-dark);
            font-weight: 400;
            font-style: italic;
            margin-bottom: 28px;
            animation: fadeInUp 0.9s ease 0.2s both;
        }
        .hero-desc {
            font-size: 16px;
            color: var(--muted);
            line-height: 1.85;
            max-width: 600px;
            margin: 0 auto 48px;
            animation: fadeInUp 0.9s ease 0.3s both;
        }
        .hero-actions {
            display: flex; align-items: center; justify-content: center;
            gap: 16px; flex-wrap: wrap;
            animation: fadeInUp 0.9s ease 0.4s both;
        }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 10px;
            background: var(--olive);
            color: var(--cream);
            padding: 14px 28px;
            border-radius: 100px;
            font-family: 'Tajawal', sans-serif;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 24px rgba(74,94,42,0.25);
        }
        .btn-primary:hover {
            background: var(--olive-light);
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(74,94,42,0.3);
        }
        .btn-primary svg { width: 18px; height: 18px; transition: transform 0.2s; }
        .btn-primary:hover svg { transform: translateX(-4px); }

        .btn-secondary {
            display: inline-flex; align-items: center; gap: 8px;
            background: transparent;
            border: 1.5px solid rgba(74,94,42,0.3);
            color: var(--olive);
            padding: 13px 28px;
            border-radius: 100px;
            font-family: 'Tajawal', sans-serif;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-secondary:hover {
            border-color: var(--olive);
            background: rgba(74,94,42,0.05);
        }

        .hero-mockup {
            position: relative;
            margin-top: 72px;
            animation: fadeInUp 1s ease 0.5s both;
            display: inline-block;
            width: auto;
        }
        .phone-frame {
            width: 260px;
            margin: 0 auto;
            background: var(--ink);
            border-radius: 40px;
            padding: 14px 10px;
            box-shadow:
                0 32px 80px rgba(26,31,14,0.25),
                0 0 0 1px rgba(255,255,255,0.1) inset;
            position: relative;
            overflow: hidden;
        }
        .phone-screen {
            background: linear-gradient(160deg, #1e2d12 0%, #0f1a08 100%);
            border-radius: 30px;
            padding: 24px 16px;
            overflow: hidden;
        }
        .phone-notch {
            width: 80px; height: 8px;
            background: rgba(255,255,255,0.08);
            border-radius: 4px;
            margin: 0 auto 20px;
        }
        .phone-date {
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            text-align: center;
            margin-bottom: 16px;
            letter-spacing: 0.05em;
        }
        .phone-score {
            text-align: center;
            margin-bottom: 20px;
        }
        .phone-score .num {
            font-family: 'Amiri', serif;
            font-size: 52px;
            color: var(--gold-light);
            font-weight: 700;
            line-height: 1;
        }
        .phone-score .label {
            font-size: 11px;
            color: rgba(255,255,255,0.5);
            margin-top: 4px;
        }
        .phone-tree {
            text-align: center;
            font-size: 48px;
            margin-bottom: 16px;
            filter: drop-shadow(0 4px 12px rgba(107,138,58,0.4));
        }
        .phone-activities { display: flex; flex-direction: column; gap: 8px; }
        .phone-act {
            display: flex; align-items: center; justify-content: space-between;
            background: rgba(255,255,255,0.06);
            border-radius: 10px;
            padding: 8px 12px;
        }
        .phone-act .name { font-size: 11px; color: rgba(255,255,255,0.8); }
        .phone-act .check {
            width: 20px; height: 20px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px;
        }
        .phone-act .check.done {
            background: var(--gold);
            color: var(--ink);
        }
        .phone-act .check.pending {
            border: 1.5px solid rgba(255,255,255,0.2);
        }

        .float-badge {
            position: absolute;
            background: var(--white);
            border: 1px solid rgba(74,94,42,0.15);
            border-radius: 14px;
            padding: 8px 12px;
            box-shadow: 0 8px 32px rgba(26,31,14,0.12);
            font-size: 12px;
            font-weight: 600;
            color: var(--ink-soft);
            display: flex; align-items: center; gap: 8px;
            white-space: nowrap;
            animation: float 4s ease-in-out infinite;
        }
        .float-badge.b1 { top: 5%; right: -30px; animation-delay: 0s; }
        .float-badge.b2 { bottom: 10%; left: -30px; animation-delay: 1.5s; }
        .float-badge .icon {
            width: 28px; height: 28px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
        }
        .float-badge.b1 .icon { background: rgba(201,168,76,0.15); }
        .float-badge.b2 .icon { background: rgba(74,94,42,0.12); }

        .section-wrap {
            padding: var(--section-gap) 5%;
            position: relative;
        }
        .section-label {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--gold-dark);
            margin-bottom: 16px;
        }
        .section-label::before {
            content: '';
            width: 24px; height: 2px;
            background: var(--gold);
            border-radius: 2px;
        }
        .section-title {
            font-family: 'Amiri', serif;
            font-size: clamp(32px, 4vw, 52px);
            font-weight: 700;
            color: var(--ink);
            line-height: 1.2;
            margin-bottom: 16px;
        }
        .section-desc {
            font-size: 16px;
            color: var(--muted);
            line-height: 1.8;
            max-width: 520px;
        }

        .stats-bar {
            background: var(--olive);
            padding: 20px 5%;
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        .stat-item {
            flex: 1 1 auto;
            padding: 20px 20px;
            text-align: center;
            border-left: 1px solid rgba(255,255,255,0.1);
        }
        .stat-item:last-child { border-right: 1px solid rgba(255,255,255,0.1); }
        .stat-num {
            font-family: 'Amiri', serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--gold-light);
            line-height: 1;
            display: block;
        }
        .stat-txt {
            font-size: 12px;
            color: rgba(255,255,255,0.65);
            margin-top: 6px;
            white-space: normal;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2px;
            background: rgba(74,94,42,0.08);
            border-radius: 24px;
            overflow: hidden;
            margin-top: 64px;
        }
        .feat-card {
            background: var(--cream);
            padding: 32px 28px;
            position: relative;
            transition: background 0.3s;
            cursor: default;
        }
        .feat-card:hover { background: #f5f2e9; }
        .feat-icon {
            width: 52px; height: 52px;
            border-radius: 16px;
            background: var(--olive-pale);
            display: flex; align-items: center; justify-content: center;
            font-size: 26px;
            margin-bottom: 24px;
            transition: transform 0.3s;
        }
        .feat-card:hover .feat-icon { transform: scale(1.08) rotate(-4deg); }
        .feat-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 10px;
        }
        .feat-desc {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.75;
        }
        .feat-tag {
            position: absolute; top: 20px; left: 20px;
            background: var(--gold-pale);
            border: 1px solid rgba(201,168,76,0.3);
            color: var(--gold-dark);
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 100px;
            letter-spacing: 0.05em;
        }

        .showcase-bg {
            background: var(--ink);
            position: relative;
            overflow: hidden;
        }
        .showcase-bg::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 20% 50%, rgba(74,94,42,0.2) 0%, transparent 70%),
                radial-gradient(ellipse 40% 60% at 80% 50%, rgba(201,168,76,0.08) 0%, transparent 70%);
            pointer-events: none;
        }
        .showcase-bg .section-title { color: var(--cream); }
        .showcase-bg .section-desc  { color: rgba(255,255,255,0.55); }
        .showcase-bg .section-label { color: var(--gold-light); }
        .showcase-bg .section-label::before { background: var(--gold-light); }

        .sections-wheel {
            display: flex; flex-wrap: wrap;
            gap: 12px;
            margin-top: 56px;
            position: relative; z-index: 1;
        }
        .sec-pill {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 18px;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.25s;
            background: rgba(255,255,255,0.04);
        }
        .sec-pill:hover, .sec-pill.active {
            background: rgba(74,94,42,0.3);
            border-color: var(--olive-mid);
            transform: translateY(-2px);
        }
        .sec-pill .emoji { font-size: 20px; }
        .sec-pill .name {
            font-size: 13px; font-weight: 600;
            color: rgba(255,255,255,0.8);
        }
        .sec-pill:hover .name, .sec-pill.active .name { color: var(--cream); }

        .showcase-panel {
            margin-top: 40px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 30px 24px;
            position: relative; z-index: 1;
            min-height: 200px;
            display: none;
        }
        .showcase-panel.active { display: block; }
        .panel-title {
            font-family: 'Amiri', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--gold-light);
            margin-bottom: 12px;
        }
        .panel-acts { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px; }
        .panel-act {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 100px;
            padding: 6px 14px;
            font-size: 12px;
            color: rgba(255,255,255,0.75);
            display: flex; align-items: center; gap: 6px;
        }
        .panel-act::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--gold);
        }

        .steps-wrap {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 40px;
            margin-top: 72px;
            position: relative;
        }
        .step {
            text-align: center;
            padding: 0 16px;
            position: relative;
        }
        .step-num {
            width: 70px; height: 70px;
            border-radius: 50%;
            border: 2px solid var(--olive-mid);
            background: var(--cream);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Amiri', serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--olive);
            margin: 0 auto 24px;
            position: relative; z-index: 1;
            transition: all 0.3s;
        }
        .step:hover .step-num {
            background: var(--olive);
            color: var(--cream);
            border-color: var(--olive);
            transform: scale(1.08);
        }
        .step-title {
            font-size: 16px; font-weight: 700;
            color: var(--ink); margin-bottom: 8px;
        }
        .step-desc { font-size: 14px; color: var(--muted); line-height: 1.7; }

        .ai-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        .tips-stack {
            display: flex; flex-direction: column;
            gap: 16px;
        }
        .tip-card {
            background: var(--white);
            border: 1px solid rgba(74,94,42,0.1);
            border-radius: 20px;
            padding: 18px 20px;
            display: flex; gap: 16px;
            align-items: flex-start;
            box-shadow: 0 4px 20px rgba(26,31,14,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: default;
        }
        .tip-card:hover {
            transform: translateX(-4px);
            box-shadow: 0 8px 32px rgba(26,31,14,0.1);
        }
        .tip-icon {
            width: 42px; height: 42px; flex-shrink: 0;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .tip-icon.green  { background: rgba(74,94,42,0.1); }
        .tip-icon.gold   { background: rgba(201,168,76,0.15); }
        .tip-icon.soft   { background: rgba(107,138,58,0.12); }
        .tip-text { font-size: 14px; color: var(--ink-soft); line-height: 1.7; font-weight: 500; }
        .tip-tag {
            display: inline-block;
            margin-top: 6px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: var(--olive);
            background: var(--olive-pale);
            padding: 2px 8px;
            border-radius: 100px;
        }

        .gamif-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin-top: 64px;
        }
        .gamif-card {
            background: var(--white);
            border: 1px solid rgba(74,94,42,0.1);
            border-radius: 20px;
            padding: 24px 16px;
            text-align: center;
            transition: all 0.25s;
        }
        .gamif-card:hover {
            background: var(--olive);
            border-color: var(--olive);
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(74,94,42,0.25);
        }
        .gamif-card:hover .gamif-title { color: var(--cream); }
        .gamif-card:hover .gamif-desc  { color: rgba(255,255,255,0.65); }
        .gamif-emoji { font-size: 32px; margin-bottom: 12px; }
        .gamif-title { font-size: 15px; font-weight: 700; color: var(--ink); margin-bottom: 6px; }
        .gamif-desc  { font-size: 12px; color: var(--muted); line-height: 1.6; }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            margin-top: 64px;
        }
        .testi-card {
            background: var(--white);
            border: 1px solid rgba(74,94,42,0.1);
            border-radius: 20px;
            padding: 28px;
            position: relative;
            transition: box-shadow 0.25s;
        }
        .testi-card:hover { box-shadow: 0 12px 40px rgba(26,31,14,0.1); }
        .testi-quote {
            font-family: 'Amiri', serif;
            font-size: 48px;
            color: var(--olive-pale);
            line-height: 1;
            position: absolute;
            top: 16px; right: 24px;
            font-weight: 700;
        }
        .testi-text {
            font-size: 14px; color: var(--muted); line-height: 1.8;
            margin-bottom: 20px; position: relative; z-index: 1;
            font-style: italic;
        }
        .testi-author { display: flex; align-items: center; gap: 12px; }
        .testi-avatar {
            width: 40px; height: 40px; border-radius: 50%;
            background: var(--olive);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; color: var(--cream); font-weight: 700;
        }
        .testi-name { font-size: 14px; font-weight: 700; color: var(--ink); }
        .testi-role { font-size: 12px; color: var(--muted); }
        .stars { color: var(--gold); font-size: 12px; margin-bottom: 12px; }

        .cta-section {
            background: var(--olive);
            text-align: center;
            padding: 80px 5%;
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute; inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 32px 32px;
        }
        .cta-title {
            font-family: 'Amiri', serif;
            font-size: clamp(32px, 5vw, 60px);
            font-weight: 700;
            color: var(--cream);
            margin-bottom: 16px;
            position: relative; z-index: 1;
        }
        .cta-sub {
            font-size: 16px;
            color: rgba(255,255,255,0.7);
            margin-bottom: 40px;
            position: relative; z-index: 1;
        }
        .btn-gold {
            display: inline-flex; align-items: center; gap: 10px;
            background: var(--gold);
            color: var(--ink);
            padding: 16px 40px;
            border-radius: 100px;
            font-size: 16px;
            font-weight: 800;
            text-decoration: none;
            position: relative; z-index: 1;
            transition: all 0.2s;
            box-shadow: 0 4px 24px rgba(201,168,76,0.4);
        }
        .btn-gold:hover {
            background: var(--gold-light);
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(201,168,76,0.5);
        }

        footer {
            background: var(--ink);
            padding: 30px 5%;
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 16px;
        }
        .footer-logo {
            font-family: 'Amiri', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--gold-light);
        }
        .footer-links { display: flex; gap: 20px; flex-wrap: wrap; }
        .footer-links a {
            font-size: 13px;
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-links a:hover { color: rgba(255,255,255,0.8); }
        .footer-copy { font-size: 12px; color: rgba(255,255,255,0.3); }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes underline {
            to { transform: scaleX(1); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-8px); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.6; transform: scale(0.8); }
        }

        .reveal {
            opacity: 0; transform: translateY(32px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* Responsive (Mobile) */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            .hero {
                padding: 100px 5% 60px;
            }
            .hero-actions {
                flex-direction: column;
                width: 100%;
                max-width: 280px;
                margin: 0 auto;
            }
            .btn-primary, .btn-secondary {
                width: 100%;
                justify-content: center;
            }
            .float-badge.b1 {
                top: -10px;
                right: -20px;
                transform: scale(0.8);
            }
            .float-badge.b2 {
                bottom: -10px;
                left: -20px;
                transform: scale(0.8);
            }
            .stats-bar {
                flex-direction: column;
                gap: 0;
            }
            .stat-item {
                border-left: none;
                border-bottom: 1px solid rgba(255,255,255,0.1);
                padding: 16px;
            }
            .stat-item:last-child {
                border-bottom: none;
                border-right: none;
            }
            .features-grid {
                grid-template-columns: 1fr;
            }
            .steps-wrap {
                grid-template-columns: 1fr;
                gap: 32px;
            }
            .steps-wrap::before {
                display: none;
            }
            .ai-section {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            .gamif-grid {
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            }
            .testimonials-grid {
                grid-template-columns: 1fr;
            }
            .sections-wheel {
                justify-content: center;
            }
            .sec-pill {
                flex: 0 0 auto;
            }
            .showcase-panel {
                padding: 20px 16px;
            }
            .panel-title {
                font-size: 20px;
            }
            .panel-act {
                font-size: 11px;
                padding: 5px 12px;
            }
            .cta-section {
                padding: 60px 5%;
            }
            footer {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .float-badge {
                display: none;
            }
            .hero-title {
                font-size: 36px;
            }
            .hero-sub {
                font-size: 16px;
            }
            .hero-desc {
                font-size: 14px;
            }
            .section-title {
                font-size: 28px;
            }
            .stat-num {
                font-size: 28px;
            }
            .feat-card {
                padding: 24px 20px;
            }
            .tip-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .tip-icon {
                margin-bottom: 8px;
            }
        }
    </style>
</head>
<body>

<nav>
    <div class="nav-logo">
        <span class="dot"></span>
        إنتاجي
    </div>
    <ul class="nav-links">
        <li><a href="#features">المميزات</a></li>
        <li><a href="#sections">الأقسام</a></li>
        <li><a href="#how">كيف يعمل</a></li>
        <li><a href="#cta" class="nav-cta">ابدأ مجاناً</a></li>
    </ul>
</nav>

<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-pattern"></div>
    <div class="hero-inner">
        <div class="hero-badge">
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M8 1l1.5 4.5H14l-3.75 2.75L11.5 13 8 10.5 4.5 13l1.25-4.75L2 5.5h4.5z"/>
            </svg>
            التطبيق الأول من نوعه في العالم العربي
        </div>

        <h1 class="hero-title">
            كن <span class="accent">منتِجاً</span><br>بكل جوانب حياتك
        </h1>
        <p class="hero-sub">لأن الإنتاجية الحقيقية أكبر من قائمة مهام</p>
        <p class="hero-desc">
            تطبيق ذكي يقيس إنتاجيتك في ٩ مجالات حياتية — من العبادات إلى الصحة إلى المال —
            ويربطها بوقت استخدامك للجوال ليعطيك رؤية حقيقية عن يومك.
        </p>
        <div class="hero-actions">
            <a href="#cta" class="btn-primary">
                ابدأ رحلتك الآن
                <svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9h12M9 3l6 6-6 6"/>
                </svg>
            </a>
            <a href="#how" class="btn-secondary">كيف يعمل؟</a>
        </div>

        <div class="hero-mockup">
            <div style="position: relative; display: inline-block;">
                <div class="phone-frame">
                    <div class="phone-screen">
                        <div class="phone-notch"></div>
                        <div class="phone-date">الأربعاء، ١٣ مايو ٢٠٢٦</div>
                        <div class="phone-score">
                            <div class="num">٨٤</div>
                            <div class="label">نقطة إنتاجية اليوم</div>
                        </div>
                        <div class="phone-tree">🌳</div>
                        <div class="phone-activities">
                            <div class="phone-act">
                                <span class="name">صلاة الفجر ✓</span>
                                <span class="check done">✓</span>
                            </div>
                            <div class="phone-act">
                                <span class="name">قراءة القرآن ✓</span>
                                <span class="check done">✓</span>
                            </div>
                            <div class="phone-act">
                                <span class="name">شرب الماء</span>
                                <span class="check pending"></span>
                            </div>
                            <div class="phone-act">
                                <span class="name">وقت العمل المركز</span>
                                <span class="check pending"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="float-badge b1">
                    <div class="icon">🏆</div>
                    <div>
                        <div style="font-size:12px; font-weight:700; color:#1a1f0e;">شارة جديدة!</div>
                        <div style="font-size:11px; color:#6b7a4a;">مواظب على الفجر ٧ أيام</div>
                    </div>
                </div>
                <div class="float-badge b2">
                    <div class="icon">📱</div>
                    <div>
                        <div style="font-size:12px; font-weight:700; color:#1a1f0e;">تنبيه ذكي</div>
                        <div style="font-size:11px; color:#6b7a4a;">انستغرام: ١ ساعة ٤٥ د</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="stats-bar">
    <div class="stat-item">
        <span class="stat-num" data-target="9">٠</span>
        <span class="stat-txt">مجالات حياتية</span>
    </div>
    <div class="stat-item">
        <span class="stat-num" data-target="30">٠</span>
        <span class="stat-txt">نشاط جاهز للتتبع</span>
    </div>
    <div class="stat-item">
        <span class="stat-num" data-target="8">٠</span>
        <span class="stat-txt">طرق قياس مختلفة</span>
    </div>
    <div class="stat-item">
        <span class="stat-num" data-target="100">٠</span>
        <span class="stat-txt">% مجاني في النسخة الأولى</span>
    </div>
</div>

<section id="features" class="section-wrap reveal">
    <div class="section-label">المميزات</div>
    <h2 class="section-title">كل ما تحتاجه في مكان واحد</h2>
    <p class="section-desc">
        صُمِّم إنتاجي ليكون مرافقك اليومي الذكي، لا مجرد تطبيق تسجيل.
    </p>
    <div class="features-grid">
        <div class="feat-card">
            <span class="feat-tag">جديد</span>
            <div class="feat-icon">📱</div>
            <div class="feat-title">تتبع وقت التطبيقات</div>
            <p class="feat-desc">يربط وقت إنستغرام وتيك توك بأدائك في الصلاة والدراسة — ليريك الحقيقة بالأرقام.</p>
        </div>
        <div class="feat-card">
            <div class="feat-icon">🤖</div>
            <div class="feat-title">نصائح ذكية بالـ AI</div>
            <p class="feat-desc">يتعلم من أنماطك ويقدم نصائح مخصصة — لا عامة. مثل: "يوم الخميس تنسى العصر، جهّز منبهاً."</p>
        </div>
        <div class="feat-card">
            <div class="feat-icon">🌳</div>
            <div class="feat-title">شجرة الإنتاجية</div>
            <p class="feat-desc">شجرة افتراضية تنمو مع التزامك وتذبل مع الإهمال — تحويل مجرد — لكنه يعمل.</p>
        </div>
        <div class="feat-card">
            <span class="feat-tag">ذكي</span>
            <div class="feat-icon">📊</div>
            <div class="feat-title">إحصاءات مركّبة</div>
            <p class="feat-desc">اكتشف العلاقات: "في أيام شرب الماء أكثر من ٨ أكواب، أداؤك في الرياضة يرتفع ٤٠٪".</p>
        </div>
        <div class="feat-card">
            <div class="feat-icon">🔔</div>
            <div class="feat-title">تذكيرات تتعلم منك</div>
            <p class="feat-desc">لا ينتظر منك ضبط كل شيء — يلاحظ متى تنجز أنشطتك ويقترح التوقيت المثالي تلقائياً.</p>
        </div>
        <div class="feat-card">
            <div class="feat-icon">🎖️</div>
            <div class="feat-title">نقاط وشارات وتحديات</div>
            <p class="feat-desc">نظام تحفيز كامل: اكسب نقاطاً، افتح شارات، تنافس مع نفسك أسبوعاً بعد أسبوع.</p>
        </div>
    </div>
</section>

<section id="sections" class="section-wrap showcase-bg reveal">
    <div style="position: relative; z-index: 1;">
        <div class="section-label">الأقسام</div>
        <h2 class="section-title">٩ مجالات، حياة متكاملة</h2>
        <p class="section-desc">كل جانب من حياتك له مكانه — تابعه وطوّره بشكل مستقل ومترابط.</p>

        <div class="sections-wheel">
            <div class="sec-pill active" onclick="showPanel(0)">
                <span class="emoji">🕌</span><span class="name">العبادات</span>
            </div>
            <div class="sec-pill" onclick="showPanel(1)">
                <span class="emoji">💪</span><span class="name">الصحة واللياقة</span>
            </div>
            <div class="sec-pill" onclick="showPanel(2)">
                <span class="emoji">📚</span><span class="name">التعلم والمعرفة</span>
            </div>
            <div class="sec-pill" onclick="showPanel(3)">
                <span class="emoji">💼</span><span class="name">العمل والإنتاجية</span>
            </div>
            <div class="sec-pill" onclick="showPanel(4)">
                <span class="emoji">💰</span><span class="name">المالي</span>
            </div>
            <div class="sec-pill" onclick="showPanel(5)">
                <span class="emoji">👨‍👩‍👧</span><span class="name">الاجتماعي</span>
            </div>
            <div class="sec-pill" onclick="showPanel(6)">
                <span class="emoji">🧘</span><span class="name">النفسي والروحي</span>
            </div>
            <div class="sec-pill" onclick="showPanel(7)">
                <span class="emoji">🎨</span><span class="name">الإبداع والمهارة</span>
            </div>
            <div class="sec-pill" onclick="showPanel(8)">
                <span class="emoji">🌱</span><span class="name">البيئي</span>
            </div>
        </div>

        <div id="panel-0" class="showcase-panel active">
            <div class="panel-title">🕌 العبادات</div>
            <p style="color: rgba(255,255,255,0.55); font-size:14px; line-height:1.8;">تابع صلواتك الخمس، قراءة القرآن، الأذكار والأوراد اليومية بطريقة سهلة ومحفّزة.</p>
            <div class="panel-acts">
                <span class="panel-act">صلاة الفجر</span>
                <span class="panel-act">صلاة الظهر</span>
                <span class="panel-act">صلاة العصر</span>
                <span class="panel-act">صلاة المغرب</span>
                <span class="panel-act">صلاة العشاء</span>
                <span class="panel-act">قراءة القرآن</span>
                <span class="panel-act">الأذكار الصباحية</span>
                <span class="panel-act">الأذكار المسائية</span>
            </div>
        </div>
        <div id="panel-1" class="showcase-panel">
            <div class="panel-title">💪 الصحة واللياقة</div>
            <p style="color: rgba(255,255,255,0.55); font-size:14px; line-height:1.8;">جسمك أمانة — تابع شرب الماء، النوم، الرياضة، والتغذية بأهداف يومية واقعية.</p>
            <div class="panel-acts">
                <span class="panel-act">شرب الماء</span>
                <span class="panel-act">ممارسة الرياضة</span>
                <span class="panel-act">النوم المبكر</span>
                <span class="panel-act">وجبة صحية</span>
            </div>
        </div>
        <div id="panel-2" class="showcase-panel">
            <div class="panel-title">📚 التعلم والمعرفة</div>
            <p style="color: rgba(255,255,255,0.55); font-size:14px; line-height:1.8;">العقل يحتاج غذاءه — تابع قراءتك، مهاراتك الجديدة، ومراجعاتك الدراسية.</p>
            <div class="panel-acts">
                <span class="panel-act">القراءة اليومية</span>
                <span class="panel-act">تعلم مهارة جديدة</span>
                <span class="panel-act">مراجعة الدراسة</span>
            </div>
        </div>
        <div id="panel-3" class="showcase-panel">
            <div class="panel-title">💼 العمل والإنتاجية</div>
            <p style="color: rgba(255,255,255,0.55); font-size:14px; line-height:1.8;">مؤقت بومودورو مدمج، تتبع إنجاز المهام المخططة، وتحليل وقت التركيز اليومي.</p>
            <div class="panel-acts">
                <span class="panel-act">العمل المركز (بومودورو)</span>
                <span class="panel-act">إنجاز المهام</span>
            </div>
        </div>
        <div id="panel-4" class="showcase-panel">
            <div class="panel-title">💰 المالي والاقتصادي</div>
            <p style="color: rgba(255,255,255,0.55); font-size:14px; line-height:1.8;">عادة تسجيل المصاريف والادخار اليومي — خطوات صغيرة نحو استقرار مالي حقيقي.</p>
            <div class="panel-acts">
                <span class="panel-act">تسجيل المصاريف</span>
                <span class="panel-act">الادخار اليومي</span>
            </div>
        </div>
        <div id="panel-5" class="showcase-panel">
            <div class="panel-title">👨‍👩‍👧 الاجتماعي والأسري</div>
            <p style="color: rgba(255,255,255,0.55); font-size:14px; line-height:1.8;">صلة الرحم، مساعدة الآخرين، والوقت العائلي — قيم لا تُهمَل في خضم الانشغال.</p>
            <div class="panel-acts">
                <span class="panel-act">صلة الرحم</span>
                <span class="panel-act">مساعدة شخص</span>
            </div>
        </div>
        <div id="panel-6" class="showcase-panel">
            <div class="panel-title">🧘 النفسي والروحي</div>
            <p style="color: rgba(255,255,255,0.55); font-size:14px; line-height:1.8;">التأمل، تسجيل المشاعر، وتقييم مزاجك اليومي — الصحة النفسية جزء من الإنتاجية.</p>
            <div class="panel-acts">
                <span class="panel-act">التأمل</span>
                <span class="panel-act">كتابة المشاعر</span>
                <span class="panel-act">تقييم المزاج</span>
            </div>
        </div>
        <div id="panel-7" class="showcase-panel">
            <div class="panel-title">🎨 الإبداعي والمهاري</div>
            <p style="color: rgba(255,255,255,0.55); font-size:14px; line-height:1.8;">الكتابة الإبداعية، المهارات اليدوية، والفنون — موهبتك تحتاج تمريناً يومياً.</p>
            <div class="panel-acts">
                <span class="panel-act">الكتابة الإبداعية</span>
                <span class="panel-act">تعلم مهارة يدوية</span>
            </div>
        </div>
        <div id="panel-8" class="showcase-panel">
            <div class="panel-title">🌱 البيئي والاستدامة</div>
            <p style="color: rgba(255,255,255,0.55); font-size:14px; line-height:1.8;">تقليل البلاستيك، إعادة التدوير، والاهتمام بالبيئة — مسؤوليتنا المشتركة.</p>
            <div class="panel-acts">
                <span class="panel-act">تقليل البلاستيك</span>
                <span class="panel-act">إعادة التدوير</span>
            </div>
        </div>
    </div>
</section>

<section id="how" class="section-wrap reveal">
    <div style="text-align: center; max-width: 600px; margin: 0 auto;">
        <div class="section-label" style="justify-content: center;">كيف يعمل</div>
        <h2 class="section-title">ثلاث خطوات فقط</h2>
        <p class="section-desc" style="margin: 0 auto;">بدون تعقيد، بدون إعداد طويل — ابدأ وتتبع واحصل على نتائج حقيقية.</p>
    </div>
    <div class="steps-wrap">
        <div class="step">
            <div class="step-num">١</div>
            <div class="step-title">أنشئ حسابك</div>
            <p class="step-desc">سجّل ببريدك أو هاتفك وأجب على ٣ أسئلة لتخصيص تجربتك (صباحي أم مسائي؟ أهدافك؟)</p>
        </div>
        <div class="step">
            <div class="step-num">٢</div>
            <div class="step-title">سجّل يومك</div>
            <p class="step-desc">بضغطة واحدة أو بنقرة سريعة على التقويم — سجّل ما أنجزته في ثوانٍ.</p>
        </div>
        <div class="step">
            <div class="step-num">٣</div>
            <div class="step-title">اقرأ تحليلك</div>
            <p class="step-desc">الـ AI يعطيك نصيحة مخصصة يومياً بناءً على بياناتك الحقيقية — لا عامة، لا مكررة.</p>
        </div>
    </div>
</section>

<section class="section-wrap reveal" style="background: var(--gold-pale);">
    <div class="ai-section">
        <div>
            <div class="section-label">الذكاء الاصطناعي</div>
            <h2 class="section-title">نصائح تعرف<br>من أنت</h2>
            <p class="section-desc">لا نصائح عامة من الإنترنت — نصائح مبنية على بياناتك أنت، أنماطك أنت، أسبابك أنت.</p>
            <a href="#cta" class="btn-primary" style="margin-top: 32px; display: inline-flex;">
                جربها مجاناً
            </a>
        </div>
        <div class="tips-stack">
            <div class="tip-card">
                <div class="tip-icon green">🌙</div>
                <div>
                    <p class="tip-text">"لاحظت أنك تستخدم إنستغرام حتى ١٢ منتصف الليل — هذا يؤثر على يقظتك للفجر بنسبة ٦٠٪"</p>
                    <span class="tip-tag">تحليل وقت التطبيقات</span>
                </div>
            </div>
            <div class="tip-card">
                <div class="tip-icon gold">📈</div>
                <div>
                    <p class="tip-text">"أداؤك يرتفع كل يوم ثلاثاء — هذا ليس صدفة، ليلة الاثنين نومك أفضل بـ ٤٢ دقيقة في المتوسط"</p>
                    <span class="tip-tag">تحليل الأنماط</span>
                </div>
            </div>
            <div class="tip-card">
                <div class="tip-icon soft">🎯</div>
                <div>
                    <p class="tip-text">"تحدي الأسبوع: انقص وقت الألعاب ٣٠ دقيقة فقط، وهذا سيمنحك وقتاً لصفحتين قرآن إضافيتين يومياً"</p>
                    <span class="tip-tag">تحدي ذكي</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-wrap reveal">
    <div style="text-align: center; max-width: 600px; margin: 0 auto;">
        <div class="section-label" style="justify-content: center;">التحفيز</div>
        <h2 class="section-title">الالتزام ممتع<br>ليس فقط واجب</h2>
    </div>
    <div class="gamif-grid">
        <div class="gamif-card">
            <div class="gamif-emoji">⭐</div>
            <div class="gamif-title">نظام النقاط</div>
            <p class="gamif-desc">كل نشاط يعطيك نقاطاً حسب أهميته</p>
        </div>
        <div class="gamif-card">
            <div class="gamif-emoji">🏅</div>
            <div class="gamif-title">شارات الإنجاز</div>
            <p class="gamif-desc">مواظب على الفجر، ختم القرآن، منخفض الجوال</p>
        </div>
        <div class="gamif-card">
            <div class="gamif-emoji">🌳</div>
            <div class="gamif-title">شجرة تنمو معك</div>
            <p class="gamif-desc">التزم وانظر شجرتك تزهر — أهمل وستذبل</p>
        </div>
        <div class="gamif-card">
            <div class="gamif-emoji">🏪</div>
            <div class="gamif-title">متجر المكافآت</div>
            <p class="gamif-desc">افتح خلفيات وأيقونات وأصوات تشجيعية</p>
        </div>
        <div class="gamif-card">
            <div class="gamif-emoji">🎯</div>
            <div class="gamif-title">تحديات أسبوعية</div>
            <p class="gamif-desc">تنافس مع نفسك — ليس مع غيرك</p>
        </div>
    </div>
</section>

<section class="section-wrap reveal" style="background: var(--olive-pale);">
    <div style="text-align: center; max-width: 600px; margin: 0 auto;">
        <div class="section-label" style="justify-content: center;">آراء المستخدمين</div>
        <h2 class="section-title">ماذا قالوا عنه</h2>
    </div>
    <div class="testimonials-grid">
        <div class="testi-card">
            <div class="testi-quote">"</div>
            <div class="stars">★★★★★</div>
            <p class="testi-text">أخيراً تطبيق يفهم أن الإنسان المسلم لا يفصل بين دينه وصحته وعمله. كل شيء في مكان واحد.</p>
            <div class="testi-author">
                <div class="testi-avatar">ع</div>
                <div>
                    <div class="testi-name">عبدالرحمن السيد</div>
                    <div class="testi-role">مهندس برمجيات</div>
                </div>
            </div>
        </div>
        <div class="testi-card">
            <div class="testi-quote">"</div>
            <div class="stars">★★★★★</div>
            <p class="testi-text">النصيحة اللي قالت لي أن إنستغرام يأخذ وقت صلاتي — كانت صدمة حقيقية. غيّرت الكثير بحياتي.</p>
            <div class="testi-author">
                <div class="testi-avatar">س</div>
                <div>
                    <div class="testi-name">سارة المنصور</div>
                    <div class="testi-role">طالبة جامعية</div>
                </div>
            </div>
        </div>
        <div class="testi-card">
            <div class="testi-quote">"</div>
            <div class="stars">★★★★★</div>
            <p class="testi-text">شجرة الإنتاجية حفّزتني أكثر من أي تطبيق جربته. لما شفتها تذبل أول مرة — ما تركته يحصل مجدداً.</p>
            <div class="testi-author">
                <div class="testi-avatar">م</div>
                <div>
                    <div class="testi-name">محمد الغامدي</div>
                    <div class="testi-role">معلم ورياضي هاوي</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="cta" class="cta-section">
    <h2 class="cta-title">يومك يستحق أكثر<br>من قائمة مهام</h2>
    <p class="cta-sub">انضم وابدأ رحلتك نحو إنتاجية متكاملة — مجاناً</p>
    <a href="{{ route('register') }}" class="btn-gold">
        ابدأ الآن — مجاناً
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 9h12M9 3l6 6-6 6"/>
        </svg>
    </a>
</section>

<footer>
    <div class="footer-logo">إنتاجي – منتِج</div>
    <div class="footer-links">
        <a href="#">سياسة الخصوصية</a>
        <a href="#">شروط الاستخدام</a>
        <a href="#">تواصل معنا</a>
    </div>
    <div class="footer-copy">© {{ date('Y') }} إنتاجي. جميع الحقوق محفوظة.</div>
</footer>

<script>
    function showPanel(idx) {
        document.querySelectorAll('.sec-pill').forEach((p, i) => {
            p.classList.toggle('active', i === idx);
        });
        document.querySelectorAll('.showcase-panel').forEach((p, i) => {
            p.classList.toggle('active', i === idx);
        });
    }

    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    reveals.forEach(r => observer.observe(r));

    const counters = document.querySelectorAll('.stat-num[data-target]');
    const arabic = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
    const toArabic = n => String(n).split('').map(d => arabic[+d] ?? d).join('');

    const counterObs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (!e.isIntersecting) return;
            const el = e.target;
            const target = +el.dataset.target;
            let current = 0;
            const step = Math.max(1, Math.ceil(target / 40));
            const timer = setInterval(() => {
                current = Math.min(current + step, target);
                el.textContent = toArabic(current);
                if (current >= target) clearInterval(timer);
            }, 40);
            counterObs.unobserve(el);
        });
    }, { threshold: 0.5 });
    counters.forEach(c => counterObs.observe(c));

    window.addEventListener('scroll', () => {
        document.querySelector('nav').style.boxShadow =
            window.scrollY > 20 ? '0 4px 24px rgba(26,31,14,0.08)' : 'none';
    });
</script>
</body>
</html>
