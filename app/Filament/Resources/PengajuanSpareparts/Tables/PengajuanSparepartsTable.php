<?php

namespace App\Filament\Resources\PengajuanSpareparts\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Collection;
use App\Models\SuratJalan;
use App\Models\SuratJalanDetail;
use App\Models\PengajuanSparepart;

class PengajuanSparepartsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),

                TextColumn::make('user.name')
                    ->label('Workshop')
                    ->searchable(),

                TextColumn::make('sparepart.nama_sparepart')
                    ->label('Sparepart')
                    ->searchable()
                    ->wrap()
                    ->formatStateUsing(function ($state, $record) {
                        $jenisUnit = is_array($record->sparepart->jenis_unit)
                            ? collect($record->sparepart->jenis_unit)->pluck('value')->implode(' / ')
                            : $record->sparepart->jenis_unit;

                        $numberPart = is_array($record->sparepart->number_part)
                            ? collect($record->sparepart->number_part)->pluck('value')->implode(' / ')
                            : $record->sparepart->number_part;

                        return $record->sparepart->nama_sparepart . ' / ' . ($jenisUnit ?: '-') . ' / ' . ($numberPart ?: '-');
                    }),

                TextColumn::make('requested_quantity')
                    ->label('Qty Permintaan')
                    ->badge()
                    ->visible(fn() => auth()->user()->hasAnyRole(['manager', 'kepala gudang', 'workshop'])),

                TextColumn::make('approved_quantity')
                    ->label('Qty Disetujui')
                    ->badge()
                    ->default('-')
                    ->color(fn($state) => filled($state) ? 'success' : 'gray'),

                TextColumn::make('approver.name')
                    ->label('Approved by')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('foto')
                    ->label('Foto')
                    ->disk('public')
                    ->stacked()
                    ->circular()
                    ->limit(3)
                    ->visible(fn() => auth()->user()->hasAnyRole(['manager', 'kepala gudang', 'workshop']))
                    ->action(
                        Action::make('previewFoto')
                            ->modalHeading('Preview Foto Kerusakan')
                            ->modalWidth('5xl')
                            ->modalSubmitAction(false)
                            ->modalCancelActionLabel('Tutup')
                            ->modalContent(function ($record) {
                                $images = collect($record->foto)->map(function ($image) {
                                    $url = asset('storage/' . $image);
                                    return "
                                        <div style='overflow:hidden; border-radius:16px; box-shadow:0 2px 10px rgba(0,0,0,.1);'>
                                            <img src='{$url}' style='width:100%; height:250px; object-fit:cover; display:block;'>
                                        </div>
                                    ";
                                })->implode('');

                                return new HtmlString("
                                    <div style='display:grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap:16px;'>
                                        {$images}
                                    </div>
                                ");
                            })
                    ),

                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->icon('heroicon-o-exclamation-triangle')
                    ->iconColor('warning')
                    ->badge()
                    ->color('warning')
                    ->wrap()
                    ->limit(40)
                    ->tooltip(fn($state) => $state)
                    ->visible(fn() => auth()->user()->hasAnyRole(['manager', 'kepala gudang', 'workshop'])),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'menunggu' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make()
                    ->visible(fn() => auth()->user()->hasRole('workshop')),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Setuju')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->modalWidth('md')
                    ->authorize(fn() => auth()->user()->can('approve', PengajuanSparepart::class))
                    ->visible(fn($record) => $record->status === 'menunggu' && auth()->user()->can('approve', PengajuanSparepart::class))
                    ->form([
                        TextInput::make('approved_quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->required()
                            ->minValue(1),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'approved_quantity' => $data['approved_quantity'],
                            'status' => 'disetujui',
                            'approved_by' => Auth::id(),
                            'approved_at' => now(),
                        ]);
                    }),

                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalWidth('md')
                    ->modalHeading('Tolak Pengajuan?')
                    ->modalDescription('Yakin ingin menolak pengajuan ini?')
                    ->modalSubmitActionLabel('Tolak')
                    ->modalCancelActionLabel('Batal')
                    ->authorize(fn() => auth()->user()->can('reject', PengajuanSparepart::class))
                    ->visible(fn($record) => $record->status === 'menunggu' && auth()->user()->can('reject', PengajuanSparepart::class))
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'ditolak',
                            'approved_by' => Auth::id(),
                            'approved_at' => now(),
                        ]);
                    })
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('buatSuratJalan')
                        ->label('Buat Surat Jalan')
                        ->icon('heroicon-o-document-text')
                        ->color('success')
                        ->form([
                            DatePicker::make('tanggal')
                                ->required()
                                ->default(now()),
                            Textarea::make('keterangan')
                                ->rows(3),
                        ])
                        ->action(function (Collection $records, array $data) {
                            if ($records->pluck('user_id')->unique()->count() > 1) {
                                Notification::make()->title('Surat Jalan Hanya Untuk Workshop Yang sama')->danger()->send();
                                return;
                            }

                            if ($records->contains(fn($record) => $record->status !== 'disetujui')) {
                                Notification::make()->title('Semua Pengajuan Harus Disetujui Terlebih Dahulu')->danger()->send();
                                return;
                            }

                            if ($records->contains(fn($record) => $record->surat_jalan_id)) {
                                Notification::make()->title('Ada pengajuan yang sudah memiliki surat jalan')->danger()->send();
                                return;
                            }

                            $tahun = now()->year;
                            $last = SuratJalan::count() + 1;
                            $nomorSurat = 'SJ-' . $tahun . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);

                            $suratJalan = SuratJalan::create([
                                'nomor_surat' => $nomorSurat,
                                'tanggal' => $data['tanggal'],
                                'user_id' => $records->first()->user_id,
                                'admin_id' => auth()->id(),
                                'status' => 'draft',
                                'keterangan' => $data['keterangan'],
                            ]);

                            foreach ($records as $record) {
                                SuratJalanDetail::create([
                                    'surat_jalan_id' => $suratJalan->id,
                                    'pengajuan_sparepart_id' => $record->id,
                                    'sparepart_id' => $record->sparepart_id,
                                    'quantity' => $record->approved_quantity,
                                ]);

                                $record->update([
                                    'surat_jalan_id' => $suratJalan->id,
                                ]);
                            }

                            Notification::make()->title('Surat Jalan berhasil dibuat')->success()->send();
                        })
                        ->authorize(fn() => auth()->user()->hasRole('admin')),

                    // GANTI DeleteBulkAction MENJADI BULKACTION KUSTOM INI
                    BulkAction::make('deleteSelected')
                        ->label('Hapus Terpilih')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Data Terpilih?')
                        ->modalDescription('Data yang sudah memiliki Surat Jalan tidak akan ikut terhapus.')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->modalCancelActionLabel('Batal')
                        ->authorize(fn() => auth()->user()->can('deleteAny', \App\Models\PengajuanSparepart::class))
                        ->action(function (Collection $records) {
                            $terhapus = 0;
                            $gagal = 0;

                            foreach ($records as $record) {
                                // PERBAIKAN DI SINI: Tambahkan pengecekan status === 'menunggu'
                                if (
                                    $record->status === 'menunggu' &&
                                    $record->surat_jalan_id === null &&
                                    auth()->user()->can('delete', $record)
                                ) {
                                    $record->delete();
                                    $terhapus++;
                                } else {
                                    $gagal++;
                                }
                            }

                            if ($terhapus > 0) {
                                Notification::make()
                                    ->title("$terhapus data berhasil dihapus.")
                                    ->success()
                                    ->send();
                            }

                            if ($gagal > 0) {
                                Notification::make()
                                    ->title("$gagal data gagal dihapus karena sudah memiliki Surat Jalan / status disetujui.")
                                    ->warning()
                                    ->send();
                            }
                        }),

                    ForceDeleteBulkAction::make()
                        ->authorize(fn() => auth()->user()->can('forceDeleteAny', PengajuanSparepart::class)),
                    RestoreBulkAction::make()
                        ->authorize(fn() => auth()->user()->can('restoreAny', PengajuanSparepart::class)),
                ]),
            ]);
    }
}
