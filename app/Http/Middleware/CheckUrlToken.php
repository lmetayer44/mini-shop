<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Order;

class CheckUrlToken
{
    public function handle(Request $request, Closure $next)
    {
        // 1) Récupérer l'id depuis la route (ex: /commande/{id})
        $id = $request->route('id');

        // 2) Récupérer le token depuis l’URL ?token=XYZ
        $token = $request->query('token');

        // 3) Retrouver l'entité concernée, ici "Order"
        //    (ou tu peux faire autrement selon ta logique)Z
        $order = Order::find($id);
        if (! $order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 4) Vérifier la correspondance du token
        if ($order->url_token !== $token) {
            return response()->json(['message' => 'Invalid token'], 403);
        }

        // 5) Tout est bon => On peut continuer
        // Optionnel : injecter $order dans la request
        $request->attributes->set('order', $order);

        return $next($request);
    }
}
