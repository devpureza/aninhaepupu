<?php

namespace App\Filament\Admin\Resources\Messages\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

class MessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order.code')
                    ->label('Pedido')
                    ->sortable(),
                TextColumn::make('guest_name')
                    ->label('Convidado')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('content')
                    ->label('Mensagem')
                    ->limit(60)
                    ->tooltip(fn (?string $state) => $state)
                    ->searchable(),
                IconColumn::make('is_public')
                    ->label('Pública')
                    ->boolean(),
                IconColumn::make('approved')
                    ->label('Aprovada')
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
