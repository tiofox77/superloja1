<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Pedidos - SuperLoja</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            border-radius: 10px;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .filters {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        
        .filters h3 {
            color: #4f46e5;
            margin-bottom: 10px;
        }
        
        .filter-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
            padding: 5px 10px;
            background-color: white;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 11px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        th {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
        }
        
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        tr:hover {
            background-color: #f3f4f6;
        }
        
        .status {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
            color: white;
        }
        
        .status.pending {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        
        .status.processing {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }
        
        .status.shipped {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }
        
        .status.delivered {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .status.cancelled {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }
        
        .payment-status {
            padding: 3px 6px;
            border-radius: 8px;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
        }
        
        .payment-status.pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .payment-status.paid {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .payment-status.failed {
            background-color: #fecaca;
            color: #991b1b;
        }
        
        .payment-status.refunded {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .total-row {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            font-weight: bold;
            border-top: 2px solid #4f46e5;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 15px;
            background-color: #f8fafc;
            border-radius: 8px;
            font-size: 10px;
            color: #6b7280;
        }
        
        .summary {
            margin-bottom: 20px;
            padding: 15px;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-radius: 8px;
            border: 1px solid #10b981;
        }
        
        .summary h3 {
            color: #065f46;
            margin-bottom: 10px;
        }
        
        .summary-item {
            display: inline-block;
            margin-right: 25px;
            font-weight: bold;
        }
        
        .amount {
            font-weight: bold;
            color: #059669;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de Pedidos</h1>
        <p>SuperLoja - Sistema de Gestão</p>
        <p>Gerado em: {{ $exportDate }}</p>
    </div>

    @if($filters['search'] || $filters['status'] || $filters['payment_status'] || $filters['date_from'] || $filters['date_to'] || $filters['selected_orders'])
    <div class="filters">
        <h3>Filtros Aplicados:</h3>
        @if($filters['selected_orders'])
            <span class="filter-item"><strong>Tipo:</strong> {{ $filters['selected_orders'] }}</span>
        @endif
        @if($filters['search'])
            <span class="filter-item"><strong>Busca:</strong> {{ $filters['search'] }}</span>
        @endif
        @if($filters['status'])
            <span class="filter-item"><strong>Status:</strong> {{ ucfirst($filters['status']) }}</span>
        @endif
        @if($filters['payment_status'])
            <span class="filter-item"><strong>Pagamento:</strong> {{ ucfirst($filters['payment_status']) }}</span>
        @endif
        @if($filters['date_from'])
            <span class="filter-item"><strong>Data Início:</strong> {{ $filters['date_from'] }}</span>
        @endif
        @if($filters['date_to'])
            <span class="filter-item"><strong>Data Fim:</strong> {{ $filters['date_to'] }}</span>
        @endif
    </div>
    @endif

    <div class="summary">
        <h3>Resumo do Relatório</h3>
        <span class="summary-item">Total de Pedidos: {{ $totalOrders }}</span>
        <span class="summary-item">Valor Total: {{ number_format($orders->sum('total_amount'), 2, ',', '.') }} Kz</span>
        <span class="summary-item">Valor Médio: {{ $totalOrders > 0 ? number_format($orders->sum('total_amount') / $totalOrders, 2, ',', '.') : '0,00' }} Kz</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>Número</th>
                <th>Cliente</th>
                <th>Status</th>
                <th>Pagamento</th>
                <th style="text-align: right;">Subtotal</th>
                <th style="text-align: right;">Total</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td><strong>{{ $order->order_number }}</strong></td>
                <td>
                    <strong>{{ $order->user->name ?? 'N/A' }}</strong><br>
                    <small>{{ $order->user->email ?? 'N/A' }}</small>
                </td>
                <td>
                    @php
                        $statusLabels = [
                            'pending' => 'Pendente',
                            'processing' => 'Processando',
                            'shipped' => 'Enviado',
                            'delivered' => 'Entregue',
                            'cancelled' => 'Cancelado'
                        ];
                    @endphp
                    <span class="status {{ $order->status }}">
                        {{ $statusLabels[$order->status] ?? $order->status }}
                    </span>
                </td>
                <td>
                    @php
                        $paymentLabels = [
                            'pending' => 'Pendente',
                            'paid' => 'Pago',
                            'failed' => 'Falhado',
                            'refunded' => 'Reembolsado'
                        ];
                    @endphp
                    <span class="payment-status {{ $order->payment_status }}">
                        {{ $paymentLabels[$order->payment_status] ?? $order->payment_status }}
                    </span>
                </td>
                <td style="text-align: right;">{{ number_format($order->subtotal, 2, ',', '.') }} Kz</td>
                <td style="text-align: right;" class="amount">{{ number_format($order->total_amount, 2, ',', '.') }} Kz</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px; color: #6b7280;">
                    Nenhum pedido encontrado com os filtros aplicados.
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($orders->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="4"><strong>TOTAIS</strong></td>
                <td style="text-align: right;"><strong>{{ number_format($orders->sum('subtotal'), 2, ',', '.') }} Kz</strong></td>
                <td style="text-align: right;"><strong>{{ number_format($orders->sum('total_amount'), 2, ',', '.') }} Kz</strong></td>
                <td><strong>{{ $orders->count() }} pedidos</strong></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        <p>Relatório gerado automaticamente pelo Sistema SuperLoja</p>
        <p>{{ $exportDate }} | Documento confidencial</p>
    </div>
</body>
</html>
