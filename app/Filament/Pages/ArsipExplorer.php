<?php

namespace App\Filament\Pages;

use App\Models\Box;
use App\Models\Dokumen;
use App\Models\JenisDokumen;
use App\Models\Lokasi;
use App\Models\Rak;
use App\Models\Ruangan;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;
use Filament\Schemas\Components\Utilities\Set;

class ArsipExplorer extends Page implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    protected static ?int    $navigationSort = 0;
    protected static ?string $title          = 'Arsip Explorer';

    protected string $view = 'filament.pages.arsip-explorer';

    // Level aktif: ruangan | lokasi | rak | box | dokumen
    public string $level = 'ruangan';

    public ?int $ruanganId = null;
    public ?int $lokasiId  = null;
    public ?int $rakId     = null;
    public ?int $boxId     = null;

    public string $search = '';

    // ── Breadcrumb ────────────────────────────────────────────────────────────

    public function getBreadcrumbsProperty(): array
    {
        $crumbs = [
            [
                'label'     => 'Semua Ruangan',
                'level'     => 'ruangan',
                'ruanganId' => null,
                'lokasiId'  => null,
                'rakId'     => null,
                'boxId'     => null,
            ],
        ];

        if ($this->ruanganId) {
            $ruangan  = Ruangan::find($this->ruanganId);
            $crumbs[] = [
                'label'     => $ruangan?->nama_ruangan ?? 'Ruangan',
                'level'     => 'lokasi',
                'ruanganId' => $this->ruanganId,
                'lokasiId'  => null,
                'rakId'     => null,
                'boxId'     => null,
            ];
        }

        if ($this->lokasiId) {
            $lokasi   = Lokasi::find($this->lokasiId);
            $crumbs[] = [
                'label'     => $lokasi?->nama_lokasi ?? 'Lokasi/Lemari',
                'level'     => 'rak',
                'ruanganId' => $this->ruanganId,
                'lokasiId'  => $this->lokasiId,
                'rakId'     => null,
                'boxId'     => null,
            ];
        }

        if ($this->rakId) {
            $rak      = Rak::find($this->rakId);
            $crumbs[] = [
                'label'     => $rak?->nama_rak ?? 'Rak',
                'level'     => 'box',
                'ruanganId' => $this->ruanganId,
                'lokasiId'  => $this->lokasiId,
                'rakId'     => $this->rakId,
                'boxId'     => null,
            ];
        }

        if ($this->boxId) {
            $box      = Box::find($this->boxId);
            $crumbs[] = [
                'label'     => $box?->nama_box ?? ('Box #' . $this->boxId),
                'level'     => 'dokumen',
                'ruanganId' => $this->ruanganId,
                'lokasiId'  => $this->lokasiId,
                'rakId'     => $this->rakId,
                'boxId'     => $this->boxId,
            ];
        }

        return $crumbs;
    }

    // ── Navigation ────────────────────────────────────────────────────────────

    public function navigateTo(
        string $level,
        ?int $ruanganId = null,
        ?int $lokasiId  = null,
        ?int $rakId     = null,
        ?int $boxId     = null,
    ): void {
        $this->level     = $level;
        $this->ruanganId = $ruanganId;
        $this->lokasiId  = $lokasiId;
        $this->rakId     = $rakId;
        $this->boxId     = $boxId;
        $this->search    = '';
    }

    public function drillDown(string $targetLevel, int $id): void
    {
        $this->search = '';

        match ($targetLevel) {
            'lokasi'  => $this->navigateTo('lokasi',  $id),
            'rak'     => $this->navigateTo('rak',     $this->ruanganId, $id),
            'box'     => $this->navigateTo('box',     $this->ruanganId, $this->lokasiId, $id),
            'dokumen' => $this->navigateTo('dokumen', $this->ruanganId, $this->lokasiId, $this->rakId, $id),
            default   => null,
        };
    }

    // ── Data ──────────────────────────────────────────────────────────────────

    public function getItemsProperty()
    {
        return match ($this->level) {
            'ruangan' => $this->fetchRuangans(),
            'lokasi'  => $this->fetchLokasis(),
            'rak'     => $this->fetchRaks(),
            'box'     => $this->fetchBoxes(),
            'dokumen' => $this->fetchDokumens(),
            default   => collect(),
        };
    }

    private function fetchRuangans()
    {
        return Ruangan::withCount('lokasis')
            ->when($this->search, fn($q) =>
                $q->where('nama_ruangan', 'like', "%{$this->search}%")
                  ->orWhere('kode_ruangan', 'like', "%{$this->search}%")
            )
            ->orderBy('kode_ruangan')
            ->paginate(12);
    }

    private function fetchLokasis()
    {
        return Lokasi::withCount('raks')
            ->where('ruangan_id', $this->ruanganId)
            ->when($this->search, fn($q) =>
                $q->where('nama_lokasi', 'like', "%{$this->search}%")
                  ->orWhere('kode_lokasi', 'like', "%{$this->search}%")
            )
            ->orderBy('kode_lokasi')
            ->paginate(12);
    }

    private function fetchRaks()
    {
        return Rak::withCount('Box')
            ->where('lokasi_id', $this->lokasiId)
            ->when($this->search, fn($q) =>
                $q->where('nama_rak', 'like', "%{$this->search}%")
                  ->orWhere('kode_rak', 'like', "%{$this->search}%")
            )
            ->orderBy('kode_rak')
            ->paginate(12);
    }

    private function fetchBoxes()
    {
        return Box::withCount('dokumens')
            ->where('rak_id', $this->rakId)
            ->when($this->search, fn($q) =>
                $q->where('nama_box', 'like', "%{$this->search}%")
                  ->orWhere('kode_box', 'like', "%{$this->search}%")
            )
            ->orderBy('kode_box')
            ->paginate(12);
    }

    private function fetchDokumens()
    {
        return Dokumen::with(['jenisDokumen', 'user'])
            ->where('box_id', $this->boxId)
            ->when($this->search, fn($q) =>
                $q->where('judul', 'like', "%{$this->search}%")
                  ->orWhere('nomor_dokumen', 'like', "%{$this->search}%")
                  ->orWhere('kode_dokumen', 'like', "%{$this->search}%")
                  ->orWhere('perihal', 'like', "%{$this->search}%")
            )
            ->orderBy('tanggal', 'desc')
            ->paginate(15);
    }

    // ── Stats ─────────────────────────────────────────────────────────────────

    public function getStatsProperty(): array
    {
        return match ($this->level) {
            'ruangan' => [
                ['label' => 'Total Ruangan', 'value' => Ruangan::count(), 'icon' => 'heroicon-o-home-modern',       'color' => 'blue'],
                ['label' => 'Total Lokasi',  'value' => Lokasi::count(),  'icon' => 'heroicon-o-map-pin',           'color' => 'purple'],
                ['label' => 'Total Rak',     'value' => Rak::count(),     'icon' => 'heroicon-o-building-office-2', 'color' => 'green'],
                ['label' => 'Total Box',     'value' => Box::count(),     'icon' => 'heroicon-o-archive-box',       'color' => 'amber'],
            ],
            'lokasi' => [
                ['label' => 'Lokasi dalam Ruangan', 'value' => Lokasi::where('ruangan_id', $this->ruanganId)->count(), 'icon' => 'heroicon-o-map-pin',           'color' => 'purple'],
                ['label' => 'Total Rak',            'value' => Rak::whereHas('Lokasi', fn($q) => $q->where('ruangan_id', $this->ruanganId))->count(),            'icon' => 'heroicon-o-building-office-2', 'color' => 'green'],
                ['label' => 'Total Box',            'value' => Box::whereHas('rak.Lokasi', fn($q) => $q->where('ruangan_id', $this->ruanganId))->count(),        'icon' => 'heroicon-o-archive-box',       'color' => 'amber'],
            ],
            'rak' => [
                ['label' => 'Rak dalam Lokasi', 'value' => Rak::where('lokasi_id', $this->lokasiId)->count(),                                                   'icon' => 'heroicon-o-building-office-2', 'color' => 'green'],
                ['label' => 'Total Box',         'value' => Box::whereHas('rak', fn($q) => $q->where('lokasi_id', $this->lokasiId))->count(),                    'icon' => 'heroicon-o-archive-box',       'color' => 'amber'],
                ['label' => 'Total Dokumen',     'value' => Dokumen::whereHas('box.rak', fn($q) => $q->where('lokasi_id', $this->lokasiId))->count(),            'icon' => 'heroicon-o-document-text',     'color' => 'blue'],
            ],
            'box' => [
                ['label' => 'Box dalam Rak',  'value' => Box::where('rak_id', $this->rakId)->count(),                                                           'icon' => 'heroicon-o-archive-box',   'color' => 'amber'],
                ['label' => 'Total Dokumen',  'value' => Dokumen::whereHas('box', fn($q) => $q->where('rak_id', $this->rakId))->count(),                        'icon' => 'heroicon-o-document-text', 'color' => 'blue'],
            ],
            'dokumen' => [
                ['label' => 'Dokumen dalam Box', 'value' => Dokumen::where('box_id', $this->boxId)->count(), 'icon' => 'heroicon-o-document-text', 'color' => 'blue'],
            ],
            default => [],
        };
    }

    // ── Level metadata ────────────────────────────────────────────────────────

    public function getLevelMetaProperty(): array
    {
        return match ($this->level) {
            'ruangan' => ['label' => 'Ruangan', 'icon' => 'heroicon-o-home-modern',      'empty' => 'Belum ada ruangan'],
            'lokasi'  => ['label' => 'Lokasi',  'icon' => 'heroicon-o-map-pin',           'empty' => 'Belum ada lokasi di ruangan ini'],
            'rak'     => ['label' => 'Rak',     'icon' => 'heroicon-o-building-office-2', 'empty' => 'Belum ada rak di lokasi ini'],
            'box'     => ['label' => 'Box',     'icon' => 'heroicon-o-archive-box',       'empty' => 'Belum ada box di rak ini'],
            'dokumen' => ['label' => 'Dokumen', 'icon' => 'heroicon-o-document-text',     'empty' => 'Belum ada dokumen di box ini'],
            default   => [],
        };
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function getJenisDokumenOptionsProperty(): array
    {
        return JenisDokumen::orderBy('nama_jenis_dokumen')->pluck('nama_jenis_dokumen', 'id')->toArray();
    }

    // ── Form Schema (per level) ───────────────────────────────────────────────

    protected function getFormSchema(): array
    {
        return match ($this->level) {
            'ruangan' => [
                TextInput::make('kode_ruangan')
                    ->label('Kode Ruangan')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('R-001'),
                TextInput::make('nama_ruangan')
                    ->label('Nama Ruangan')
                    ->required()
                    ->maxLength(255),
                // Textarea::make('deskripsi')
                //     ->label('Deskripsi')
                //     ->rows(3),
            ],
            'lokasi' => [
                TextInput::make('kode_lokasi')
                    ->label('Kode Lokasi')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('L-001'),
                TextInput::make('nama_lokasi')
                    ->label('Nama Lokasi')
                    ->required()
                    ->maxLength(255),
                // Textarea::make('deskripsi')
                //     ->label('Deskripsi')
                //     ->rows(3),
            ],
            'rak' => [
                TextInput::make('kode_rak')
                    ->label('Kode Rak')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('RAK-001'),
                TextInput::make('nama_rak')
                    ->label('Nama Rak')
                    ->required()
                    ->maxLength(255),
                // Textarea::make('deskripsi')
                //     ->label('Deskripsi')
                //     ->rows(3),
            ],
            'box' => [
                TextInput::make('kode_box')
                    ->label('Kode Box')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('BOX-001'),
                TextInput::make('nama_box')
                    ->label('Nama Box')
                    ->required()
                    ->maxLength(255),
                // Textarea::make('deskripsi')
                //     ->label('Deskripsi')
                //     ->rows(3),
            ],
            'dokumen' => 
              [
                TextInput::make('judul')
                    ->label('Judul Dokumen')
                    ->required()
                    ->maxLength(255),

                TextInput::make('nomor_dokumen')
                    ->label('Nomor Dokumen')
                    // ->required()
                    ->maxLength(100),

                TextInput::make('kode_dokumen')
                    ->label('Kode Dokumen')
                    ->required()
                    ->maxLength(50)
                    // ->readonly()
                    ->disabled()
                    ->dehydrated()
                    ->default(fn (callable $get) => $get('kode_dokumen')),

                Select::make('jenis_dokumen_id')
                    ->label('Jenis Dokumen')
                    ->options(JenisDokumen::pluck('nama_jenis_dokumen', 'id'))
                    ->required()
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set) {
                    if ($state) {
                        $jenis = JenisDokumen::find($state);
                        $kode = strtoupper(substr($jenis->nama_jenis_dokumen, 0, 3));
                        $count = \App\Models\Dokumen::where('jenis_dokumen_id', $state)->count() + 1;
                        // Format dengan padding 0 (misal: 001, 002, dst)
                        $nomorUrut = str_pad($count, 3, '0', STR_PAD_LEFT);
                        $set('kode_dokumen', $kode .  $nomorUrut);
                    }
                    }),
                // Select::make('box_id')
                //     ->label('Box')
                //     ->options(Box::pluck('kode_box', 'id'))
                //     // ->relationship('box', 'nama_box')
                //     ->createOptionForm([
                //         Select::make('rak_id')
                //             ->label('Rak')
                //             ->options(Rak::pluck('nama_rak', 'id'))
                //             ->required()
                //             ->searchable(),
                //         TextInput::make('kode_box')
                //             ->label('Kode Box')
                //             ->required()
                //             ->maxLength(50),
                //         TextInput::make('nama_box')
                //             ->label('Nama Box')
                //             ->required()
                //             ->maxLength(100),
                //         Textarea::make('deskripsi')
                //             ->label('Deskripsi Box')
                //             ->rows(2)
                //             ->columnSpanFull(),
                //     ])
                //     ->required()
                //     ->searchable(),

                // Textarea::make('deskripsi_dokumen')
                //     ->label('Deskripsi Dokumen')
                //     ->columnSpanFull()
                //     ->rows(3),

                // Textarea::make('perihal')
                //     ->label('Perihal')
                //     ->columnSpanFull()
                //     ->rows(3),

                DatePicker::make('tanggal')
                    ->label('Tanggal Dokumen')
                    ->required(),

                FileUpload::make('file_path')
                    ->disk('public')
                    ->directory('ArsipFiles')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(10240)
                    ->required(),

                // Textarea::make('catatan')
                //     ->label('Catatan')
                //     ->columnSpanFull()
                //     ->rows(2),

                // Select::make('status')
                //     ->label('Status')
                //     ->options([
                //         'aktif' => 'Aktif',
                //         'kadaluarsa' => 'Kadaluarsa',
                //         'dipinjam' => 'Dipinjam',
                //         'rusak' => 'Rusak',
                //     ])
                //     ->default('aktif')
                //     ->required(),
            ]
            ,
            default => [],
        };
    }

    // ── Actions ───────────────────────────────────────────────────────────────

    /**
     * Dipanggil dari view: wire:click="mountAction('create')"
     */
    public function createAction(): Action
    {
        $label = $this->levelMeta['label'];

        return Action::make('create')
            ->label("Tambah {$label}")
            ->modalHeading("Tambah {$label}")
            ->modalSubmitActionLabel('Simpan')
            ->modalWidth('lg')
            ->form(fn () => $this->getFormSchema())
            ->action(function (array $data): void {
                match ($this->level) {
                    'ruangan' => Ruangan::create($data),
                    'lokasi'  => Lokasi::create([...$data,  'ruangan_id' => $this->ruanganId]),
                    'rak'     => Rak::create([...$data,     'lokasi_id'  => $this->lokasiId]),
                    'box'     => Box::create([...$data,     'rak_id'     => $this->rakId]),
                    'dokumen' => Dokumen::create([...$data, 'box_id'     => $this->boxId]),
                    default   => null,
                };

                $label = $this->levelMeta['label'];
                Notification::make()->title("{$label} berhasil ditambahkan.")->success()->send();
            });
    }

    /**
     * Dipanggil dari view: wire:click="mountAction('edit', { id: {{ $item->id }} })"
     */
    public function editAction(): Action
    {
        return Action::make('edit')
            ->modalHeading(fn (array $arguments) => 'Edit ' . $this->levelMeta['label'])
            ->modalSubmitActionLabel('Perbarui')
            ->modalWidth('lg')
            ->form(fn () => $this->getFormSchema())
            ->fillForm(function (array $arguments): array {
                $id = $arguments['id'];

                return match ($this->level) {
                    'ruangan' => Ruangan::findOrFail($id)->only(['kode_ruangan', 'nama_ruangan', 'deskripsi']),
                    'lokasi'  => Lokasi::findOrFail($id)->only(['kode_lokasi', 'nama_lokasi', 'deskripsi']),
                    'rak'     => Rak::findOrFail($id)->only(['kode_rak', 'nama_rak', 'deskripsi']),
                    'box'     => Box::findOrFail($id)->only(['kode_box', 'nama_box', 'deskripsi']),
                    'dokumen' => Dokumen::findOrFail($id)->only([
                        'judul', 'nomor_dokumen', 'kode_dokumen', 'perihal','file_path',
                        'tanggal', 'deskripsi_dokumen', 'catatan', 'jenis_dokumen_id',
                    ]),
                    default => [],
                };
            })
            ->action(function (array $data, array $arguments): void {
                $id = $arguments['id'];

                match ($this->level) {
                    'ruangan' => Ruangan::findOrFail($id)->update($data),
                    'lokasi'  => Lokasi::findOrFail($id)->update($data),
                    'rak'     => Rak::findOrFail($id)->update($data),
                    'box'     => Box::findOrFail($id)->update($data),
                    'dokumen' => Dokumen::findOrFail($id)->update($data),
                    default   => null,
                };

                $label = $this->levelMeta['label'];
                Notification::make()->title("{$label} berhasil diperbarui.")->success()->send();
            });
    }

    /**
     * Dipanggil dari view: wire:click="mountAction('delete', { id: {{ $item->id }}, label: '...' })"
     */
    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->requiresConfirmation()
            ->modalHeading('Konfirmasi Hapus')
            ->modalDescription(fn (array $arguments) => "Hapus \"{$arguments['label']}\"? Tindakan ini tidak dapat dibatalkan.")
            ->modalSubmitActionLabel('Hapus')
            ->color('danger')
            ->action(function (array $arguments): void {
                $id = $arguments['id'];

                match ($this->level) {
                    'ruangan' => Ruangan::findOrFail($id)->delete(),
                    'lokasi'  => Lokasi::findOrFail($id)->delete(),
                    'rak'     => Rak::findOrFail($id)->delete(),
                    'box'     => $this->deleteBox($id),
                    'dokumen' => $this->deleteDokumen($id),
                    default   => null,
                };

                $label = $this->levelMeta['label'];
                Notification::make()->title("{$label} berhasil dihapus.")->success()->send();
            });
    }

    // ── Delete helpers (dengan file cleanup) ─────────────────────────────────

    private function deleteBox(int $id): void
    {
        $box = Box::findOrFail($id);
        if ($box->qr_code_path) {
            Storage::disk('public')->delete($box->qr_code_path);
        }
        $box->delete();
    }

    private function deleteDokumen(int $id): void
    {
        $dok = Dokumen::findOrFail($id);
        if ($dok->file_path) {
            Storage::disk('public')->delete($dok->file_path);
        }
        $dok->delete();
    }
}