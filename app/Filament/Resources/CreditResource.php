<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CreditResource\Pages;
use App\Models\Client;
use App\Models\CreditCardStatement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\SpacedColumns;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\CreditResource\Actions\CheckRisikoCreditAction;
use App\Filament\Resources\CreditResource\Actions\PaymentAction;
use Carbon\Carbon;

class CreditResource extends Resource
{
    protected static ?string $model = CreditCardStatement::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $modelLabel = 'Tagihan Kredit';
    protected static ?string $pluralModelLabel = 'Manajemen Kredit';
    protected static ?string $navigationLabel = 'Manajemen Kredit';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->label('Nasabah')
                    ->options(Client::query()->pluck('name', 'id'))
                    ->searchable()
                    ->placeholder("Nama Nasabah")
                    ->required(),
                Forms\Components\DatePicker::make('bill_date')
                    ->label("Jatuh Tempo")
                    ->required()
                    ->date(),
                Forms\Components\TextInput::make('bill_amt')
                    ->label("Jumlah Tagihan")
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0),
                Forms\Components\TextInput::make('pay_amt')
                    ->label("Jumlah Sudah Bayar")
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Nasabah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bill_amt')
                    ->label("Tagihan")
                    ->prefix('NT$')
                    ->money('TWD')
                    ->numeric(
                        thousandsSeparator: '.',
                        decimalSeparator: ',',
                    ),
                Tables\Columns\TextColumn::make('bill_date')
                    ->label('Jatuh Tempo')
                    ->formatStateUsing(fn($record) => $record->bill_date->format('M d, Y')),
                Tables\Columns\BadgeColumn::make('default_payments')
                    ->label('Risiko Terlambat Bayar')
                    ->getStateUsing(function ($record) {
                        $defaultPayment = $record->predict;
                        if ($defaultPayment && $defaultPayment->default_payment_next_month) {
                            return 'Terlambat';
                        } elseif ($defaultPayment && !$defaultPayment->default_payment_next_month) {
                            return 'Tepat Waktu';
                        } else {
                            return '';
                        }
                    })
                    ->colors([
                        'success' => 'Tepat Waktu',
                        'danger' => 'Terlambat',
                        '' => '',
                    ]),
                BadgeColumn::make('payments.payment_status')
                    ->label('Status Pembayaran')
                    ->default("Belum Bayar")
                    ->getStateUsing(fn($record) => $record->payments?->payment_status)
                    ->formatStateUsing(fn($state) => match ($state) {
                        'completed' => 'Sudah Bayar',
                        default => 'Belum Bayar',
                    })
                    ->colors([
                        'success' => 'completed',
                        'warning' => 'Belum Bayar',
                    ]),
            ])
            ->filters([
                Tables\Filters\Filter::make('bill_date')
                    ->form([
                        Forms\Components\DatePicker::make('bill_date_from')
                            ->label('From')
                            ->default(now()->startOfMonth()),
                        Forms\Components\DatePicker::make('bill_date_to')
                            ->label('To')
                            ->default(now()->endOfMonth()),
                    ])
                    ->query(function ($query, array $data): void {
                        $query->when(
                            $data['bill_date_from'] ?? null,
                            fn($query, $date) => $query->whereDate('bill_date', '>=', $date)
                        )->when(
                            $data['bill_date_to'] ?? null,
                            fn($query, $date) => $query->whereDate('bill_date', '<=', $date)
                        );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['bill_date_from'] ?? null) {
                            $indicators['from'] = 'Bill date from ' . Carbon::parse($data['bill_date_from'])->toFormattedDateString();
                        }

                        if ($data['bill_date_to'] ?? null) {
                            $indicators['to'] = 'Bill date to ' . Carbon::parse($data['bill_date_to'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->defaultSort('bill_date', 'desc')
            ->actions([
                PaymentAction::make(),
                CheckRisikoCreditAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCredits::route('/'),
            'create' => Pages\CreateCredit::route('/create'),
            'edit' => Pages\EditCredit::route('/{record}/edit'),
        ];
    }
}
