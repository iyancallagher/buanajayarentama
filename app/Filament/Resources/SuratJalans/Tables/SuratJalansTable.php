<?php

namespace App\Filament\Resources\SuratJalans\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Support\HtmlString;

class SuratJalansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                TextColumn::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->searchable()
                    ->copyable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('workshop.name')
                    ->label('Workshop')
                    ->searchable()
                    ->icon('heroicon-o-building-storefront'),

                TextColumn::make('details_count')
                    ->counts('details')
                    ->label('Jumlah Item')
                    ->badge()
                    ->color('info'),

                TextColumn::make('status')
                    ->badge()
                    ->color(
                        fn(string $state) => match ($state) {
                            'draft' => 'gray',
                            'dikirim' => 'warning',
                            'diterima' => 'success',
                            default => 'gray',
                        }
                    ),

                TextColumn::make('tanggal')
                    ->date()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('admin.name')
                    ->label('Admin')
                    ->badge()
                    ->color('info'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('detail')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading('Detail Surat Jalan')
                    ->modalWidth('7xl')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(function ($record) {
                        $cards = '';
                        foreach ($record->details as $detail) {
                            $sparepart = $detail->sparepart;
                            $jenisUnit = is_array($sparepart->jenis_unit)
                                ? collect($sparepart->jenis_unit)
                                ->pluck('value')
                                ->implode(' / ')
                                : ($sparepart->jenis_unit ?? '-');

                            $numberPart = is_array($sparepart->number_part)
                                ? collect($sparepart->number_part)
                                ->pluck('value')
                                ->implode(' / ')
                                : ($sparepart->number_part ?? '-');

                            $info = $sparepart->nama_sparepart . ' / ' . $jenisUnit . ' / ' . $numberPart;

                            $cards .= "
                            <div
                                style='
                                    background:white;
                                    border:1px solid #e5e7eb;
                                    border-left:5px solid #3b82f6;
                                    border-radius:16px;
                                    padding:18px;
                                    box-shadow: 0 4px 12px rgba(0,0,0,.06);
                                    transition:.2s;'>
                                    <div
                                        style='
                                            font-size:15px;
                                            font-weight:700;
                                            color:#111827;
                                            margin-bottom:12px;
                                            line-height:1.6;
                                        '
                                    >
                                    🔧 {$info}
                                    </div>
                                    <div
                                        style='
                                            display:flex;
                                            align-items:center;
                                            justify-content:space-between;
                                        '
                                    >
                                        <span style='color:#6b7280; font-size:13px;'>
                                            Quantity Dikirim
                                        </span>
                                        <span
                                            style='
                                                background:#dcfce7;
                                                color:#166534;
                                                padding:6px 14px;
                                                border-radius:999px;
                                                font-weight:700;
                                                font-size:14px;
                                            '
                                        >
                                            {$detail->quantity}
                                        </span>
                                    </div>
                            </div>
                            ";
                        }

                        $statusColor = match ($record->status) {
                            'draft' => '#6b7280',
                            'dikirim' => '#f59e0b',
                            'diterima' => '#16a34a',
                            default => '#6b7280',
                        };

                        return new HtmlString("
                        <div style='display:flex; flex-direction:column; gap:18px;'>
                            <div
                                style='
                                    background: linear-gradient(135deg, #2563eb, #1d4ed8);
                                    color:white;
                                    border-radius:18px;
                                    padding:24px;
                                    box-shadow: 0 10px 20px rgba(37, 235, .25);
                                '
                            >
                                <div style='font-size:22px; font-weight:700; margin-bottom:10px;'>
                                    📄 {$record->nomor_surat}
                                </div>
                                <div style='display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:14px;'>
                                    <div>
                                        <div style='opacity:.8; font-size:12px;'>WORKSHOP</div>
                                        <div style='font-weight:600;'>{$record->workshop->name}</div>
                                    </div>
                                    <div>
                                        <div style='opacity:.8; font-size:12px;'>TANGGAL</div>
                                        <div style='font-weight:600;'>{$record->tanggal->format('d M Y')}</div>
                                    </div>
                                    <div>
                                        <div style='opacity:.8; font-size:12px;'>STATUS</div>
                                        <div
                                            style='
                                                font-weight:700;
                                                color: {$statusColor};
                                                background:white;
                                                display:inline-block;
                                                padding:6px 12px;
                                                border-radius:999px;
                                            '
                                        >
                                            " . strtoupper($record->status) . "
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style='display:grid; gap:14px;'>
                                {$cards}
                            </div>
                        </div>
                        ");
                    }),

                Action::make('kirim')
                    ->label('Kirim')
                    ->icon('heroicon-o-truck')
                    ->color('warning')
                    ->visible(fn($record) => $record->status === 'draft')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'dikirim',
                        ]);
                    }),

                Action::make('terima')
                    ->label('Konfirmasi Terima')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(function ($record) {
                        return $record->status === 'dikirim'
                            && auth()->user()?->hasRole('workshop');
                    })
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        abort_unless(
                            auth()->user()?->hasRole('workshop'),
                            403
                        );
                        $record->update([
                            'status' => 'diterima',
                        ]);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
