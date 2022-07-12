<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class RegisterRequest extends FormRequest
{
    // use UserTrait;

    private $validationFactory;

    public function __construct(ValidationFactory $validationFactory)
    {
        $this->validationFactory = $validationFactory;
        $this->responseErrors = [];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'username' => 'required|string|unique:users|max:255',
            'email' => 'sometimes|required|email',
            'password' => 'required|min:6|max:100|checkspecialcharacter',
            'password_confirmation' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return[
            'password.required' => 'password is required',
            'password.checkspecialcharacter' => 'special character not allowed',
            'password_confirmation.required' => 'password confirmation is required',
            'password_confirmation.same' => 'password confirmation is different with password field',
        ];
    }

    /**
     * Handle username rule for (email | phone) register
     */
    private function username()
    {
        //
    }

    /**
     * Add custom validation rules
     */
    public function validationFactory()
    {
        $this->username();

        $this->validationFactory->extend('alphabert', function ($attribute, $value, $parameters) {
            if (!ctype_alpha($value)) {
                return false;
            }

            return true;
        }, /** error msg handle here */ '');
    }
}
