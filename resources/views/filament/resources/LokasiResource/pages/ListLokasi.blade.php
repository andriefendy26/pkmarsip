@php use App\Filament\Resources\Lokasis\LokasiResource; @endphp

<x-filament-panels::page>
    <div class="space-y-4">

        {{-- Header --}}
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Manajemen Arsip Fisik
                    </p>
                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                        Data Lokasi
                    </h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-300">
                        Halaman ini digunakan untuk mengelola data lokasi penyimpanan beserta rak-rak yang berada di dalamnya.
                    </p>
                </div>
                <div class="rounded-lg bg-primary-50 px-4 py-2 text-sm font-semibold text-primary-700 dark:bg-primary-500/10 dark:text-primary-400">
                    Fisik
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
                <div class="flex items-center gap-4">
                    <div class="rounded-lg bg-blue-50 p-3 dark:bg-blue-500/10">
                        <x-heroicon-o-map-pin class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Lokasi</p>
                        <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $totalLokasis }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
                <div class="flex items-center gap-4">
                    <div class="rounded-lg bg-green-50 p-3 dark:bg-green-500/10">
                        <x-heroicon-o-building-office-2 class="h-6 w-6 text-green-600 dark:text-green-400" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Rak</p>
                        <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $totalRaks }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
                <div class="flex items-center gap-4">
                    <div class="rounded-lg bg-amber-50 p-3 dark:bg-amber-500/10">
                        <x-heroicon-o-archive-box class="h-6 w-6 text-amber-600 dark:text-amber-400" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Box</p>
                        <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $totalBoxes }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Search & Filter --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-1 gap-3">

                {{-- Search Input (dengan icon search) --}}
                <div class="relative flex-1 max-w-xs">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-heroicon-o-magnifying-glass class="h-4 w-4 text-gray-400" />
                    </div>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari kode atau nama lokasi..."
                        class="w-full rounded-lg border border-gray-200 bg-white py-2 pl-9 pr-4 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    />
                </div>

                <select
                    wire:model.live="filterIsi"
                    class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                >
                    <option value="">Semua Lokasi</option>
                    <option value="has_rak">Ada Rak</option>
                    <option value="no_rak">Kosong</option>
                </select>

            </div>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $this->lokasis->total() }} lokasi ditemukan
            </p>
        </div>

        {{-- Grid Lokasi --}}
        @if ($this->lokasis->isEmpty())
            <div class="flex flex-col items-center justify-center rounded-xl bg-white py-16 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
                <x-heroicon-o-map-pin class="h-12 w-12 text-gray-300 dark:text-gray-600" />
                <p class="mt-4 text-sm font-medium text-gray-500 dark:text-gray-400">Tidak ada lokasi ditemukan</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($this->lokasis as $lokasi)
                    @php
                        $rakCount = $lokasi->raks_count;
                        $boxCount = $lokasi->raks->sum('box_count');
                    @endphp

                    <a
                        href="{{ LokasiResource::getUrl('edit', ['record' => $lokasi]) }}"
                        wire:navigate
                        class="group relative flex flex-col overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md dark:bg-gray-900 dark:hover:bg-gray-800"
                    >
                        {{-- Status strip --}}
                        <div class="h-1.5 w-full {{ $rakCount > 0 ? 'bg-blue-400' : 'bg-gray-200 dark:bg-gray-700' }}"></div>

                        <div class="flex flex-col gap-4 p-5">

                            {{-- Icon + Status badge --}}
                            <div class="flex items-start justify-between">
                                <div class="rounded-lg p-2 {{ $rakCount > 0 ? 'bg-blue-50 dark:bg-blue-500/10' : 'bg-gray-100 dark:bg-gray-800' }}">
                                    <x-heroicon-o-map-pin class="h-5 w-5 {{ $rakCount > 0 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400' }}" />
                                </div>
                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium
                                    {{ $rakCount > 0
                                        ? 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400'
                                        : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' }}">
                                    {{ $rakCount > 0 ? 'Aktif' : 'Kosong' }}
                                </span>
                            </div>

                            {{-- Kode & Nama --}}
                            <div class="min-w-0">
                                @if ($lokasi->kode_lokasi)
                                    <p class="truncate text-xs font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">
                                        {{ $lokasi->kode_lokasi }}
                                    </p>
                                @endif
                                <p class="mt-0.5 truncate text-base font-semibold text-gray-900 dark:text-white">
                                    {{ $lokasi->nama_lokasi }}
                                </p>
                                @if ($lokasi->deskripsi)
                                    <p class="mt-1 line-clamp-2 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $lokasi->deskripsi }}
                                    </p>
                                @endif
                            </div>

                            {{-- Divider --}}
                            <div class="border-t border-gray-100 dark:border-gray-800"></div>

                            {{-- Stats Rak & Box --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div class="flex flex-col gap-1 rounded-lg bg-gray-50 p-3 dark:bg-gray-800">
                                    <div class="flex items-center gap-1.5">
                                        <x-heroicon-o-building-office-2 class="h-3.5 w-3.5 text-gray-400" />
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Rak</span>
                                    </div>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $rakCount }}</p>
                                </div>

                                <div class="flex flex-col gap-1 rounded-lg bg-gray-50 p-3 dark:bg-gray-800">
                                    <div class="flex items-center gap-1.5">
                                        <x-heroicon-o-archive-box class="h-3.5 w-3.5 text-gray-400" />
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Box</span>
                                    </div>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $boxCount }}</p>
                                </div>
                            </div>

                            {{-- Mini rak preview --}}
                            @if ($rakCount > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($lokasi->raks->take(10) as $rak)
                                        <div
                                            title="{{ $rak->nama_rak }} ({{ $rak->box_count }} box)"
                                            class="flex h-6 w-6 items-center justify-center rounded text-[10px] font-bold
                                                {{ $rak->box_count > 0
                                                    ? 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400'
                                                    : 'bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500' }}"
                                        >
                                            {{ $rak->box_count }}
                                        </div>
                                    @endforeach
                                    @if ($rakCount > 10)
                                        <div class="flex h-6 items-center rounded px-1.5 text-[10px] font-medium bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                            +{{ $rakCount - 10 }}
                                        </div>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-2">
                {{ $this->lokasis->links() }}
            </div>
        @endif

    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>