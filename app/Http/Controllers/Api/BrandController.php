<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $cacheKey = 'api_brands_' . md5(json_encode($request->all()));

        $result = Cache::remember($cacheKey, 120, function () use ($request) {
            $query = Brand::query()->withCount('products');

            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            if ($request->filled('is_active')) {
                $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
            }

            $query->ordered();

            $perPage = min((int) $request->input('per_page', 15), 30);
            $brands = $query->paginate($perPage);

            return [
                'success' => true,
                'data' => $brands->items(),
                'meta' => [
                    'current_page' => $brands->currentPage(),
                    'last_page' => $brands->lastPage(),
                    'per_page' => $brands->perPage(),
                    'total' => $brands->total(),
                ],
            ];
        });

        return response()->json($result);
    }

    public function show(int $id): JsonResponse
    {
        $result = Cache::remember("api_brand_{$id}", 120, function () use ($id) {
            $brand = Brand::withCount('products')->find($id);
            return $brand ?: null;
        });

        if (!$result) {
            return response()->json(['success' => false, 'message' => 'Marca não encontrada.'], 404);
        }

        return response()->json(['success' => true, 'data' => $result]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brands,slug',
            'description' => 'nullable|string',
            'logo' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:500',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $brand = Brand::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Marca criada com sucesso.',
            'data' => $brand,
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json(['success' => false, 'message' => 'Marca não encontrada.'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => ['sometimes', 'nullable', 'string', 'max:255', Rule::unique('brands', 'slug')->ignore($brand->id)],
            'description' => 'nullable|string',
            'logo' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:500',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $brand->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Marca atualizada com sucesso.',
            'data' => $brand->fresh(),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $brand = Brand::withCount('products')->find($id);

        if (!$brand) {
            return response()->json(['success' => false, 'message' => 'Marca não encontrada.'], 404);
        }

        if ($brand->products_count > 0) {
            return response()->json([
                'success' => false,
                'message' => "Não é possível excluir. Existem {$brand->products_count} produto(s) vinculado(s).",
            ], 422);
        }

        $brand->delete();

        return response()->json([
            'success' => true,
            'message' => 'Marca excluída com sucesso.',
        ]);
    }
}
