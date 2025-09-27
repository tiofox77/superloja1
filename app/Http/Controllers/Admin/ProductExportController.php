<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ProductExportController extends Controller
{
    public function exportPdf(Request $request)
    {
        $query = Product::with(['category', 'brand']);
        
        // Se há produtos selecionados, exportar apenas esses
        if ($request->has('selected_ids') && $request->selected_ids) {
            $selectedIds = explode(',', $request->selected_ids);
            $products = $query->whereIn('id', $selectedIds)->orderBy('created_at', 'desc')->get();
        } else {
            // Aplicar filtros normais se não há produtos selecionados
            if ($request->has('search') && $request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('sku', 'like', '%' . $request->search . '%');
                });
            }
            
            if ($request->has('category') && $request->category) {
                $query->where('category_id', $request->category);
            }
            
            if ($request->has('brand') && $request->brand) {
                $query->where('brand_id', $request->brand);
            }
            
            if ($request->has('status') && $request->status !== '') {
                $query->where('is_active', $request->status);
            }
            
            $products = $query->orderBy('created_at', 'desc')->get();
        }
        
        $data = [
            'products' => $products,
            'totalProducts' => $products->count(),
            'exportDate' => now()->format('d/m/Y H:i'),
            'filters' => [
                'search' => $request->search ?? '',
                'category' => $request->category ? Category::find($request->category)->name ?? '' : '',
                'brand' => $request->brand ? Brand::find($request->brand)->name ?? '' : '',
                'status' => $request->status ?? '',
                'selected_products' => $request->has('selected_ids') && $request->selected_ids ? 'Produtos selecionados' : ''
            ]
        ];

        $pdf = Pdf::loadView('admin.exports.products', $data);
        $pdf->setPaper('A4', 'landscape');
        
        $filename = 'produtos_' . now()->format('Y-m-d_His') . '.pdf';
        
        return $pdf->download($filename);
    }
    
    public function exportCsv(Request $request)
    {
        $query = Product::with(['category', 'brand']);
        
        // Se há produtos selecionados, exportar apenas esses
        if ($request->has('selected_ids') && $request->selected_ids) {
            $selectedIds = explode(',', $request->selected_ids);
            $products = $query->whereIn('id', $selectedIds)->orderBy('created_at', 'desc')->get();
        } else {
            // Aplicar filtros normais se não há produtos selecionados
            if ($request->has('search') && $request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('sku', 'like', '%' . $request->search . '%');
                });
            }
            
            if ($request->has('category') && $request->category) {
                $query->where('category_id', $request->category);
            }
            
            if ($request->has('brand') && $request->brand) {
                $query->where('brand_id', $request->brand);
            }
            
            if ($request->has('status') && $request->status !== '') {
                $query->where('is_active', $request->status);
            }
            
            $products = $query->orderBy('created_at', 'desc')->get();
        }
        
        $csv = "Nome;SKU;Categoria;Marca;Preço;Preço de Venda;Stock;Status;Ativo;Destacado;Data de Criação\n";
        
        foreach ($products as $product) {
            $csv .= sprintf(
                '"%s";"%s";"%s";"%s";"%s";"%s";"%d";"%s";"%s";"%s";"%s"' . "\n",
                str_replace('"', '""', $product->name),
                $product->sku,
                $product->category->name ?? '',
                $product->brand->name ?? '',
                number_format($product->price, 2, ',', '.'),
                $product->sale_price ? number_format($product->sale_price, 2, ',', '.') : '',
                $product->stock_quantity,
                $product->stock_status,
                $product->is_active ? 'Sim' : 'Não',
                $product->is_featured ? 'Sim' : 'Não',
                $product->created_at->format('d/m/Y H:i')
            );
        }

        $filename = 'produtos_' . now()->format('Y-m-d_His') . '.csv';
        
        return response()->streamDownload(function() use ($csv) {
            echo $csv;
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }
}
