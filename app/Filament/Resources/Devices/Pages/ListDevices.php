<?php

namespace App\Filament\Resources\Devices\Pages;

use App\Filament\Resources\Devices\DeviceResource;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;

class ListDevices extends ListRecords
{
    protected static string $resource = DeviceResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('create')
                ->label('添加设备')
                ->color('info')
                ->modalDescription('请确认设备已存在ABM中后再进行添加！')
                ->requiresConfirmation()
                ->schema([
                    TextInput::make('serial_number')
                        ->placeholder('请填写序列号')
                        ->required()
                        ->label('序列号'),
                ])
                ->action(function () {})
                ->successNotificationTitle('指令已下发1122334'),
        ];
    }
}
