<?php

namespace App\Http\Controllers;

use App\DataTables\PaymentsDataTable;
use App\Models\ClientCourse;
use App\Models\Payments;
use Carbon\Carbon;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index(PaymentsDataTable $dataTable)
    {
        $start_month = Carbon::now()->startOfMonth();
        $end_month = Carbon::now()->endOfMonth();
        $courseClients = ClientCourse::with('client', 'course')->groupBy('client_id')->where('deleted_at', null)->whereDoesntHave('payments')
            ->orWhereHas('payments', function ($query) use ($start_month, $end_month) {
                $query->whereNotBetween('created_at', [$start_month, $end_month]);
            })->get();
        return view('payments.index', ['courseClients' => $courseClients]);
    }
    public function makeAPayment($client_id)
    {
        try {
            $courseClient = ClientCourse::where('client_id', $client_id)->DoesntHave('payments')->get();
            // dd($courseClient);
            foreach ($courseClient as $key => $course) {
                $payment = new Payments();
                $payment->course_client_id = $course->id;
                $payment->save();
            }
            $this->printPayment($courseClient);
            return json_encode(['status' => 'ok']);
        } catch (\Exception $e) {
            return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function printPayment($courseClient)
    {
        $mid = "--";
        $store_name = "ACADEMIA BECQUER";
        $store_address = "C. Manuel Fuentes 'Bocanegra', 35, Poniente Sur, 14005 Córdoba";
        $store_phone = "666 19 32 70";
        $store_email = "info@academiabecquer.es";
        $store_web = "www.academiabecquer.es";
        $transaction_id = Carbon::now()->format('YmdHis') . rand(1000, 9999);
        $currency = "EUR";
        $tax_percentage = 0;
        $printer = new ReceiptPrinter;
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );
        foreach ($courseClient as $course) {
            $printer->addItem(
                $course->course->name,
                '1',
                $course->total,
            );
        }
        $total = $courseClient->sum('total');
        $printer->setTax($tax_percentage);
        $printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_web);
        $printer->setCurrency($currency);
        $printer->setRequestAmount($total);
        $printer->setTransactionID($transaction_id);
        $printer->setQRcode([
            'tid' => $transaction_id,
            'amount' => $total,
        ]);
        $printer->printRequest();
    }
    //
}
