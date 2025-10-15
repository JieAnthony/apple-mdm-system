<?php

namespace App\Http\Controllers;

use App\Http\Requests\MDMCallbackRequest;

class MDMController extends Controller
{
    public function __invoke(MDMCallbackRequest $request)
    {
        $params = $request->all();

        match ($params['topic']) {
            'mdm.Authenticate' => MDMAuthenticateJob::dispatch($params['checkin_event'], $params['created_at']),
            'mdm.Connect' => MDMConnectJob::dispatch($params['acknowledge_event'], $params['created_at']),
            'mdm.CheckOut' => MDMCheckOutJob::dispatch($params['checkin_event']),
            default => null
            // 'mdm.DeclarativeManagement'
            // 'mdm.TokenUpdate'
        };

        return response()->noContent();
    }
}
