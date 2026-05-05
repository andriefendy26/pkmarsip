@php use App\Filament\Resources\Raks\RakResource; @endphp

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
                        Data Rak
                    </h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-300">
                        Halaman ini digunakan untuk mengelola data rak penyimpanan beserta box-box yang berada di dalamnya.
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
                        <x-heroicon-o-building-office-2 class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Rak</p>
                        <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $totalRaks }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
                <div class="flex items-center gap-4">
                    <div class="rounded-lg bg-green-50 p-3 dark:bg-green-500/10">
                        <x-heroicon-o-archive-box class="h-6 w-6 text-green-600 dark:text-green-400" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Rak Terisi</p>
                        <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $totalRakTerisi }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
                <div class="flex items-center gap-4">
                    <div class="rounded-lg bg-amber-50 p-3 dark:bg-amber-500/10">
                        <x-heroicon-o-inbox class="h-6 w-6 text-amber-600 dark:text-amber-400" />
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
                <div class="relative flex-1 max-w-xs">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari kode atau nama rak..."
                        class="w-full p-2 rounded-lg border border-gray-200 bg-white py-2 pl-9 pr-4 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    />
                </div>

                <select
                    wire:model.live="filterIsi"
                    class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                >
                    <option value="">Semua Rak</option>
                    <option value="has_box">Ada Box</option>
                    <option value="no_box">Kosong</option>
                </select>
            </div>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $this->raks->total() }} rak ditemukan
            </p>
        </div>

        {{-- Grid Kamar-Kamar --}}
        @if ($this->raks->isEmpty())
            <div class="flex flex-col items-center justify-center rounded-xl bg-white py-16 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
                <x-heroicon-o-building-office-2 class="h-12 w-12 text-gray-300 dark:text-gray-600" />
                <p class="mt-4 text-sm font-medium text-gray-500 dark:text-gray-400">Tidak ada rak ditemukan</p>
            </div>
        @else
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($this->raks as $rak)
                    @php
                        $boxCount    = $rak->box_count;
                        $isFull      = $boxCount > 0;
                        $fillPercent = $rak->kapasitas > 0
                            ? min(100, round(($boxCount / $rak->kapasitas) * 100))
                            : ($isFull ? 100 : 0);
                    @endphp
                    <a 
                    
                        href="{{ RakResource::getUrl('edit', ['record' => $rak]) }}"
                        wire:navigate
                        class="group relative flex flex-col overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md dark:bg-gray-900 dark:hover:bg-gray-800"
                    >
                        {{-- Status strip --}}
                        <div class="h-1.5 w-full
                            {{ $boxCount === 0
                                ? 'bg-gray-200 dark:bg-gray-700'
                                : ($fillPercent >= 80 ? 'bg-red-400' : 'bg-green-400') }}">
                        </div>

                        <div class="flex flex-col gap-3 p-4">

                            {{-- Icon + Badge box --}}
                            <div class="flex items-start justify-between">
                                <div class="rounded-lg p-2
                                    {{ $boxCount === 0
                                        ? 'bg-gray-100 dark:bg-gray-800'
                                        : ($fillPercent >= 80
                                            ? 'bg-red-50 dark:bg-red-500/10'
                                            : 'bg-green-50 dark:bg-green-500/10') }}">
                                    <x-heroicon-o-building-office-2 class="h-5 w-5
                                        {{ $boxCount === 0
                                            ? 'text-gray-400'
                                            : ($fillPercent >= 80
                                                ? 'text-red-500 dark:text-red-400'
                                                : 'text-green-600 dark:text-green-400') }}" />
                                </div>

                                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                    <x-heroicon-o-archive-box class="h-3 w-3" />
                                    {{ $boxCount }}
                                </span>
                            </div>

                            {{-- Kode & Nama --}}
                            <div class="min-w-0">
                                <p class="truncate text-xs font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">
                                    {{ $rak->kode_rak }}
                                </p>
                                <p class="mt-0.5 truncate text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $rak->nama_rak }}
                                </p>
                            </div>

                            {{-- Lokasi (jika ada relasi) --}}
                            @if ($rak->lokasi)
                                <div class="flex items-center gap-1.5">
                                    <x-heroicon-o-map-pin class="h-3.5 w-3.5 flex-shrink-0 text-blue-400" />
                                    <span class="truncate text-xs text-gray-500 dark:text-gray-400">
                                        {{ $rak->lokasi->nama_lokasi ?? '-' }}
                                    </span>
                                </div>
                            @endif

                            {{-- Progress bar kapasitas (opsional, hapus jika tidak ada kolom kapasitas) --}}
                            @if (isset($rak->kapasitas) && $rak->kapasitas > 0)
                                <div>
                                    <div class="flex justify-between text-xs text-gray-400 mb-1">
                                        <span>Kapasitas</span>
                                        <span>{{ $fillPercent }}%</span>
                                    </div>
                                    <div class="h-1.5 w-full rounded-full bg-gray-100 dark:bg-gray-800">
                                        <div
                                            class="h-1.5 rounded-full transition-all
                                                {{ $fillPercent >= 80 ? 'bg-red-400' : 'bg-green-400' }}"
                                            style="width: {{ $fillPercent }}%"
                                        ></div>
                                    </div>
                                </div>
                            @else
                                {{-- Status label jika tidak ada kapasitas --}}
                                <span class="inline-flex w-fit items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium
                                    {{ $boxCount === 0
                                        ? 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400'
                                        : 'bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400' }}">
                                    {{ $boxCount === 0 ? 'Kosong' : 'Terisi' }}
                                </span>
                            @endif

                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-2">
                {{ $this->raks->links() }}
            </div>
        @endif

    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>