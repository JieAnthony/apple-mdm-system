<?php

namespace Database\Seeders;

use App\Models\FunctionalRestriction;
use Illuminate\Database\Seeder;

class FunctionalRestrictionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FunctionalRestriction::truncate();
        FunctionalRestriction::insert($this->data());
    }

    private function data()
    {
        return [
            0 => [
                'id' => 1,
                'key' => 'allowAccountModification',
                'name' => '允许修改Apple ID',
                'default_value' => true,
                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:24',
            ],
            1 => [
                'id' => 2,
                'key' => 'allowActivityContinuation',
                'name' => '允许活动继续',
                'default_value' => true,
                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:25',
            ],
            2 => [
                'id' => 3,
                'key' => 'allowAddingGameCenterFriends',
                'name' => '允许添加GameCenter好友',
                'default_value' => true,
                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:26',
            ],
            3 => [
                'id' => 4,
                'key' => 'allowAirDrop',
                'name' => '允许空投',
                'default_value' => true,
                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:27',
            ],
            4 => [
                'id' => 5,
                'key' => 'allowAirPlayIncomingRequests',
                'name' => '允许AirPlay传入请求',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:29',
            ],
            5 => [
                'id' => 6,
                'key' => 'allowAirPrint',
                'name' => '允许AirPrint',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:30',
            ],
            6 => [
                'id' => 7,
                'key' => 'allowAirPrintCredentialsStorage',
                'name' => '允许AirPrintCredentialsStorage',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:31',
            ],
            7 => [
                'id' => 8,
                'key' => 'allowAirPrintiBeaconDiscovery',
                'name' => '允许AirPrintiBeaconDiscovery',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:32',
            ],
            8 => [
                'id' => 9,
                'key' => 'allowAppCellularDataModification',
                'name' => '允许AppCellular数据修改',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:34',
            ],
            9 => [
                'id' => 10,
                'key' => 'allowAppClips',
                'name' => '允许应用剪辑',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:35',
            ],
            10 => [
                'id' => 11,
                'key' => 'allowAppInstallation',
                'name' => '允许安装App',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:36',
            ],
            11 => [
                'id' => 12,
                'key' => 'allowApplePersonalizedAdvertising',
                'name' => '允许Apple个性化广告',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:37',
            ],
            12 => [
                'id' => 13,
                'key' => 'allowAppRemoval',
                'name' => '允许移除App',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:39',
            ],
            13 => [
                'id' => 14,
                'key' => 'allowARDRemoteManagementModification',
                'name' => '允许ARD远程管理修改',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:40',
            ],
            14 => [
                'id' => 15,
                'key' => 'allowAssistant',
                'name' => '允许助手',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:41',
            ],
            15 => [
                'id' => 16,
                'key' => 'allowAssistantUserGeneratedContent',
                'name' => '允许助理用户生成内容',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:42',
            ],
            16 => [
                'id' => 17,
                'key' => 'allowAssistantWhileLocked',
                'name' => '允许锁定时使用Siri',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:44',
            ],
            17 => [
                'id' => 18,
                'key' => 'allowAutoCorrection',
                'name' => '允许自动更正',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:45',
            ],
            18 => [
                'id' => 19,
                'key' => 'allowAutomaticAppDownloads',
                'name' => '允许自动应用程序下载',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:46',
            ],
            19 => [
                'id' => 20,
                'key' => 'allowAutomaticScreenSaver',
                'name' => '允许自动屏幕保护程序',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:47',
            ],
            20 => [
                'id' => 21,
                'key' => 'allowAutoUnlock',
                'name' => '允许自动解锁',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:49',
            ],
            21 => [
                'id' => 22,
                'key' => 'allowBluetoothModification',
                'name' => '允许蓝牙修改',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:50',
            ],
            22 => [
                'id' => 23,
                'key' => 'allowBluetoothSharingModification',
                'name' => '允许蓝牙共享修改',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:51',
            ],
            23 => [
                'id' => 24,
                'key' => 'allowBookstore',
                'name' => '允许书店',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:52',
            ],
            24 => [
                'id' => 25,
                'key' => 'allowBookstoreErotica',
                'name' => '允许书店情色',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:53',
            ],
            25 => [
                'id' => 26,
                'key' => 'allowCamera',
                'name' => '允许相机',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:55',
            ],
            26 => [
                'id' => 27,
                'key' => 'allowCellularPlanModification',
                'name' => '允许修改蜂窝计划',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:56',
            ],
            27 => [
                'id' => 28,
                'key' => 'allowChat',
                'name' => '允许聊天',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:57',
            ],
            28 => [
                'id' => 29,
                'key' => 'allowCloudAddressBook',
                'name' => '允许云地址簿',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:58',
            ],
            29 => [
                'id' => 30,
                'key' => 'allowCloudBackup',
                'name' => '允许云备份',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:49:59',
            ],
            30 => [
                'id' => 31,
                'key' => 'allowCloudBookmarks',
                'name' => '允许云书签',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:01',
            ],
            31 => [
                'id' => 32,
                'key' => 'allowCloudCalendar',
                'name' => '允许云日历',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:02',
            ],
            32 => [
                'id' => 33,
                'key' => 'allowCloudDesktopAndDocuments',
                'name' => '允许云桌面和文档',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:03',
            ],
            33 => [
                'id' => 34,
                'key' => 'allowCloudDocumentSync',
                'name' => '允许云文档同步',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:04',
            ],
            34 => [
                'id' => 35,
                'key' => 'allowCloudFreeform',
                'name' => '允许云自由形式',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:06',
            ],
            35 => [
                'id' => 36,
                'key' => 'allowCloudKeychainSync',
                'name' => '允许云钥匙串同步',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:07',
            ],
            36 => [
                'id' => 37,
                'key' => 'allowCloudMail',
                'name' => '允许云邮件',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:08',
            ],
            37 => [
                'id' => 38,
                'key' => 'allowCloudNotes',
                'name' => '允许云笔记',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:09',
            ],
            38 => [
                'id' => 39,
                'key' => 'allowCloudPhotoLibrary',
                'name' => '允许云照片库',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:10',
            ],
            39 => [
                'id' => 40,
                'key' => 'allowCloudPrivateRelay',
                'name' => '允许云私有中继',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:12',
            ],
            40 => [
                'id' => 41,
                'key' => 'allowCloudReminders',
                'name' => '允许云提醒',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:13',
            ],
            41 => [
                'id' => 42,
                'key' => 'allowContentCaching',
                'name' => '允许内容缓存',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:14',
            ],
            42 => [
                'id' => 43,
                'key' => 'allowContinuousPathKeyboard',
                'name' => '允许连续路径键盘',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:15',
            ],
            43 => [
                'id' => 44,
                'key' => 'allowDefinitionLookup',
                'name' => '允许定义查找',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:16',
            ],
            44 => [
                'id' => 45,
                'key' => 'allowDeviceNameModification',
                'name' => '允许设备名称修改',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:18',
            ],
            45 => [
                'id' => 46,
                'key' => 'allowDeviceSleep',
                'name' => '允许设备睡眠',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:19',
            ],
            46 => [
                'id' => 47,
                'key' => 'allowDiagnosticSubmission',
                'name' => '允许诊断提交',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:20',
            ],
            47 => [
                'id' => 48,
                'key' => 'allowDiagnosticSubmissionModification',
                'name' => '允许诊断提交修改',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:21',
            ],
            48 => [
                'id' => 49,
                'key' => 'allowDictation',
                'name' => '允许听写',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:23',
            ],
            49 => [
                'id' => 50,
                'key' => 'allowEnablingRestrictions',
                'name' => '允许启用限制',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:24',
            ],
            50 => [
                'id' => 51,
                'key' => 'allowEnterpriseAppTrust',
                'name' => '允许企业级App',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:25',
            ],
            51 => [
                'id' => 52,
                'key' => 'allowEnterpriseBookBackup',
                'name' => '允许企业图书备份',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:26',
            ],
            52 => [
                'id' => 53,
                'key' => 'allowEnterpriseBookMetadataSync',
                'name' => '允许EnterpriseBookMetadataSync',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:27',
            ],
            53 => [
                'id' => 54,
                'key' => 'allowEraseContentAndSettings',
                'name' => '允许抹掉内容和设置',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:29',
            ],
            54 => [
                'id' => 55,
                'key' => 'allowESIMModification',
                'name' => '允许ESIM修改',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:30',
            ],
            55 => [
                'id' => 56,
                'key' => 'allowExplicitContent',
                'name' => '允许显式内容',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:31',
            ],
            56 => [
                'id' => 57,
                'key' => 'allowFileSharingModification',
                'name' => '允许文件共享修改',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:32',
            ],
            57 => [
                'id' => 58,
                'key' => 'allowFilesNetworkDriveAccess',
                'name' => '允许"文件"App访问网络驱动器',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:34',
            ],
            58 => [
                'id' => 59,
                'key' => 'allowFilesUSBDriveAccess',
                'name' => '允许"文件"App访问USB驱动器',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:35',
            ],
            59 => [
                'id' => 60,
                'key' => 'allowFindMyDevice',
                'name' => '允许“查找我的设备”',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:36',
            ],
            60 => [
                'id' => 61,
                'key' => 'allowFindMyFriends',
                'name' => '允许“查找我的朋友”',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:37',
            ],
            61 => [
                'id' => 62,
                'key' => 'allowFindMyFriendsModification',
                'name' => '允许修改查找我的朋友',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:39',
            ],
            62 => [
                'id' => 63,
                'key' => 'allowFingerprintForUnlock',
                'name' => '允许指纹解锁',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:40',
            ],
            63 => [
                'id' => 64,
                'key' => 'allowFingerprintModification',
                'name' => '允许指纹修改',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:41',
            ],
            64 => [
                'id' => 65,
                'key' => 'allowGameCenter',
                'name' => '允许游戏中心',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:42',
            ],
            65 => [
                'id' => 66,
                'key' => 'allowGlobalBackgroundFetchWhenRoaming',
                'name' => '允许全局背景漫游时获取',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:43',
            ],
            66 => [
                'id' => 67,
                'key' => 'allowHostPairing',
                'name' => '允许与iTunes配对',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:45',
            ],
            67 => [
                'id' => 68,
                'key' => 'allowInAppPurchases',
                'name' => '允许应用内购买',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:46',
            ],
            68 => [
                'id' => 69,
                'key' => 'allowInternetSharingModification',
                'name' => '允许互联网共享修改',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:47',
            ],
            69 => [
                'id' => 70,
                'key' => 'allowiPhoneWidgetsOnMac',
                'name' => '允许 iPhoneWidgetsOnMac',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:48',
            ],
            70 => [
                'id' => 71,
                'key' => 'allowiTunes',
                'name' => '允许使用iTunes Store',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:50',
            ],
            71 => [
                'id' => 72,
                'key' => 'allowiTunesFileSharing',
                'name' => '允许 iTunes 文件共享',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:51',
            ],
            72 => [
                'id' => 73,
                'key' => 'allowKeyboardShortcuts',
                'name' => '允许键盘快捷键',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:52',
            ],
            73 => [
                'id' => 74,
                'key' => 'allowLiveVoicemail',
                'name' => '允许实时语音邮件',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:53',
            ],
            74 => [
                'id' => 75,
                'key' => 'allowLocalUserCreation',
                'name' => '允许本地用户创建',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:54',
            ],
            75 => [
                'id' => 76,
                'key' => 'allowLockScreenControlCenter',
                'name' => '允许锁屏时使用控制中心',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:56',
            ],
            76 => [
                'id' => 77,
                'key' => 'allowLockScreenNotificationsView',
                'name' => '允许锁屏时查看通知',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:57',
            ],
            77 => [
                'id' => 78,
                'key' => 'allowLockScreenTodayView',
                'name' => '允许锁屏今日查看',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:58',
            ],
            78 => [
                'id' => 79,
                'key' => 'allowMailPrivacyProtection',
                'name' => '允许邮件隐私保护',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:50:59',
            ],
            79 => [
                'id' => 80,
                'key' => 'allowManagedAppsCloudSync',
                'name' => '允许托管应用程序云同步',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:01',
            ],
            80 => [
                'id' => 81,
                'key' => 'allowManagedToWriteUnmanagedContacts',
                'name' => '允许托管写入非托管联系人',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:02',
            ],
            81 => [
                'id' => 82,
                'key' => 'allowMarketplaceAppInstallation',
                'name' => '允许MarketplaceApp安装',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:03',
            ],
            82 => [
                'id' => 83,
                'key' => 'allowMultiplayerGaming',
                'name' => '允许多人游戏',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:04',
            ],
            83 => [
                'id' => 84,
                'key' => 'allowMusicService',
                'name' => '允许音乐服务',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:05',
            ],
            84 => [
                'id' => 85,
                'key' => 'allowNews',
                'name' => '允许新闻',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:07',
            ],
            85 => [
                'id' => 86,
                'key' => 'allowNFC',
                'name' => '允许NFC',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:08',
            ],
            86 => [
                'id' => 87,
                'key' => 'allowNotificationsModification',
                'name' => '允许通知修改',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:09',
            ],
            87 => [
                'id' => 88,
                'key' => 'allowOpenFromManagedToUnmanaged',
                'name' => '允许从托管到非托管打开',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:10',
            ],
            88 => [
                'id' => 89,
                'key' => 'allowOpenFromUnmanagedToManaged',
                'name' => '允许从非托管到托管打开',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:12',
            ],
            89 => [
                'id' => 90,
                'key' => 'allowOTAPKIUpdates',
                'name' => '允许OTAPKI更新',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:13',
            ],
            90 => [
                'id' => 91,
                'key' => 'allowPairedWatch',
                'name' => '允许配对手表',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:14',
            ],
            91 => [
                'id' => 92,
                'key' => 'allowPasscodeModification',
                'name' => '允许密码修改',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:15',
            ],
            92 => [
                'id' => 93,
                'key' => 'allowPassbookWhileLocked',
                'name' => '允许密码簿锁定时',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:16',
            ],
            93 => [
                'id' => 94,
                'key' => 'allowPasswordAutoFill',
                'name' => '允许密码自动填充',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:18',
            ],
            94 => [
                'id' => 95,
                'key' => 'allowPasswordProximityRequests',
                'name' => '允许密码邻近请求',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:19',
            ],
            95 => [
                'id' => 96,
                'key' => 'allowPasswordSharing',
                'name' => '允许密码共享',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:20',
            ],
            96 => [
                'id' => 97,
                'key' => 'allowPersonalHotspotModification',
                'name' => '允许个人热点修改',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:21',
            ],
            97 => [
                'id' => 98,
                'key' => 'allowPodcasts',
                'name' => '允许播客',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:22',
            ],
            98 => [
                'id' => 99,
                'key' => 'allowPredictiveKeyboard',
                'name' => '允许预测键盘',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:24',
            ],
            99 => [
                'id' => 100,
                'key' => 'allowPrinterSharingModification',
                'name' => '允许打印机共享修改',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:25',
            ],
            100 => [
                'id' => 101,
                'key' => 'allowProximitySetupToNewDevice',
                'name' => '允许ProximitySetupToNewDevice',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:26',
            ],
            101 => [
                'id' => 102,
                'key' => 'allowRadioService',
                'name' => '允许无线服务',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:27',
            ],
            102 => [
                'id' => 103,
                'key' => 'allowRapidSecurityResponseInstallation',
                'name' => '允许快速安全响应安装',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:29',
            ],
            103 => [
                'id' => 104,
                'key' => 'allowRapidSecurityResponseRemoval',
                'name' => '允许快速安全响应删除',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:30',
            ],
            104 => [
                'id' => 105,
                'key' => 'allowRemoteAppleEventsModification',
                'name' => '允许RemoteAppleEvents修改',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:31',
            ],
            105 => [
                'id' => 106,
                'key' => 'allowRemoteAppPairing',
                'name' => '允许远程应用程序配对',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:32',
            ],
            106 => [
                'id' => 107,
                'key' => 'allowRemoteScreenObservation',
                'name' => '允许远程屏幕观察',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:33',
            ],
            107 => [
                'id' => 108,
                'key' => 'allowSafari',
                'name' => '允许Safari',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:35',
            ],
            108 => [
                'id' => 109,
                'key' => 'allowScreenShot',
                'name' => '允许屏幕截图',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:36',
            ],
            109 => [
                'id' => 110,
                'key' => 'allowSharedDeviceTemporarySession',
                'name' => '允许共享设备临时会话',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:37',
            ],
            110 => [
                'id' => 111,
                'key' => 'allowSharedStream',
                'name' => '允许共享流',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:38',
            ],
            111 => [
                'id' => 112,
                'key' => 'allowSpellCheck',
                'name' => '允许拼写检查',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:40',
            ],
            112 => [
                'id' => 113,
                'key' => 'allowSpotlightInternetResults',
                'name' => '允许SpotlightInternet结果',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:41',
            ],
            113 => [
                'id' => 114,
                'key' => 'allowStartupDiskModification',
                'name' => '允许启动磁盘修改',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:42',
            ],
            114 => [
                'id' => 115,
                'key' => 'allowSystemAppRemoval',
                'name' => '允许系统应用程序删除',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:43',
            ],
            115 => [
                'id' => 116,
                'key' => 'allowTimeMachineBackup',
                'name' => '允许时间机器备份',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:45',
            ],
            116 => [
                'id' => 117,
                'key' => 'allowUIAppInstallation',
                'name' => '允许UIApp安装',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:46',
            ],
            117 => [
                'id' => 118,
                'key' => 'allowUIConfigurationProfileInstallation',
                'name' => '允许安装配置描述文件',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:47',
            ],
            118 => [
                'id' => 119,
                'key' => 'allowUniversalControl',
                'name' => '允许通用控制',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:48',
            ],
            119 => [
                'id' => 120,
                'key' => 'allowUnmanagedToReadManagedContacts',
                'name' => '允许非托管读取托管联系人',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:50',
            ],
            120 => [
                'id' => 121,
                'key' => 'allowUnpairedExternalBootToRecovery',
                'name' => '允许未配对的设备进入恢复模式',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:51',
            ],
            121 => [
                'id' => 122,
                'key' => 'allowUntrustedTLSPrompt',
                'name' => '允许不可信TLS连接',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:52',
            ],
            122 => [
                'id' => 123,
                'key' => 'allowUSBRestrictedMode',
                'name' => '允许USB限制模式',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:53',
            ],
            123 => [
                'id' => 124,
                'key' => 'allowVideoConferencing',
                'name' => '允许视频会议',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:55',
            ],
            124 => [
                'id' => 125,
                'key' => 'allowVPNCreation',
                'name' => '允许创建VPN',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:56',
            ],
            125 => [
                'id' => 126,
                'key' => 'allowWallpaperModification',
                'name' => '允许修改壁纸',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:57',
            ],
            126 => [
                'id' => 127,
                'key' => 'forceAirDropUnmanaged',
                'name' => '强制AirDrop非托管',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:51:58',
            ],
            127 => [
                'id' => 128,
                'key' => 'forceAirPlayIncomingRequestsPairingPassword',
                'name' => '强制AirPlay传入请求配对密码',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:00',
            ],
            128 => [
                'id' => 129,
                'key' => 'forceAirPlayOutgoingRequestsPairingPassword',
                'name' => '强制AirPlay传出请求配对密码',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:01',
            ],
            129 => [
                'id' => 130,
                'key' => 'forceAirPrintTrustedTLSRequirement',
                'name' => '强制AirPrintTrustedTLSRequirement',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:02',
            ],
            130 => [
                'id' => 131,
                'key' => 'forceClassroomUnpromptedAppAndDeviceLock',
                'name' => '强制ClassroomUnpromptedAppAndDeviceLock',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:03',
            ],
            131 => [
                'id' => 132,
                'key' => 'forceAssistantProfanityFilter',
                'name' => '强制助手亵渎过滤器',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:04',
            ],
            132 => [
                'id' => 133,
                'key' => 'forceAuthenticationBeforeAutoFill',
                'name' => '自动填充前强制身份验证',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:06',
            ],
            133 => [
                'id' => 134,
                'key' => 'forceAutomaticDateAndTime',
                'name' => '强制自动日期和时间',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:07',
            ],
            134 => [
                'id' => 135,
                'key' => 'forceClassroomAutomaticallyJoinClasses',
                'name' => '强制课堂自动加入班级',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:08',
            ],
            135 => [
                'id' => 136,
                'key' => 'forceClassroomRequestPermissionToLeaveClasses',
                'name' => '强制ClassroomRequestPermissionToLeaveClasses',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:09',
            ],
            136 => [
                'id' => 137,
                'key' => 'forceClassroomUnpromptedScreenObservation',
                'name' => '强制课堂无提示屏幕观察',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:11',
            ],
            137 => [
                'id' => 138,
                'key' => 'forceDelayedAppSoftwareUpdates',
                'name' => '强制延迟应用程序软件更新',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:12',
            ],
            138 => [
                'id' => 139,
                'key' => 'forceDelayedMajorSoftwareUpdates',
                'name' => '强制延迟主要软件更新',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:13',
            ],
            139 => [
                'id' => 140,
                'key' => 'forceDelayedSoftwareUpdates',
                'name' => '强制延迟软件更新',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:14',
            ],
            140 => [
                'id' => 141,
                'key' => 'forceEncryptedBackup',
                'name' => '允许强制加密备份',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:16',
            ],
            141 => [
                'id' => 142,
                'key' => 'forceLimitAdTracking',
                'name' => '强制限制广告跟踪',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:17',
            ],
            142 => [
                'id' => 143,
                'key' => 'forceOnDeviceOnlyDictation',
                'name' => '仅强制设备听写',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:18',
            ],
            143 => [
                'id' => 144,
                'key' => 'forceOnDeviceOnlyTranslation',
                'name' => '仅强制设备翻译',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:19',
            ],
            144 => [
                'id' => 145,
                'key' => 'forcePreserveESIMOnErase',
                'name' => '强制保留ESIMOnErase',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:20',
            ],
            145 => [
                'id' => 146,
                'key' => 'forceWatchWristDetection',
                'name' => '免费手表手腕检测',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:22',
            ],
            146 => [
                'id' => 147,
                'key' => 'forceWiFiToAllowedNetworksOnly',
                'name' => '强制 WiFi 仅限允许的网络',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:23',
            ],
            147 => [
                'id' => 148,
                'key' => 'forceWiFiPowerOn',
                'name' => '强制 WiFi 打开电源',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:24',
            ],
            148 => [
                'id' => 149,
                'key' => 'requireManagedPasteboard',
                'name' => '需要管理粘贴板',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:25',
            ],
            149 => [
                'id' => 150,
                'key' => 'safariAllowAutoFill',
                'name' => 'safari允许自动填充',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:27',
            ],
            150 => [
                'id' => 151,
                'key' => 'safariAllowJavaScript',
                'name' => 'safari允许JavaScript',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:28',
            ],
            151 => [
                'id' => 152,
                'key' => 'safariAllowPopups',
                'name' => 'safari允许弹出窗口',

                'default_value' => true,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:29',
            ],
            152 => [
                'id' => 153,
                'key' => 'safariForceFraudWarning',
                'name' => 'safari强制欺诈警告',

                'default_value' => false,

                'created_at' => '2024-04-08 14:32:35',
                'updated_at' => '2024-04-08 14:52:30',
            ],
        ];
    }
}
