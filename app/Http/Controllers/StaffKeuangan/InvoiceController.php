<?php

namespace App\Http\Controllers\StaffKeuangan;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::latest()->paginate(10);
        return view('staff-keuangan.invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff-keuangan.invoice.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'type' => 'required|string',
            'partner_name' => 'required|string',
            'activity' => 'required|string',
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            // Validasi tipe item (header/subheader/item)
            'items.*.type' => 'required|in:header,subheader,item', 
            'items.*.description' => 'required|string',
            // Header/Subheader bisa null/0
            'items.*.amount' => 'nullable|numeric',
        ]);

        DB::transaction(function () use ($request) {
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $totalAmount += (float) ($item['amount'] ?? 0);
            }

            $invoice = Invoice::create([
                'invoice_number' => $request->invoice_number,
                'type' => $request->type,
                'partner_name' => $request->partner_name,
                'activity' => $request->activity,
                'date' => $request->date,
                'total_amount' => $totalAmount,
            ]);

            foreach ($request->items as $item) {
                $invoice->items()->create([
                    'item_type' => $item['type'],
                    'description' => $item['description'],
                    'amount' => $item['amount'] ?? 0,
                ]);
            }
        });

        return redirect()->route('staff-keuangan.invoice.index')->with('success', 'Invoice berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('items');
        return view('staff-keuangan.invoice.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $invoice->load('items');
        return view('staff-keuangan.invoice.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'invoice_number' => 'required|unique:invoices,invoice_number,' . $invoice->id,
            'type' => 'required|string',
            'partner_name' => 'required|string',
            'activity' => 'required|string',
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.type' => 'required|in:header,subheader,item',
            'items.*.description' => 'required|string',
            'items.*.amount' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $invoice) {
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $totalAmount += $item['amount'];
            }

            $invoice->update([
                'invoice_number' => $request->invoice_number,
                'type' => $request->type,
                'partner_name' => $request->partner_name,
                'activity' => $request->activity,
                'date' => $request->date,
                'total_amount' => $totalAmount,
            ]);

            // Delete old items and create new ones
            $invoice->items()->delete();

            foreach ($request->items as $item) {
                $invoice->items()->create([
                    'item_type' => $item['type'],
                    'description' => $item['description'],
                    'amount' => $item['amount'],
                ]);
            }
        });

        return redirect()->route('staff-keuangan.invoice.index')->with('success', 'Invoice berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('staff-keuangan.invoice.index')->with('success', 'Invoice berhasil dihapus.');
    }

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
