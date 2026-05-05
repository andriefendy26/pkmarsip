@php
use App\Filament\Resources\Boxes\BoxResource;
@endphp
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
                        Data Boxes
                    </h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-300">
                        Halaman ini digunakan untuk mengelola data box arsip, lokasi rak, dan dokumen yang tersimpan di dalam box.
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
                        <x-heroicon-o-archive-box class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Box</p>
                        <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $totalBoxes }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
                <div class="flex items-center gap-4">
                    <div class="rounded-lg bg-green-50 p-3 dark:bg-green-500/10">
                        <x-heroicon-o-building-office class="h-6 w-6 text-green-600 dark:text-green-400" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Box Memiliki Rak</p>
                        <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $totalRakTerisi }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
                <div class="flex items-center gap-4">
                    <div class="rounded-lg bg-purple-50 p-3 dark:bg-purple-500/10">
                        <x-heroicon-o-document-text class="h-6 w-6 text-purple-600 dark:text-purple-400" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Dokumen</p>
                        <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $totalDokumen }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search & Filter --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between ">
            <div class="flex flex-1 gap-3">
                <div class="relative flex-1 max-w-xs ">
                    {{-- <x-heroicon-o-magnifying-glass class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" /> --}}
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari kode atau nama box..."
                        class="w-full p-2 rounded-lg border border-gray-200 bg-white py-2 pl-9 pr-4 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    />
                </div>

                <select
                    wire:model.live="filterRak"
                    class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                >
                    <option value="">Semua Box</option>
                    <option value="has_rak">Sudah Punya Rak</option>
                    <option value="no_rak">Belum Ada Rak</option>
                </select>
            </div>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $this->boxes->total() }} box ditemukan
            </p>
        </div>

        {{-- Grid Kamar-Kamar --}}
        @if ($this->boxes->isEmpty())
            <div class="flex flex-col items-center justify-center rounded-xl bg-white py-16 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900">
                <x-heroicon-o-archive-box class="h-12 w-12 text-gray-300 dark:text-gray-600" />
                <p class="mt-4 text-sm font-medium text-gray-500 dark:text-gray-400">Tidak ada box ditemukan</p>
            </div>
        @else
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
                @foreach ($this->boxes as $box)
                    <a
                        href="{{ BoxResource::getUrl('view', ['record' => $box]) }}"
                        wire:navigate
                        class="group relative flex flex-col overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md dark:bg-gray-900 dark:hover:bg-gray-800"
                    >
                        {{-- Status strip di atas --}}
                        <div class="h-1.5 w-full {{ $box->rak_id ? 'bg-green-400' : 'bg-amber-400' }}"></div>

                        <div class="flex flex-col gap-3 p-4">
                            {{-- Icon Box --}}
                            <div class="flex items-start justify-between">
                                <div class="rounded-lg {{ $box->rak_id ? 'bg-green-50 dark:bg-green-500/10' : 'bg-amber-50 dark:bg-amber-500/10' }} p-2">
                                    <x-heroicon-o-archive-box class="h-5 w-5 {{ $box->rak_id ? 'text-green-600 dark:text-green-400' : 'text-amber-600 dark:text-amber-400' }}" />
                                </div>

                                {{-- Dokumen badge --}}
                                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                    <x-heroicon-o-document-text class="h-3 w-3" />
                                    {{ $box->dokumens_count }}
                                </span>
                            </div>

                            {{-- Info --}}
                            <div class="min-w-0">
                                <p class="truncate text-xs font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">
                                    {{ $box->kode_box }}
                                </p>
                                <p class="mt-0.5 truncate text-sm text-gray-900 dark:text-white">
                                    {{ $box->nama_box }}
                                </p>
                            </div>

                            {{-- Rak info --}}
                            <div class="flex items-center gap-1.5">
                                @if ($box->rak)
                                    <x-heroicon-o-map-pin class="h-3.5 w-3.5 flex-shrink-0 text-green-500" />
                                    <span class="truncate text-xs text-gray-500 dark:text-gray-400">
                                        {{ $box->rak->nama_rak }}
                                    </span>
                                @else
                                    <x-heroicon-o-question-mark-circle class="h-3.5 w-3.5 flex-shrink-0 text-amber-400" />
                                    <span class="text-xs text-amber-500">Belum ada rak</span>
                                @endif
                            </div>
                        </div>

                        {{-- QR Code (jika ada) --}}
                        @if ($box->qr_code_url)
                            <div class="border-t border-gray-100 p-3 dark:border-gray-800">
                                <img
                                    src="{{ $box->qr_code_url }}"
                                    alt="QR {{ $box->kode_box }}"
                                    class="mx-auto h-24 w-24 object-contain opacity-60 transition-opacity group-hover:opacity-100"
                                />
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-2">
                {{ $this->boxes->links() }}
            </div>
        @endif

    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>