<x-filament-panels::page>
    <div class="space-y-4">

        {{-- ══ BREADCRUMB ══════════════════════════════════════════════════════ --}}
        <nav class="flex flex-wrap items-center gap-1 rounded-xl bg-white px-4 py-3 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
            <x-heroicon-o-folder-open class="h-4 w-4 flex-shrink-0 text-primary-500" />

            @foreach ($this->breadcrumbs as $i => $crumb)
                @if ($i > 0)
                    <x-heroicon-o-chevron-right class="h-3.5 w-3.5 flex-shrink-0 text-gray-400" />
                @endif

                @if ($i < count($this->breadcrumbs) - 1)
                    <button
                        wire:click="navigateTo(
                            '{{ $crumb['level'] }}',
                            {{ $crumb['ruanganId'] ?? 'null' }},
                            {{ $crumb['lokasiId']  ?? 'null' }},
                            {{ $crumb['rakId']     ?? 'null' }},
                            {{ $crumb['boxId']     ?? 'null' }}
                        )"
                        class="truncate text-sm font-medium text-primary-600 hover:text-primary-800 hover:underline dark:text-primary-400"
                    >
                        {{ $crumb['label'] }}
                    </button>
                @else
                    <span class="truncate text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $crumb['label'] }}
                    </span>
                @endif
            @endforeach
        </nav>

        {{-- ══ STATS ════════════════════════════════════════════════════════════ --}}
        @php
            $stats = $this->stats;
            $cols  = min(4, count($stats));
        @endphp
        @if (count($stats))
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-{{ $cols }}">
                @foreach ($stats as $stat)
                    @php
                        $colorMap = [
                            'blue'   => ['bg' => 'bg-blue-50 dark:bg-blue-500/10',    'icon' => 'text-blue-600 dark:text-blue-400'],
                            'purple' => ['bg' => 'bg-purple-50 dark:bg-purple-500/10','icon' => 'text-purple-600 dark:text-purple-400'],
                            'green'  => ['bg' => 'bg-green-50 dark:bg-green-500/10',  'icon' => 'text-green-600 dark:text-green-400'],
                            'amber'  => ['bg' => 'bg-amber-50 dark:bg-amber-500/10',  'icon' => 'text-amber-600 dark:text-amber-400'],
                        ];
                        $c = $colorMap[$stat['color']] ?? $colorMap['blue'];
                    @endphp
                    <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
                        <div class="flex items-center gap-3">
                            <div class="rounded-lg p-2.5 {{ $c['bg'] }}">
                                <x-dynamic-component :component="$stat['icon']" class="h-5 w-5 {{ $c['icon'] }}" />
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</p>
                                <p class="text-xl font-bold text-gray-950 dark:text-white">{{ $stat['value'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ══ TOOLBAR: SEARCH + TAMBAH ════════════════════════════════════════ --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="relative max-w-xs flex-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <x-heroicon-o-magnifying-glass class="h-4 w-4 text-gray-400" />
                </div>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari {{ $this->levelMeta['label'] }}..."
                    class="w-full rounded-lg border border-gray-200 bg-white py-2 pl-9 pr-4 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                />
            </div>
            <div class="flex items-center gap-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $this->items->total() }} {{ strtolower($this->levelMeta['label']) }} ditemukan
                </p>
                {{-- ── Tombol Tambah ── --}}
                <button
                    wire:click="openCreateModal"
                    class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                >
                    <x-heroicon-o-plus class="h-4 w-4" />
                    Tambah {{ $this->levelMeta['label'] }}
                </button>
            </div>
        </div>

        {{-- ══ GRID / LIST CARDS ════════════════════════════════════════════════ --}}
        @php
            $items = $this->items;
            $level = $this->level;
            $meta  = $this->levelMeta;
        @endphp

        @if ($items->isEmpty())
            <div class="flex flex-col items-center justify-center rounded-xl bg-white py-16 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
                <x-dynamic-component :component="$meta['icon']" class="h-12 w-12 text-gray-300 dark:text-gray-600" />
                <p class="mt-4 text-sm font-medium text-gray-500 dark:text-gray-400">{{ $meta['empty'] }}</p>
                <button
                    wire:click="openCreateModal"
                    class="mt-4 inline-flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-700"
                >
                    <x-heroicon-o-plus class="h-4 w-4" />
                    Tambah {{ $meta['label'] }} Pertama
                </button>
            </div>
        @else

            {{-- Grid untuk Ruangan / Lokasi / Rak / Box --}}
            @if ($level !== 'dokumen')
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">

                    {{-- ── RUANGAN ─────────────────────────────────────────── --}}
                    @if ($level === 'ruangan')
                        @foreach ($items as $item)
                            @php $count = $item->lokasis_count; @endphp
                            <div class="group relative flex flex-col overflow-hidden rounded-xl bg-white text-left shadow-sm ring-1 ring-gray-950/5 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md dark:bg-gray-900 dark:hover:bg-gray-800">
                                <div class="h-1.5 w-full {{ $count > 0 ? 'bg-blue-400' : 'bg-gray-200 dark:bg-gray-700' }}"></div>
                                <button
                                    wire:click="drillDown('lokasi', {{ $item->id }})"
                                    class="flex flex-1 flex-col gap-3 p-4 text-left"
                                >
                                    <div class="flex items-start justify-between">
                                        <div class="rounded-lg p-2 {{ $count > 0 ? 'bg-blue-50 dark:bg-blue-500/10' : 'bg-gray-100 dark:bg-gray-800' }}">
                                            <x-heroicon-o-home-modern class="h-5 w-5 {{ $count > 0 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400' }}" />
                                        </div>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                            <x-heroicon-o-map-pin class="h-3 w-3" />
                                            {{ $count }} Lokasi
                                        </span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate text-xs font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">{{ $item->kode_ruangan }}</p>
                                        <p class="mt-0.5 truncate text-sm font-semibold text-gray-900 dark:text-white">{{ $item->nama_ruangan }}</p>
                                        @if ($item->deskripsi)
                                            <p class="mt-1 line-clamp-2 text-xs text-gray-500 dark:text-gray-400">{{ $item->deskripsi }}</p>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs font-medium text-blue-600 dark:text-blue-400">
                                        <x-heroicon-o-folder-open class="h-3.5 w-3.5" />
                                        Buka Ruangan
                                    </div>
                                </button>
                                {{-- Action buttons --}}
                                <div class="flex items-center gap-1 border-t border-gray-100 px-3 py-2 dark:border-gray-800">
                                    <button
                                        wire:click.stop="openEditModal({{ $item->id }})"
                                        class="flex items-center gap-1 rounded px-2 py-1 text-xs text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                                        title="Edit"
                                    >
                                        <x-heroicon-o-pencil-square class="h-3.5 w-3.5" /> Edit
                                    </button>
                                    <button
                                        wire:click.stop="confirmDelete({{ $item->id }}, '{{ addslashes($item->nama_ruangan) }}')"
                                        class="flex items-center gap-1 rounded px-2 py-1 text-xs text-red-500 transition hover:bg-red-50 hover:text-red-700 dark:hover:bg-red-900/20"
                                        title="Hapus"
                                    >
                                        <x-heroicon-o-trash class="h-3.5 w-3.5" /> Hapus
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{-- ── LOKASI ───────────────────────────────────────────── --}}
                    @if ($level === 'lokasi')
                        @foreach ($items as $item)
                            @php $count = $item->raks_count; @endphp
                            <div class="group relative flex flex-col overflow-hidden rounded-xl bg-white text-left shadow-sm ring-1 ring-gray-950/5 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md dark:bg-gray-900 dark:hover:bg-gray-800">
                                <div class="h-1.5 w-full {{ $count > 0 ? 'bg-purple-400' : 'bg-gray-200 dark:bg-gray-700' }}"></div>
                                <button
                                    wire:click="drillDown('rak', {{ $item->id }})"
                                    class="flex flex-1 flex-col gap-3 p-4 text-left"
                                >
                                    <div class="flex items-start justify-between">
                                        <div class="rounded-lg p-2 {{ $count > 0 ? 'bg-purple-50 dark:bg-purple-500/10' : 'bg-gray-100 dark:bg-gray-800' }}">
                                            <x-heroicon-o-map-pin class="h-5 w-5 {{ $count > 0 ? 'text-purple-600 dark:text-purple-400' : 'text-gray-400' }}" />
                                        </div>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                            <x-heroicon-o-building-office-2 class="h-3 w-3" />
                                            {{ $count }} Rak
                                        </span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate text-xs font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">{{ $item->kode_lokasi }}</p>
                                        <p class="mt-0.5 truncate text-sm font-semibold text-gray-900 dark:text-white">{{ $item->nama_lokasi }}</p>
                                        @if ($item->deskripsi)
                                            <p class="mt-1 line-clamp-2 text-xs text-gray-500 dark:text-gray-400">{{ $item->deskripsi }}</p>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs font-medium text-purple-600 dark:text-purple-400">
                                        <x-heroicon-o-folder-open class="h-3.5 w-3.5" />
                                        Buka Lokasi
                                    </div>
                                </button>
                                <div class="flex items-center gap-1 border-t border-gray-100 px-3 py-2 dark:border-gray-800">
                                    <button
                                        wire:click.stop="openEditModal({{ $item->id }})"
                                        class="flex items-center gap-1 rounded px-2 py-1 text-xs text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                                    >
                                        <x-heroicon-o-pencil-square class="h-3.5 w-3.5" /> Edit
                                    </button>
                                    <button
                                        wire:click.stop="confirmDelete({{ $item->id }}, '{{ addslashes($item->nama_lokasi) }}')"
                                        class="flex items-center gap-1 rounded px-2 py-1 text-xs text-red-500 transition hover:bg-red-50 hover:text-red-700 dark:hover:bg-red-900/20"
                                    >
                                        <x-heroicon-o-trash class="h-3.5 w-3.5" /> Hapus
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{-- ── RAK ──────────────────────────────────────────────── --}}
                    @if ($level === 'rak')
                        @foreach ($items as $item)
                            @php $count = $item->box_count; @endphp
                            <div class="group relative flex flex-col overflow-hidden rounded-xl bg-white text-left shadow-sm ring-1 ring-gray-950/5 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md dark:bg-gray-900 dark:hover:bg-gray-800">
                                <div class="h-1.5 w-full {{ $count > 0 ? 'bg-green-400' : 'bg-gray-200 dark:bg-gray-700' }}"></div>
                                <button
                                    wire:click="drillDown('box', {{ $item->id }})"
                                    class="flex flex-1 flex-col gap-3 p-4 text-left"
                                >
                                    <div class="flex items-start justify-between">
                                        <div class="rounded-lg p-2 {{ $count > 0 ? 'bg-green-50 dark:bg-green-500/10' : 'bg-gray-100 dark:bg-gray-800' }}">
                                            <x-heroicon-o-building-office-2 class="h-5 w-5 {{ $count > 0 ? 'text-green-600 dark:text-green-400' : 'text-gray-400' }}" />
                                        </div>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                            <x-heroicon-o-archive-box class="h-3 w-3" />
                                            {{ $count }} Box
                                        </span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate text-xs font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">{{ $item->kode_rak }}</p>
                                        <p class="mt-0.5 truncate text-sm font-semibold text-gray-900 dark:text-white">{{ $item->nama_rak }}</p>
                                        @if ($item->deskripsi)
                                            <p class="mt-1 line-clamp-2 text-xs text-gray-500 dark:text-gray-400">{{ $item->deskripsi }}</p>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs font-medium text-green-600 dark:text-green-400">
                                        <x-heroicon-o-folder-open class="h-3.5 w-3.5" />
                                        Buka Rak
                                    </div>
                                </button>
                                <div class="flex items-center gap-1 border-t border-gray-100 px-3 py-2 dark:border-gray-800">
                                    <button
                                        wire:click.stop="openEditModal({{ $item->id }})"
                                        class="flex items-center gap-1 rounded px-2 py-1 text-xs text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                                    >
                                        <x-heroicon-o-pencil-square class="h-3.5 w-3.5" /> Edit
                                    </button>
                                    <button
                                        wire:click.stop="confirmDelete({{ $item->id }}, '{{ addslashes($item->nama_rak) }}')"
                                        class="flex items-center gap-1 rounded px-2 py-1 text-xs text-red-500 transition hover:bg-red-50 hover:text-red-700 dark:hover:bg-red-900/20"
                                    >
                                        <x-heroicon-o-trash class="h-3.5 w-3.5" /> Hapus
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{-- ── BOX ──────────────────────────────────────────────── --}}
                    @if ($level === 'box')
                        @foreach ($items as $item)
                            @php $count = $item->dokumens_count; @endphp
                            <div class="group relative flex flex-col overflow-hidden rounded-xl bg-white text-left shadow-sm ring-1 ring-gray-950/5 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md dark:bg-gray-900 dark:hover:bg-gray-800">
                                <div class="h-1.5 w-full {{ $count > 0 ? 'bg-amber-400' : 'bg-gray-200 dark:bg-gray-700' }}"></div>
                                <button
                                    wire:click="drillDown('dokumen', {{ $item->id }})"
                                    class="flex flex-1 flex-col gap-3 p-4 text-left"
                                >
                                    <div class="flex items-start justify-between">
                                        <div class="rounded-lg p-2 {{ $count > 0 ? 'bg-amber-50 dark:bg-amber-500/10' : 'bg-gray-100 dark:bg-gray-800' }}">
                                            <x-heroicon-o-archive-box class="h-5 w-5 {{ $count > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-gray-400' }}" />
                                        </div>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                            <x-heroicon-o-document-text class="h-3 w-3" />
                                            {{ $count }} Dok
                                        </span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate text-xs font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">{{ $item->kode_box }}</p>
                                        <p class="mt-0.5 truncate text-sm font-semibold text-gray-900 dark:text-white">{{ $item->nama_box }}</p>
                                        @if ($item->deskripsi)
                                            <p class="mt-1 line-clamp-2 text-xs text-gray-500 dark:text-gray-400">{{ $item->deskripsi }}</p>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs font-medium text-amber-600 dark:text-amber-400">
                                        <x-heroicon-o-folder-open class="h-3.5 w-3.5" />
                                        Lihat Dokumen
                                    </div>
                                </button>
                                {{-- QR Code link --}}
                                @if ($item->qr_code_url)
                                    <div class="flex items-center gap-1 border-t border-gray-100 px-3 py-1 dark:border-gray-800">
                                        <a
                                            href="{{ $item->qr_code_url }}"
                                            target="_blank"
                                            wire:click.stop
                                            class="flex items-center gap-1 rounded px-2 py-1 text-xs text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-800"
                                        >
                                            <x-heroicon-o-qr-code class="h-3.5 w-3.5" /> QR
                                        </a>
                                        <button
                                            wire:click.stop="openEditModal({{ $item->id }})"
                                            class="flex items-center gap-1 rounded px-2 py-1 text-xs text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                                        >
                                            <x-heroicon-o-pencil-square class="h-3.5 w-3.5" /> Edit
                                        </button>
                                        <button
                                            wire:click.stop="confirmDelete({{ $item->id }}, '{{ addslashes($item->nama_box) }}')"
                                            class="flex items-center gap-1 rounded px-2 py-1 text-xs text-red-500 transition hover:bg-red-50 hover:text-red-700 dark:hover:bg-red-900/20"
                                        >
                                            <x-heroicon-o-trash class="h-3.5 w-3.5" /> Hapus
                                        </button>
                                    </div>
                                @else
                                    <div class="flex items-center gap-1 border-t border-gray-100 px-3 py-2 dark:border-gray-800">
                                        <button
                                            wire:click.stop="openEditModal({{ $item->id }})"
                                            class="flex items-center gap-1 rounded px-2 py-1 text-xs text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                                        >
                                            <x-heroicon-o-pencil-square class="h-3.5 w-3.5" /> Edit
                                        </button>
                                        <button
                                            wire:click.stop="confirmDelete({{ $item->id }}, '{{ addslashes($item->nama_box) }}')"
                                            class="flex items-center gap-1 rounded px-2 py-1 text-xs text-red-500 transition hover:bg-red-50 hover:text-red-700 dark:hover:bg-red-900/20"
                                        >
                                            <x-heroicon-o-trash class="h-3.5 w-3.5" /> Hapus
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif

                </div>
            @endif

            {{-- ── DOKUMEN — List view (leaf node) ─────────────────────────── --}}
            @if ($level === 'dokumen')
                <div class="flex flex-col gap-2">
                    @foreach ($items as $item)
                        <div class="flex flex-col gap-3 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-950/5 transition-colors hover:bg-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 sm:flex-row sm:items-start sm:gap-4">

                            {{-- Icon --}}
                            <div class="flex-shrink-0">
                                <div class="rounded-lg bg-blue-50 p-2.5 dark:bg-blue-500/10">
                                    <x-heroicon-o-document-text class="h-5 w-5 text-blue-600 dark:text-blue-400" />
                                </div>
                            </div>

                            {{-- Info utama --}}
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $item->judul }}
                                        </p>
                                        <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1">
                                            @if ($item->nomor_dokumen)
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    No. {{ $item->nomor_dokumen }}
                                                </span>
                                            @endif
                                            @if ($item->kode_dokumen)
                                                <span class="rounded bg-gray-100 px-1.5 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                                    {{ $item->kode_dokumen }}
                                                </span>
                                            @endif
                                            @if ($item->tanggal)
                                                <span class="text-xs text-gray-400 dark:text-gray-500">
                                                    {{ $item->tanggal->format('d M Y') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Badge jenis dokumen --}}
                                    @if ($item->jenisDokumen)
                                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                                            {{ $item->jenisDokumen->nama_jenis_dokumen ?? $item->jenisDokumen->nama ?? '-' }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Perihal & deskripsi --}}
                                @if ($item->perihal)
                                    <p class="mt-1.5 text-xs text-gray-600 dark:text-gray-400">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Perihal:</span>
                                        {{ $item->perihal }}
                                    </p>
                                @endif
                                @if ($item->deskripsi_dokumen)
                                    <p class="mt-1 line-clamp-1 text-xs text-gray-500 dark:text-gray-400">{{ $item->deskripsi_dokumen }}</p>
                                @endif

                                {{-- Footer: uploader + file + actions --}}
                                <div class="mt-2 flex flex-wrap items-center gap-3">
                                    @if ($item->user)
                                        <span class="flex items-center gap-1 text-xs text-gray-400 dark:text-gray-500">
                                            <x-heroicon-o-user class="h-3 w-3" />
                                            {{ $item->user->name }}
                                        </span>
                                    @endif
                                    @if ($item->file_path)
                                        <a
                                            href="{{ asset('storage/' . $item->file_path) }}"
                                            target="_blank"
                                            class="flex items-center gap-1 text-xs font-medium text-primary-600 hover:underline dark:text-primary-400"
                                        >
                                            <x-heroicon-o-arrow-down-tray class="h-3 w-3" />
                                            Unduh File
                                        </a>
                                    @endif
                                    <div class="ml-auto flex items-center gap-1">
                                        <button
                                            wire:click="openEditModal({{ $item->id }})"
                                            class="flex items-center gap-1 rounded px-2 py-1 text-xs text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                                        >
                                            <x-heroicon-o-pencil-square class="h-3.5 w-3.5" /> Edit
                                        </button>
                                        <button
                                            wire:click="confirmDelete({{ $item->id }}, '{{ addslashes($item->judul) }}')"
                                            class="flex items-center gap-1 rounded px-2 py-1 text-xs text-red-500 transition hover:bg-red-50 hover:text-red-700 dark:hover:bg-red-900/20"
                                        >
                                            <x-heroicon-o-trash class="h-3.5 w-3.5" /> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Pagination --}}
            <div class="mt-2">
                {{ $this->items->links() }}
            </div>

        @endif

    </div>

    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    {{-- MODAL CREATE / EDIT                                                    --}}
    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    @if ($showModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            x-data
            x-on:keydown.escape.window="$wire.closeModal()"
        >
            {{-- Backdrop --}}
            <div
                class="absolute inset-0 bg-gray-950/50 backdrop-blur-sm"
                wire:click="closeModal"
            ></div>

            {{-- Panel --}}
            <div class="relative z-10 w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl dark:bg-gray-900">

                {{-- Header --}}
                <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4 dark:border-gray-800">
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">
                        {{ $this->modalTitle }}
                    </h2>
                    <button
                        wire:click="closeModal"
                        class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800"
                    >
                        <x-heroicon-o-x-mark class="h-5 w-5" />
                    </button>
                </div>

                {{-- Body --}}
                <div class="max-h-[70vh] overflow-y-auto px-6 py-5">

                    {{-- ── FORM RUANGAN ── --}}
                    @if ($level === 'ruangan')
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Kode Ruangan <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    wire:model="f_kode_ruangan"
                                    placeholder="Contoh: R-001"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                />
                                @error('f_kode_ruangan') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nama Ruangan <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    wire:model="f_nama_ruangan"
                                    placeholder="Nama ruangan..."
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                />
                                @error('f_nama_ruangan') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                                <textarea
                                    wire:model="f_deskripsi_ruangan"
                                    rows="3"
                                    placeholder="Deskripsi opsional..."
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                ></textarea>
                            </div>
                        </div>
                    @endif

                    {{-- ── FORM LOKASI ── --}}
                    @if ($level === 'lokasi')
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Kode Lokasi <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    wire:model="f_kode_lokasi"
                                    placeholder="Contoh: L-001"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                />
                                @error('f_kode_lokasi') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nama Lokasi <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    wire:model="f_nama_lokasi"
                                    placeholder="Nama lokasi..."
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                />
                                @error('f_nama_lokasi') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                                <textarea
                                    wire:model="f_deskripsi_lokasi"
                                    rows="3"
                                    placeholder="Deskripsi opsional..."
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                ></textarea>
                            </div>
                        </div>
                    @endif

                    {{-- ── FORM RAK ── --}}
                    @if ($level === 'rak')
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Kode Rak <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    wire:model="f_kode_rak"
                                    placeholder="Contoh: RAK-001"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                />
                                @error('f_kode_rak') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nama Rak <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    wire:model="f_nama_rak"
                                    placeholder="Nama rak..."
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                />
                                @error('f_nama_rak') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                                <textarea
                                    wire:model="f_deskripsi_rak"
                                    rows="3"
                                    placeholder="Deskripsi opsional..."
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                ></textarea>
                            </div>
                        </div>
                    @endif

                    {{-- ── FORM BOX ── --}}
                    @if ($level === 'box')
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Kode Box <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    wire:model="f_kode_box"
                                    placeholder="Contoh: BOX-001"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                />
                                @error('f_kode_box') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nama Box <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    wire:model="f_nama_box"
                                    placeholder="Nama box..."
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                />
                                @error('f_nama_box') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                                <textarea
                                    wire:model="f_deskripsi_box"
                                    rows="3"
                                    placeholder="Deskripsi opsional..."
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                ></textarea>
                            </div>
                        </div>
                    @endif

                    {{-- ── FORM DOKUMEN ── --}}
                    @if ($level === 'dokumen')
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Judul Dokumen <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    wire:model="f_judul"
                                    placeholder="Judul dokumen..."
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                />
                                @error('f_judul') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Dokumen</label>
                                    <input
                                        type="text"
                                        wire:model="f_nomor_dokumen"
                                        placeholder="No. Dok..."
                                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                    />
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Dokumen</label>
                                    <input
                                        type="text"
                                        wire:model="f_kode_dokumen"
                                        placeholder="Kode..."
                                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                    />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal</label>
                                    <input
                                        type="date"
                                        wire:model="f_tanggal"
                                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                    />
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Dokumen</label>
                                    <select
                                        wire:model="f_jenis_dokumen_id"
                                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                    >
                                        <option value="">-- Pilih Jenis --</option>
                                        @foreach ($this->jenisDokumenOptions as $id => $nama)
                                            <option value="{{ $id }}">{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('f_jenis_dokumen_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Perihal</label>
                                <input
                                    type="text"
                                    wire:model="f_perihal"
                                    placeholder="Perihal dokumen..."
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Dokumen</label>
                                <textarea
                                    wire:model="f_deskripsi_dokumen"
                                    rows="2"
                                    placeholder="Deskripsi singkat..."
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                ></textarea>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan</label>
                                <textarea
                                    wire:model="f_catatan"
                                    rows="2"
                                    placeholder="Catatan tambahan..."
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                ></textarea>
                            </div>

                            {{-- File upload info untuk edit --}}
                            @if ($modalMode === 'edit' && $f_file_path)
                                <div class="flex items-center gap-2 rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 dark:border-blue-800 dark:bg-blue-900/20">
                                    <x-heroicon-o-paper-clip class="h-4 w-4 flex-shrink-0 text-blue-600 dark:text-blue-400" />
                                    <span class="text-xs text-blue-700 dark:text-blue-300">File terlampir. Upload file baru melalui halaman detail dokumen.</span>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-3 border-t border-gray-100 px-6 py-4 dark:border-gray-800">
                    <button
                        wire:click="closeModal"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                    >
                        Batal
                    </button>
                    <button
                        wire:click="save"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-700 disabled:opacity-60"
                    >
                        <span wire:loading wire:target="save">
                            <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </span>
                        <span wire:loading.remove wire:target="save">
                            @if ($modalMode === 'create')
                                <x-heroicon-o-plus class="h-4 w-4" />
                            @else
                                <x-heroicon-o-check class="h-4 w-4" />
                            @endif
                        </span>
                        {{ $modalMode === 'create' ? 'Simpan' : 'Perbarui' }}
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    {{-- MODAL KONFIRMASI HAPUS                                                 --}}
    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    @if ($showDeleteModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            x-data
            x-on:keydown.escape.window="$wire.cancelDelete()"
        >
            <div class="absolute inset-0 bg-gray-950/50 backdrop-blur-sm" wire:click="cancelDelete"></div>

            <div class="relative z-10 w-full max-w-sm overflow-hidden rounded-2xl bg-white shadow-2xl dark:bg-gray-900">
                <div class="p-6">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 rounded-full bg-red-100 p-3 dark:bg-red-900/30">
                            <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-red-600 dark:text-red-400" />
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Konfirmasi Hapus</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Hapus <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $deletingLabel }}</span>?
                                Tindakan ini tidak dapat dibatalkan.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 border-t border-gray-100 px-6 py-4 dark:border-gray-800">
                    <button
                        wire:click="cancelDelete"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                    >
                        Batal
                    </button>
                    <button
                        wire:click="executeDelete"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 disabled:opacity-60"
                    >
                        <x-heroicon-o-trash class="h-4 w-4" />
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif

    <x-filament-actions::modals />
</x-filament-panels::page>