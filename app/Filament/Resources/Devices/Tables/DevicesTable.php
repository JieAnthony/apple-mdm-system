<?php

namespace App\Filament\Resources\Devices\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DevicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('设备'),
                TextColumn::make('serial_number')
                    ->label('序列号')
                    ->searchable(),
                TextColumn::make('registered_at')
                    ->label('注册时间'),
                TextColumn::make('last_active_at')
                    ->label('最后活跃时间'),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
