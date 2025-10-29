<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações do produto')
                    ->columns(12)
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(6),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->helperText('Se deixar em branco, será gerado automaticamente a partir do título.')
                            ->maxLength(255)
                            ->columnSpan(6),
                        Textarea::make('description')
                            ->label('Descrição')
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ]),
                Section::make('Valores e estoque')
                    ->columns(12)
                    ->schema([
                        TextInput::make('price_cents')
                            ->label('Preço (centavos)')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->helperText('Informe o valor base em centavos. Ex.: 5000 corresponde a R$ 50,00.')
                            ->columnSpan(4),
                        TextInput::make('min_cents')
                            ->label('Valor mínimo (centavos)')
                            ->numeric()
                            ->minValue(0)
                            ->helperText('Opcional — usado para valores livres.')
                            ->columnSpan(4),
                        TextInput::make('max_cents')
                            ->label('Valor máximo (centavos)')
                            ->numeric()
                            ->minValue(0)
                            ->helperText('Opcional — limite máximo para valores livres.')
                            ->columnSpan(4),
                        TextInput::make('stock')
                            ->label('Estoque simbólico')
                            ->numeric()
                            ->minValue(0)
                            ->helperText('Deixe em branco para estoque ilimitado.')
                            ->columnSpan(4),
                        TextInput::make('sort')
                            ->label('Ordem de exibição')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->minValue(0)
                            ->helperText('Quanto menor o número, mais alto o item aparece na lista.')
                            ->columnSpan(4),
                        Toggle::make('active')
                            ->label('Produto ativo')
                            ->default(true)
                            ->inline(false)
                            ->helperText('Itens inativos não aparecem na lista pública.')
                            ->columnSpan(4),
                    ]),
                Section::make('Mídia')
                    ->columns(12)
                    ->schema([
                        FileUpload::make('cover_image')
                            ->label('Imagem de capa')
                            ->image()
                            ->directory('products')
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('4:3')
                            ->helperText('Utilize imagens horizontais (mínimo 1200x900).')
                            ->columnSpan(6),
                    ]),
            ]);
    }
}
