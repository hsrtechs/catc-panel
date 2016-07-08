<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;


class BuildServerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function authorize(\Illuminate\Http\Request $request)
    {
        return !($request->user()->isSuspended() || $request->user()->isTerminated());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cpu' => "required|numeric|min:1|cpu",
            'ram' => "required|numeric|min:512|ram",
            'storage' => "required|numeric|min:10|storage",
            'os' => "required|numeric",
        ];
    }
}
