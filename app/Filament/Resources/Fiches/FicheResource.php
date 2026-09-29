<?php

namespace App\Filament\Resources\Fiches;

use App\Filament\Resources\Fiches\Pages\CreateFiche;
use App\Filament\Resources\Fiches\Pages\EditFiche;
use App\Filament\Resources\Fiches\Pages\ListFiches;
use App\Filament\Resources\Fiches\Pages\ViewFiche;
use App\Filament\Resources\Fiches\Schemas\FicheForm;
use App\Filament\Resources\Fiches\Schemas\FicheInfolist;
use App\Filament\Resources\Fiches\Tables\FichesTable;
use App\Models\Fiche;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FicheResource extends Resource
{
    protected static ?string $model = Fiche::class;

    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

protected static ?string $navigationLabel = 'Fiches';

protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'Fiche';

    public static function form(Schema $schema): Schema
    {
        return FicheForm::configure($schema);
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

    public static function infolist(Schema $schema): Schema
    {
        return FicheInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FichesTable::configure($table);
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
        'index' => Pages\ListFiches::route('/'),
        'create' => Pages\CreateFiche::route('/create'),
        'search' => Pages\RechercheFiche::route('/rechercher-une-fiche'),
        'export' => Pages\ExportFiches::route('/exporter-les-fiches'),
        'view' => Pages\ViewFiche::route('/{record}'),
        'edit' => Pages\EditFiche::route('/{record}/edit'),
    ];
}


public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery();

    if (auth()->user()?->role === 'CC') {
        $query->where('user_id', auth()->id());
    }

    return $query;
}


}
