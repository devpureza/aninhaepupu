<?php

namespace App\Filament\Admin\Resources\Payments\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dados do pagamento')
                    ->columns(12)
                    ->schema([
                        Select::make('order_id')
                            ->label('Pedido')
                            ->relationship('order', 'code')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->columnSpan(6),
                        TextInput::make('gateway')
                            ->label('Gateway')
                            ->required()
                            ->maxLength(50)
                            ->columnSpan(3),
                        Select::make('method')
                            ->label('Método')
                            ->options([
                                'pix' => 'Pix',
                                'card' => 'Cartão',
                                'boleto' => 'Boleto',
                            ])
                            ->native(false)
                            ->required()
                            ->columnSpan(3),
                        TextInput::make('installments')
                            ->label('Parcelas')
                            ->numeric()
                            ->nullable()
                            ->minValue(1)
                            ->maxValue(12)
                            ->helperText('Preencha apenas para pagamentos no cartão.')
                            ->columnSpan(3),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pendente',
                                'processing' => 'Processando',
                                'paid' => 'Pago',
                                'failed' => 'Falhou',
                                'refunded' => 'Estornado',
                            ])
                            ->required()
                            ->native(false)
                            ->columnSpan(3),
                    ]),
                Section::make('Detalhes adicionais')
                    ->columns(12)
                    ->schema([
                        TextInput::make('gateway_charge_id')
                            ->label('ID da cobrança')
                            ->maxLength(120)
                            ->nullable()
                            ->columnSpan(6),
                        DateTimePicker::make('paid_at')
                            ->label('Pago em')
                            ->seconds(false)
                            ->native(false)
                            ->columnSpan(6),
                        Textarea::make('raw_payload')
                            ->label('Payload bruto do gateway')
                            ->rows(6)
                            ->helperText('Cole a resposta JSON recebida do provedor de pagamento.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
