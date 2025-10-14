<?php

namespace App\Filament\Resources\Devices\Pages;

use App\Enums\DeviceLogStateEnum;
use App\Filament\Resources\Devices\DeviceResource;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ManagerDeviceLogs extends ManageRelatedRecords
{
    protected static string $resource = DeviceResource::class;

    protected static string $relationship = 'logs';

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-circle-stack';

    public function getRecordTitle(): string|Htmlable
    {
        /** @var \App\Models\Device */
        $record = $this->getRecord();

        return $record->serial_number;
    }

    public static function getNavigationLabel(): string
    {
        return '日志';
    }

    public static function getRelationshipTitle(): string
    {
        return '日志';
    }

    public function getTitle(): string|Htmlable
    {
        /** @var \App\Models\Device */
        $record = $this->getRecord();

        return $record->serial_number.' - 日志';
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->select(['id', 'device_id', 'state', 'content', 'command_uuid', 'created_at', 'response_at'])
                    ->orderByDesc('id');
            })
            ->columns([
                TextColumn::make('id')->label('日志ID'),
                TextColumn::make('content')->label('内容')->wrap(),
                TextColumn::make('state')
                    ->label('状态')
                    ->formatStateUsing(function (DeviceLogStateEnum $state) {
                        return match ($state) {
                            DeviceLogStateEnum::ACKNOWLEDGED => '已确认',
                            DeviceLogStateEnum::ERROR => '失败',
                            default => '处理中'
                        };
                    })
                    ->color(function (DeviceLogStateEnum $state) {
                        return match ($state) {
                            DeviceLogStateEnum::ACKNOWLEDGED => 'success',
                            DeviceLogStateEnum::ERROR => 'danger',
                            default => 'primary'
                        };
                    }),
                TextColumn::make('created_at')->label('记录时间'),
                TextColumn::make('response_at')->label('响应时间'),
                TextColumn::make('command_uuid')->label('UUID'),
            ])
            ->filters([
                //
            ]);

    }
}
