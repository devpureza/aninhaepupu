<?php

namespace App\Filament\Admin\Resources\Payments\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order.code')
                    ->label('Pedido')
                    ->sortable(),
                TextColumn::make('gateway')
                    ->label('Gateway')
                    ->sortable(),
                TextColumn::make('method')
                    ->label('Método')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'pix' => 'Pix',
                        'card' => 'Cartão',
                        'boleto' => 'Boleto',
                        default => $state,
                    })
                    ->color(fn (?string $state) => match ($state) {
                        'pix' => 'success',
                        'card' => 'primary',
                        'boleto' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('installments')
                    ->label('Parcelas')
                    ->formatStateUsing(fn (?int $state) => $state ? "{$state}x" : '—'),
                TextColumn::make('gateway_charge_id')
                    ->label('ID Cobrança')
                    ->wrap()
                    ->copyable()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (?string $state) => match ($state) {
                        'paid' => 'success',
                        'processing', 'pending' => 'warning',
                        'failed', 'refunded' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('paid_at')
                    ->label('Pago em')
                    ->dateTime('d/m/Y H:i')
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
