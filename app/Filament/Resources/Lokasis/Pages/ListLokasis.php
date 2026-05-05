<?php

namespace App\Filament\Resources\Lokasis\Pages;

use App\Filament\Resources\Lokasis\LokasiResource;
use App\Models\Lokasi;
use App\Models\Rak;
use App\Models\Box;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLokasis extends ListRecords
{
    protected static string $resource = LokasiResource::class;

    protected string $view = 'filament.resources.LokasiResource.pages.ListLokasi';

    public int $totalLokasis = 0;
    public int $totalRaks    = 0;
    public int $totalBoxes   = 0;

    public string $search    = '';
    public string $filterIsi = '';

    public function mount(): void
    {
        parent::mount();
        $this->refreshStats();
    }

    public function refreshStats(): void
    {
        $this->totalLokasis = Lokasi::count();
        $this->totalRaks    = Rak::count();
        $this->totalBoxes   = Box::count();
    }

    public function getLokasisProperty()
    {
        return Lokasi::withCount('raks')
            ->with(['raks' => fn($q) => $q->withCount('box')])
            ->when($this->search, fn($q) =>
                $q->where('kode_lokasi', 'like', "%{$this->search}%")
                  ->orWhere('nama_lokasi', 'like', "%{$this->search}%")
            )
            ->when($this->filterIsi, function ($q) {
                if ($this->filterIsi === 'has_rak') {
                    $q->has('raks');
                } elseif ($this->filterIsi === 'no_rak') {
                    $q->doesntHave('raks');
                }
            })
            ->orderBy('kode_lokasi')
            ->paginate(12);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Lokasi'),
        ];
    }
}