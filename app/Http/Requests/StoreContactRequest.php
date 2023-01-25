<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * The URI that users should be redirected to if validation fails.
     * 
     * @var string
     */
    protected $redirectRoute = 'contacts.error';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->check()) return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address' => 'required|regex:/^(0x)?(?i:[0-9a-f]){40}$/'
        ];
    }
}
