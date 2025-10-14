<?php

namespace App\Filament\Resources\Devices\Tables;

use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DevicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->select(['id', 'serial_number', 'name', 'registered_at', 'last_active_at'])
                    ->orderByDesc('id');
            })
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),
                TextColumn::make('serial_number')
                    ->copyable()
                    ->copyMessage('序列号已复制')
                    ->copyMessageDuration(1500)
                    ->label('序列号'),
                TextColumn::make('name')
                    ->label('设备名')
                    ->wrap(),
                TextColumn::make('registered_at')
                    ->label('注册时间'),
                TextColumn::make('last_active_at')
                    ->label('最后活跃时间'),
            ])
            ->filters([

                Filter::make('id')
                    ->schema([
                        TextInput::make('value')
                            ->numeric()
                            ->label('ID'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['value'], function ($q, $value) {
                            $q->where('id', (int) $value);
                        });
                    })
                    ->indicateUsing(function (array $data): ?string {
                        return $data['value'] ? "ID：{$data['value']}" : null;
                    }),

                Filter::make('serial_number')
                    ->schema([
                        TextInput::make('value')
                            ->label('序列号'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['value'], function ($q, $value) {
                            $q->where('serial_number', $value);
                        });
                    })
                    ->indicateUsing(function (array $data): ?string {
                        return $data['value'] ? "序列号：{$data['value']}" : null;
                    }),

                Filter::make('name')
                    ->schema([
                        TextInput::make('value')
                            ->label('设备名'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['value'], function ($q, $value) {
                            $q->where('name', 'like', "{$value}%");
                        });
                    })
                    ->indicateUsing(function (array $data): ?string {
                        return $data['value'] ? "设备名包含：{$data['value']}" : null;
                    }),

                Filter::make('registered_range')
                    ->schema([
                        DateTimePicker::make('registered_from')->label('注册时间 从'),
                        DateTimePicker::make('registered_until')->label('注册时间 到'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['registered_from'], fn ($q, $value) => $q->where('registered_at', '>=', $value))
                            ->when($data['registered_until'], fn ($q, $value) => $q->where('registered_at', '<=', $value));
                    })
                    ->indicateUsing(function (array $data) {
                        $indicators = [];

                        if (! empty($data['registered_from'])) {
                            $indicators[] = '注册时间 >= '.$data['registered_from'];
                        }
                        if (! empty($data['registered_until'])) {
                            $indicators[] = '注册时间 <= '.$data['registered_until'];
                        }

                        return $indicators ? implode('｜', $indicators) : null;
                    }),

                Filter::make('last_active_range')
                    ->schema([
                        DateTimePicker::make('last_active_from')->label('最后活跃时间 从'),
                        DateTimePicker::make('last_active_until')->label('最后活跃时间 到'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['last_active_from'], fn ($q, $value) => $q->where('last_active_at', '>=', $value))
                            ->when($data['last_active_until'], fn ($q, $value) => $q->where('last_active_at', '<=', $value));
                    })
                    ->indicateUsing(function (array $data) {
                        $indicators = [];

                        if (! empty($data['last_active_from'])) {
                            $indicators[] = '最后活跃时间 >= '.$data['last_active_from'];
                        }
                        if (! empty($data['last_active_until'])) {
                            $indicators[] = '最后活跃时间 <= '.$data['last_active_until'];
                        }

                        return $indicators ? implode('|', $indicators) : null;
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
