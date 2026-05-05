<?php

// namespace App\Filament\Resources\Raks\Pages;

// use App\Filament\Resources\Raks\RakResource;
// use Filament\Actions\CreateAction;
// use Filament\Resources\Pages\ListRecords;

// class ListRaks extends ListRecords
// {
//     protected static string $resource = RakResource::class;

//     protected function getHeaderActions(): array
//     {
//         return [
//             CreateAction::make(),
//         ];
//     }
// }
namespace App\Filament\Resources\Raks\Pages;

use App\Filament\Resources\Raks\RakResource;
use App\Models\Rak;
use App\Models\Box;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRaks extends ListRecords
{
    protected static string $resource = RakResource::class;

    protected string $view = 'filament.resources.RakResource.pages.ListRaks';

    public int $totalRaks     = 0;
    public int $totalRakTerisi = 0;
    public int $totalBoxes    = 0;

    public string $search    = '';
    public string $filterIsi = '';

    public function mount(): void
    {
        parent::mount();
        $this->refreshStats();
    }

    public function refreshStats(): void
    {
        $this->totalRaks      = Rak::count();
        $this->totalRakTerisi = Rak::has('box')->count();
        $this->totalBoxes     = Box::count();
    }

    public function getRaksProperty()
    {
        return Rak::withCount('box')
            ->with('lokasi')
            ->when($this->search, fn($q) =>
                $q->where('kode_rak', 'like', "%{$this->search}%")
                  ->orWhere('nama_rak', 'like', "%{$this->search}%")
            )
            ->when($this->filterIsi, function ($q) {
                if ($this->filterIsi === 'has_box') {
                    $q->has('box');
                } elseif ($this->filterIsi === 'no_box') {
                    $q->doesntHave('box');
                }
            })
            ->orderBy('kode_rak')
            ->paginate(15);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Rak'),
        ];
    }
}
