<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPA — Sistem Informasi Pengarsipan</title>
    <meta name="description" content="Sistem Informasi Pengarsipan digital yang aman, terstruktur, dan efisien untuk institusi Anda.">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Google Fonts: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        navy: {
                            50:  '#f0f4ff',
                            100: '#e0e9ff',
                            200: '#c7d7fe',
                            300: '#a4bcfd',
                            400: '#7a96f8',
                            500: '#5570f1',
                            600: '#3d4fe6',
                            700: '#313dcb',
                            800: '#2a33a5',
                            900: '#1e2460',
                            950: '#141640',
                        },
                        slate: {
                            ...tailwind.defaultTheme?.colors?.slate,
                        }
                    },
                }
            }
        }
    </script>

    <style>
        /* ===== BASE ===== */
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fafafa;
            color: #1a1f36;
            -webkit-font-smoothing: antialiased;
        }

        /* ===== NAVBAR ===== */
        .navbar-blur {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            background: rgba(250, 250, 250, 0.88);
            border-bottom: 1px solid rgba(30, 36, 96, 0.07);
        }

        /* ===== HERO ===== */
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e8edff;
            color: #3d4fe6;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            padding: 5px 14px;
            border-radius: 100px;
            border: 1px solid #c7d7fe;
        }

        .hero-title {
            font-size: clamp(2rem, 5vw, 3.6rem);
            font-weight: 800;
            line-height: 1.12;
            letter-spacing: -0.03em;
            color: #141640;
        }

        .hero-title span {
            color: #3d4fe6;
        }

        /* ===== DASHBOARD VISUAL ===== */
        .dashboard-card {
            background: #ffffff;
            border: 1px solid #e8edf5;
            border-radius: 14px;
            box-shadow: 0 2px 16px rgba(20, 22, 64, 0.06);
        }

        .stat-card {
            background: #fff;
            border: 1px solid #eef1f8;
            border-radius: 10px;
            padding: 14px 16px;
        }

        .stat-card.accent {
            background: #3d4fe6;
            border-color: #3d4fe6;
            color: #fff;
        }

        /* ===== SECTION LABELS ===== */
        .section-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #3d4fe6;
        }

        .section-eyebrow::before {
            content: '';
            display: block;
            width: 20px;
            height: 2px;
            background: #3d4fe6;
            border-radius: 2px;
            flex-shrink: 0;
        }

        /* ===== FEATURE CARDS ===== */
        .feature-card {
            background: #fff;
            border: 1px solid #edf0f7;
            border-radius: 16px;
            padding: 28px;
            transition: box-shadow 0.2s ease, transform 0.2s ease, border-color 0.2s ease;
        }
        .feature-card:hover {
            box-shadow: 0 8px 32px rgba(61, 79, 230, 0.08);
            transform: translateY(-2px);
            border-color: #c7d7fe;
        }

        .feature-icon-wrap {
            width: 48px;
            height: 48px;
            background: #eef1ff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            flex-shrink: 0;
        }

        /* ===== BENEFIT ROWS ===== */
        .benefit-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 22px 0;
            border-bottom: 1px solid #f0f3f9;
        }
        .benefit-item:last-child { border-bottom: none; }

        .benefit-check {
            width: 22px;
            height: 22px;
            background: #eef1ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* ===== WORKFLOW ===== */
        .workflow-step {
            background: #fff;
            border: 1px solid #edf0f7;
            border-radius: 14px;
            padding: 24px 22px;
            position: relative;
        }

        .step-number {
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: #3d4fe6;
            background: #eef1ff;
            padding: 4px 10px;
            border-radius: 100px;
            display: inline-block;
            margin-bottom: 14px;
        }

        /* ===== BUTTONS ===== */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #3d4fe6;
            color: #fff;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 13px 26px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: background 0.18s, box-shadow 0.18s, transform 0.15s;
            text-decoration: none;
        }
        .btn-primary:hover {
            background: #313dcb;
            box-shadow: 0 6px 20px rgba(61, 79, 230, 0.3);
            transform: translateY(-1px);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: #1a1f36;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 12px 24px;
            border-radius: 10px;
            border: 1.5px solid #d6dae8;
            cursor: pointer;
            transition: border-color 0.18s, background 0.18s;
            text-decoration: none;
        }
        .btn-secondary:hover {
            border-color: #3d4fe6;
            color: #3d4fe6;
            background: #f4f6ff;
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #3d4fe6;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            transition: gap 0.18s;
        }
        .btn-ghost:hover { gap: 10px; }

        /* ===== FOOTER ===== */
        .footer-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #d6dae8, transparent);
            margin: 0;
        }

        /* ===== MOBILE NAV ===== */
        #mobile-menu { display: none; }
        #mobile-menu.open { display: block; }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c7d7fe; border-radius: 4px; }

        /* ===== REDUCED MOTION ===== */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { transition: none !important; animation: none !important; }
        }
    </style>
</head>

<body>

{{-- ============================================================
     NAVBAR
     ============================================================ --}}
<header class="navbar-blur fixed top-0 left-0 right-0 z-50">
    <nav class="max-w-7xl mx-auto px-5 sm:px-8 flex items-center justify-between h-16">

        {{-- Logo --}}
        <a href="#" class="flex items-center gap-2.5 no-underline">
            {{-- Custom archive icon --}}
            <div class="w-8 h-8 bg-navy-900 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="3" width="20" height="5" rx="1.5" fill="#fff" fill-opacity="0.9"/>
                    <path d="M3 9h18v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" fill="#fff" fill-opacity="0.2"/>
                    <path d="M3 9h18v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" stroke="#fff" stroke-width="1.4" stroke-opacity="0.7"/>
                    <path d="M9 13h6" stroke="#fff" stroke-width="1.4" stroke-linecap="round"/>
                </svg>
            </div>
            <span class="text-navy-950 font-bold text-base tracking-tight leading-none">
                SIPA<span class="text-navy-500 font-medium">rsip</span>
            </span>
        </a>

        {{-- Desktop Menu --}}
        <ul class="hidden md:flex items-center gap-1 list-none m-0 p-0">
            @foreach([
                ['#beranda',    'Beranda'],
                ['#fitur',      'Fitur'],
                ['#alur',       'Alur Sistem'],
                ['#keunggulan', 'Keunggulan'],
                ['#kontak',     'Kontak'],
            ] as $item)
            <li>
                <a href="{{ $item[0] }}"
                   class="text-sm font-medium text-slate-600 hover:text-navy-800 px-3 py-2 rounded-lg hover:bg-slate-100 transition-colors no-underline block">
                    {{ $item[1] }}
                </a>
            </li>
            @endforeach
        </ul>

        {{-- CTA + Hamburger --}}
        <div class="flex items-center gap-3">
            <a href="{{ url('admin/login') ?? '#' }}" class="btn-primary text-sm px-4 py-2.5 hidden sm:inline-flex">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Masuk Sistem
            </a>

            {{-- Hamburger --}}
            <button id="hamburger-btn" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-colors" aria-label="Buka menu">
                <svg id="icon-open" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
                <svg id="icon-close" class="hidden" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
    </nav>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="navbar-blur border-t border-slate-100 px-5 pb-4 pt-2 md:hidden">
        <ul class="list-none m-0 p-0 space-y-1">
            @foreach([
                ['#beranda',    'Beranda'],
                ['#fitur',      'Fitur'],
                ['#alur',       'Alur Sistem'],
                ['#keunggulan', 'Keunggulan'],
                ['#kontak',     'Kontak'],
            ] as $item)
            <li>
                <a href="{{ $item[0] }}" onclick="closeMobileMenu()"
                   class="block text-sm font-medium text-slate-700 hover:text-navy-800 px-3 py-2.5 rounded-lg hover:bg-slate-100 transition-colors no-underline">
                    {{ $item[1] }}
                </a>
            </li>
            @endforeach
        </ul>
        <div class="mt-3 pt-3 border-t border-slate-100">
            <a href="{{ url('admin/login') ?? '#' }}" class="btn-primary w-full justify-center">
                Masuk Sistem
            </a>
        </div>
    </div>
</header>


{{-- ============================================================
     HERO SECTION
     ============================================================ --}}
<section id="beranda" class="pt-28 pb-20 sm:pt-36 sm:pb-28 px-5 sm:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-14 items-center">

            {{-- Left: Copy --}}
            <div class="max-w-xl">
                <div class="hero-badge mb-6">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor"><circle cx="6" cy="6" r="6"/></svg>
                    Sistem Arsip Digital Terpusat
                </div>

                <h1 class="hero-title mb-5">
                    Kelola Arsip<br>
                    <span>Lebih Cerdas,</span><br>
                    Lebih Aman.
                </h1>

                <p class="text-slate-500 text-base sm:text-lg leading-relaxed mb-8 font-normal">
                    Platform pengarsipan dokumen digital untuk institusi, pemerintah, kampus, dan
                    organisasi — terstruktur, mudah dicari, dan selalu dapat diakses kapan pun dibutuhkan.
                </p>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ url('admin/login') ?? '#' }}" class="btn-primary">
                        Masuk ke Sistem
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"/>
                        </svg>
                    </a>
                    <a href="#fitur" class="btn-secondary">
                        Pelajari Fitur
                    </a>
                </div>

                {{-- Micro stats --}}
                <div class="flex flex-wrap gap-6 mt-10 pt-10 border-t border-slate-100">
                    @foreach([
                        ['99.9%',  'Uptime sistem'],
                        ['<2 dtk', 'Rata-rata waktu pencarian'],
                        ['AES-256','Enkripsi data'],
                    ] as $stat)
                    <div>
                        <div class="text-navy-900 font-bold text-xl leading-none">{{ $stat[0] }}</div>
                        <div class="text-slate-500 text-xs mt-1">{{ $stat[1] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Right: Dashboard Illustration --}}
            <div class="relative hidden lg:block">
                {{-- Main dashboard card --}}
                <div class="dashboard-card p-5 relative z-10">
                    {{-- Header bar --}}
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <div class="text-xs font-semibold text-slate-400 mb-0.5">DASBOR ARSIP</div>
                            <div class="font-bold text-navy-900 text-sm">Ringkasan Dokumen</div>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                            <span class="text-xs text-slate-500 font-medium">Live</span>
                        </div>
                    </div>

                    {{-- Stat row --}}
                    <div class="grid grid-cols-3 gap-3 mb-4">
                        <div class="stat-card accent">
                            <div class="text-white/70 text-xs mb-1">Total Arsip</div>
                            <div class="text-white font-bold text-xl">4,821</div>
                        </div>
                        <div class="stat-card">
                            <div class="text-slate-400 text-xs mb-1">Bulan Ini</div>
                            <div class="text-navy-900 font-bold text-xl">+138</div>
                        </div>
                        <div class="stat-card">
                            <div class="text-slate-400 text-xs mb-1">Kategori</div>
                            <div class="text-navy-900 font-bold text-xl">24</div>
                        </div>
                    </div>

                    {{-- Document list --}}
                    <div class="space-y-2">
                        @foreach([
                            ['Surat Keputusan Rektor No. 012/2025',   'SK', 'bg-blue-50 text-blue-600',    '12 Jun 2025'],
                            ['Laporan Keuangan Triwulan II 2025',     'LK', 'bg-emerald-50 text-emerald-600','08 Jun 2025'],
                            ['Perjanjian Kerjasama MBKM 2025',        'PK', 'bg-amber-50 text-amber-600',   '03 Jun 2025'],
                            ['Notulen Rapat Senat Akademik',          'NS', 'bg-violet-50 text-violet-600', '28 Mei 2025'],
                        ] as $doc)
                        <div class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-slate-50 transition-colors group cursor-default">
                            <div class="w-8 h-8 rounded-lg {{ $doc[2] }} flex items-center justify-center text-xs font-bold flex-shrink-0">
                                {{ $doc[1] }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-semibold text-slate-700 truncate">{{ $doc[0] }}</div>
                                <div class="text-xs text-slate-400">{{ $doc[3] }}</div>
                            </div>
                            {{-- Download icon --}}
                            <svg class="text-slate-300 group-hover:text-navy-500 flex-shrink-0 transition-colors" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </div>
                        @endforeach
                    </div>

                    {{-- Search bar mock --}}
                    <div class="mt-4 flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5">
                        <svg class="text-slate-400 flex-shrink-0" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                        </svg>
                        <span class="text-xs text-slate-400">Cari arsip, nomor surat, kategori…</span>
                    </div>
                </div>

                {{-- Floating accent cards --}}
                <div class="absolute -top-4 -right-4 bg-navy-900 text-white rounded-xl px-4 py-3 shadow-xl text-xs font-semibold z-20">
                    <div class="text-white/60 text-xs mb-0.5">Ditemukan dalam</div>
                    <div class="text-base font-bold">0.8 detik</div>
                </div>

                <div class="absolute -bottom-4 -left-4 bg-white border border-slate-100 rounded-xl px-4 py-3 shadow-xl z-20 flex items-center gap-2">
                    <div class="w-7 h-7 bg-emerald-50 rounded-lg flex items-center justify-center">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-slate-700">Dokumen Terarsip</div>
                        <div class="text-xs text-slate-400">SK-012/2025 berhasil disimpan</div>
                    </div>
                </div>

                {{-- Subtle background shape --}}
                <div class="absolute inset-0 -z-10 rounded-2xl"
                     style="background: radial-gradient(ellipse at 60% 40%, rgba(61,79,230,0.06) 0%, transparent 70%); transform: scale(1.15);">
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ============================================================
     FEATURE SECTION
     ============================================================ --}}
<section id="fitur" class="py-20 sm:py-28 px-5 sm:px-8 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14">
            <div class="section-eyebrow justify-center mb-4">Fitur Sistem</div>
            <h2 class="text-3xl sm:text-4xl font-bold text-navy-950 tracking-tight leading-tight mb-4">
                Satu Platform, Semua Kebutuhan<br class="hidden sm:block"> Pengarsipan Anda
            </h2>
            <p class="text-slate-500 text-base max-w-xl mx-auto leading-relaxed">
                Dirancang untuk kemudahan pengelolaan dokumen dari berbagai unit dan divisi dalam satu sistem terpusat.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @php
            $features = [
                [
                    'title' => 'Pengelolaan Arsip Digital',
                    'desc'  => 'Unggah, simpan, dan kelola dokumen dalam format digital dengan struktur folder yang tertata rapi dan mudah dipahami.',
                    'icon'  => '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
                ],
                [
                    'title' => 'Pencarian Dokumen Cepat',
                    'desc'  => 'Temukan arsip yang dibutuhkan dalam hitungan detik menggunakan pencarian berdasarkan judul, nomor, kategori, atau tanggal.',
                    'icon'  => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>',
                ],
                [
                    'title' => 'Klasifikasi & Kategori',
                    'desc'  => 'Atur arsip berdasarkan jenis surat, divisi, tahun, atau label khusus agar semua dokumen mudah ditemukan dan dikelola.',
                    'icon'  => '<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>',
                ],
                [
                    'title' => 'Keamanan Data Berlapis',
                    'desc'  => 'Dilengkapi enkripsi AES-256, proteksi akses, dan pencatatan aktivitas untuk memastikan dokumen penting selalu aman.',
                    'icon'  => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
                ],
                [
                    'title' => 'Riwayat Aktivitas',
                    'desc'  => 'Pantau setiap perubahan dan akses dokumen melalui log aktivitas lengkap — siapa mengakses, kapan, dan apa yang dilakukan.',
                    'icon'  => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
                ],
                [
                    'title' => 'Akses Berbasis Peran',
                    'desc'  => 'Atur hak akses setiap pengguna sesuai jabatan dan tanggung jawabnya — Admin, Operator, dan Viewer dalam satu sistem.',
                    'icon'  => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>',
                ],
            ];
            @endphp

            @foreach($features as $f)
            <div class="feature-card">
                <div class="feature-icon-wrap">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#3d4fe6" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        {!! $f['icon'] !!}
                    </svg>
                </div>
                <h3 class="font-bold text-navy-950 text-base mb-2 leading-snug">{{ $f['title'] }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ============================================================
     WORKFLOW SECTION
     ============================================================ --}}
<section id="alur" class="py-20 sm:py-28 px-5 sm:px-8 bg-slate-50">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14">
            <div class="section-eyebrow justify-center mb-4">Alur Sistem</div>
            <h2 class="text-3xl sm:text-4xl font-bold text-navy-950 tracking-tight leading-tight mb-4">
                Empat Langkah Mudah
            </h2>
            <p class="text-slate-500 text-base max-w-lg mx-auto">
                Proses pengarsipan yang sederhana, konsisten, dan dapat dilacak dari awal hingga akhir.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 relative">
            {{-- Connector line (desktop only) --}}
            <div class="hidden lg:block absolute top-10 left-[12.5%] right-[12.5%] h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent z-0 pointer-events-none"></div>

            @php
            $steps = [
                [
                    'num'   => '01',
                    'title' => 'Unggah Dokumen',
                    'desc'  => 'Unggah file dari komputer atau simpan langsung dari pemindai dokumen ke dalam sistem.',
                    'icon'  => '<path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>',
                ],
                [
                    'num'   => '02',
                    'title' => 'Klasifikasi Arsip',
                    'desc'  => 'Tentukan jenis, kategori, dan metadata arsip agar dokumen terindeks dengan baik dan mudah ditemukan.',
                    'icon'  => '<line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>',
                ],
                [
                    'num'   => '03',
                    'title' => 'Simpan Secara Digital',
                    'desc'  => 'Sistem menyimpan arsip secara aman dengan enkripsi dan pencatatan riwayat perubahan otomatis.',
                    'icon'  => '<path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>',
                ],
                [
                    'num'   => '04',
                    'title' => 'Temukan Kembali',
                    'desc'  => 'Cari dan akses arsip kapan saja menggunakan kata kunci, filter, atau kategori dalam hitungan detik.',
                    'icon'  => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>',
                ],
            ];
            @endphp

            @foreach($steps as $step)
            <div class="workflow-step relative z-10">
                <div class="step-number">{{ $step['num'] }}</div>
                <div class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center mb-4 shadow-sm">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3d4fe6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        {!! $step['icon'] !!}
                    </svg>
                </div>
                <h3 class="font-bold text-navy-950 text-sm mb-2">{{ $step['title'] }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ============================================================
     BENEFITS SECTION
     ============================================================ --}}
<section id="keunggulan" class="py-20 sm:py-28 px-5 sm:px-8 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            {{-- Left: Heading --}}
            <div>
                <div class="section-eyebrow mb-4">Keunggulan</div>
                <h2 class="text-3xl sm:text-4xl font-bold text-navy-950 tracking-tight leading-tight mb-5">
                    Mengapa Beralih ke<br>Arsip Digital?
                </h2>
                <p class="text-slate-500 text-base leading-relaxed mb-8">
                    Pengelolaan arsip secara manual memakan waktu, berisiko, dan sulit diskalakan.
                    SIPArsip hadir sebagai solusi yang dirancang khusus untuk kebutuhan institusi modern.
                </p>

                <a href="#" class="btn-ghost">
                    Lihat panduan lengkap
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </a>
            </div>

            {{-- Right: Benefit list --}}
            <div>
                @php
                $benefits = [
                    ['Mengurangi risiko kehilangan dokumen penting akibat kerusakan fisik atau kelalaian.'],
                    ['Mempercepat proses pencarian arsip dari hitungan jam menjadi detik.'],
                    ['Membuat alur administrasi lebih tertata, terukur, dan dapat diaudit.'],
                    ['Mendukung program digitalisasi tata kelola dokumen pemerintah dan instansi.'],
                    ['Meningkatkan efisiensi kerja tim dengan akses dokumen yang terpusat dan terstruktur.'],
                ];
                @endphp

                <div>
                    @foreach($benefits as $b)
                    <div class="benefit-item">
                        <div class="benefit-check">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#3d4fe6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                        <p class="text-slate-700 text-sm leading-relaxed font-medium">{{ $b[0] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ============================================================
     CTA SECTION
     ============================================================ --}}
<section class="py-16 sm:py-20 px-5 sm:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-navy-950 rounded-2xl px-8 sm:px-14 py-14 text-center relative overflow-hidden">
            {{-- Subtle accent blob --}}
            <div class="absolute inset-0 pointer-events-none"
                 style="background: radial-gradient(ellipse at 30% 50%, rgba(61,79,230,0.35) 0%, transparent 60%);"></div>
            <div class="absolute inset-0 pointer-events-none"
                 style="background: radial-gradient(ellipse at 75% 60%, rgba(99,130,255,0.15) 0%, transparent 55%);"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/15 rounded-full px-4 py-1.5 text-white/70 text-xs font-semibold mb-6">
                    Siap Memulai?
                </div>
                <h2 class="text-white text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight leading-tight mb-4">
                    Mulai Kelola Arsip Anda<br>Secara Digital Sekarang
                </h2>
                <p class="text-white/60 text-base mb-8 max-w-lg mx-auto leading-relaxed">
                    Bergabunglah dengan ratusan institusi yang telah mempercayakan pengelolaan dokumen mereka kepada SIPArsip.
                </p>
                <div class="flex flex-wrap gap-3 justify-center">
                    <a href="{{ url('admin/login') ?? '#' }}" class="btn-primary bg-white text-navy-900 hover:bg-slate-100"
                       style="background:#fff; color:#1e2460;">
                        Masuk ke Sistem
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"/>
                        </svg>
                    </a>
                    <a href="#kontak" class="btn-secondary border-white/25 text-white hover:bg-white/10 hover:border-white/50 hover:text-white">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ============================================================
     FOOTER
     ============================================================ --}}
<footer id="kontak" class="bg-white border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 py-14">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10">

            {{-- Brand --}}
            <div class="lg:col-span-2">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-8 h-8 bg-navy-900 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="2" y="3" width="20" height="5" rx="1.5" fill="#fff" fill-opacity="0.9"/>
                            <path d="M3 9h18v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" stroke="#fff" stroke-width="1.4" stroke-opacity="0.7"/>
                            <path d="M9 13h6" stroke="#fff" stroke-width="1.4" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <span class="text-navy-950 font-bold text-base tracking-tight">
                        SIPA<span class="text-navy-500 font-medium">rsip</span>
                    </span>
                </div>
                <p class="text-slate-500 text-sm leading-relaxed max-w-xs mb-5">
                    Sistem Informasi Pengarsipan digital yang aman dan efisien untuk institusi, pemerintahan, kampus, dan organisasi modern.
                </p>
                {{-- Contact --}}
                <div class="space-y-2 text-sm text-slate-500">
                    <div class="flex items-center gap-2">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                        </svg>
                        admin@siparsip.go.id
                    </div>
                    <div class="flex items-center gap-2">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.69 12 19.79 19.79 0 011.61 3.37a2 2 0 012-2.18h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
                        </svg>
                        (021) 123-4567
                    </div>
                </div>
            </div>

            {{-- Links: Sistem --}}
            <div>
                <h4 class="font-semibold text-navy-950 text-sm mb-4">Sistem</h4>
                <ul class="space-y-2.5 list-none m-0 p-0">
                    @foreach(['Beranda', 'Fitur', 'Alur Sistem', 'Keunggulan'] as $link)
                    <li>
                        <a href="#" class="text-slate-500 text-sm hover:text-navy-700 transition-colors no-underline">{{ $link }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Links: Dukungan --}}
            <div>
                <h4 class="font-semibold text-navy-950 text-sm mb-4">Dukungan</h4>
                <ul class="space-y-2.5 list-none m-0 p-0">
                    @foreach(['Panduan Pengguna', 'FAQ', 'Kebijakan Privasi', 'Hubungi Admin'] as $link)
                    <li>
                        <a href="#" class="text-slate-500 text-sm hover:text-navy-700 transition-colors no-underline">{{ $link }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="footer-divider mt-12 mb-6"></div>
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-400">
            <span>© {{ date('Y') }} SIPArsip — Sistem Informasi Pengarsipan. Hak cipta dilindungi.</span>
            <span class="flex items-center gap-1">
                Dibangun dengan
                <svg width="11" height="11" viewBox="0 0 24 24" fill="#ef4444" stroke="none"><path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402z"/></svg>
                menggunakan Laravel & Tailwind CSS
            </span>
        </div>
    </div>
</footer>


{{-- ============================================================
     JAVASCRIPT: Mobile menu toggle
     ============================================================ --}}
<script>
    const btn       = document.getElementById('hamburger-btn');
    const menu      = document.getElementById('mobile-menu');
    const iconOpen  = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');

    btn.addEventListener('click', () => {
        const isOpen = menu.classList.toggle('open');
        iconOpen.classList.toggle('hidden', isOpen);
        iconClose.classList.toggle('hidden', !isOpen);
        btn.setAttribute('aria-expanded', isOpen);
    });

    function closeMobileMenu() {
        menu.classList.remove('open');
        iconOpen.classList.remove('hidden');
        iconClose.classList.add('hidden');
    }

    // Close menu on outside click
    document.addEventListener('click', (e) => {
        if (!btn.contains(e.target) && !menu.contains(e.target)) {
            closeMobileMenu();
        }
    });
</script>

</body>
</html>
