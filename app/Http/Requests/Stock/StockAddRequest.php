<?php

namespace App\Http\Requests\Stock;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class StockAddRequest extends FormRequest
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
            'user_id' => 'required|string|exists:users,id',
            'code' => 'required|string|unique:stocks',
            'price' => ['required', 'numeric', 'gt:0', 'lte:'.$this->maxPrice()],
            'description' => 'required|string|max:65535',
        ];
    }

    private function maxPrice()
    {
        $length = 19;
        $decimal = config('constant.decimals');

        $prefix = str_pad("", $length-$decimal, "9", STR_PAD_RIGHT);
        return str_pad($prefix, $length, "0", STR_PAD_RIGHT);
    }

    public function messages()
    {
        return[
           //
        ];
    }

    /**
     * Add custom validation rules
     */
    public function validationFactory()
    {
        //
    }
}
