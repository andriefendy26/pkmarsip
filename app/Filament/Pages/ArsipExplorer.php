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
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;

class ArsipExplorer extends Page implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    protected static ?int    $navigationSort  = 0;
    protected static ?string $title           = 'Arsip Explorer';

    protected string $view = 'filament.pages.arsip-explorer';

    // Level aktif: ruangan | lokasi | rak | box | dokumen
    public string $level = 'ruangan';

    public ?int $ruanganId = null;
    public ?int $lokasiId  = null;
    public ?int $rakId     = null;
    public ?int $boxId     = null;

    public string $search = '';

    // Modal state
    public bool $showModal     = false;
    public string $modalMode   = 'create'; // create | edit
    public ?int $editingId     = null;

    // Form fields — Ruangan
    public string $f_kode_ruangan = '';
    public string $f_nama_ruangan = '';
    public string $f_deskripsi_ruangan = '';

    // Form fields — Lokasi
    public string $f_kode_lokasi = '';
    public string $f_nama_lokasi = '';
    public string $f_deskripsi_lokasi = '';

    // Form fields — Rak
    public string $f_kode_rak = '';
    public string $f_nama_rak = '';
    public string $f_deskripsi_rak = '';

    // Form fields — Box
    public string $f_kode_box = '';
    public string $f_nama_box = '';
    public string $f_deskripsi_box = '';

    // Form fields — Dokumen
    public string  $f_judul            = '';
    public string  $f_nomor_dokumen    = '';
    public string  $f_kode_dokumen     = '';
    public string  $f_perihal          = '';
    public string  $f_tanggal          = '';
    public string  $f_deskripsi_dokumen = '';
    public string  $f_catatan          = '';
    public ?int    $f_jenis_dokumen_id  = null;
    public ?string $f_file_path        = null;

    // Delete confirm
    public bool   $showDeleteModal = false;
    public ?int   $deletingId      = null;
    public string $deletingLabel   = '';

    // ── Breadcrumb ───────────────────────────────────────────────────────────

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
                'label'     => $lokasi?->nama_lokasi ?? 'Lokasi',
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
        $this->closeModal();
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

    // ── Stats per level ───────────────────────────────────────────────────────

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
                ['label' => 'Lokasi dalam Ruangan', 'value' => Lokasi::where('ruangan_id', $this->ruanganId)->count(), 'icon' => 'heroicon-o-map-pin', 'color' => 'purple'],
                ['label' => 'Total Rak',    'value' => Rak::whereHas('Lokasi', fn($q) => $q->where('ruangan_id', $this->ruanganId))->count(), 'icon' => 'heroicon-o-building-office-2', 'color' => 'green'],
                ['label' => 'Total Box',    'value' => Box::whereHas('rak.Lokasi', fn($q) => $q->where('ruangan_id', $this->ruanganId))->count(), 'icon' => 'heroicon-o-archive-box', 'color' => 'amber'],
            ],
            'rak' => [
                ['label' => 'Rak dalam Lokasi', 'value' => Rak::where('lokasi_id', $this->lokasiId)->count(), 'icon' => 'heroicon-o-building-office-2', 'color' => 'green'],
                ['label' => 'Total Box',     'value' => Box::whereHas('rak', fn($q) => $q->where('lokasi_id', $this->lokasiId))->count(), 'icon' => 'heroicon-o-archive-box', 'color' => 'amber'],
                ['label' => 'Total Dokumen', 'value' => Dokumen::whereHas('box.rak', fn($q) => $q->where('lokasi_id', $this->lokasiId))->count(), 'icon' => 'heroicon-o-document-text', 'color' => 'blue'],
            ],
            'box' => [
                ['label' => 'Box dalam Rak',  'value' => Box::where('rak_id', $this->rakId)->count(),     'icon' => 'heroicon-o-archive-box',  'color' => 'amber'],
                ['label' => 'Total Dokumen',  'value' => Dokumen::whereHas('box', fn($q) => $q->where('rak_id', $this->rakId))->count(), 'icon' => 'heroicon-o-document-text', 'color' => 'blue'],
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

    // ── Modal helpers ─────────────────────────────────────────────────────────

    public function openCreateModal(): void
    {
        $this->resetFormFields();
        $this->modalMode  = 'create';
        $this->editingId  = null;
        $this->showModal  = true;
    }

    public function openEditModal(int $id): void
    {
        $this->resetFormFields();
        $this->modalMode = 'edit';
        $this->editingId = $id;

        match ($this->level) {
            'ruangan' => $this->loadRuangan($id),
            'lokasi'  => $this->loadLokasi($id),
            'rak'     => $this->loadRak($id),
            'box'     => $this->loadBox($id),
            'dokumen' => $this->loadDokumen($id),
            default   => null,
        };

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetFormFields();
    }

    private function resetFormFields(): void
    {
        $this->f_kode_ruangan = '';
        $this->f_nama_ruangan = '';
        $this->f_deskripsi_ruangan = '';

        $this->f_kode_lokasi = '';
        $this->f_nama_lokasi = '';
        $this->f_deskripsi_lokasi = '';

        $this->f_kode_rak = '';
        $this->f_nama_rak = '';
        $this->f_deskripsi_rak = '';

        $this->f_kode_box = '';
        $this->f_nama_box = '';
        $this->f_deskripsi_box = '';

        $this->f_judul             = '';
        $this->f_nomor_dokumen     = '';
        $this->f_kode_dokumen      = '';
        $this->f_perihal           = '';
        $this->f_tanggal           = '';
        $this->f_deskripsi_dokumen = '';
        $this->f_catatan           = '';
        $this->f_jenis_dokumen_id  = null;
        $this->f_file_path         = null;
    }

    // ── Load for edit ─────────────────────────────────────────────────────────

    private function loadRuangan(int $id): void
    {
        $r = Ruangan::findOrFail($id);
        $this->f_kode_ruangan      = $r->kode_ruangan ?? '';
        $this->f_nama_ruangan      = $r->nama_ruangan ?? '';
        $this->f_deskripsi_ruangan = $r->deskripsi    ?? '';
    }

    private function loadLokasi(int $id): void
    {
        $l = Lokasi::findOrFail($id);
        $this->f_kode_lokasi      = $l->kode_lokasi ?? '';
        $this->f_nama_lokasi      = $l->nama_lokasi ?? '';
        $this->f_deskripsi_lokasi = $l->deskripsi   ?? '';
    }

    private function loadRak(int $id): void
    {
        $r = Rak::findOrFail($id);
        $this->f_kode_rak      = $r->kode_rak  ?? '';
        $this->f_nama_rak      = $r->nama_rak  ?? '';
        $this->f_deskripsi_rak = $r->deskripsi ?? '';
    }

    private function loadBox(int $id): void
    {
        $b = Box::findOrFail($id);
        $this->f_kode_box      = $b->kode_box  ?? '';
        $this->f_nama_box      = $b->nama_box  ?? '';
        $this->f_deskripsi_box = $b->deskripsi ?? '';
    }

    private function loadDokumen(int $id): void
    {
        $d = Dokumen::findOrFail($id);
        $this->f_judul             = $d->judul             ?? '';
        $this->f_nomor_dokumen     = $d->nomor_dokumen     ?? '';
        $this->f_kode_dokumen      = $d->kode_dokumen      ?? '';
        $this->f_perihal           = $d->perihal           ?? '';
        $this->f_tanggal           = $d->tanggal?->format('Y-m-d') ?? '';
        $this->f_deskripsi_dokumen = $d->deskripsi_dokumen ?? '';
        $this->f_catatan           = $d->catatan           ?? '';
        $this->f_jenis_dokumen_id  = $d->jenis_dokumen_id;
        $this->f_file_path         = $d->file_path;
    }

    // ── Save (Create / Update) ────────────────────────────────────────────────

    public function save(): void
    {
        match ($this->level) {
            'ruangan' => $this->saveRuangan(),
            'lokasi'  => $this->saveLokasi(),
            'rak'     => $this->saveRak(),
            'box'     => $this->saveBox(),
            'dokumen' => $this->saveDokumen(),
            default   => null,
        };
    }

    private function saveRuangan(): void
    {
        $this->validate([
            'f_kode_ruangan' => 'required|string|max:50',
            'f_nama_ruangan' => 'required|string|max:255',
            'f_deskripsi_ruangan' => 'nullable|string',
        ], [], [
            'f_kode_ruangan' => 'Kode Ruangan',
            'f_nama_ruangan' => 'Nama Ruangan',
        ]);

        $data = [
            'kode_ruangan' => $this->f_kode_ruangan,
            'nama_ruangan' => $this->f_nama_ruangan,
            'deskripsi'    => $this->f_deskripsi_ruangan ?: null,
        ];

        if ($this->modalMode === 'edit') {
            Ruangan::findOrFail($this->editingId)->update($data);
            $msg = 'Ruangan berhasil diperbarui.';
        } else {
            Ruangan::create($data);
            $msg = 'Ruangan berhasil ditambahkan.';
        }

        $this->closeModal();
        Notification::make()->title($msg)->success()->send();
    }

    private function saveLokasi(): void
    {
        $this->validate([
            'f_kode_lokasi' => 'required|string|max:50',
            'f_nama_lokasi' => 'required|string|max:255',
            'f_deskripsi_lokasi' => 'nullable|string',
        ], [], [
            'f_kode_lokasi' => 'Kode Lokasi',
            'f_nama_lokasi' => 'Nama Lokasi',
        ]);

        $data = [
            'kode_lokasi' => $this->f_kode_lokasi,
            'nama_lokasi' => $this->f_nama_lokasi,
            'deskripsi'   => $this->f_deskripsi_lokasi ?: null,
            'ruangan_id'  => $this->ruanganId,
        ];

        if ($this->modalMode === 'edit') {
            Lokasi::findOrFail($this->editingId)->update($data);
            $msg = 'Lokasi berhasil diperbarui.';
        } else {
            Lokasi::create($data);
            $msg = 'Lokasi berhasil ditambahkan.';
        }

        $this->closeModal();
        Notification::make()->title($msg)->success()->send();
    }

    private function saveRak(): void
    {
        $this->validate([
            'f_kode_rak' => 'required|string|max:50',
            'f_nama_rak' => 'required|string|max:255',
            'f_deskripsi_rak' => 'nullable|string',
        ], [], [
            'f_kode_rak' => 'Kode Rak',
            'f_nama_rak' => 'Nama Rak',
        ]);

        $data = [
            'kode_rak'  => $this->f_kode_rak,
            'nama_rak'  => $this->f_nama_rak,
            'deskripsi' => $this->f_deskripsi_rak ?: null,
            'lokasi_id' => $this->lokasiId,
        ];

        if ($this->modalMode === 'edit') {
            Rak::findOrFail($this->editingId)->update($data);
            $msg = 'Rak berhasil diperbarui.';
        } else {
            Rak::create($data);
            $msg = 'Rak berhasil ditambahkan.';
        }

        $this->closeModal();
        Notification::make()->title($msg)->success()->send();
    }

    private function saveBox(): void
    {
        $this->validate([
            'f_kode_box' => 'required|string|max:50',
            'f_nama_box' => 'required|string|max:255',
            'f_deskripsi_box' => 'nullable|string',
        ], [], [
            'f_kode_box' => 'Kode Box',
            'f_nama_box' => 'Nama Box',
        ]);

        $data = [
            'kode_box'  => $this->f_kode_box,
            'nama_box'  => $this->f_nama_box,
            'deskripsi' => $this->f_deskripsi_box ?: null,
            'rak_id'    => $this->rakId,
        ];

        if ($this->modalMode === 'edit') {
            Box::findOrFail($this->editingId)->update($data);
            $msg = 'Box berhasil diperbarui.';
        } else {
            Box::create($data);
            $msg = 'Box berhasil ditambahkan.';
        }

        $this->closeModal();
        Notification::make()->title($msg)->success()->send();
    }

    private function saveDokumen(): void
    {
        $this->validate([
            'f_judul'            => 'required|string|max:255',
            'f_nomor_dokumen'    => 'nullable|string|max:100',
            'f_kode_dokumen'     => 'nullable|string|max:100',
            'f_perihal'          => 'nullable|string',
            'f_tanggal'          => 'nullable|date',
            'f_deskripsi_dokumen'=> 'nullable|string',
            'f_catatan'          => 'nullable|string',
            'f_jenis_dokumen_id' => 'nullable|exists:jenis_dokumens,id',
        ], [], [
            'f_judul'         => 'Judul Dokumen',
            'f_nomor_dokumen' => 'Nomor Dokumen',
        ]);

        $data = [
            'judul'             => $this->f_judul,
            'nomor_dokumen'     => $this->f_nomor_dokumen    ?: null,
            'kode_dokumen'      => $this->f_kode_dokumen     ?: null,
            'perihal'           => $this->f_perihal          ?: null,
            'tanggal'           => $this->f_tanggal          ?: null,
            'deskripsi_dokumen' => $this->f_deskripsi_dokumen ?: null,
            'catatan'           => $this->f_catatan          ?: null,
            'jenis_dokumen_id'  => $this->f_jenis_dokumen_id,
            'box_id'            => $this->boxId,
        ];

        if ($this->modalMode === 'edit') {
            Dokumen::findOrFail($this->editingId)->update($data);
            $msg = 'Dokumen berhasil diperbarui.';
        } else {
            Dokumen::create($data);
            $msg = 'Dokumen berhasil ditambahkan.';
        }

        $this->closeModal();
        Notification::make()->title($msg)->success()->send();
    }

    // ── Delete ────────────────────────────────────────────────────────────────

    public function confirmDelete(int $id, string $label): void
    {
        $this->deletingId    = $id;
        $this->deletingLabel = $label;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->deletingId      = null;
        $this->deletingLabel   = '';
        $this->showDeleteModal = false;
    }

    public function executeDelete(): void
    {
        $id = $this->deletingId;

        match ($this->level) {
            'ruangan' => $this->deleteRuangan($id),
            'lokasi'  => $this->deleteLokasi($id),
            'rak'     => $this->deleteRak($id),
            'box'     => $this->deleteBox($id),
            'dokumen' => $this->deleteDokumen($id),
            default   => null,
        };

        $this->cancelDelete();
    }

    private function deleteRuangan(int $id): void
    {
        Ruangan::findOrFail($id)->delete();
        Notification::make()->title('Ruangan berhasil dihapus.')->success()->send();
    }

    private function deleteLokasi(int $id): void
    {
        Lokasi::findOrFail($id)->delete();
        Notification::make()->title('Lokasi berhasil dihapus.')->success()->send();
    }

    private function deleteRak(int $id): void
    {
        Rak::findOrFail($id)->delete();
        Notification::make()->title('Rak berhasil dihapus.')->success()->send();
    }

    private function deleteBox(int $id): void
    {
        $box = Box::findOrFail($id);
        if ($box->qr_code_path) {
            Storage::disk('public')->delete($box->qr_code_path);
        }
        $box->delete();
        Notification::make()->title('Box berhasil dihapus.')->success()->send();
    }

    private function deleteDokumen(int $id): void
    {
        $dok = Dokumen::findOrFail($id);
        if ($dok->file_path) {
            Storage::disk('public')->delete($dok->file_path);
        }
        $dok->delete();
        Notification::make()->title('Dokumen berhasil dihapus.')->success()->send();
    }

    // ── Helpers for view ──────────────────────────────────────────────────────

    public function getJenisDokumenOptionsProperty(): array
    {
        return JenisDokumen::orderBy('nama_jenis_dokumen')->pluck('nama_jenis_dokumen', 'id')->toArray();
    }

    public function getModalTitleProperty(): string
    {
        $action = $this->modalMode === 'create' ? 'Tambah' : 'Edit';
        return match ($this->level) {
            'ruangan' => "$action Ruangan",
            'lokasi'  => "$action Lokasi",
            'rak'     => "$action Rak",
            'box'     => "$action Box",
            'dokumen' => "$action Dokumen",
            default   => $action,
        };
    }
}