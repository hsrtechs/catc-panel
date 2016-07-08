<?php

namespace App\Http\Requests;


use App\Http\Requests\Request;

class ServerRenameRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param \App\Http\Requests\Request|Request $request
     * @return bool
     */
    public function authorize(\Illuminate\Http\Request $request)
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'servername' => 'required',
        ];
    }
}
