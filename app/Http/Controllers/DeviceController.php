<?php

namespace App\Http\Controllers;

use App\Services\DeviceService;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function enrollmentPage(Request $request, DeviceService $deviceService)
    {
        $message = $request->get('message');
        if (! $message) {
            return view('enrollment-error', ['message' => 'message参数不存在']);
        }

        try {
            $deviceInfo = $deviceService->parseAppleAspenDeviceInfoMessage($request->get('message'));

            return view('enrollment', $deviceInfo);
        } catch (\Exception $exception) {
            return view('enrollment-error', ['message' => $exception->getMessage()]);
        }
    }

    public function enrollment(Request $request, DeviceService $deviceService)
    {
        $message = $request->get('message');
        if (! $message) {
            return response()->json(['message' => 'message 不存在'], 500);
        }

        try {
            $file = $deviceService->enrollment($message);

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
