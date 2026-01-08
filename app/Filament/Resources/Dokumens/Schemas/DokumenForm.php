<?php

namespace App\Filament\Resources\Dokumens\Schemas;

use App\Models\JenisDokumen;
use App\Models\Lokasi;
use App\Models\Rak;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DokumenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('judul')
                    ->label('Judul Dokumen')
                    ->required()
                    ->maxLength(255),

                TextInput::make('nomor_dokumen')
                    ->label('Nomor Dokumen')
                    ->required()
                    ->maxLength(100),

                TextInput::make('kode_dokumen')
                    ->label('Kode Dokumen')
                    ->required()
                    ->maxLength(50),

                Select::make('jenis_dokumen_id')
                    ->label('Jenis Dokumen')
                    ->options(JenisDokumen::pluck('nama_jenis_dokumen', 'id'))
                    ->required()
                    ->searchable(),

                Select::make('lokasi_id')
                    ->label('Lokasi')
                    ->options(Lokasi::pluck('nama_lokasi', 'id'))
                    ->required()
                    ->searchable(),

                Select::make('rak_id')
                    ->label('Rak')
                    ->options(Rak::pluck('nama_rak', 'id'))
                    ->required()
                    ->searchable(),

                Textarea::make('deskripsi_dokumen')
                    ->label('Deskripsi Dokumen')
                    ->columnSpanFull()
                    ->rows(3),

                Textarea::make('perihal')
                    ->label('Perihal')
                    ->columnSpanFull()
                    ->rows(3),

                DatePicker::make('tanggal')
                    ->label('Tanggal Dokumen')
                    ->required(),

                // FileUpload::make('file_path')
                //     ->label('File Dokumen')
                //     ->directory('dokumen')
                //     ->preserveFilenames()
                //     ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                //     ->maxSize(10240),
                FileUpload::make('file_path')
                    ->disk('public')
                    ->directory('ArsipFiles')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(10240)
                    ->required(),

                Textarea::make('catatan')
                    ->label('Catatan')
                    ->columnSpanFull()
                    ->rows(2),

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
            ]);
    }
}
