<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderExportController extends Controller
{
    public function exportPdf(Request $request)
    {
        $query = Order::with(['user']);
        
        // Se há pedidos selecionados, exportar apenas esses
        if ($request->has('selected_ids') && $request->selected_ids) {
            $selectedIds = explode(',', $request->selected_ids);
            $orders = $query->whereIn('id', $selectedIds)->orderBy('created_at', 'desc')->get();
        } else {
            // Aplicar filtros normais se não há pedidos selecionados
            if ($request->has('search') && $request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('order_number', 'like', '%' . $request->search . '%')
                      ->orWhereHas('user', function($userQuery) use ($request) {
                          $userQuery->where('name', 'like', '%' . $request->search . '%')
                                   ->orWhere('email', 'like', '%' . $request->search . '%');
                      });
                });
            }
            
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }
            
            if ($request->has('payment_status') && $request->payment_status) {
                $query->where('payment_status', $request->payment_status);
            }
            
            if ($request->has('date_from') && $request->date_from) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            
            if ($request->has('date_to') && $request->date_to) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            
            $orders = $query->orderBy('created_at', 'desc')->get();
        }
        
        $data = [
            'orders' => $orders,
            'totalOrders' => $orders->count(),
            'exportDate' => now()->format('d/m/Y H:i'),
            'filters' => [
                'search' => $request->search ?? '',
                'status' => $request->status ?? '',
                'payment_status' => $request->payment_status ?? '',
                'date_from' => $request->date_from ?? '',
                'date_to' => $request->date_to ?? '',
                'selected_orders' => $request->has('selected_ids') && $request->selected_ids ? 'Pedidos selecionados' : ''
            ]
        ];

        $pdf = Pdf::loadView('admin.exports.orders', $data);
        $pdf->setPaper('A4', 'landscape');
        
        $filename = 'pedidos_' . now()->format('Y-m-d_His') . '.pdf';
        
        return $pdf->download($filename);
    }
    
    public function exportCsv(Request $request)
    {
        $query = Order::with(['user']);
        
        // Se há pedidos selecionados, exportar apenas esses
        if ($request->has('selected_ids') && $request->selected_ids) {
            $selectedIds = explode(',', $request->selected_ids);
            $orders = $query->whereIn('id', $selectedIds)->orderBy('created_at', 'desc')->get();
        } else {
            // Aplicar filtros normais se não há pedidos selecionados
            if ($request->has('search') && $request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('order_number', 'like', '%' . $request->search . '%')
                      ->orWhereHas('user', function($userQuery) use ($request) {
                          $userQuery->where('name', 'like', '%' . $request->search . '%')
                                   ->orWhere('email', 'like', '%' . $request->search . '%');
                      });
                });
            }
            
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }
            
            if ($request->has('payment_status') && $request->payment_status) {
                $query->where('payment_status', $request->payment_status);
            }
            
            if ($request->has('date_from') && $request->date_from) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            
            if ($request->has('date_to') && $request->date_to) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            
            $orders = $query->orderBy('created_at', 'desc')->get();
        }
        
        $csv = "Número;Cliente;Email;Status;Pagamento;Subtotal;Total;Data\n";
        
        foreach ($orders as $order) {
            $csv .= sprintf(
                '"%s";"%s";"%s";"%s";"%s";"%s";"%s";"%s"' . "\n",
                $order->order_number,
                str_replace('"', '""', $order->user->name ?? 'N/A'),
                $order->user->email ?? 'N/A',
                $order->status,
                $order->payment_status,
                number_format((float)$order->subtotal, 2, ',', '.'),
                number_format((float)$order->total_amount, 2, ',', '.'),
                $order->created_at->format('d/m/Y H:i')
            );
        }
        
        $filename = 'pedidos_' . now()->format('Y-m-d_His') . '.csv';
        
        return response($csv)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Length', strlen($csv));
    }
}
