<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SubcategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $cacheKey = 'api_subcategories_' . md5(json_encode($request->all()));

        $result = Cache::remember($cacheKey, 120, function () use ($request) {
            $query = Category::query()
                ->whereNotNull('parent_id')
                ->with(['parent:id,name,slug'])
                ->withCount('products');

            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            if ($request->filled('parent_id')) {
                $query->where('parent_id', $request->parent_id);
            }

            if ($request->filled('is_active')) {
                $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
            }

            $query->ordered();

            $perPage = min((int) $request->input('per_page', 15), 30);
            $subcategories = $query->paginate($perPage);

            return [
                'success' => true,
                'data' => $subcategories->items(),
                'meta' => [
                    'current_page' => $subcategories->currentPage(),
                    'last_page' => $subcategories->lastPage(),
                    'per_page' => $subcategories->perPage(),
                    'total' => $subcategories->total(),
                ],
            ];
        });

        return response()->json($result);
    }

    public function show(int $id): JsonResponse
    {
        $result = Cache::remember("api_subcategory_{$id}", 120, function () use ($id) {
            $subcategory = Category::whereNotNull('parent_id')
                ->with(['parent:id,name,slug'])
                ->withCount('products')
                ->find($id);

            return $subcategory ?: null;
        });

        if (!$result) {
            return response()->json(['success' => false, 'message' => 'Subcategoria não encontrada.'], 404);
        }

        return response()->json(['success' => true, 'data' => $result]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'parent_id' => 'required|exists:categories,id',
            'meta_data' => 'nullable|array',
        ]);

        $parent = Category::whereNull('parent_id')->find($validated['parent_id']);
        if (!$parent) {
            return response()->json([
                'success' => false,
                'message' => 'parent_id deve referenciar uma categoria raiz (não outra subcategoria).',
            ], 422);
        }

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $subcategory = Category::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Subcategoria criada com sucesso.',
            'data' => $subcategory->load('parent:id,name,slug'),
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $subcategory = Category::whereNotNull('parent_id')->find($id);

        if (!$subcategory) {
            return response()->json(['success' => false, 'message' => 'Subcategoria não encontrada.'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => ['sometimes', 'nullable', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($subcategory->id)],
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'parent_id' => 'sometimes|required|exists:categories,id',
            'meta_data' => 'nullable|array',
        ]);

        if (isset($validated['parent_id'])) {
            $parent = Category::whereNull('parent_id')->find($validated['parent_id']);
            if (!$parent) {
                return response()->json([
                    'success' => false,
                    'message' => 'parent_id deve referenciar uma categoria raiz.',
                ], 422);
            }
        }

        $subcategory->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Subcategoria atualizada com sucesso.',
            'data' => $subcategory->fresh(['parent:id,name,slug']),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $subcategory = Category::whereNotNull('parent_id')->withCount('products')->find($id);

        if (!$subcategory) {
            return response()->json(['success' => false, 'message' => 'Subcategoria não encontrada.'], 404);
        }

        if ($subcategory->products_count > 0) {
            return response()->json([
                'success' => false,
                'message' => "Não é possível excluir. Existem {$subcategory->products_count} produto(s) vinculado(s).",
            ], 422);
        }

        $subcategory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subcategoria excluída com sucesso.',
        ]);
    }
}
