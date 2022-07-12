<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\PurchaseNotification;
use App\Models\User;

class PurchaseCodeMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stock;
    protected $payment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($stock, $payment)
    {
        $this->stock = $stock;
        $this->payment = $payment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $multiplier = str_pad("1", config('constant.decimals')+1, "0", STR_PAD_RIGHT);
        $this->stock['price'] = ($this->stock['price'] / $multiplier);

        Mail::to($this->payment['email'])->send(new PurchaseNotification($this->stock, $this->payment));
    }
}
