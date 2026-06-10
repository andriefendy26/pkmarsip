<?php

namespace App\Filament\Resources\Dokumens\Tables;

use Filament\Actions\BulkActionGroup as ActionsBulkActionGroup;
use Filament\Actions\DeleteAction as ActionsDeleteAction;
use Filament\Actions\DeleteBulkAction as ActionsDeleteBulkAction;
use Filament\Actions\EditAction as ActionsEditAction;
use Filament\Actions\ViewAction as ActionsViewAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\TextInput;
// use Joaopaulolndev\FilamentPdfViewer\Infolists\Components\PdfViewerEntry;

class DokumensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor_dokumen')
                    ->label('Nomor Dokumen')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->copyable()
                    ->copyMessage('Nomor dokumen berhasil disalin')
                    ->tooltip('Klik untuk menyalin'),

                TextColumn::make('judul')
                    ->label('Judul Dokumen')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50)
                    ->description(fn ($record) => 'Dibuat : ' . $record->created_at->format('d M Y H:i')),
                    // ->description(fn ($record) => 'Dibuat : '. $record->jenisDokumen->nama_jenis_dokumen),

                // TextColumn::make('kode_dokumen')
                //     ->label('Kode')
                //     ->searchable()
                //     ->sortable()
                //     ->badge()
                //     ->color('info'),

                TextColumn::make('jenisDokumen.nama_jenis_dokumen')
                    ->label('Jenis Dokumen')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('user.name')
                    ->label('Dibuat Oleh')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('tanggal')
                    ->label('Tanggal Dokumen')
                    ->alignCenter()
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-o-calendar'),

                // TextColumn::make('file_path')
                //     ->label('File')
                //     ->formatStateUsing(fn () => 'Lihat PDF')
                //     ->url(fn ($record) => asset('storage/' . $record->file_path))
                //     ->openUrlInNewTab()
                //     ->icon('heroicon-o-document')
                //     ->color('primary')
                //     ->weight(FontWeight::SemiBold),

                // PdfViewerEntry::make('file_path')
                //     ->label('View the PDF')
                //     ->minHeight('40svh'),

                // TextColumn::make('created_at')
                //     ->label('Dibuat Pada')
                //     ->dateTime('d M Y H:i')
                //     ->sortable(),
                    // ->toggleable(isToggledHiddenByDefault: false),

                // TextColumn::make('updated_at')
                //     ->label('Diperbarui Pada')
                //     ->dateTime('d M Y H:i')
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true)
                //     ->since()
                //     ->tooltip(fn ($record) => $record->updated_at->format('d M Y H:i:s')),
            ])
            ->filters([
                SelectFilter::make('jenis_dokumen_id')
                    ->label('Jenis Dokumen')
                    ->relationship('jenisDokumen', 'nama_jenis_dokumen')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('user_id')
                    ->label('Dibuat Oleh')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ActionsViewAction::make()
                    ->label('Lokasi Dokumen')
                    ->icon('heroicon-o-eye')
                    ->schema([
                        Section::make('Informasi Lokasi')
                            ->schema([ 
                                TextEntry::make('box.nama_box')
                                    ->label('Box')
                                    ->default('-'), // untuk menghindari null
                                TextEntry::make('box.rak.nama_rak')
                                    ->label('Rak')
                                    ->default('-'),
                                TextEntry::make('box.rak.Lokasi.nama_lokasi')
                                    ->label('Lemari')
                                    ->default('-'),
                                TextEntry::make('lokasi.rak.box.lokasi.ruangan.nama_ruangan')
                                    ->label('Ruangan')
                                    ->default('-'),])
                                    ->columns(2),
                        Section::make('QR Code Box')
                            ->schema([
                                ImageEntry::make('box.qr_code_path')
                                    ->label('QR Code')
                                    ->getStateUsing(fn ($record) => $record->box ? $record->box->qr_code_url : null)
                                    ->height(150)
                                    ->width(150)
                                    ->circular(false)
                                    ->default(null),
                            ])
                            ->columns(1),
                    ])
                    // ->modalHeading(fn ($record) => 'Preview: ' . $record->judul)
                    // ->modalContent(fn ($record) => view('filament.pdf-preview', [
                    //     'url' => $record->file_path ? asset('storage/' . $record->file_path) : null
                    // ]))
                    // ->modalWidth('7xl')
                    // ->modal()
                    , 
                ActionsEditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil'),
                ActionsDeleteAction::make()
                    ->label('Hapus')
                    ->icon('heroicon-o-trash'),
            ])
            ->toolbarActions([
                ActionsBulkActionGroup::make([
                    ActionsDeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->poll('30s'); // Auto refresh setiap 30 detik (opsional)
    }
}