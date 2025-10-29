<?php

namespace App\Filament\Admin\Resources\Guests\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class GuestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dados do convidado')
                    ->columns(12)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(6),
                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(6),
                        TextInput::make('phone')
                            ->label('Telefone')
                            ->tel()
                            ->maxLength(20)
                            ->columnSpan(4),
                        TextInput::make('household_id')
                            ->label('Família / Household')
                            ->numeric()
                            ->minValue(0)
                            ->helperText('Use o mesmo número para agrupar convidados da mesma família.')
                            ->columnSpan(4),
                        TextInput::make('invite_code')
                            ->label('Código do convite')
                            ->maxLength(8)
                            ->helperText('Deixe em branco para gerar automaticamente.')
                            ->columnSpan(4),
                    ]),
                Section::make('RSVP e acompanhantes')
                    ->columns(12)
                    ->schema([
                        Select::make('rsvp_status')
                            ->label('Status RSVP')
                            ->options([
                                'pending' => 'Pendente',
                                'confirmed' => 'Confirmado',
                                'declined' => 'Não irá',
                            ])
                            ->default('pending')
                            ->native(false)
                            ->columnSpan(4),
                        TextInput::make('companions_allowed')
                            ->label('Acompanhantes permitidos')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->columnSpan(4),
                        TextInput::make('companions_confirmed')
                            ->label('Acompanhantes confirmados')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->columnSpan(4),
                        Textarea::make('notes')
                            ->label('Observações')
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
