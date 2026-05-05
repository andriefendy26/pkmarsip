@php use App\Filament\Resources\Ruangans\RuangansResource; @endphp

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
                        Data Ruangan
                    </h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-300">
                        Halaman ini digunakan untuk mengelola data ruangan penyimpanan beserta lokasi-lokasi yang berada di dalamnya.
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
                        <x-heroicon-o-home-modern class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Ruangan</p>
                        <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $totalRuangans }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
                <div class="flex items-center gap-4">
                    <div class="rounded-lg bg-green-50 p-3 dark:bg-green-500/10">
                        <x-heroicon-o-check-circle class="h-6 w-6 text-green-600 dark:text-green-400" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Ruangan Terisi</p>
                        <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $totalRuanganTerisi }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
                <div class="flex items-center gap-4">
                    <div class="rounded-lg bg-amber-50 p-3 dark:bg-amber-500/10">
                        <x-heroicon-o-map-pin class="h-6 w-6 text-amber-600 dark:text-amber-400" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Lokasi</p>
                        <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $totalLokasis }}</p>
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
                        placeholder="Cari kode atau nama ruangan..."
                        class="w-full rounded-lg border border-gray-200 bg-white py-2 pl-4 pr-4 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    />
                </div>

                <select
                    wire:model.live="filterIsi"
                    class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                >
                    <option value="">Semua Ruangan</option>
                    <option value="has_lokasi">Ada Lokasi</option>
                    <option value="no_lokasi">Kosong</option>
                </select>
            </div>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $this->ruangans->total() }} ruangan ditemukan
            </p>
        </div>

        {{-- Grid Ruangan --}}
        @if ($this->ruangans->isEmpty())
            <div class="flex flex-col items-center justify-center rounded-xl bg-white py-16 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
                <x-heroicon-o-home-modern class="h-12 w-12 text-gray-300 dark:text-gray-600" />
                <p class="mt-4 text-sm font-medium text-gray-500 dark:text-gray-400">Tidak ada ruangan ditemukan</p>
            </div>
        @else
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($this->ruangans as $ruangan)
                    @php
                        $lokasiCount = $ruangan->lokasis_count;
                        $isFull      = $lokasiCount > 0;
                    @endphp

                    <a
                        href="{{ RuangansResource::getUrl('edit', ['record' => $ruangan]) }}"
                        wire:navigate
                        class="group relative flex flex-col overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md dark:bg-gray-900 dark:hover:bg-gray-800"
                    >
                        {{-- Status strip --}}
                        <div class="h-1.5 w-full {{ $lokasiCount === 0 ? 'bg-gray-200 dark:bg-gray-700' : 'bg-green-400' }}">
                        </div>

                        <div class="flex flex-col gap-3 p-4">

                            {{-- Icon + Badge lokasi --}}
                            <div class="flex items-start justify-between">
                                <div class="rounded-lg p-2 {{ $lokasiCount === 0 ? 'bg-gray-100 dark:bg-gray-800' : 'bg-green-50 dark:bg-green-500/10' }}">
                                    <x-heroicon-o-home-modern class="h-5 w-5 {{ $lokasiCount === 0 ? 'text-gray-400' : 'text-green-600 dark:text-green-400' }}" />
                                </div>
                                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                    <x-heroicon-o-map-pin class="h-3 w-3" />
                                    {{ $lokasiCount }}
                                </span>
                            </div>

                            {{-- Kode & Nama --}}
                            <div class="min-w-0">
                                <p class="truncate text-xs font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">
                                    {{ $ruangan->kode_ruangan }}
                                </p>
                                <p class="mt-0.5 truncate text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $ruangan->nama_ruangan }}
                                </p>
                            </div>

                            {{-- Deskripsi (jika ada) --}}
                            @if ($ruangan->deskripsi)
                                <p class="truncate text-xs text-gray-500 dark:text-gray-400">
                                    {{ $ruangan->deskripsi }}
                                </p>
                            @endif

                            {{-- Status label --}}
                            <span class="inline-flex w-fit items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium
                                {{ $lokasiCount === 0
                                    ? 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400'
                                    : 'bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400' }}">
                                {{ $lokasiCount === 0 ? 'Kosong' : 'Terisi' }}
                            </span>

                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-2">
                {{ $this->ruangans->links() }}
            </div>
        @endif

    </div>

    <x-filament-actions::modals />

</x-filament-panels::page>