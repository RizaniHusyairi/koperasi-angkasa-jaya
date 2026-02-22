<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::latest()->paginate(10);
        return view('superadmin.invoice.index', compact('invoices'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('items');
        return view('superadmin.invoice.show', compact('invoice'));
    }

    /**
     * View PDF of the specified resource.
     */
    public function streamPdf($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);
        
        // Load view khusus PDF
        $pdf = Pdf::loadView('staff-keuangan.invoice.pdf', compact('invoice'));
        
        // Set ukuran kertas A4 Portrait
        $pdf->setPaper('a4', 'portrait');

        // Stream (buka di browser) dengan nama file custom
        $filename = 'Invoice-' . str_replace(['/', '\\'], '-', $invoice->invoice_number) . '.pdf';
        return $pdf->stream($filename);
    }
}
