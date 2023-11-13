<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\MailNotify;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        $status = 2;
        if($request->status){
            $user = User::where("id", $request->user_id)->first();
            // $invoiceDetail = InvoiceDetail::where("user_id", $request->user_id)->where("id_invoice", 0)->get();
            // $invoiceLasted = Invoice::latest()->first();
            if($user && session()->has('cart')){
                $invoice_code = 'INV' . $random = mt_rand(1000000000, 9999999999);
                $invoice = Invoice::create([
                    'invoice_code'     => $invoice_code,
                    'total_money'      => $request->price,
                    'user_id'          => $user->id,
                    'name'             => $user->name,
                    'address'          => $user->address,
                    'phone'            => $user->phone,
                    'email'            => $user->email,
                ]);
                $listCart = session()->get('cart');
                foreach($listCart as $key => $value){
                    $product = Product::where('id', $value['id'])->first();
                    if($product){
                        InvoiceDetail::create([
                            'id_product'       => $value['id'],
                            'name_product'     => $product->name,
                            'user_id'          => $user->id,
                            'quantity'         => $value['qty'],
                            'price'            => $product->price,
                            'id_invoice'       => $invoice->id,
                        ]);
                    }
                }
                session()->forget('cart');
                session()->save();
                $this->sendMail($listCart, $user);
                $status =  1;
                return view("frontend.cart.cart", compact("status"));
            }
        }else{
            $idProduct = session()->get('cart');
            $product = [];
            foreach ($idProduct as $key => $value) {
                $product[] = Product::find($value['id'])->toArray();
                $product[$key]['qty'] = $value['qty'];
            }

            $sum = 0;
            foreach ($product as $key => $value) {
                $sum = $sum+$value['price']*$value['qty'];
            }
            return view("frontend.cart.cart", compact("status", "product", "sum"));
        }

    }

    public function processPaypal(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success', ['user_id' => $request->user_id, 'price' => $request->price]),
                "cancel_url" => route('cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->price
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return response()->json([
                        'status' => true,
                        'link' => $links['href'],
                    ]);
                }
            }
            return redirect()
                ->route('createPayment', ['status' => 0]);

        } else {
            return redirect()
                ->route('createPayment', ['status' => 0]);
        }
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return redirect()
                ->route('createPayment', ['status' => 1, 'price' => $request->price, 'user_id' => $request->user_id]);
        } else {
            return redirect()
                ->route('createPayment', ['status' => 0]);
        }
    }

    public function cancel(Request $request)
    {
        return redirect()
            ->route('createPayment', ['status' => 0]);
    }

    public function sendMail($idProduct, $user)
    {
        $product = [];
        foreach ($idProduct as $key => $value) {
            $product[] = Product::find($value['id'])->toArray();
            $product[$key]['qty'] = $value['qty'];
        }

        $sum = 0;
        foreach ($product as $key => $value) {
            $sum = $sum+$value['price']*$value['qty'];
        }

    	$emailTo = $user->email;
        $subject = "Mail order product";

        $data = [
            'subject' => $subject,
            'product'=>$product,
            'sum' => $sum,
            'getRequest' => $user,
        ];

        try {
            Mail::to($emailTo)->send(new MailNotify($data));
            session()->forget('cart');
            return view('frontend.cart.cart');
        } catch (Exception $th) {
            return response()->json(['Sorry, dont send mail.']);
        }
    }
}

//