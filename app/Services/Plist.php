<?php

namespace App\Services;

use CFPropertyList\CFArray;
use CFPropertyList\CFBoolean;
use CFPropertyList\CFData;
use CFPropertyList\CFDictionary;
use CFPropertyList\CFNumber;
use CFPropertyList\CFPropertyList;
use CFPropertyList\CFString;
use Illuminate\Support\Str;

class Plist
{
    public function parse(string $xmlString)
    {
        $plist = new CFPropertyList;
        $plist->parse($xmlString);

        return $plist->toArray();
    }

    public function generatePlist(CFDictionary $dictContent, string $requestType)
    {
        $plist = new CFPropertyList;
        $dict = new CFDictionary;
        $plist->add($dict);
        $dict->add('Command', $dictContent);
        $dictContent->add('RequestType', new CFString($requestType));
        $dict->add('CommandUUID', new CFString(Str::uuid()));

        return $plist->toXML();
    }

    public function enableLostModePlist(string $message, string $phoneNumber, string $footnote)
    {
        $dictContent = new CFDictionary;

        $dictContent->add('Message', new CFString($message));
        $dictContent->add('PhoneNumber', new CFString($phoneNumber));
        $dictContent->add('Footnote', new CFString($footnote));

        return $this->generatePlist($dictContent, 'EnableLostMode');
    }

    public function disableLostModePlist()
    {
        return $this->generatePlist(new CFDictionary, 'DisableLostMode');
    }

    public function installProfilePlist(string $plist)
    {
        $dictContent = new CFDictionary;

        $dictContent->add('Payload', new CFData($plist));

        return $this->generatePlist($dictContent, 'InstallProfile');
    }

    public function deviceInformationPlist()
    {
        $queries = collect([
            'AccessibilitySettings',
            'ActiveManagedUsers',
            'AppAnalyticsEnabled',
            'AutoSetupAdminAccounts',
            'AvailableDeviceCapacity',
            'AwaitingConfiguration',
            'BatteryLevel',
            'BluetoothMAC',
            'BuildVersion',
            'CellularTechnology',
            'DataRoamingEnabled',
            'DeviceCapacity',
            'DeviceID',
            'DeviceName',
            'DevicePropertiesAttestation',
            'DiagnosticSubmissionEnabled',
            'EACSPreflight',
            'EASDeviceIdentifier',
            'EstimatedResidentUsers',
            'EthernetMAC',
            'HasBattery',
            'HostName',
            'IsActivationLockSupported',
            'IsAppleSilicon',
            'IsCloudBackupEnabled',
            'IsDeviceLocatorServiceEnabled',
            'IsDoNotDisturbInEffect',
            'IsMDMLostModeEnabled',
            'IsMultiUser',
            'IsNetworkTethered',
            'IsRoaming',
            'IsSupervised',
            'iTunesStoreAccountHash',
            'iTunesStoreAccountIsActive',
            'LastCloudBackupDate',
            'LocalHostName',
            'ManagedAppleIDDefaultDomains',
            'MaximumResidentUsers',
            'MDMOptions',
            'Model',
            'ModelName',
            'ModemFirmwareVersion',
            'ModelNumber',
            'OnlineAuthenticationGracePeriod',
            'OrganizationInfo',
            'OSUpdateSettings',
            'OSVersion',
            'PersonalHotspotEnabled',
            'PINRequiredForDeviceLock',
            'PINRequiredForEraseDevice',
            'ProductName',
            'ProvisioningUDID',
            'PushToken',
            'QuotaSize',
            'ResidentUsers',
            'SerialNumber',
            'ServiceSubscriptions',
            'SkipLanguageAndLocaleSetupForNewUsers',
            'SoftwareUpdateDeviceID',
            'SoftwareUpdateSettings',
            'SupplementalBuildVersion',
            'SupplementalOSVersionExtra',
            'SupportsiOSAppInstalls',
            'SupportsLOMDevice',
            'SystemIntegrityProtectionEnabled',
            'TemporarySessionOnly',
            'TemporarySessionTimeout',
            'TimeZone',
            'UDID',
            'UserSessionTimeout',
            'WiFiMAC',
        ])->map(fn ($item) => new CFString($item));

        $dictContent = new CFDictionary;

        $dictContent->add('Queries', new CFArray($queries));

        return $this->generatePlist($dictContent, 'DeviceInformation');
    }

    public function restrictionsPlist()
    {
        $dictContent = new CFDictionary;
        $dictContent->add('ProfileRestrictions', new CFBoolean(true));

        return $this->generatePlist($dictContent, 'Restrictions');
    }

    public function generateRestrictionsProfileFile(array $restrictions = [], array $allowListedAppBundleIDs = [], array $blockedAppBundleIDs = [])
    {
        $plist = new CFPropertyList;
        $dict = new CFDictionary;
        $plist->add($dict);

        $bundle = config('mdm.bundle_id').'ForRestrictions';

        // top level
        $dict->add('PayloadDisplayName', new CFString('Restrictions'));
        $dict->add('PayloadIdentifier', new CFString($bundle));
        $dict->add('PayloadType', new CFString('Configuration'));
        $dict->add('PayloadUUID', new CFString(\strtoupper(Str::uuid())));
        $dict->add('PayloadVersion', new CFNumber(1));

        $content = new CFDictionary;
        $content->add('PayloadIdentifier', new CFString($bundle.'Payload'));
        $content->add('PayloadType', new CFString('com.apple.applicationaccess'));
        $content->add('PayloadUUID', new CFString(\strtoupper(Str::uuid())));
        $content->add('PayloadVersion', new CFNumber(1));

        foreach ($restrictions as $key => $restriction) {
            $content->add($key, new CFBoolean($restriction));
        }

        if ($allowListedAppBundleIDs) {
            $allowListedAppBundleIDItems = [];
            foreach ($allowListedAppBundleIDs as $allowListedAppBundleID) {
                $allowListedAppBundleIDItems[] = new CFString($allowListedAppBundleID);
            }
            $content->add('allowListedAppBundleIDs', new CFArray($allowListedAppBundleIDItems));
        }

        if ($blockedAppBundleIDs) {
            $blockedAppBundleIDItems = [];
            foreach ($blockedAppBundleIDs as $blockedAppBundleID) {
                $blockedAppBundleIDItems[] = new CFString($blockedAppBundleID);
            }
            $content->add('blockedAppBundleIDs', new CFArray($blockedAppBundleIDItems));
        }

        $dict->add('PayloadContent', new CFArray([
            $content,
        ]));

        return $plist->toXML();
    }

    public function generateDescriptionFile()
    {
        $plist = new CFPropertyList;
        $dict = new CFDictionary;
        $plist->add($dict);

        // top level
        $dict->add('PayloadDisplayName', new CFString('Enrollment Profile'));
        $dict->add('PayloadDescription', new CFString('Enrollment Profile'));
        $dict->add('PayloadIdentifier', new CFString(config('mdm.bundle_id')));
        $dict->add('PayloadType', new CFString('Configuration'));
        $dict->add('PayloadUUID', new CFString(\strtoupper(Str::uuid())));
        $dict->add('PayloadVersion', new CFNumber(1));
        // scep
        $useUUID = \strtoupper(Str::uuid());
        $scepDict = new CFDictionary;
        $scepDict->add('PayloadIdentifier', new CFString(\sprintf('com.apple.security.scep.%s', $useUUID)));
        $scepDict->add('PayloadType', new CFString('com.apple.security.scep'));
        $scepDict->add('PayloadUUID', new CFString($useUUID));
        $scepDict->add('PayloadVersion', new CFNumber(1));
        $scepPayloadContentDict = new CFDictionary;
        $scepPayloadContentDict->add('Challenge', new CFString(config('scep.challenge')));
        $scepPayloadContentDict->add('Key Type', new CFString('RSA'));
        $scepPayloadContentDict->add('Key Usage', new CFNumber(5));
        $scepPayloadContentDict->add('Keysize', new CFNumber(2048));
        $scepPayloadContentDict->add('URL', new CFString(config('scep.enrollment_host').'/scep'));
        $scepDict->add('PayloadContent', $scepPayloadContentDict);
        // mdm
        $mdmUUID = \strtoupper(Str::uuid());
        $mdmDict = new CFDictionary;
        $mdmDict->add('AccessRights', new CFNumber(8191));
        $mdmDict->add('CheckOutWhenRemoved', new CFBoolean(true));
        $mdmDict->add('IdentityCertificateUUID', new CFString($useUUID));
        $mdmDict->add('ServerCapabilities', new CFArray([
            new CFString('com.apple.mdm.per-user-connections'),
            new CFString('com.apple.mdm.bootstraptoken'),
        ]));
        $mdmDict->add('ServerURL', new CFString(\sprintf('%s/mdm', config('mdm.enrollment_host'))));
        // $mdmDict->add('CheckInURL', new CFString(\sprintf('%s/checkin?%s', config('mdm.host'), http_build_query(\compact('key')))));
        $mdmDict->add('SignMessage', new CFBoolean(true));
        $mdmDict->add('Topic', new CFString(config('apple.apns_topic')));
        $mdmDict->add('PayloadIdentifier', new CFString(\sprintf('com.apple.mdm.%s', $mdmUUID)));
        $mdmDict->add('PayloadType', new CFString('com.apple.mdm'));
        $mdmDict->add('PayloadUUID', new CFString($mdmUUID));
        $mdmDict->add('PayloadVersion', new CFNumber(1));

        $dict->add('PayloadContent', new CFArray([
            $scepDict,
            $mdmDict,
        ]));

        return $plist->toXML();
    }

    public function installedApplicationListPlist()
    {
        return $this->generatePlist(new CFDictionary, 'InstalledApplicationList');
    }
}
