<?php

namespace App\Filament\Resources\Devices\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DeviceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Flex::make([
                            Grid::make(3)
                                ->schema([
                                    TextEntry::make('name')->label('设备'),
                                    TextEntry::make('serial_number')->label('序列号'),
                                    TextEntry::make('udid')->label('UDID'),
                                ])
                        ])
                    ]),
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Flex::make([
                            Grid::make(4)
                                ->schema([
                                    IconEntry::make('in_abm')
                                        ->label('ABM')
                                        ->boolean(),
                                    IconEntry::make('supervision')
                                        ->label('受监管')
                                        ->boolean(),
                                    IconEntry::make('activation_lock')
                                        ->label('激活锁')
                                        ->boolean(),
                                    IconEntry::make('lost_mode')
                                        ->label('丢失模式')
                                        ->boolean(),
                                ])
                        ])
                    ]),
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Flex::make([
                            Grid::make(3)
                                ->schema([
                                    TextEntry::make('last_active_at')->label('最后活跃时间'),
                                    TextEntry::make('registered_at')->label('注册时间'),
                                ])
                        ])
                    ]),
            ]);
    }
}
