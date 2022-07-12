<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Stock\StockAddRequest;
use App\Http\Requests\Stock\StockPurchaseRequest;
use App\Http\Requests\Stock\StockPaymentRequest;
use App\Models\Stock;
use App\Services\StockService;
use App\Services\PaymentService;
use App\Models\PaymentMethod;
use App\Models\Payment;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Jobs\PurchaseCodeMail;

class GameController extends Controller
{
    private $stockService;
    private $paymentService;
    private $result;

    /**
     * Create a new controller instance.
     */
    public function __construct(StockService $stockService, PaymentService $paymentService)
    {
        $this->stockService = $stockService;
        $this->paymentService = $paymentService;
        $this->result = $this->requestResponses();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->result;
        $statuses = $this->stockService->stockStatus(['keyBy' => 'name']);

        $stocks = Stock::with(['status:id,name'])
        ->where(['status_id' => $statuses['published']['id']])
        ->get()
        ->toArray();

        $result['data'] = $stocks;

        return response()->json($result, $this->successStatus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockAddRequest $request)
    {
        $params = $request->all();
        $result = $this->result;
        $statuses = $this->stockService->stockStatus(['keyBy' => 'name']);

        $stock = Stock::create([
            'user_id' => $params['user_id'],
            'code' => $params['code'],
            'price' => $params['price'],
            'status_id' => $statuses['published']['id'],
            'description' => $params['description'],
        ]);

        unset($stock['code']);
        $stock['status'] = $statuses['published'];
        $result['message'] = 'goods published';
        $result['data'] = $stock;

        return response()->json($result, $this->successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function purchase(StockPurchaseRequest $request)
    {
        $params = $request->all();
        $result = $this->result;
        
        $purchase = DB::transaction(function () use ($params) {
            $paymentStatuses = $this->paymentService->paymentStatus(['keyBy' => 'name']);
            $stockStatuses = $this->stockService->stockStatus(['keyBy' => 'name']);
            
            $cardDetails = [
                'card_number' => $params['card_number'],
                'card_holder_name' => $params['card_holder_name'],
                'card_cvv' => $params['card_cvv'],
            ];

            $payment = Payment::create([
                'email' => $params['email'],
                'order_no' => md5(Str::uuid()),
                'payment_method_id' => $params['payment_method_id'],
                'stock_id' => $params['stock_id'],
                'status_id' => $paymentStatuses['pending']['id'],
                'details' => json_encode($cardDetails)
            ]);
            
            $stock = Stock::find($params['stock_id'], ['id', 'price']);
            $stock->status_id = $stockStatuses['pending_payment']['id'];
            $stock->save();

            $payment['status'] = $paymentStatuses['pending'];
            $payment['details'] = $cardDetails;
            $stock['status'] = $stockStatuses['pending_payment'];

            return [
                'payment' => $payment,
                'stock' => $stock,
            ];
        }, 1);

        $result['data'] = $purchase;
        return response()->json($result, $this->successStatus);
    }

    public function payment(StockPaymentRequest $request)
    {
        $params = $request->all();
        $result = $this->result;

        $payment = DB::transaction(function () use ($params) {
            $paymentStatuses = $this->paymentService->paymentStatus(['keyBy' => 'name']);
            $stockStatuses = $this->stockService->stockStatus(['keyBy' => 'name']);

            $payment = Payment::where('order_no', $params['order_no'])->first();
            $payment->status_id = $paymentStatuses[$params['status']]['id'];
            $payment->save();
          
            $stock = Stock::find($payment['stock_id'], ['id', 'user_id', 'code', 'price']);
            $stock->status_id = $stockStatuses['sold']['id'];
            $stock->save();

            $payment['status'] = $paymentStatuses[$params['status']];
            $stock['status'] = $stockStatuses['sold'];

            $commission = config('constant.commission');
            $commissionId = config('constant.commission_id');

            $earn = $stock['price'] * ((100-$commission) / 100);
            $charge = $stock['price'] - $earn;

            Transaction::create([
                'user_id' => $stock['user_id'],
                'stock_id' => $stock['id'],
                'subject' => 'purchase_code',
                'amount' => $earn
            ]);

            Transaction::create([
                'user_id' => $stock['user_id'],
                'stock_id' => $stock['id'],
                'subject' => 'commission',
                'amount' => '-'.$charge
            ]);

            $this->dispatch(new PurchaseCodeMail($stock->toArray(), $payment->toArray()));

            return [
                'payment' => $payment
            ];
        }, 1);

        $result['message'] = 'update payment successfully';
        $result['data'] = $payment;

        return response()->json($result, $this->successStatus);
    }

    public function paymentMethod(Request $request)
    {
        $params = $request->all();
        $result = $this->result;

        $paymentMethods = PaymentMethod::select('id', 'name')
        ->where('status', true)->get();

        $result['data'] = $paymentMethods;
        return response()->json($result, $this->successStatus);
    }
}
