<?php

namespace App\Filament\Resources\Devices\Pages;

use App\Filament\Resources\Devices\DeviceResource;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ManagerDeviceInstalledApplications extends ManageRelatedRecords
{
    protected static string $resource = DeviceResource::class;

    protected static string $relationship = 'installedApplications';

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-squares-2x2';

    public function getRecordTitle(): string|Htmlable
    {
        /** @var \App\Models\Device */
        $record = $this->getRecord();

        return $record->serial_number;
    }

    public static function getNavigationLabel(): string
    {
        return 'Apps';
    }

    public static function getRelationshipTitle(): string
    {
        return 'Apps';
    }

    public function getTitle(): string|Htmlable
    {
        /** @var \App\Models\Device */
        $record = $this->getRecord();

        return $record->serial_number.' - Apps';
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->select(['id', 'device_id', 'identifier', 'name', 'version'])
                    ->orderByDesc('id');
            })
            ->paginated(false)
            ->columns([
                TextColumn::make('identifier')->label('Identifier'),
                TextColumn::make('name')->label('Name'),
                TextColumn::make('version')->label('版本'),
            ]);

    }
}
