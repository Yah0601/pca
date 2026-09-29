<?php

namespace App\Filament\Resources\Motifs;

use App\Filament\Resources\Motifs\Pages\CreateMotif;
use App\Filament\Resources\Motifs\Pages\EditMotif;
use App\Filament\Resources\Motifs\Pages\ListMotifs;
use App\Filament\Resources\Motifs\Pages\ViewMotif;
use App\Filament\Resources\Motifs\Schemas\MotifForm;
use App\Filament\Resources\Motifs\Schemas\MotifInfolist;
use App\Filament\Resources\Motifs\Tables\MotifsTable;
use App\Models\Motif;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MotifResource extends Resource
{
    protected static ?string $model = Motif::class;

//protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

protected static ?string $navigationLabel = 'Motifs CRM';

protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'Motif';

    public static function form(Schema $schema): Schema
    {
        return MotifForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MotifInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MotifsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function shouldRegisterNavigation(): bool
{
    return in_array(auth()->user()?->role, [
        'Superviseur',
        'Chef de production',
        'RO',
        'Super Admin',
    ]);
}

public static function getNavigationGroup(): ?string
{
    return 'Administrer';
}

    public static function getPages(): array
    {
        return [
            'index' => ListMotifs::route('/'),
            'create' => CreateMotif::route('/create'),
            'view' => ViewMotif::route('/{record}'),
            'edit' => EditMotif::route('/{record}/edit'),
        ];
    }
}
