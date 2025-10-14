<?php

namespace App\Filament\Resources\Devices\Pages;

use App\Filament\Resources\Devices\DeviceResource;
use App\Models\FunctionalRestriction;
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
        /** @var \App\Models\Device */
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

        return [
            Action::make('test')
                ->label('设备信息')
                ->color('info')
                ->button()
                ->modalHeading('获取设备信息')
                ->requiresConfirmation()
                ->action(function () {})
                ->successNotificationTitle('指令已下发1122334'),

            Action::make('test6')
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
                        ->default($functionalRestrictionDefaultIds)
                        ->columns(),
                ])
                ->action(function (Action $action, array $data) {
                    try {
                        /* Perform your specific action */
                        $action->successNotificationTitle('Process queued successfully.');
                        $action->success(); // Trigger success notification
                    } catch (\Exception $e) {
                        $action->failureNotificationTitle('Process failed with error: '.$e->getMessage());
                        $action->failure(); // Trigger failure notification
                    }
                }),

            Action::make('test1')
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
                ->action(function () {})
                ->successNotificationTitle('指令已下发1122334'),

            Action::make('test2')
                ->hidden(! $record->lost_mode)
                ->label('解除丢失')
                ->color('success')
                ->button()
                ->requiresConfirmation()
                ->action(function () {})
                ->successNotificationTitle('指令已下发1122334'),

            Action::make('test3')
                ->hidden(! $record->activation_lock)
                ->label('关闭激活锁')
                ->color('danger')
                ->button()
                ->modalDescription('关闭激活锁是一个危险行为且不可逆，确认要这样操作吗？')
                ->requiresConfirmation()
                ->action(function () {})
                ->successNotificationTitle('指令已下发1122334'),

            Action::make('test4')
                ->hidden($record->activation_lock)
                ->label('开启激活锁')
                ->color('success')
                ->button()
                ->requiresConfirmation()
                ->action(function () {})
                ->successNotificationTitle('指令已下发1122334'),

            Action::make('test5')
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
                ->action(function (Action $action, array $data) {
                    try {
                        /* Perform your specific action */
                        $action->successNotificationTitle('Process queued successfully.');
                        $action->success(); // Trigger success notification
                    } catch (\Exception $e) {
                        $action->failureNotificationTitle('Process failed with error: '.$e->getMessage());
                        $action->failure(); // Trigger failure notification
                    }
                }),
        ];
    }
}
