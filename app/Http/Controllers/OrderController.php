<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Str;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\View\Factory;
use App\Notifications\OrderClosed;
use App\Notifications\OrderCanceled;
use App\Models\User;


class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orderQuery = Order::query();
        if (Auth::user()->user_type == 'C') {
            $orderQuery->where('customer_id', Auth::user()->id);
        }
        if (Auth::user()->user_type == 'E') {
            $orderQuery = Order::query()->whereIn('status', ['pending', 'paid']);
        }
        $filterByStatus = $request->status ?? '';
        $filterByDate = $request->date ?? '';
        $filterByNif = $request->nif ?? '';
        if ($filterByStatus !== '') {
            $orderQuery->where('status', $filterByStatus);
        }
        if ($filterByDate !== '') {
            $orderQuery->where('date', $filterByDate);
        }
        if ($filterByNif !== '') {
            $orderQuery->where('nif', $filterByNif);
        }
        $orders = $orderQuery->paginate(10);
        return view('orders.index', compact(
            'orders',
            'filterByStatus',
            'filterByNif',
            'filterByDate'
        ));
    }

    public function create(): View
    {
        return view('orders.create');
    }
    public function store(OrderRequest $request): RedirectResponse
    {
        $newOrder = Order::create($request->validated());
        $url = route('orders.show', ['order' => $newOrder]);
        $htmlMessage = "Order <a href='$url'>#{$newOrder->id}</a>
            <strong>\"{$newOrder->nome}\"</strong> foi criada com sucesso!";
        return redirect('/orders')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function edit(Order $order): View
    {
        $this->authorize('cienteNao');
        return view('orders.edit')->withOrder($order);
    }

    public function update(OrderRequest $request, Order $order): RedirectResponse
    {
        $this->authorize('cienteNao');
        $order->update($request->validated());
        if ($order->status == 'closed') {
            $pdf = new PDF(
                $options = new Dompdf(),
                $domPdfOptions = app(Repository::class),
                $app = app(Filesystem::class),
                $config = app(Factory::class)
            );
            // Generate your HTML content here
            $html = view('orders.pdf')->withOrder($order);
            // Generate a random filename
            $randomFilename = Str::random(10) . '.pdf';
            // Specify the directory path for the generated PDF
            $outputDirectory = storage_path('app/pdf_receipts');
            // Combine the directory path and random filename
            $outputFilePath = $outputDirectory . '/' . $randomFilename;
            // Load HTML content into the PDF instance
            $pdf->loadHTML($html);
            // Save the PDF to the specified file path
            $pdf->save($outputFilePath);
            // Store the path in a variable
            $order->receipt_url = $randomFilename;

            $user = User::find($order->customer_id);
            $user->notify(new OrderClosed($order));
            $order->update($request->validated());
        }
        if ($order->status == 'canceled') {
            $user = User::find($order->customer_id);
            $user->notify(new OrderCanceled($order));
            $order->update($request->validated());
        }
        $url = route('orders.show', ['order' => $order]);
        $htmlMessage = "Order <a href='$url'>#{$order->id}</a>
            <strong>\"{$order->user->name}\"</strong> foi alterada com sucesso!";
        return redirect()->route('orders.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $this->authorize('cienteNao');
        try {
            $order->delete();
            $htmlMessage = "Order #{$order->id}
            <strong>\"{$order->nome}\"</strong>
            foi apagada com sucesso!";
            $alertType = 'success';
        } catch (\Exception $error) {
            $url = route('orders.show', ['order' => $order]);
            $htmlMessage = "Não foi possível apagar a order
            <a href='$url'>#{$order->id}</a>
            <strong>\"{$order->user->name}\"</strong> porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return redirect()->route('orders.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function show(Order $order): View
    {
        return view('orders.show')->withOrder($order);
    }

    public function downloadPDF(Order $order)
    {
        $outputDirectory = storage_path('app/pdf_receipts');
        // Replace 'path/to/pdf/file.pdf' with the actual path to your PDF file
        $pdfFilePath = $outputDirectory . '/' . $order->receipt_url;

        return Response::download($pdfFilePath);
    }
}
