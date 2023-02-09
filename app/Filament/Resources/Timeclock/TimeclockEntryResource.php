<?php

namespace App\Filament\Resources\Timeclock;

use App\Filament\Resources\Timeclock\TimeclockEntryResource\Pages;
use App\Filament\Resources\Timeclock\TimeclockEntryResource\RelationManagers;
use App\Models\Timeclock\TimeclockEntry;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TimeclockEntryResource extends Resource
{
    protected static ?string $model = TimeclockEntry::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('timeclock_entry_type_id')
                    ->relationship('entryType', 'name'),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name'),
                Forms\Components\DateTimePicker::make('clock_in_at'),
                Forms\Components\DateTimePicker::make('clock_out_at'),
                Forms\Components\Select::make('approved_by')
                    ->relationship('approvedBy', 'name'),
                Forms\Components\TextInput::make('replaced_by_timeclock_entry_id'),
                Forms\Components\DateTimePicker::make('approved_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('entryType.name'),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('clock_in_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('clock_out_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('clocked_in_time')
                    ->getStateUsing(function (TimeclockEntry $record) {
                        if ($record->clock_in_at && $record->clock_out_at) {
                            return number_format($record->clock_out_at->floatDiffInHours($record->clock_in_at), 2);
                        }
                    })
                    ->extraAttributes(['class' => 'text-center']),
                Tables\Columns\TextColumn::make('approvedBy.name'),
                Tables\Columns\TextColumn::make('approved_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')->relationship('user', 'name'),
                Tables\Filters\TernaryFilter::make('approved_at')
                    ->label('Approved')
                    ->nullable()
                    ->default(false),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTimeclockEntries::route('/'),
        ];
    }    
    
    public static function getRelations(): array
{
    return [
        RelationManagers\TimeclockEntryTypesRelationManager::class,
        // RelationManagers\UsersRelationManager::class,
    ];
}

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
