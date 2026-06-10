<?php

namespace App\Filament\Resources\Dokumens\Schemas;

use App\Models\Box;
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
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class DokumenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(
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
                    ->relationship(
                        name: 'jenisDokumen',
                        titleAttribute: 'nama_jenis_dokumen'
                    )
                    // ->options(JenisDokumen::pluck('nama_jenis_dokumen', 'id'))
                    ->createOptionForm([
                        TextInput::make('nama_jenis_dokumen')
                            ->label('Nama Jenis Dokumen')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        // Textarea::make('deskripsi')
                        //     ->label('Deskripsi Jenis Dokumen')
                        //     ->rows(3)
                        //     ->columnSpanFull(),
                        TextInput::make('priode_retensi')
                            ->label('Priode Retensi (tahun)')
                            ->numeric()
                            ->required(),
                        Select::make('tindakan')
                            ->label('Tindakan')
                            ->options([
                                'arsipkan' => 'Arsipkan',
                                'musnahkan' => 'Musnahkan',
                                'kembalikan' => 'Kembalikan',
                            ])
                            ->required(),
                        // Textarea::make('keterangan')
                        //     ->label('Keterangan Tindakan')
                        //     ->rows(3)
                        //     ->columnSpanFull(),
                    ])
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
                Select::make('box_id')
                    ->label('Box')
                    ->options(Box::pluck('kode_box', 'id'))
                    // ->relationship('box', 'nama_box')
                    ->createOptionForm([
                        Select::make('rak_id')
                            ->label('Rak')
                            ->options(Rak::pluck('nama_rak', 'id'))
                            ->required()
                            ->searchable(),
                        TextInput::make('kode_box')
                            ->label('Kode Box')
                            ->required()
                            ->maxLength(50),
                        TextInput::make('nama_box')
                            ->label('Nama Box')
                            ->required()
                            ->maxLength(100),
                        Textarea::make('deskripsi')
                            ->label('Deskripsi Box')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    // ->required()
                    ->searchable(),

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

                // FileUpload::make('file_path')
                //     ->label('File Dokumen')
                //     ->directory('dokumen')
                //     ->preserveFilenames()
                //     ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                //     ->maxSize(10240),
                FileUpload::make('file_path')
                    ->label('File Dokumen')
                    ->disk('public')
                    ->directory('ArsipFiles')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(10240)
                    ->required()
                    ->columnSpanFull(),

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
            ]);
    }
}
