<?php

namespace App\Filament\Resources\Ruangans\Pages;

use App\Filament\Resources\Ruangans\RuangansResource;
use App\Models\Ruangan;
use App\Models\Lokasi;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRuangans extends ListRecords
{
    protected static string $resource = RuangansResource::class;

    protected string $view = 'filament.resources.RuangansResource.pages.ListRuangans';

    public int $totalRuangans     = 0;
    public int $totalRuanganTerisi = 0;
    public int $totalLokasis      = 0;

    public string $search    = '';
    public string $filterIsi = '';

    public function mount(): void
    {
        parent::mount();
        $this->refreshStats();
    }

    public function refreshStats(): void
    {
        $this->totalRuangans      = Ruangan::count();
        $this->totalRuanganTerisi = Ruangan::has('lokasis')->count();
        $this->totalLokasis       = Lokasi::count();
    }

    public function getRuangansProperty()
    {
        return Ruangan::withCount('lokasis')
            ->when($this->search, fn($q) =>
                $q->where('kode_ruangan', 'like', "%{$this->search}%")
                  ->orWhere('nama_ruangan', 'like', "%{$this->search}%")
            )
            ->when($this->filterIsi, function ($q) {
                if ($this->filterIsi === 'has_lokasi') {
                    $q->has('lokasis');
                } elseif ($this->filterIsi === 'no_lokasi') {
                    $q->doesntHave('lokasis');
                }
            })
            ->orderBy('kode_ruangan')
            ->paginate(15);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Ruangan'),
        ];
    }
}