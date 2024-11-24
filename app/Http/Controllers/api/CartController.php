<?php

namespace App\Http\Controllers\api;

use App\Http\Services\api\CartService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\CartRequest;

class CartController extends Controller
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function addToCart(CartRequest $request)
    {
        return $this->cartService->addToCart($request);
    }

    public function getAllTicketsCart()
    {
        return $this->cartService->getAllTicketsCart();
    }

    public function deleteFromCart($id)
    {
        return $this->cartService->deleteFromCart($id);
    } 

}
