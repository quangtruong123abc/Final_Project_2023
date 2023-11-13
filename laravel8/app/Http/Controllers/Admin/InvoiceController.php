<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function listTransaction()
    {

        $getInvoice = Invoice::orderBy("id","desc")->get();
        return view('admin.transaction.list', compact('getInvoice'));
    }

    public function transactionById($id)
    {
        $invoiceDetail = InvoiceDetail::where("id_invoice", $id)
                                        // ->join("product", "invoice_details.")
                                        ->get();

        return view('admin.transaction.detail', compact('invoiceDetail'));
    }
}
