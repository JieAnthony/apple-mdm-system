<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MDMCallbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isConnect = $this->get('topic') === 'mdm.Connect';

        $rules = [
            'topic' => ['required', Rule::in(['mdm.Authenticate', 'mdm.TokenUpdate', 'mdm.CheckOut', 'mdm.Connect', 'mdm.DeclarativeManagement'])],
            'created_at' => ['required', 'string'],
        ];

        if ($isConnect) {
            $rules['acknowledge_event'] = ['required', 'array'];
            $rules['acknowledge_event.command_uuid'] = [Rule::requiredIf($this->input('acknowledge_event.status') !== 'Idle'), 'uuid'];
            $rules['acknowledge_event.raw_payload'] = ['required', 'string'];
            $rules['acknowledge_event.status'] = ['required', Rule::in(['Idle', 'Acknowledged', 'Error'])];
            $rules['acknowledge_event.udid'] = ['required', 'string'];
            //            $rules['acknowledge_event.url_params'] = ['required', 'array'];
            //            $rules['acknowledge_event.url_params.key'] = ['required', 'string'];

            return $rules;
        }

        $rules['checkin_event'] = ['required', 'array'];
        $rules['checkin_event.udid'] = ['required', 'string'];
        $rules['checkin_event.raw_payload'] = ['required', 'string'];
        //        $rules['checkin_event.url_params'] = ['required', 'array'];
        //        $rules['checkin_event.url_params.key'] = ['required', 'string'];

        return $rules;
    }
}
