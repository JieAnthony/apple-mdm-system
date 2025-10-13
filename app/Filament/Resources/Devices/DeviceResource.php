<?php

namespace App\Filament\Resources\Devices;


use App\Filament\Resources\Devices\Pages\ListDevices;
use App\Filament\Resources\Devices\Pages\ManagerDeviceInstalledApplications;
use App\Filament\Resources\Devices\Pages\ManagerDeviceLogs;
use App\Filament\Resources\Devices\Pages\ViewDevice;
use App\Filament\Resources\Devices\Schemas\DeviceInfolist;
use App\Filament\Resources\Devices\Tables\DevicesTable;
use App\Models\Device;
use BackedEnum;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'device';

    public static function getLabel(): ?string
    {
        return '设备';
    }

    public static function getNavigationLabel(): string
    {
        return '设备';
    }

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function infolist(Schema $schema): Schema
    {
        return DeviceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DevicesTable::configure($table);
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
            'index' => ListDevices::route('/'),
            'view' => ViewDevice::route('/{record}'),
            'logs' => ManagerDeviceLogs::route('/{record}/logs'),
            'installed-applications' => ManagerDeviceInstalledApplications::route('/{record}/installed-applications'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewDevice::class,
            ManagerDeviceLogs::class,
            ManagerDeviceInstalledApplications::class,
        ]);
    }

}
