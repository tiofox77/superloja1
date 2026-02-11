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

        // Tipos suportados para visualização inline (streaming)
        $supportedTypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/svg+xml',
            'application/pdf'
        ];

        // Retorna arquivo para visualização inline (streaming)
        if (in_array($mimeType, $supportedTypes)) {
            return response()->file($filePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="comprovativo_' . $order->order_number . '"'
            ]);
        }

        // Para tipos não suportados, retorna inline mesmo assim (usuário pode baixar via browser)
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="comprovativo_' . $order->order_number . '"'
        ]);
    }
}
