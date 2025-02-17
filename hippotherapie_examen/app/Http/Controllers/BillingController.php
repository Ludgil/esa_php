<?php

namespace App\Http\Controllers;

use App\Models\Week;
use App\Models\Invoice;
use Illuminate\View\View;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\BillingRequest;
use Illuminate\Http\RedirectResponse;

class BillingController extends Controller
{
    public function index(): View
    {
        $invoices = Invoice::with('customer')->get();
        return view('billing.index', compact('invoices'));
    }

    public function create(): View
    {
        return view ('billing.create');
    }

    public function store(BillingRequest $request): RedirectResponse
    {
        $year = $request->year;
        $month = $request->month;
        $weeks = Week::whereYear('start_date', $year)
             ->whereMonth('start_date', $month)
             ->get();
 
        $weekIds = $weeks->pluck('id');
    
        $appointments = Appointment::with('customer')
            ->whereIn('week_id', $weekIds)
            ->where('billed', false)
            ->get();

        if ($appointments->isEmpty()) {
            return redirect()->back()->with('error', 'Aucun rendez-vous non facturé pour ce mois.');
        }  
    
        $appointmentsGroupedByCustomer = $appointments->groupBy('customer_id');
        foreach ($appointmentsGroupedByCustomer as $customerId => $customerAppointments) {
            
            $totalAmount = $customerAppointments->sum('price');

            $invoice = Invoice::create([
                'customer_id' => $customerId,
                'month' => "{$request->year}-{$request->month}-01",
                'total_amount' => $totalAmount,
            ]);

            // Ajouter les rendez-vous comme objet de la facture
            foreach ($customerAppointments as $appointment) {
                InvoiceDetail::create([
                    'invoice_id' => $invoice->id,
                    'appointment_id' => $appointment->id,
                    'price' => $appointment->price,
                ]);

                $appointment->update(['billed' => true]);
            }
        }

        return redirect()->route('billing.index');
    }

    /**
     * La variable s'appelle billing, car la route à été générée via Ressource et donc par défaut l'attribut ID dans la route
     * est appelée billing et non invoice
     */
    public function destroy(Invoice $billing): RedirectResponse
    {
        foreach ($billing->details as $detail) {
            $appointment = $detail->appointment;
            $appointment->update(['billed' => false]);
        }
        $billing->delete();
        return redirect()->route('billing.index');
    }

    /** 
     * Ici la variable s'appele Invoice car contrairement à Destroy j'ai créé la route à la main
     */
    public function showInvoice(Invoice $invoice): View
    {
        return view('billing.invoice', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        $data = [
            'invoice' => $invoice,
            'customer' => $invoice->customer,
            'details' => $invoice->details,
        ];

        $pdf = Pdf::loadView('invoice.pdf', $data);

        return $pdf->download('facture-' . $invoice->id . '.pdf');
    }
}
