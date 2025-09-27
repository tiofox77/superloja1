<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /**
     * Get cart items from session
     */
    public function getItems(Request $request): JsonResponse
    {
        $cartItems = session()->get('cart.items', []);
        
        return response()->json([
            'success' => true,
            'items' => $cartItems,
            'count' => array_sum(array_column($cartItems, 'quantity'))
        ]);
    }
    
    /**
     * Update cart items in session
     */
    public function updateCart(Request $request): JsonResponse
    {
        $request->validate([
            'items' => 'array',
            'items.*.id' => 'required|integer',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.image' => 'nullable|string',
            'items.*.sku' => 'nullable|string'
        ]);
        
        $items = $request->input('items', []);
        session()->put('cart.items', $items);
        
        return response()->json([
            'success' => true,
            'message' => 'Carrinho atualizado com sucesso',
            'count' => array_sum(array_column($items, 'quantity'))
        ]);
    }
    
    /**
     * Add item to cart
     */
    public function addItem(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'integer|min:1',
            'image' => 'nullable|string',
            'sku' => 'nullable|string'
        ]);
        
        $cartItems = session()->get('cart.items', []);
        $newItem = $request->only(['id', 'name', 'price', 'quantity', 'image', 'sku']);
        $newItem['quantity'] = $newItem['quantity'] ?? 1;
        
        // Check if item already exists
        $existingIndex = null;
        foreach ($cartItems as $index => $item) {
            if ($item['id'] == $newItem['id']) {
                $existingIndex = $index;
                break;
            }
        }
        
        if ($existingIndex !== null) {
            // Update existing item quantity
            $cartItems[$existingIndex]['quantity'] += $newItem['quantity'];
        } else {
            // Add new item
            $cartItems[] = $newItem;
        }
        
        session()->put('cart.items', $cartItems);
        
        return response()->json([
            'success' => true,
            'message' => 'Produto adicionado ao carrinho',
            'count' => array_sum(array_column($cartItems, 'quantity'))
        ]);
    }
    
    /**
     * Remove item from cart
     */
    public function removeItem(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|integer'
        ]);
        
        $cartItems = session()->get('cart.items', []);
        $itemId = $request->input('id');
        
        $cartItems = array_values(array_filter($cartItems, fn($item) => $item['id'] != $itemId));
        
        session()->put('cart.items', $cartItems);
        
        return response()->json([
            'success' => true,
            'message' => 'Produto removido do carrinho',
            'count' => array_sum(array_column($cartItems, 'quantity'))
        ]);
    }
    
    /**
     * Clear cart
     */
    public function clearCart(Request $request): JsonResponse
    {
        session()->forget('cart.items');
        
        return response()->json([
            'success' => true,
            'message' => 'Carrinho limpo'
        ]);
    }
}
