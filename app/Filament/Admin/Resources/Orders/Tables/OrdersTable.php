<?php

namespace App\Filament\Admin\Resources\Orders\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Código')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('buyer_name')
                    ->label('Comprador')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('buyer_email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('subtotal_cents')
                    ->label('Subtotal')
                    ->formatStateUsing(fn (?int $state) => $state !== null
                        ? 'R$ ' . number_format($state / 100, 2, ',', '.')
                        : null)
                    ->sortable()
                    ->alignRight(),
                TextColumn::make('fee_cents')
                    ->label('Taxa')
                    ->formatStateUsing(fn (?int $state) => $state !== null
                        ? 'R$ ' . number_format($state / 100, 2, ',', '.')
                        : null)
                    ->alignRight()
                    ->sortable(),
                TextColumn::make('total_cents')
                    ->label('Total')
                    ->formatStateUsing(fn (?int $state) => $state !== null
                        ? 'R$ ' . number_format($state / 100, 2, ',', '.')
                        : null)
                    ->alignRight()
                    ->sortable(),
                TextColumn::make('currency')
                    ->label('Moeda')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (?string $state) => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'failed', 'refunded', 'cancelled' => 'danger',
                        default => 'gray',
                    })
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
