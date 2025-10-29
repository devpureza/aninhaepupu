<?php

namespace App\Filament\Admin\Resources\Orders\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identificação do pedido')
                    ->columns(12)
                    ->schema([
                        TextInput::make('code')
                            ->label('Código')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpan(4),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pendente',
                                'processing' => 'Processando',
                                'paid' => 'Pago',
                                'failed' => 'Falhou',
                                'refunded' => 'Estornado',
                                'cancelled' => 'Cancelado',
                            ])
                            ->required()
                            ->native(false)
                            ->columnSpan(4),
                        TextInput::make('currency')
                            ->label('Moeda')
                            ->maxLength(3)
                            ->default('BRL')
                            ->required()
                            ->columnSpan(4),
                    ]),
                Section::make('Dados do comprador')
                    ->columns(12)
                    ->schema([
                        TextInput::make('buyer_name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(6),
                        TextInput::make('buyer_email')
                            ->label('E-mail')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(6),
                        TextInput::make('buyer_phone')
                            ->label('Telefone')
                            ->tel()
                            ->maxLength(30)
                            ->columnSpan(4),
                        Textarea::make('message')
                            ->label('Recado enviado com o pedido')
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ]),
                Section::make('Valores')
                    ->columns(12)
                    ->schema([
                        TextInput::make('subtotal_cents')
                            ->label('Subtotal (centavos)')
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->columnSpan(4),
                        TextInput::make('fee_cents')
                            ->label('Taxa repassada (centavos)')
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->columnSpan(4),
                        TextInput::make('total_cents')
                            ->label('Total (centavos)')
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->columnSpan(4),
                    ]),
            ]);
    }
}
