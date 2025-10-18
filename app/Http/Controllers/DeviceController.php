<?php

namespace App\Http\Controllers;

use App\Services\DeviceService;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function enrollmentPage(Request $request, DeviceService $deviceService)
    {
        $content = $request->header('x-apple-aspen-deviceinfo');
        if (! $content) {
            return view('enrollment-error', ['message' => 'x-apple-aspen-deviceinfo参数有误']);
        }

        try {
            $deviceInfo = $deviceService->parseAppleAspenDeviceInfo($content);

            return view('enrollment', array_merge($deviceInfo, ['content' => $content]));
        } catch (\Exception $exception) {
            return view('enrollment-error', ['message' => $exception->getMessage()]);
        }
    }

    public function enrollment(Request $request, DeviceService $deviceService)
    {
        $content = $request->get('content');
        if (! $content) {
            return response()->json(['message' => 'content 不存在'], 500);
        }

        try {
            $file = $deviceService->enrollment($content);

            return response()->download(
                $file,
                'mdm.mobileconfig',
                ['Content-Type' => 'application/x-apple-aspen-config']
            )->deleteFileAfterSend();
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
