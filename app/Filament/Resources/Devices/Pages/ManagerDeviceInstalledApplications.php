<?php

namespace App\Filament\Resources\Devices\Pages;

use App\Filament\Resources\Devices\DeviceResource;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class ManagerDeviceInstalledApplications extends ManageRelatedRecords
{
    protected static string $resource = DeviceResource::class;

    protected static string $relationship = 'installedApplications';

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-squares-2x2';


    public static function getNavigationLabel(): string
    {
        return 'Apps';
    }

    public function getTitle(): string|Htmlable
    {
        /** @var \App\Models\Device */
        $record = $this->getRecord();

        return $record->serial_number . ' - Apps';
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('id','desc')
            ->paginated(false)
            ->columns([
                TextColumn::make('identifier')->label('Identifier'),
                TextColumn::make('name')->label('Name'),
                TextColumn::make('version')->label('版本'),
            ]);

    }
}