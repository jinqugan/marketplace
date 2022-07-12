<?php

namespace App\Http\Requests\Stock;

use App\Http\Requests\FormRequest;
use App\Models\PaymentMethod;
use Illuminate\Validation\Factory as ValidationFactory;
use App\Models\Stock;
use App\Services\StockService;
use App\Traits\MethodTrait;

class StockPurchaseRequest extends FormRequest
{
    use MethodTrait;

    private $validationFactory;

    public function __construct(
        ValidationFactory $validationFactory,
        StockService $stockService
    )
    {
        $this->validationFactory = $validationFactory;
        $this->responseErrors = [];
        $this->stockService = $stockService;
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
            'stock_id' => 'bail|required|numeric|exists:stocks,id|published',
            'payment_method_id' => 'required|numeric|exists:payment_methods,id',
            'email' => 'required|email',
            'price' => ['required', 'gt:0', 'lte:'.$this->stockService->maxPrice(), 'price'],
            'card_number' => ['required', 'luhn_algorithm'],
            'card_holder_name' => ['required', 'string'],
            'card_cvv' => ['required', 'numeric', 'digits:3'],
        ];
    }

    public function messages()
    {
        return[
           'stock_id.required' => 'stock id is required',
           'stock_id.exists' => 'stock id is invalid',
           'stock_id.published' => 'goods is unpublished',
           'payment_method_id.required' => 'payment method id is required',
           'payment_method_id.exists' => 'payment method id is invalid',
           'email.required' => 'email is required',
           'email.email' => 'email format is invalid',
           'price.required' => 'price is required',
           'price.price' => 'price amount is not equal to goods price',
           'price.gt' => 'price must greater than :value',
           'price.lte' => 'price must less than or equal to :value',
           'card_number.required' => 'card number is required',
           'card_number.luhn_algorithm' => 'card number is invalid',
           'card_holder_name.required' => 'card holder name is required',
           'card_cvv.required' => 'card cvv is required',
           'card_cvv.digits' => 'card cvv must be :digits digit',
        ];
    }

    /**
     * Add custom validation rules
     */
    public function validationFactory()
    {
        $statuses = $this->stockService->stockStatus(['keyBy' => 'name']);

        $this->validationFactory->extend('published', function ($attribute, $value, $parameters) use ($statuses) {
            $stockId = $value;
            $stock = Stock::where([
                'id' => $stockId,
                'status_id' => $statuses['published']['id']
            ])->first();

            if (empty($stock)) {
                return false;
            }

            return true;
        }, /** error msg handle here */ '');

        $this->validationFactory->extend('price', function ($attribute, $value, $parameters) use ($statuses) {
            $stockPrice = $value;
            $stock = Stock::where([
                'id' => $this->get('stock_id')
            ])->first();

            if (empty($stock) || $stock['price'] != $stockPrice) {
                return false;
            }

            return true;
        }, /** error msg handle here */ '');

        $this->validationFactory->extend('luhn_algorithm', function ($attribute, $value, $parameters) use ($statuses) {
            $cardNumber = $value;

            return $this->validateLuhn($cardNumber);
        }, /** error msg handle here */ '');
        
    }
}
