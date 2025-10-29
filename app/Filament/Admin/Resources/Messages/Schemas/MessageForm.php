<?php

namespace App\Filament\Admin\Resources\Messages\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class MessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Mensagem para os noivos')
                    ->columns(12)
                    ->schema([
                        Select::make('order_id')
                            ->label('Pedido relacionado')
                            ->relationship('order', 'code')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->helperText('Opcional — vincule a mensagem a um pedido existente.')
                            ->columnSpan(6),
                        TextInput::make('guest_name')
                            ->label('Nome de quem enviou')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(6),
                        Textarea::make('content')
                            ->label('Conteúdo da mensagem')
                            ->rows(5)
                            ->required()
                            ->maxLength(1000)
                            ->columnSpanFull(),
                        Toggle::make('is_public')
                            ->label('Exibir no mural público')
                            ->default(true)
                            ->inline(false)
                            ->columnSpan(3),
                        Toggle::make('approved')
                            ->label('Aprovada para publicação')
                            ->default(true)
                            ->inline(false)
                            ->columnSpan(3),
                    ]),
            ]);
    }
}
