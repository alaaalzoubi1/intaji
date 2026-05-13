<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>لوحة التحكم – إنتاجي</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
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
  --sidebar-w:   260px;

  --bg:          #f4f1e8;
  --card:        #ffffff;
  --border:      rgba(74,94,42,0.1);
  --border-md:   rgba(74,94,42,0.18);
  --danger:      #dc3545;
  --success:     #28a745;
  --info:        #1a73e8;
}

*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
body {
  font-family: 'Tajawal', sans-serif;
  background: var(--bg);
  color: var(--ink);
  display: flex;
  min-height: 100vh;
}

/* ══════════════════════════
   SIDEBAR
══════════════════════════ */
.sidebar {
  width: var(--sidebar-w);
  background: var(--ink);
  min-height: 100vh;
  position: fixed; top: 0; right: 0;
  display: flex; flex-direction: column;
  z-index: 200;
  transition: transform 0.3s;
}
.sidebar-logo {
  padding: 24px 20px;
  border-bottom: 1px solid rgba(255,255,255,0.08);
  display: flex; align-items: center; gap: 12px;
}
.sidebar-logo .mark {
  width: 36px; height: 36px; border-radius: 10px;
  background: var(--olive);
  display: flex; align-items: center; justify-content: center;
  font-size: 18px;
}
.sidebar-logo .text { font-size: 16px; font-weight: 700; color: var(--cream); }
.sidebar-logo .sub  { font-size: 11px; color: rgba(255,255,255,0.35); }

.sidebar-section {
  padding: 16px 12px 8px;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.12em;
  color: rgba(255,255,255,0.25);
  text-transform: uppercase;
}

.nav-item {
  display: flex; align-items: center; gap: 12px;
  padding: 11px 16px;
  margin: 2px 8px;
  border-radius: 10px;
  color: rgba(255,255,255,0.55);
  font-size: 14px; font-weight: 500;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.2s;
}
.nav-item:hover { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.85); }
.nav-item.active { background: var(--olive); color: var(--cream); }
.nav-item.active .nav-icon { opacity: 1; }
.nav-icon { font-size: 17px; opacity: 0.7; }
.nav-badge {
  margin-right: auto;
  background: var(--gold);
  color: var(--ink);
  font-size: 10px; font-weight: 800;
  padding: 2px 7px; border-radius: 100px;
}

.sidebar-footer {
  margin-top: auto;
  padding: 16px;
  border-top: 1px solid rgba(255,255,255,0.08);
}
.admin-card {
  display: flex; align-items: center; gap: 10px;
  padding: 10px 12px;
  background: rgba(255,255,255,0.05);
  border-radius: 10px;
}
.admin-avatar {
  width: 34px; height: 34px; border-radius: 50%;
  background: var(--olive);
  display: flex; align-items: center; justify-content: center;
  font-size: 14px; font-weight: 700; color: var(--cream);
  flex-shrink: 0;
}
.admin-name  { font-size: 13px; font-weight: 600; color: var(--cream); }
.admin-role  { font-size: 11px; color: rgba(255,255,255,0.35); }
.logout-btn {
  margin-right: auto;
  background: none; border: none;
  color: rgba(255,255,255,0.3);
  font-size: 16px; cursor: pointer;
  padding: 4px; border-radius: 6px;
  transition: color 0.2s, background 0.2s;
}
.logout-btn:hover { color: rgba(255,255,255,0.7); background: rgba(255,255,255,0.08); }

/* ══════════════════════════
   MAIN
══════════════════════════ */
.main {
  margin-right: var(--sidebar-w);
  flex: 1;
  display: flex; flex-direction: column;
  min-height: 100vh;
}

/* TOPBAR */
.topbar {
  background: var(--card);
  border-bottom: 1px solid var(--border);
  padding: 0 32px;
  height: 64px;
  display: flex; align-items: center; justify-content: space-between;
  position: sticky; top: 0; z-index: 100;
}
.topbar-title { font-size: 16px; font-weight: 700; color: var(--ink); }
.topbar-right { display: flex; align-items: center; gap: 12px; }
.topbar-btn {
  width: 36px; height: 36px; border-radius: 9px;
  border: 1px solid var(--border-md);
  background: none; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  font-size: 16px; color: var(--muted);
  transition: all 0.2s; position: relative;
}
.topbar-btn:hover { background: var(--bg); color: var(--ink); }
.topbar-btn .badge {
  position: absolute; top: -3px; left: -3px;
  width: 14px; height: 14px; border-radius: 50%;
  background: var(--danger); border: 2px solid var(--card);
  font-size: 8px; color: white; font-weight: 800;
  display: flex; align-items: center; justify-content: center;
}
.search-wrap {
  display: flex; align-items: center; gap: 8px;
  background: var(--bg);
  border: 1px solid var(--border);
  border-radius: 9px;
  padding: 0 14px;
  height: 36px; width: 220px;
}
.search-wrap input {
  border: none; background: none;
  font-family: 'Tajawal', sans-serif;
  font-size: 13px; color: var(--ink);
  flex: 1; outline: none;
}
.search-wrap input::placeholder { color: var(--muted); }

/* CONTENT */
.content { padding: 28px 32px; flex: 1; }
.page-header {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 24px;
}
.page-title    { font-size: 22px; font-weight: 800; color: var(--ink); }
.page-subtitle { font-size: 13px; color: var(--muted); margin-top: 2px; }
.btn {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 9px 18px;
  border-radius: 9px;
  font-family: 'Tajawal', sans-serif;
  font-size: 13px; font-weight: 700;
  cursor: pointer; border: none;
  transition: all 0.2s; text-decoration: none;
}
.btn-olive  { background: var(--olive);  color: var(--cream); }
.btn-olive:hover  { background: var(--olive-light); transform: translateY(-1px); }
.btn-outline { background: var(--card); border: 1px solid var(--border-md); color: var(--ink-soft); }
.btn-outline:hover { border-color: var(--olive); color: var(--olive); }

/* ══════════════════════════
   KPI CARDS
══════════════════════════ */
.kpi-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 16px;
  margin-bottom: 24px;
}
.kpi-card {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 20px 20px 16px;
  position: relative;
  overflow: hidden;
  transition: box-shadow 0.2s, transform 0.2s;
}
.kpi-card:hover { box-shadow: 0 8px 32px rgba(26,31,14,0.08); transform: translateY(-2px); }
.kpi-card::before {
  content: '';
  position: absolute; top: 0; right: 0;
  width: 4px; height: 100%;
  border-radius: 0 16px 16px 0;
}
.kpi-card.green::before  { background: var(--olive); }
.kpi-card.gold::before   { background: var(--gold); }
.kpi-card.blue::before   { background: var(--info); }
.kpi-card.red::before    { background: var(--danger); }

.kpi-label {
  font-size: 12px; color: var(--muted); font-weight: 600;
  margin-bottom: 8px;
  display: flex; align-items: center; gap: 6px;
}
.kpi-label .dot {
  width: 7px; height: 7px; border-radius: 50%;
}
.kpi-card.green .dot  { background: var(--olive); }
.kpi-card.gold .dot   { background: var(--gold); }
.kpi-card.blue .dot   { background: var(--info); }
.kpi-card.red .dot    { background: var(--danger); }

.kpi-val {
  font-size: 32px; font-weight: 800; color: var(--ink);
  line-height: 1; margin-bottom: 8px;
}
.kpi-trend {
  font-size: 12px; font-weight: 600;
  display: flex; align-items: center; gap: 4px;
}
.kpi-trend.up   { color: var(--success); }
.kpi-trend.down { color: var(--danger); }
.kpi-trend.neutral { color: var(--muted); }

/* ══════════════════════════
   CHARTS ROW
══════════════════════════ */
.charts-row {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 16px;
  margin-bottom: 24px;
}
.card {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 20px 24px;
}
.card-header {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 20px;
}
.card-title {
  font-size: 14px; font-weight: 700; color: var(--ink);
}
.card-sub { font-size: 12px; color: var(--muted); margin-top: 2px; }
.chart-wrap { position: relative; height: 220px; }

/* ══════════════════════════
   DATA TABLES
══════════════════════════ */
.bottom-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
  margin-bottom: 24px;
}
table { width: 100%; border-collapse: collapse; }
thead th {
  text-align: right;
  font-size: 11px; font-weight: 700;
  letter-spacing: 0.06em; text-transform: uppercase;
  color: var(--muted);
  padding: 0 0 12px;
  border-bottom: 1px solid var(--border);
}
tbody tr {
  border-bottom: 1px solid var(--border);
  transition: background 0.15s;
}
tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: var(--bg); }
tbody td {
  padding: 11px 0;
  font-size: 13px; color: var(--ink-soft);
  vertical-align: middle;
}
.act-name { display: flex; align-items: center; gap: 8px; }
.act-icon {
  width: 30px; height: 30px; border-radius: 8px;
  background: var(--olive-pale);
  display: flex; align-items: center; justify-content: center;
  font-size: 14px; flex-shrink: 0;
}
.progress-wrap {
  display: flex; align-items: center; gap: 8px;
}
.progress-bar {
  flex: 1; height: 5px; border-radius: 3px;
  background: var(--olive-pale);
  overflow: hidden;
}
.progress-fill {
  height: 100%; border-radius: 3px;
  background: var(--olive);
  transition: width 0.8s ease;
}
.progress-fill.gold { background: var(--gold); }
.pct { font-size: 11px; font-weight: 700; color: var(--ink-soft); min-width: 30px; }

/* pill badges */
.pill {
  display: inline-flex; align-items: center;
  padding: 3px 9px; border-radius: 100px;
  font-size: 11px; font-weight: 700;
}
.pill.active   { background: rgba(74,94,42,0.1);  color: var(--olive); }
.pill.inactive { background: rgba(107,122,74,0.08); color: var(--muted); }
.pill.high     { background: rgba(220,53,69,0.1);  color: var(--danger); }
.pill.medium   { background: rgba(201,168,76,0.15); color: var(--gold-dark); }
.pill.low      { background: rgba(40,167,69,0.1);  color: var(--success); }

/* section usage chart */
.section-bars { display: flex; flex-direction: column; gap: 12px; }
.sec-bar-row { display: flex; align-items: center; gap: 12px; }
.sec-bar-label {
  width: 90px; font-size: 12px; color: var(--ink-soft);
  display: flex; align-items: center; gap: 6px; flex-shrink: 0;
}
.sec-bar-track {
  flex: 1; height: 8px; border-radius: 4px;
  background: var(--olive-pale); overflow: hidden;
}
.sec-bar-fill {
  height: 100%; border-radius: 4px;
  background: var(--olive);
  transition: width 1s ease;
}
.sec-bar-pct { font-size: 12px; font-weight: 700; color: var(--muted); min-width: 36px; text-align: left; }

/* Quick actions floating */
.fab {
  position: fixed; bottom: 28px; left: 28px;
  z-index: 300;
}
.fab-btn {
  width: 52px; height: 52px; border-radius: 50%;
  background: var(--olive);
  border: none; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  font-size: 22px; color: var(--cream);
  box-shadow: 0 4px 20px rgba(74,94,42,0.35);
  transition: all 0.2s;
}
.fab-btn:hover { background: var(--olive-light); transform: scale(1.06); }
.fab-menu {
  position: absolute; bottom: 60px; left: 0;
  display: flex; flex-direction: column; gap: 8px;
  opacity: 0; pointer-events: none;
  transform: translateY(10px);
  transition: all 0.25s;
}
.fab.open .fab-menu { opacity: 1; pointer-events: auto; transform: translateY(0); }
.fab-item {
  display: flex; align-items: center; gap: 10px;
  background: var(--card);
  border: 1px solid var(--border-md);
  border-radius: 10px;
  padding: 9px 14px;
  font-size: 13px; font-weight: 600; color: var(--ink-soft);
  cursor: pointer; white-space: nowrap;
  box-shadow: 0 4px 16px rgba(26,31,14,0.1);
  transition: all 0.15s;
}
.fab-item:hover { background: var(--olive); color: var(--cream); border-color: var(--olive); }

/* modal */
.modal-backdrop {
  position: fixed; inset: 0;
  background: rgba(26,31,14,0.5);
  backdrop-filter: blur(4px);
  z-index: 500; display: none;
  align-items: center; justify-content: center;
}
.modal-backdrop.open { display: flex; }
.modal {
  background: var(--card);
  border-radius: 20px;
  padding: 28px;
  width: 480px; max-width: 90%;
  box-shadow: 0 24px 80px rgba(26,31,14,0.25);
  animation: slideUp 0.25s ease;
}
.modal-header {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 24px;
}
.modal-title { font-size: 17px; font-weight: 800; color: var(--ink); }
.modal-close {
  width: 30px; height: 30px; border-radius: 8px;
  border: none; background: var(--bg);
  cursor: pointer; font-size: 16px; color: var(--muted);
  display: flex; align-items: center; justify-content: center;
  transition: all 0.2s;
}
.modal-close:hover { background: var(--border); color: var(--ink); }
.form-group { margin-bottom: 16px; }
.form-label { font-size: 13px; font-weight: 600; color: var(--ink-soft); margin-bottom: 6px; display: block; }
.form-control {
  width: 100%;
  padding: 10px 14px;
  border: 1px solid var(--border-md);
  border-radius: 10px;
  font-family: 'Tajawal', sans-serif;
  font-size: 14px; color: var(--ink);
  background: var(--bg);
  outline: none;
  transition: border-color 0.2s;
}
.form-control:focus { border-color: var(--olive); background: var(--card); }
select.form-control { cursor: pointer; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.modal-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px; }

@keyframes slideUp {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* notifications panel */
.notif-panel {
  position: fixed; top: 0; left: 0;
  width: 340px; height: 100vh;
  background: var(--card);
  border-right: 1px solid var(--border);
  z-index: 400;
  transform: translateX(-100%);
  transition: transform 0.3s;
  display: flex; flex-direction: column;
  box-shadow: 4px 0 32px rgba(26,31,14,0.1);
}
.notif-panel.open { transform: translateX(0); }
.notif-head {
  padding: 20px 20px 16px;
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center; justify-content: space-between;
}
.notif-head h3 { font-size: 15px; font-weight: 800; color: var(--ink); }
.notif-list { flex: 1; overflow-y: auto; }
.notif-item {
  padding: 14px 20px;
  border-bottom: 1px solid var(--border);
  cursor: pointer; transition: background 0.15s;
  display: flex; gap: 12px; align-items: flex-start;
}
.notif-item:hover { background: var(--bg); }
.notif-item.unread { background: rgba(74,94,42,0.04); }
.notif-dot {
  width: 8px; height: 8px; border-radius: 50%;
  background: var(--olive); flex-shrink: 0; margin-top: 5px;
}
.notif-item.read .notif-dot { background: transparent; border: 1px solid var(--border-md); }
.notif-text { font-size: 13px; color: var(--ink-soft); line-height: 1.6; }
.notif-time { font-size: 11px; color: var(--muted); margin-top: 3px; }

@media (max-width: 900px) {
  .sidebar { transform: translateX(100%); }
  .main { margin-right: 0; }
  .charts-row, .bottom-row { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <div class="mark">🌿</div>
    <div>
      <div class="text">إنتاجي</div>
      <div class="sub">لوحة التحكم</div>
    </div>
  </div>

  <div class="sidebar-section">الرئيسية</div>
  <a href="#" class="nav-item active" onclick="switchTab('overview',this)">
    <span class="nav-icon">📊</span> نظرة عامة
    <span class="nav-badge">جديد</span>
  </a>
  <a href="#" class="nav-item" onclick="switchTab('users',this)">
    <span class="nav-icon">👥</span> المستخدمون
  </a>

  <div class="sidebar-section">المحتوى</div>
  <a href="#" class="nav-item" onclick="switchTab('sections',this)">
    <span class="nav-icon">📁</span> الأقسام
  </a>
  <a href="#" class="nav-item" onclick="switchTab('activities',this)">
    <span class="nav-icon">✅</span> الأنشطة
  </a>
  <a href="#" class="nav-item" onclick="switchTab('tips',this)">
    <span class="nav-icon">💡</span> النصائح
  </a>

  <div class="sidebar-section">الإعدادات</div>
  <a href="#" class="nav-item" onclick="switchTab('ai',this)">
    <span class="nav-icon">🤖</span> قواعد الـ AI
  </a>
  <a href="#" class="nav-item" onclick="switchTab('badges',this)">
    <span class="nav-icon">🏅</span> الشارات
  </a>
  <a href="#" class="nav-item" onclick="switchTab('store',this)">
    <span class="nav-icon">🏪</span> المتجر
  </a>

  <div class="sidebar-footer">
    <div class="admin-card">
      <div class="admin-avatar">A</div>
      <div>
        <div class="admin-name">Admin</div>
        <div class="admin-role">المطور / المالك</div>
      </div>
      <form method="POST" action="{{ route('logout') }}" style="margin:0">
        @csrf
        <button type="submit" class="logout-btn" title="تسجيل الخروج">⬚</button>
      </form>
    </div>
  </div>
</aside>

<!-- MAIN -->
<div class="main">

  <!-- TOPBAR -->
  <header class="topbar">
    <div class="topbar-title" id="topbar-title">نظرة عامة</div>
    <div class="topbar-right">
      <div class="search-wrap">
        <span style="color:var(--muted); font-size:14px;">🔍</span>
        <input type="text" placeholder="بحث...">
      </div>
      <button class="topbar-btn" onclick="toggleNotif()" title="الإشعارات">
        🔔
        <span class="badge">3</span>
      </button>
      <button class="topbar-btn" title="الإعدادات">⚙️</button>
    </div>
  </header>

  <!-- CONTENT -->
  <div class="content">

    <!-- ═══ TAB: OVERVIEW ═══ -->
    <div id="tab-overview" class="tab-content">
      <div class="page-header">
        <div>
          <div class="page-title">مرحباً، Admin 👋</div>
          <div class="page-subtitle">{{ now()->translatedFormat('l، j F Y') }}</div>
        </div>
        <button class="btn btn-outline" onclick="refreshData()">🔄 تحديث</button>
      </div>

      <!-- KPIs -->
      <div class="kpi-grid">
        <div class="kpi-card green">
          <div class="kpi-label"><span class="dot"></span>إجمالي المستخدمين</div>
          <div class="kpi-val" id="kpi-users">{{ $stats['total_users'] ?? '—' }}</div>
          <div class="kpi-trend up">↑ ١٢٪ هذا الأسبوع</div>
        </div>
        <div class="kpi-card gold">
          <div class="kpi-label"><span class="dot"></span>تسجيلات اليوم</div>
          <div class="kpi-val" id="kpi-logs">{{ $stats['today_logs'] ?? '—' }}</div>
          <div class="kpi-trend up">↑ ٨٪ مقارنة بالأمس</div>
        </div>
        <div class="kpi-card blue">
          <div class="kpi-label"><span class="dot"></span>معدل الالتزام</div>
          <div class="kpi-val" id="kpi-commit">{{ $stats['avg_commitment'] ?? '—' }}٪</div>
          <div class="kpi-trend neutral">← ثابت</div>
        </div>
        <div class="kpi-card red">
          <div class="kpi-label"><span class="dot"></span>المستخدمون غير النشطين</div>
          <div class="kpi-val" id="kpi-inactive">{{ $stats['inactive_users'] ?? '—' }}</div>
          <div class="kpi-trend down">↑ ٣ مستخدمين</div>
        </div>
      </div>

      <!-- Charts -->
      <div class="charts-row">
        <div class="card">
          <div class="card-header">
            <div>
              <div class="card-title">نشاط المستخدمين — آخر ٣٠ يوماً</div>
              <div class="card-sub">عدد التسجيلات اليومية</div>
            </div>
            <div style="display:flex; gap:8px;">
              <button class="btn btn-outline" style="padding:5px 12px; font-size:12px;" onclick="setChartRange(7)">٧ أيام</button>
              <button class="btn btn-olive"   style="padding:5px 12px; font-size:12px;" onclick="setChartRange(30)">٣٠ يوماً</button>
            </div>
          </div>
          <div class="chart-wrap">
            <canvas id="activityChart"></canvas>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <div>
              <div class="card-title">توزيع الأقسام</div>
              <div class="card-sub">الأكثر استخداماً</div>
            </div>
          </div>
          <div class="chart-wrap" style="height:180px;">
            <canvas id="sectionChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Bottom Tables -->
      <div class="bottom-row">
        <!-- Top Activities -->
        <div class="card">
          <div class="card-header">
            <div class="card-title">أكثر الأنشطة التزاماً</div>
            <a href="#" onclick="switchTab('activities', null)" class="btn btn-outline" style="padding:5px 14px; font-size:12px;">عرض الكل</a>
          </div>
          <table>
            <thead>
              <tr>
                <th>النشاط</th>
                <th>الالتزام</th>
                <th>الحالة</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><div class="act-name"><div class="act-icon">🕌</div>صلاة الفجر</div></td>
                <td>
                  <div class="progress-wrap">
                    <div class="progress-bar"><div class="progress-fill" style="width:78%"></div></div>
                    <span class="pct">٧٨٪</span>
                  </div>
                </td>
                <td><span class="pill active">نشط</span></td>
              </tr>
              <tr>
                <td><div class="act-name"><div class="act-icon">📖</div>قراءة القرآن</div></td>
                <td>
                  <div class="progress-wrap">
                    <div class="progress-bar"><div class="progress-fill gold" style="width:65%"></div></div>
                    <span class="pct">٦٥٪</span>
                  </div>
                </td>
                <td><span class="pill active">نشط</span></td>
              </tr>
              <tr>
                <td><div class="act-name"><div class="act-icon">💧</div>شرب الماء</div></td>
                <td>
                  <div class="progress-wrap">
                    <div class="progress-bar"><div class="progress-fill" style="width:72%"></div></div>
                    <span class="pct">٧٢٪</span>
                  </div>
                </td>
                <td><span class="pill active">نشط</span></td>
              </tr>
              <tr>
                <td><div class="act-name"><div class="act-icon">🏃</div>الرياضة</div></td>
                <td>
                  <div class="progress-wrap">
                    <div class="progress-bar"><div class="progress-fill" style="width:43%"></div></div>
                    <span class="pct">٤٣٪</span>
                  </div>
                </td>
                <td><span class="pill active">نشط</span></td>
              </tr>
              <tr>
                <td><div class="act-name"><div class="act-icon">📚</div>القراءة اليومية</div></td>
                <td>
                  <div class="progress-wrap">
                    <div class="progress-bar"><div class="progress-fill gold" style="width:38%"></div></div>
                    <span class="pct">٣٨٪</span>
                  </div>
                </td>
                <td><span class="pill inactive">منخفض</span></td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Section usage bars -->
        <div class="card">
          <div class="card-header">
            <div class="card-title">الأقسام — نسبة الاستخدام</div>
          </div>
          <div class="section-bars" style="margin-top:8px;">
            <div class="sec-bar-row">
              <div class="sec-bar-label">🕌 العبادات</div>
              <div class="sec-bar-track"><div class="sec-bar-fill" style="width:88%"></div></div>
              <span class="sec-bar-pct">٨٨٪</span>
            </div>
            <div class="sec-bar-row">
              <div class="sec-bar-label">💪 الصحة</div>
              <div class="sec-bar-track"><div class="sec-bar-fill" style="width:71%"></div></div>
              <span class="sec-bar-pct">٧١٪</span>
            </div>
            <div class="sec-bar-row">
              <div class="sec-bar-label">📚 التعلم</div>
              <div class="sec-bar-track"><div class="sec-bar-fill" style="width:55%"></div></div>
              <span class="sec-bar-pct">٥٥٪</span>
            </div>
            <div class="sec-bar-row">
              <div class="sec-bar-label">💼 العمل</div>
              <div class="sec-bar-track"><div class="sec-bar-fill" style="width:49%"></div></div>
              <span class="sec-bar-pct">٤٩٪</span>
            </div>
            <div class="sec-bar-row">
              <div class="sec-bar-label">💰 المالي</div>
              <div class="sec-bar-track"><div class="sec-bar-fill" style="width:32%"></div></div>
              <span class="sec-bar-pct">٣٢٪</span>
            </div>
            <div class="sec-bar-row">
              <div class="sec-bar-label">🧘 النفسي</div>
              <div class="sec-bar-track"><div class="sec-bar-fill" style="width:28%"></div></div>
              <span class="sec-bar-pct">٢٨٪</span>
            </div>
            <div class="sec-bar-row">
              <div class="sec-bar-label">👨‍👩‍👧 الاجتماعي</div>
              <div class="sec-bar-track"><div class="sec-bar-fill" style="width:25%"></div></div>
              <span class="sec-bar-pct">٢٥٪</span>
            </div>
            <div class="sec-bar-row">
              <div class="sec-bar-label">🎨 الإبداع</div>
              <div class="sec-bar-track"><div class="sec-bar-fill" style="width:18%"></div></div>
              <span class="sec-bar-pct">١٨٪</span>
            </div>
            <div class="sec-bar-row">
              <div class="sec-bar-label">🌱 البيئي</div>
              <div class="sec-bar-track"><div class="sec-bar-fill" style="width:12%"></div></div>
              <span class="sec-bar-pct">١٢٪</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ═══ TAB: ACTIVITIES (مثال للصفحات الأخرى) ═══ -->
    <div id="tab-activities" class="tab-content" style="display:none;">
      <div class="page-header">
        <div>
          <div class="page-title">إدارة الأنشطة</div>
          <div class="page-subtitle">{{ $activitiesCount ?? '٢٩' }} نشاط في {{ $sectionsCount ?? '٩' }} أقسام</div>
        </div>
        <button class="btn btn-olive" onclick="openModal('modal-add-activity')">+ إضافة نشاط</button>
      </div>

      <div class="card">
        <div style="display:flex; gap:10px; margin-bottom:20px;">
          <select class="form-control" style="width:160px;">
            <option>كل الأقسام</option>
            <option>العبادات</option>
            <option>الصحة</option>
            <option>التعلم</option>
          </select>
          <select class="form-control" style="width:160px;">
            <option>كل طرق القياس</option>
            <option>نعم/لا</option>
            <option>عدد دقائق</option>
            <option>عدد صفحات</option>
            <option>مؤقت</option>
          </select>
        </div>
        <table>
          <thead>
            <tr>
              <th>النشاط</th>
              <th>القسم</th>
              <th>طريقة القياس</th>
              <th>النقاط</th>
              <th>الحالة</th>
              <th>إجراءات</th>
            </tr>
          </thead>
          <tbody>
            @foreach($activities ?? [] as $activity)
            <tr>
              <td><div class="act-name"><div class="act-icon">{{ $activity->icon ?? '📋' }}</div>{{ $activity->name }}</div></td>
              <td>{{ $activity->section->name }}</td>
              <td><span class="pill medium">{{ $activity->measurement_type }}</span></td>
              <td>{{ $activity->points }} نقطة</td>
              <td><span class="pill {{ $activity->is_active ? 'active' : 'inactive' }}">{{ $activity->is_active ? 'نشط' : 'متوقف' }}</span></td>
              <td>
                <div style="display:flex; gap:6px;">
                  <button class="btn btn-outline" style="padding:4px 10px; font-size:12px;">تعديل</button>
                  <button class="btn" style="padding:4px 10px; font-size:12px; background:rgba(220,53,69,0.08); color:var(--danger); border:1px solid rgba(220,53,69,0.2);">حذف</button>
                </div>
              </td>
            </tr>
            @endforeach
            {{-- Fallback static rows if no data --}}
            @if(empty($activities) || count($activities) == 0)
            <tr>
              <td><div class="act-name"><div class="act-icon">🕌</div>صلاة الفجر</div></td>
              <td>العبادات</td>
              <td><span class="pill medium">نعم/لا</span></td>
              <td>٣٠ نقطة</td>
              <td><span class="pill active">نشط</span></td>
              <td><div style="display:flex; gap:6px;"><button class="btn btn-outline" style="padding:4px 10px; font-size:12px;">تعديل</button><button class="btn" style="padding:4px 10px; font-size:12px; background:rgba(220,53,69,0.08); color:var(--danger); border:1px solid rgba(220,53,69,0.2);">حذف</button></div></td>
            </tr>
            <tr>
              <td><div class="act-name"><div class="act-icon">📖</div>قراءة القرآن</div></td>
              <td>العبادات</td>
              <td><span class="pill medium">عدد صفحات</span></td>
              <td>٢٥ نقطة</td>
              <td><span class="pill active">نشط</span></td>
              <td><div style="display:flex; gap:6px;"><button class="btn btn-outline" style="padding:4px 10px; font-size:12px;">تعديل</button><button class="btn" style="padding:4px 10px; font-size:12px; background:rgba(220,53,69,0.08); color:var(--danger); border:1px solid rgba(220,53,69,0.2);">حذف</button></div></td>
            </tr>
            <tr>
              <td><div class="act-name"><div class="act-icon">⏱️</div>بومودورو</div></td>
              <td>العمل</td>
              <td><span class="pill medium">مؤقت</span></td>
              <td>٢٥ نقطة</td>
              <td><span class="pill active">نشط</span></td>
              <td><div style="display:flex; gap:6px;"><button class="btn btn-outline" style="padding:4px 10px; font-size:12px;">تعديل</button><button class="btn" style="padding:4px 10px; font-size:12px; background:rgba(220,53,69,0.08); color:var(--danger); border:1px solid rgba(220,53,69,0.2);">حذف</button></div></td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>

    <!-- ═══ TAB: TIPS ═══ -->
    <div id="tab-tips" class="tab-content" style="display:none;">
      <div class="page-header">
        <div>
          <div class="page-title">إدارة النصائح</div>
          <div class="page-subtitle">النصائح الثابتة والشرطية لـ AI</div>
        </div>
        <button class="btn btn-olive" onclick="openModal('modal-add-tip')">+ إضافة نصيحة</button>
      </div>
      <div class="card">
        <table>
          <thead>
            <tr>
              <th>النصيحة</th>
              <th>النوع</th>
              <th>الفئة</th>
              <th>التقييم</th>
              <th>إجراءات</th>
            </tr>
          </thead>
          <tbody>
            @foreach($tips ?? [] as $tip)
            <tr>
              <td style="max-width:280px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $tip->content }}</td>
              <td><span class="pill {{ $tip->type === 'static' ? 'active' : 'medium' }}">{{ $tip->type === 'static' ? 'ثابتة' : 'شرطية' }}</span></td>
              <td>{{ $tip->tip_category }}</td>
              <td>—</td>
              <td><div style="display:flex; gap:6px;"><button class="btn btn-outline" style="padding:4px 10px; font-size:12px;">تعديل</button></div></td>
            </tr>
            @endforeach
            @if(empty($tips) || count($tips) == 0)
            <tr>
              <td style="max-width:280px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">"ابدأ يومك بنية صادقة وابتسامة..."</td>
              <td><span class="pill active">ثابتة</span></td>
              <td>عامة</td>
              <td><span style="color:var(--gold); font-size:13px;">★ ٩٢٪</span></td>
              <td><div style="display:flex; gap:6px;"><button class="btn btn-outline" style="padding:4px 10px; font-size:12px;">تعديل</button></div></td>
            </tr>
            <tr>
              <td style="max-width:280px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">"التزامك بصلاة الفجر منخفض هذا الأسبوع..."</td>
              <td><span class="pill medium">شرطية</span></td>
              <td>تحليل الفشل</td>
              <td><span style="color:var(--gold); font-size:13px;">★ ٨٥٪</span></td>
              <td><div style="display:flex; gap:6px;"><button class="btn btn-outline" style="padding:4px 10px; font-size:12px;">تعديل</button></div></td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>

    <!-- باقي التابز ستُعبأ لاحقاً -->
    <div id="tab-users"    class="tab-content" style="display:none;"><div class="page-header"><div class="page-title">المستخدمون</div></div><div class="card" style="padding:60px; text-align:center; color:var(--muted);">قريباً — جدول المستخدمين مع فلاتر وتصدير</div></div>
    <div id="tab-sections" class="tab-content" style="display:none;"><div class="page-header"><div class="page-title">الأقسام</div></div><div class="card" style="padding:60px; text-align:center; color:var(--muted);">قريباً — إدارة الأقسام التسعة</div></div>
    <div id="tab-ai"       class="tab-content" style="display:none;"><div class="page-header"><div class="page-title">قواعد الذكاء الاصطناعي</div></div><div class="card" style="padding:60px; text-align:center; color:var(--muted);">قريباً — ضبط معاملات ربط وقت التطبيقات بالأداء</div></div>
    <div id="tab-badges"   class="tab-content" style="display:none;"><div class="page-header"><div class="page-title">الشارات</div></div><div class="card" style="padding:60px; text-align:center; color:var(--muted);">قريباً — إدارة شارات الإنجاز وشروط فتحها</div></div>
    <div id="tab-store"    class="tab-content" style="display:none;"><div class="page-header"><div class="page-title">المتجر</div></div><div class="card" style="padding:60px; text-align:center; color:var(--muted);">قريباً — عناصر المتجر والخلفيات والأيقونات</div></div>

  </div>
</div>

<!-- FAB -->
<div class="fab" id="fab">
  <div class="fab-menu">
    <div class="fab-item" onclick="openModal('modal-add-activity')">✅ نشاط جديد</div>
    <div class="fab-item" onclick="openModal('modal-add-tip')">💡 نصيحة جديدة</div>
    <div class="fab-item">📁 قسم جديد</div>
  </div>
  <button class="fab-btn" onclick="document.getElementById('fab').classList.toggle('open')">+</button>
</div>

<!-- MODAL: Add Activity -->
<div class="modal-backdrop" id="modal-add-activity">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">إضافة نشاط جديد</div>
      <button class="modal-close" onclick="closeModal('modal-add-activity')">✕</button>
    </div>
    <form method="POST" action="{{ route('admin.activities.store') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">اسم النشاط</label>
        <input class="form-control" name="name" type="text" placeholder="مثال: صلاة الضحى" required>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">القسم</label>
          <select class="form-control" name="section_id" required>
            <option value="">اختر...</option>
            @foreach($sections ?? [] as $section)
              <option value="{{ $section->id }}">{{ $section->name }}</option>
            @endforeach
            @if(empty($sections))
              <option value="1">🕌 العبادات</option>
              <option value="2">💪 الصحة</option>
              <option value="3">📚 التعلم</option>
              <option value="4">💼 العمل</option>
            @endif
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">طريقة القياس</label>
          <select class="form-control" name="measurement_type" required>
            <option value="yes_no">نعم / لا</option>
            <option value="pages">عدد صفحات</option>
            <option value="minutes">عدد دقائق</option>
            <option value="count">عدد مرات</option>
            <option value="percentage">نسبة مئوية</option>
            <option value="rating">تقييم ١-٥</option>
            <option value="text">نص حر</option>
            <option value="timer">مؤقت</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">الوحدة (اختياري)</label>
          <input class="form-control" name="unit" type="text" placeholder="صفحة، دقيقة، كوب...">
        </div>
        <div class="form-group">
          <label class="form-label">النقاط</label>
          <input class="form-control" name="points" type="number" value="10" min="1" max="100">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">التكرار</label>
          <select class="form-control" name="repeat_type">
            <option value="daily">يومياً</option>
            <option value="specific_days">أيام محددة</option>
            <option value="odd_days">الأيام الفردية</option>
            <option value="even_days">الأيام الزوجية</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">وقت التذكير</label>
          <input class="form-control" name="default_reminder_time" type="time">
        </div>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn btn-outline" onclick="closeModal('modal-add-activity')">إلغاء</button>
        <button type="submit" class="btn btn-olive">💾 حفظ النشاط</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: Add Tip -->
<div class="modal-backdrop" id="modal-add-tip">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">إضافة نصيحة جديدة</div>
      <button class="modal-close" onclick="closeModal('modal-add-tip')">✕</button>
    </div>
    <form method="POST" action="{{ route('admin.tips.store') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">نص النصيحة</label>
        <textarea class="form-control" name="content" rows="3" placeholder="اكتب النصيحة هنا..." required style="resize:vertical; min-height:80px;"></textarea>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">النوع</label>
          <select class="form-control" name="type" onchange="toggleCondition(this)">
            <option value="static">ثابتة</option>
            <option value="conditional">شرطية</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">الفئة</label>
          <select class="form-control" name="tip_category">
            <option value="general">عامة</option>
            <option value="time_analysis">تحليل الوقت</option>
            <option value="failure_analysis">تحليل الفشل</option>
            <option value="habit_gradual">التدرج</option>
            <option value="psychological">نفسية</option>
            <option value="predictive">تنبؤية</option>
            <option value="app_usage_related">وقت التطبيقات</option>
            <option value="weekly_challenge">تحدي أسبوعي</option>
          </select>
        </div>
      </div>
      <div id="condition-group" style="display:none;">
        <div class="form-group">
          <label class="form-label">الشرط (JSON)</label>
          <input class="form-control" name="condition" type="text" placeholder='{"metric":"activity_commitment","activity_id":1,"operator":"<","value":0.5}'>
        </div>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn btn-outline" onclick="closeModal('modal-add-tip')">إلغاء</button>
        <button type="submit" class="btn btn-olive">💾 حفظ النصيحة</button>
      </div>
    </form>
  </div>
</div>

<!-- NOTIFICATIONS PANEL -->
<div class="notif-panel" id="notif-panel">
  <div class="notif-head">
    <h3>الإشعارات</h3>
    <button class="modal-close" onclick="toggleNotif()">✕</button>
  </div>
  <div class="notif-list">
    <div class="notif-item unread">
      <div class="notif-dot"></div>
      <div>
        <div class="notif-text">٣ مستخدمين جدد انضموا اليوم</div>
        <div class="notif-time">منذ ١٥ دقيقة</div>
      </div>
    </div>
    <div class="notif-item unread">
      <div class="notif-dot"></div>
      <div>
        <div class="notif-text">معدل الالتزام اليومي ارتفع ٥٪ هذا الأسبوع</div>
        <div class="notif-time">منذ ساعتين</div>
      </div>
    </div>
    <div class="notif-item unread">
      <div class="notif-dot"></div>
      <div>
        <div class="notif-text">نصيحة "تحليل وقت التطبيقات" حصلت على تقييم ٩٤٪</div>
        <div class="notif-time">أمس</div>
      </div>
    </div>
    <div class="notif-item read">
      <div class="notif-dot"></div>
      <div>
        <div class="notif-text">تم إضافة نشاط "التأمل" بنجاح</div>
        <div class="notif-time">قبل يومين</div>
      </div>
    </div>
  </div>
</div>

<script>
// Tab switching
function switchTab(name, el) {
  document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));

  document.getElementById('tab-' + name).style.display = 'block';
  if (el) el.classList.add('active');

  const titles = { overview:'نظرة عامة', users:'المستخدمون', sections:'الأقسام', activities:'الأنشطة', tips:'النصائح', ai:'قواعد الـ AI', badges:'الشارات', store:'المتجر' };
  document.getElementById('topbar-title').textContent = titles[name] || name;

  document.getElementById('fab').classList.remove('open');
  return false;
}

// Modal
function openModal(id)  { document.getElementById(id).classList.add('open');  }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.modal-backdrop').forEach(b => {
  b.addEventListener('click', e => { if (e.target === b) b.classList.remove('open'); });
});

// Notifications
function toggleNotif() { document.getElementById('notif-panel').classList.toggle('open'); }

// Condition field toggle
function toggleCondition(sel) {
  document.getElementById('condition-group').style.display =
    sel.value === 'conditional' ? 'block' : 'none';
}

// Refresh placeholder
function refreshData() {
  const btn = event.currentTarget;
  btn.textContent = '⏳ جاري التحديث...';
  setTimeout(() => { btn.textContent = '🔄 تحديث'; }, 1200);
}

// Charts
const ctx1 = document.getElementById('activityChart');
if (ctx1) {
  const labels = Array.from({length:30}, (_, i) => {
    const d = new Date(); d.setDate(d.getDate() - (29 - i));
    return d.getDate();
  });
  new Chart(ctx1, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'تسجيلات',
        data: labels.map(() => Math.floor(Math.random() * 80 + 40)),
        borderColor: '#4a5e2a',
        backgroundColor: 'rgba(74,94,42,0.08)',
        borderWidth: 2,
        fill: true,
        tension: 0.4,
        pointRadius: 0,
        pointHoverRadius: 5,
        pointBackgroundColor: '#4a5e2a',
      }]
    },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        x: { grid: { color: 'rgba(74,94,42,0.06)' }, ticks: { font: { family:'Tajawal', size:11 }, color:'#6b7a4a' } },
        y: { grid: { color: 'rgba(74,94,42,0.06)' }, ticks: { font: { family:'Tajawal', size:11 }, color:'#6b7a4a' } }
      }
    }
  });
}

const ctx2 = document.getElementById('sectionChart');
if (ctx2) {
  new Chart(ctx2, {
    type: 'doughnut',
    data: {
      labels: ['عبادات','صحة','تعلم','عمل','مالي','أخرى'],
      datasets: [{
        data: [32, 24, 18, 12, 8, 6],
        backgroundColor: ['#4a5e2a','#c9a84c','#6b8a3a','#8a6f28','#b5c98a','#d3ccb0'],
        borderWidth: 0,
        hoverOffset: 6,
      }]
    },
    options: {
      responsive: true, maintainAspectRatio: false,
      cutout: '68%',
      plugins: {
        legend: {
          position: 'bottom',
          labels: { font: { family:'Tajawal', size:11 }, color:'#3d4a22', boxWidth:10, padding:8 }
        }
      }
    }
  });
}

function setChartRange(days) {
  // placeholder — في التطبيق الحقيقي يرسل request للسيرفر
}
</script>
</body>
</html>
