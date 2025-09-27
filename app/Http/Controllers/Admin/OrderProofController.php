<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class OrderProofController extends Controller
{
    public function download($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        if (!$order->payment_proof) {
            abort(404, 'Comprovativo não encontrado');
        }

        if (!Storage::disk('public')->exists($order->payment_proof)) {
            abort(404, 'Arquivo não encontrado');
        }

        $filePath = Storage::disk('public')->path($order->payment_proof);
        $fileName = 'comprovativo_pedido_' . $order->order_number . '.' . pathinfo($order->payment_proof, PATHINFO_EXTENSION);

        return response()->download($filePath, $fileName);
    }

    public function view($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        if (!$order->payment_proof) {
            abort(404, 'Comprovativo não encontrado');
        }

        if (!Storage::disk('public')->exists($order->payment_proof)) {
            abort(404, 'Arquivo não encontrado');
        }

        $filePath = Storage::disk('public')->path($order->payment_proof);
        $mimeType = Storage::disk('public')->mimeType($order->payment_proof);

        // Verifica se é uma imagem ou PDF para visualização inline
        if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'])) {
            return response()->file($filePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="comprovativo_' . $order->order_number . '"'
            ]);
        }

        // Para outros tipos, força o download
        return $this->download($orderId);
    }
}
