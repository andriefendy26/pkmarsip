<!-- resources/views/filament/pdf-preview.blade.php -->
<div x-data="{ loading: true }">
    @if($url)
        <div x-show="loading" class="flex items-center justify-center h-96">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600"></div>
        </div>
        
        <iframe 
            src="{{ $url }}#toolbar=1&navpanes=0&scrollbar=1" 
            style="width: 100%; height: 75vh; border: none;"
            title="PDF Preview"
            @load="loading = false"
            x-show="!loading"
        ></iframe>
    @else
        <div class="text-center p-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="mt-2 text-gray-500">File PDF tidak ditemukan</p>
        </div>
    @endif
</div>