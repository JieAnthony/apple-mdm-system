<?php

namespace App\Filament\Resources\Devices\Pages;

use App\Filament\Resources\Devices\DeviceResource;
use App\Models\DeviceHasFunctionalRestriction;
use App\Models\FunctionalRestriction;
use App\Services\DeviceService;
use Filament\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class ViewDevice extends ViewRecord
{
    protected static string $resource = DeviceResource::class;

    protected static ?string $navigationLabel = '详情';

    public function getTitle(): string|Htmlable
    {
        /** @var \App\Models\Device */
        $record = $this->getRecord();

        return $record->serial_number.' - 详情';
    }

    public function getRecordTitle(): string|Htmlable
    {
        /** @var \App\Models\Device */
        $record = $this->getRecord();

        return $record->serial_number;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('profile');
    }

    protected function getActions(): array
    {
        /** @var $record \App\Models\Device */
        $record = $this->getRecord();

        $functionalRestrictionItems = [];
        $functionalRestrictionNames = [];
        $functionalRestrictionDefaultIds = [];

        $functionalRestrictions = Cache::remember('functional_restrictions', 86400, function () {
            return FunctionalRestriction::query()
                ->select(['id', 'key', 'name', 'default_value'])
                ->get();
        });

        foreach ($functionalRestrictions as $functionalRestriction) {
            $functionalRestrictionItems[$functionalRestriction->id] = $functionalRestriction->key;
            $functionalRestrictionNames[$functionalRestriction->id] = $functionalRestriction->name;
            if ($functionalRestriction->default_value) {
                $functionalRestrictionDefaultIds[] = $functionalRestriction->id;
            }
        }

        $deviceFunctionalRestrictionTrueIds = [];
        $deviceFunctionalRestrictionFalseIds = [];
        $deviceHasFunctionalRestrictions = DeviceHasFunctionalRestriction::query()
            ->select(['id', 'device_id', 'functional_restriction_id', 'value'])
            ->where('device_id', $record->id)
            ->get();

        foreach ($deviceHasFunctionalRestrictions as $deviceHasFunctionalRestriction) {
            if ($deviceHasFunctionalRestriction->value) {
                $deviceFunctionalRestrictionTrueIds[] = $deviceHasFunctionalRestriction->functional_restriction_id;
            } else {
                $deviceFunctionalRestrictionFalseIds[] = $deviceHasFunctionalRestriction->functional_restriction_id;
            }
        }
        $defaults = array_values(array_diff(array_merge($functionalRestrictionDefaultIds, $deviceFunctionalRestrictionTrueIds), $deviceFunctionalRestrictionFalseIds));

        return [
            Action::make('information')
                ->label('设备信息')
                ->color('info')
                ->button()
                ->modalHeading('获取设备信息')
                ->requiresConfirmation()
                ->action(function (Action $action) use ($record) {
                    try {
                        app(DeviceService::class)->information($record);
                    } catch (\Exception $exception) {
                        $action->failureNotificationTitle($exception->getMessage());
                        $action->failure();
                    }
                })
                ->successNotificationTitle('指令已下发'),

            Action::make('set_functional_restrictions')
                ->label('功能限制')
                ->color('warning')
                ->slideOver()
                ->modalHeading('功能限制')
                ->schema([
                    CheckboxList::make('functional_restrictions_ids')
                        ->label('勾选代表允许')
                        ->required()
                        ->options($functionalRestrictionItems)
                        ->descriptions($functionalRestrictionNames)
                        ->default($defaults)
                        ->columns(),
                ])
                ->action(function (Action $action, array $data) use ($record) {
                    try {
                        app(DeviceService::class)->setFunctionalRestrictions(
                            $record,
                            $data['functional_restrictions_ids'] ?: null
                        );
                    } catch (\Exception $e) {
                        $action->failureNotificationTitle($e->getMessage());
                        $action->failure();
                    }
                })
                ->successNotificationTitle('指令已下发'),

            Action::make('enable_lost_mode')
                ->hidden($record->lost_mode)
                ->label('启用丢失')
                ->color('danger')
                ->schema([
                    TextInput::make('body')
                        ->required()
                        ->minLength(1)
                        ->maxLength(50)
                        ->label('内容'),
                    TextInput::make('phone_number')
                        ->required()
                        ->minLength(1)
                        ->maxLength(50)
                        ->label('联系方式'),
                    TextInput::make('note')
                        ->required()
                        ->minLength(1)
                        ->maxLength(50)
                        ->label('备注'),
                ])
                ->modalDescription('启用丢失模式后设备将被锁定，请确认是否要启用？')
                ->requiresConfirmation()
                ->action(function (Action $action, array $data) use ($record) {
                    try {
                        app(DeviceService::class)->enableLostMode(
                            $record,
                            $data['body'],
                            $data['phone_number'],
                            $data['note']
                        );
                    } catch (\Exception $exception) {
                        $action->failureNotificationTitle($exception->getMessage());
                        $action->failure();
                    }
                })
                ->successNotificationTitle('指令已下发'),

            Action::make('disable_lost_mode')
                ->hidden(! $record->lost_mode)
                ->label('解除丢失')
                ->color('success')
                ->button()
                ->requiresConfirmation()
                ->action(function (Action $action) use ($record) {
                    try {
                        app(DeviceService::class)->disableLostMode($record);
                    } catch (\Exception $exception) {
                        $action->failureNotificationTitle($exception->getMessage());
                        $action->failure();
                    }
                })
                ->successNotificationTitle('指令已下发'),

            Action::make('disable_activation_lock')
                ->hidden(! $record->activation_lock)
                ->label('关闭激活锁')
                ->color('danger')
                ->button()
                ->modalDescription('关闭激活锁是一个危险行为且不可逆，确认要这样操作吗？')
                ->requiresConfirmation()
                ->action(function (Action $action) use ($record) {
                    try {
                        app(DeviceService::class)->disableActivationLock($record);
                    } catch (\Exception $exception) {
                        $action->failureNotificationTitle($exception->getMessage());
                        $action->failure();
                    }
                })
                ->successNotificationTitle('激活锁已关闭'),

            Action::make('enable_activation_lock')
                ->hidden($record->activation_lock)
                ->label('开启激活锁')
                ->color('success')
                ->button()
                ->requiresConfirmation()
                ->action(function (Action $action) use ($record) {
                    try {
                        app(DeviceService::class)->enableActivationLock($record);
                    } catch (\Exception $exception) {
                        $action->failureNotificationTitle($exception->getMessage());
                        $action->failure();
                    }
                })
                ->successNotificationTitle('激活锁已开启'),

            Action::make('custom')
                ->label('自定义指令')
                ->color('gray')
                ->slideOver()
                ->modalHeading('发送自定义指令')
                ->schema([
                    Textarea::make('plist')
                        ->rows(20)
                        ->cols(20)
                        ->label('plist')
                        ->placeholder('请输入plist内容，格式为XML，UUID请自己生成')
                        ->required(),
                ])
                ->action(function (Action $action, array $data) use ($record) {
                    try {
                        app(DeviceService::class)->custom($record, $data['plist']);
                    } catch (\Exception $e) {
                        $action->failureNotificationTitle($e->getMessage());
                        $action->failure();
                    }
                })
                ->successNotificationTitle('指令已下发'),
        ];
    }
}
