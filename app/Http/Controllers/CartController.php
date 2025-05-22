<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Models\Category;

class CartController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'name', 'slug', 'icon_class', 'dark_icon_class', 'image_path', 'dark_image_path')
            ->orderBy('name')
            ->get();

        return view('shop.cart', ['categories' => $categories]);
    }

    public function getCartData(Request $request)
    {
        $userId = Auth::id();
        $query = CartItem::with('product')->where('user_id', $userId);
        return DataTables::of($query)
            ->addColumn('product', function ($item) {
                $img = asset($item->product->image_path);
                $name = e($item->product->name);
                $desc = e($item->product->description);
                return "
                    <div class='d-flex align-items-center'>
                        <img src='{$img}' alt='{$name}' style='width:60px; height:60px; object-fit:cover;' class='me-3 rounded'>
                        <div>
                            <div class='fw-semibold'>{$name}</div>
                            <small class='text-muted'>{$desc}</small>
                        </div>
                    </div>";
            })
            ->addColumn('price', fn($item) => '₹' . number_format($item->product->price, 2))
            ->addColumn('quantity', function ($item) {
                $quantity = $item->quantity;
                $id = $item->id;

                $decrementBtn = $quantity > 1
                    ? "<button class='btn btn-sm btn-outline-secondary me-2 btn-decrement' title='Decrease Quantity'>
                            <i class='fas fa-minus'></i>
                    </button>"
                    : "<button class='btn btn-sm btn-outline-danger me-2 btn-decrement' title='Remove Item'>
                            <i class='fas fa-trash'></i>
                    </button>";

                return "
                <div class='d-flex align-items-center'>
                    {$decrementBtn}
                    <input type='text' class='form-control form-control-sm text-center quantity-input' 
                        data-id='{$id}' value='{$quantity}' readonly style='width: 50px;' />
                    <button class='btn btn-sm btn-outline-secondary ms-2 btn-increment' title='Increase Quantity'>
                        <i class='fas fa-plus'></i>
                    </button>
                </div>";
            })
            ->addColumn('total', fn($item) => '₹' . number_format($item->product->price * $item->quantity, 2))
            ->rawColumns(['product', 'quantity', 'total'])
            ->make(true);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        $cartItem = CartItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return response()->json([
            'success' => true,
            'cartCount' => CartItem::where('user_id', $userId)->sum('quantity')
        ]);
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();

        $cartItem = CartItem::where('id', $request->cart_item_id)
            ->where('user_id', $userId)
            ->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Cart item not found.'], 404);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json(['success' => true]);
    }

    public function remove($id)
    {
        $userId = Auth::id();
        $cartItem = CartItem::where('user_id', $userId)->where('id', $id)->first();

        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found.']);
    }
}
