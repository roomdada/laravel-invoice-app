<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;

class InvoiceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $orderReference)
    {
       $order = \App\Models\Order::whereReference($orderReference)->with('product', 'user')->first();

        $buyer = new Buyer([
            'name' => $order->user->name,
            'custom_fields' => [
                'phone' => '1234567890',
                'address' => '123 rue de la paix',
                'email' => $order->user->email,
            ],
        ]);

        // $seller = new Seller

        $item = InvoiceItem::make($order->product->name)->pricePerUnit($order->product->price);
        $invoice = Invoice::make()
                            ->buyer($buyer)
                            ->discountByPercent(0)
                            ->logo(public_path('logo.jpg'))
                            ->taxRate(0)->shipping(0)->addItem($item)->save();
        $link = $invoice->url();
        dd($link);
    }
}
