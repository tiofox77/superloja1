<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Diretório de armazenamento de imagens
     */
    protected const IMAGES_DIR = 'products';

    /**
     * Campos retornados pela API (leve e otimizado)
     */
    protected const API_FIELDS = [
        'id', 'name', 'description', 'price', 'sale_price',
        'stock_quantity', 'featured_image', 'images',
    ];

    public function index(Request $request): JsonResponse
    {
        $query = Product::query()
            ->select(self::API_FIELDS);

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->filled('is_featured')) {
            $query->where('is_featured', filter_var($request->is_featured, FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->filled('in_stock')) {
            $query->where('stock_quantity', '>', 0);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $sortDir = $request->input('sort_dir', 'desc');
        $allowedSorts = ['name', 'price', 'stock_quantity', 'created_at', 'order_count', 'view_count'];
        
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        $perPage = min((int) $request->input('per_page', 15), 100);
        $products = $query->paginate($perPage);

        // Formatar resposta leve
        $products->getCollection()->transform(function ($product) {
            return $this->formatProduct($product);
        });

        return response()->json([
            'success' => true,
            'data' => $products->items(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }

    /**
     * Ver Produto Específico
     */
    public function show(int $id): JsonResponse
    {
        $product = Product::select(self::API_FIELDS)->find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produto não encontrado.'], 404);
        }

        return response()->json(['success' => true, 'data' => $this->formatProduct($product)]);
    }

    /**
     * Criar Produto com Imagens
     * POST /api/v1/products
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'barcode' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'manage_stock' => 'nullable|boolean',
            'stock_status' => 'nullable|string|in:in_stock,out_of_stock,on_backorder',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'condition' => 'nullable|string|in:new,used,refurbished',
            'condition_notes' => 'nullable|string',
            'is_digital' => 'nullable|boolean',
            'is_virtual' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'attributes' => 'nullable|array',
            'specifications' => 'nullable|array',
        ]);

        // Gerar slug automaticamente se não fornecido
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Processar imagem de destaque (upload)
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->uploadImage($request->file('featured_image'));
        }

        // Processar múltiplas imagens (upload)
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $this->uploadImage($image);
            }
            $validated['images'] = $images;
        }

        $product = Product::create($validated);

        // Se há imagens mas nenhuma definida como destaque, usar a primeira
        if (!empty($images) && empty($validated['featured_image'])) {
            $product->update(['featured_image' => $images[0]]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produto criado com sucesso.',
            'data' => $this->formatProduct($product),
        ], 201);
    }

    /**
     * Atualizar Produto com Imagens
     * PUT /api/v1/products/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produto não encontrado.'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => ['sometimes', 'nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product->id)],
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'sku' => ['sometimes', 'nullable', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($product->id)],
            'barcode' => 'nullable|string|max:100',
            'price' => 'sometimes|required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'manage_stock' => 'nullable|boolean',
            'stock_status' => 'nullable|string|in:in_stock,out_of_stock,on_backorder',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'condition' => 'nullable|string|in:new,used,refurbished',
            'condition_notes' => 'nullable|string',
            'is_digital' => 'nullable|boolean',
            'is_virtual' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'delete_images' => 'nullable|array', // Array de caminhos para删除
            'attributes' => 'nullable|array',
            'specifications' => 'nullable|array',
        ]);

        // Processar nova imagem de destaque (upload)
        if ($request->hasFile('featured_image')) {
            // Excluir imagem anterior se existir
            if ($product->featured_image) {
                $this->deleteImage($product->featured_image);
            }
            $validated['featured_image'] = $this->uploadImage($request->file('featured_image'));
        }

        // Processar novas imagens adicionais (upload)
        if ($request->hasFile('images')) {
            $existingImages = $product->images ?? [];
            foreach ($request->file('images') as $image) {
                $existingImages[] = $this->uploadImage($image);
            }
            $validated['images'] = $existingImages;
        }

        // Eliminar imagens especificadas
        if ($request->filled('delete_images')) {
            $imagesToDelete = $request->delete_images;
            $existingImages = $product->images ?? [];
            
            foreach ($imagesToDelete as $imagePath) {
                $this->deleteImage($imagePath);
                $existingImages = array_values(array_diff($existingImages, [$imagePath]));
            }
            
            $validated['images'] = $existingImages;
            
            // Se a imagem de destaque foi eliminada, definir nova
            if (in_array($product->featured_image, $imagesToDelete) && !empty($existingImages)) {
                $product->update(['featured_image' => $existingImages[0]]);
            }
        }

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Produto atualizado com sucesso.',
            'data' => $this->formatProduct($product->fresh()),
        ]);
    }

    /**
     * Eliminar Produto
     * DELETE /api/v1/products/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produto não encontrado.'], 404);
        }

        // Eliminar imagens associadas
        if ($product->featured_image) {
            $this->deleteImage($product->featured_image);
        }

        if ($product->images) {
            foreach ($product->images as $image) {
                $this->deleteImage($image);
            }
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produto excluído com sucesso.',
        ]);
    }

    /**
     * Upload de imagem para o storage
     */
    protected function uploadImage($file): string
    {
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs(self::IMAGES_DIR, $filename, 'public');
        
        return $path;
    }

    /**
     * Eliminar imagem do storage
     */
    protected function deleteImage(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }

    /**
     * Formatar produto para resposta da API (campos leves)
     */
    protected function formatProduct($product): array
    {
        $data = [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => (float) $product->price,
            'sale_price' => $product->sale_price ? (float) $product->sale_price : null,
            'stock_quantity' => (int) $product->stock_quantity,
            'featured_image_url' => $product->featured_image
                ? asset('storage/' . $product->featured_image)
                : null,
            'image_urls' => $product->images
                ? array_map(fn($img) => asset('storage/' . $img), $product->images)
                : [],
        ];

        return $data;
    }
}
