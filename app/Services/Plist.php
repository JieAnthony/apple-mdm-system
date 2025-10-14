<?php

namespace App\Services;

use CFPropertyList\CFArray;
use CFPropertyList\CFBoolean;
use CFPropertyList\CFData;
use CFPropertyList\CFDictionary;
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
}
