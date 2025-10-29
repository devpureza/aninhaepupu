<?php

namespace App\Filament\Admin\Resources\Guests\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

class GuestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('companions_allowed')
                    ->label('Acompanhantes Permitidos')
                    ->sortable(),
                TextColumn::make('companions_confirmed')
                    ->label('Acompanhantes Confirmados')
                    ->sortable(),
                TextColumn::make('rsvp_status')
                    ->label('Status RSVP')
                    ->badge()
                    ->color(fn (?string $state) => match ($state) {
                        'confirmed' => 'success',
                        'declined' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('invite_code')
                    ->label('Código Convite')
                    ->copyable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
