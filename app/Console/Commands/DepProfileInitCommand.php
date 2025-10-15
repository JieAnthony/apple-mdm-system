<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DepProfileInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dep:profile-init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初始化DEP的配置文件';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $params = [
            'profile_name' => 'Enrollment Profile',
            'url' => \sprintf('%s/mdm/enroll', config('mdm.enrollment_host')), // MDM地址，公网可访问的
            'configuration_web_url' => route('device.enrollment-page'), // 注册的单页面
            'is_mandatory' => true,
            'is_supervised' => true,
            'is_mdm_removable' => false,
            'skip_setup_items' => [
                'AppleID',
                'Welcome',
                'WatchMigration',
                'UpdateCompleted',
                'TOS',
                'TermsOfAddress',
                'SoftwareUpdate',
                'Siri',
                'SIMSetup',
                'ScreenTime',
                'Safety',
                'RestoreCompleted',
                'Restore',
                'Privacy',
                'Payment',
                'Passcode',
                'MessagingActivationUsingPhoneNumber',
                'iMessageAndFaceTime',
                'iCloudStorage',
                'iCloudDiagnostics',
                'Diagnostics',
                'DeviceToDeviceMigration',
                'Biometric',
                'AppStore',
                'Appearance',
                'Android',
                'ActionButton',
                'Accessibility',
                'Location',
            ],
        ];

        $result = app('dep')->defineProfile($params);
        $this->info($result['profile_uuid']);
        $this->info('请将上述UUID复制到配置文件.env中的 DEP_PROFILE_UUID 中');

        return 0;
    }
}
