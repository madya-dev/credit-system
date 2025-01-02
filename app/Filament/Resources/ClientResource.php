<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use App\Models\Education;
use App\Models\Marriage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'Nasabah'; // Singular label
    protected static ?string $pluralModelLabel = 'Nasabah'; // Plural label
    protected static ?string $navigationLabel = 'Manajemen Nasabah'; // Sidebar label
    protected static ?int $navigationSort = 1; // Order in sidebar
    //     public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::count();
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('sex')
                    ->required()
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ]),
                Forms\Components\Select::make('education_id')
                    ->label('Education')
                    ->options(Education::query()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('marriage_id')
                    ->label('Marriage Status')
                    ->options(Marriage::query()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('age')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                Forms\Components\TextInput::make('limit_bal')
                    ->required()
                    ->numeric()
                    ->label('Credit Limit Balance'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('sex'),
                Tables\Columns\TextColumn::make('education.name'),
                Tables\Columns\TextColumn::make('marriage.name'),
                Tables\Columns\TextColumn::make('age'),
                Tables\Columns\TextColumn::make('limit_bal')
                    ->prefix('NT$')
                    ->money('TWD')
                    ->numeric(
                        thousandsSeparator: '.',
                        decimalSeparator: ',',
                    )
                    ->label('Credit Limit'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
