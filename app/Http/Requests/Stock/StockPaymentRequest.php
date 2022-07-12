<?php

namespace App\Http\Requests\Stock;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;
use App\Models\Payment;
use App\Services\StockService;
use App\Services\PaymentService;
use Illuminate\Validation\Rule;

class StockPaymentRequest extends FormRequest
{
    private $validationFactory;
    private $paymentService;
    private $stockService;
    private $paymentStatuses;

    public function __construct(
        ValidationFactory $validationFactory,
        StockService $stockService,
        PaymentService $paymentService
    )
    {
        $this->validationFactory = $validationFactory;
        $this->responseErrors = [];
        $this->stockService = $stockService;
        $this->paymentService = $paymentService;
        $this->paymentStatuses = $this->paymentService->paymentStatus(['keyBy' => 'name']);
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
            'order_no' => 'required|exists:payments|pending_payment',
            'status' => ['required', Rule::in(array_keys($this->paymentStatuses))]
        ];
    }

    public function messages()
    {
        return[
           'order_no.required' => 'order number is required',
           'order_no.exists' => 'order number is invalid',
           'order_no.pending_payment' => 'order not found',
           'status.required' => 'status is required',
           'status.in' => 'status must be either one [:values]',
        ];
    }

    /**
     * Add custom validation rules
     */
    public function validationFactory()
    {
        $this->validationFactory->extend('pending_payment', function ($attribute, $value, $parameters) {
            $orderNo = $value;
            
            $payment = Payment::where([
                'order_no' => $orderNo,
                'status_id' => $this->paymentStatuses['pending']['id']
            ])->first();

            if (empty($payment)) {
                return false;
            }

            return true;
        }, /** error msg handle here */ '');
    }
}
