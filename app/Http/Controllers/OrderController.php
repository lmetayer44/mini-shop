<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class OrderController extends Controller
{
    public function index()
    {
        return Order::all();
    }

    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'title'       => 'required|string',
            'description' => 'nullable|string',
        ]);
        $order = Order::create($validated);

        // Construisons l’URL publique
        $publicUrl = route('commande.public', ['id' => $order->id])
            . '?token=' . $order->url_token;

        return response()->json([
            'message'    => 'Order created',
            'order'      => $order,
            'public_url' => $publicUrl,
        ], 201);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return $order;
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $validated = $request->validate([
            'title'       => 'sometimes|string',
            'description' => 'sometimes|string|nullable',
        ]);
        $order->update($validated);
        return response()->json(['message' => 'Order updated', 'order' => $order]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(['message' => 'Order deleted']);
    }

    public function showPublic(Request $request, $id)
    {
        $order = $request->attributes->get('order');

        return response()->json($order);
    }
}
