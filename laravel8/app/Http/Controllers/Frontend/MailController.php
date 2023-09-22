<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use App\Http\Requests\frontend\checkoutRequest;
use App\Models\Product;

use App\Mail\MailNotify;
class MailController extends Controller
{
    public function sendMail(checkoutRequest $request)
    {
    	$getRequest = $request->all();
        // $cart = session()->get('cart');
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

    	$emailTo = $getRequest["email"];
        $subject = "Mail order product";

        $data = [
            'subject' => $subject,
            'product'=>$product,
            'sum' => $sum,
            'getRequest' => $getRequest
        ];
      
        try {
            Mail::to($emailTo)->send(new MailNotify($data));
            session()->forget('cart');
            return view('frontend.cart.cart');
            // return response()->json(['Send mail success']);
        } catch (Exception $th) {
            return response()->json(['Sorry, dont send mail.']);
        }


    	// Mail::send('frontend.sendMail.mail', 
    	// 	array(
    	// 		'product'=>$product,
        //         'sum' => $sum
    	//     ),
    	// 	function ($message) use ($subject, $emailTo){
        //            $message->from('thienbaoit@gmail.com', 'Mail order product');
        //            $message->to($emailTo);
        //            $message->subject($subject);
	    // });
	    
    }

    
}