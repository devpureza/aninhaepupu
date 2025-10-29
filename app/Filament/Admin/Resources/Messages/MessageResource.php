<?php

namespace App\Filament\Admin\Resources\Messages;

use App\Filament\Admin\Resources\Messages\Pages\CreateMessage;
use App\Filament\Admin\Resources\Messages\Pages\EditMessage;
use App\Filament\Admin\Resources\Messages\Pages\ListMessages;
use App\Filament\Admin\Resources\Messages\Schemas\MessageForm;
use App\Filament\Admin\Resources\Messages\Tables\MessagesTable;
use App\Models\Message;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $recordTitleAttribute = 'guest_name';

    protected static ?string $navigationLabel = 'Mensagens';

    public static function form(Schema $schema): Schema
    {
        return MessageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MessagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMessages::route('/'),
            'create' => CreateMessage::route('/create'),
            'edit' => EditMessage::route('/{record}/edit'),
        ];
    }
}
