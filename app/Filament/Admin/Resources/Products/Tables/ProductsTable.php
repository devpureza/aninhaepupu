<?php

namespace App\Filament\Admin\Resources\Products\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price_cents')
                    ->label('Preço')
                    ->formatStateUsing(fn (?int $state) => $state !== null
                        ? 'R$ ' . number_format($state / 100, 2, ',', '.')
                        : null)
                    ->sortable(),
                TextColumn::make('min_cents')
                    ->label('Valor Mínimo')
                    ->formatStateUsing(fn (?int $state) => $state !== null
                        ? 'R$ ' . number_format($state / 100, 2, ',', '.')
                        : '—')
                    ->sortable(),
                TextColumn::make('max_cents')
                    ->label('Valor Máximo')
                    ->formatStateUsing(fn (?int $state) => $state !== null
                        ? 'R$ ' . number_format($state / 100, 2, ',', '.')
                        : '—')
                    ->sortable(),
                TextColumn::make('stock')
                    ->label('Estoque')
                    ->formatStateUsing(fn (?int $state) => $state === null ? 'Ilimitado' : (string) $state)
                    ->sortable(),
                IconColumn::make('active')
                    ->label('Ativo')
                    ->boolean(),
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
