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

class CategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $cacheKey = 'api_categories_' . md5(json_encode($request->all()));

        $result = Cache::remember($cacheKey, 120, function () use ($request) {
            $query = Category::query()
                ->whereNull('parent_id')
                ->withCount(['products', 'children']);

            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            if ($request->filled('is_active')) {
                $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
            }

            if ($request->boolean('with_children')) {
                $query->with(['children' => fn($q) => $q->ordered()->withCount('products')]);
            }

            $query->ordered();

            $perPage = min((int) $request->input('per_page', 15), 30);
            $categories = $query->paginate($perPage);

            return [
                'success' => true,
                'data' => $categories->items(),
                'meta' => [
                    'current_page' => $categories->currentPage(),
                    'last_page' => $categories->lastPage(),
                    'per_page' => $categories->perPage(),
                    'total' => $categories->total(),
                ],
            ];
        });

        return response()->json($result);
    }

    public function show(int $id): JsonResponse
    {
        $result = Cache::remember("api_category_{$id}", 120, function () use ($id) {
            $category = Category::withCount(['products', 'children'])
                ->with(['children' => fn($q) => $q->ordered()->withCount('products')])
                ->find($id);

            if (!$category || $category->parent_id !== null) {
                return null;
            }

            return $category;
        });

        if (!$result) {
            return response()->json(['success' => false, 'message' => 'Categoria não encontrada.'], 404);
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
            'meta_data' => 'nullable|array',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['parent_id'] = null;

        $category = Category::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Categoria criada com sucesso.',
            'data' => $category,
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $category = Category::whereNull('parent_id')->find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Categoria não encontrada.'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => ['sometimes', 'nullable', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($category->id)],
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'meta_data' => 'nullable|array',
        ]);

        $category->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Categoria atualizada com sucesso.',
            'data' => $category->fresh(),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $category = Category::whereNull('parent_id')->withCount(['products', 'children'])->find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Categoria não encontrada.'], 404);
        }

        if ($category->products_count > 0) {
            return response()->json([
                'success' => false,
                'message' => "Não é possível excluir. Existem {$category->products_count} produto(s) vinculado(s).",
            ], 422);
        }

        if ($category->children_count > 0) {
            return response()->json([
                'success' => false,
                'message' => "Não é possível excluir. Existem {$category->children_count} subcategoria(s) vinculada(s).",
            ], 422);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Categoria excluída com sucesso.',
        ]);
    }
}
