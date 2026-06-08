<?php

namespace App\Filament\Resources\Boxes\Pages;

use App\Filament\Resources\Boxes\BoxResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Models\Box;

// class ListBoxes extends ListRecords
// {
//     protected static string $resource = BoxResource::class;

//     protected function getHeaderActions(): array
//     {
//         return [
//             CreateAction::make(),
//         ];
//     }
// }
class ListBoxes extends ListRecords
{
    protected static string $resource = BoxResource::class;

    protected string $view = 'filament.resources.BoxResource.pages.ListBoxes';

    public int $totalBoxes = 0;
    public int $totalRakTerisi = 0;
    public int $totalDokumen = 0;

    // Tambahan untuk card view
    public string $search = '';
    public string $filterRak = '';

    public function mount(): void
    {
        parent::mount();
        $this->refreshStats();
    }

    public function refreshStats(): void
    {
        $this->totalBoxes     = Box::count();
        $this->totalRakTerisi = Box::whereNotNull('rak_id')->count();
        $this->totalDokumen   = Box::withCount('dokumens')->get()->sum('dokumens_count');
    }

    public function getBoxesProperty()
    {
        return Box::with(['rak', 'dokumens'])
            ->withCount('dokumens')
            ->when($this->search, fn($q) =>
                $q->where('kode_box', 'like', "%{$this->search}%")
                  ->orWhere('nama_box', 'like', "%{$this->search}%")
            )
            ->when($this->filterRak, function ($q) {
                if ($this->filterRak === 'has_rak') {
                    $q->whereNotNull('rak_id');
                } elseif ($this->filterRak === 'no_rak') {
                    $q->whereNull('rak_id');
                }
            })
            ->orderBy('kode_box')
            ->paginate(12);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Box'),
        ];
    }
}