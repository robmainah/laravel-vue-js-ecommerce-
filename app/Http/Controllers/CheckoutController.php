<?php

namespace App\Http\Controllers;

use App\checkout;
use DB;
use App\Order;
use Illuminate\Http\Request;
use App\OrderProduct;
use App\Http\Requests\OrdersRequest;
use App\OrderTrack;
use Illuminate\Support\Facades\Auth;
use App\Product;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }


    public function index()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;

        $cart_products = collect($request);
        $productsId = $cart_products->map(function ($item, $key) {
            return $item['prodId'];
        });

        $getProductsData =  DB::table('products')
            ->select('id', 'title', 'productId', 'quantity', 'price')
            ->whereIn('productId', $productsId)
            ->get();

        $cart_products = $cart_products->sortBy('prodId')->values();
        $getProductsData = $getProductsData->sortBy('productId')->values();

        $moreProductsInStock = [];
        $lessProductsInStock = [];
        $newProductQuantities = [];
        foreach ($getProductsData as $key => $product) {
            $stockDiff = $product->quantity - $cart_products[$key]['qty'];

            if ($stockDiff >= 0) {
                $moreProductsInStock[$key] = $product;
                $newProductQuantities[] = ["id" => $product->id, "newQuantity" => $stockDiff];
            } else {
                $lessProductsInStock[$key] = ['title' => $product->title, 'qty' => abs($stockDiff)];
            }
        }

        $countFewStock = count($lessProductsInStock);
        if ($countFewStock > 0) {
            return response()->json(['fewStock' => $lessProductsInStock]);
        }

        if (count($moreProductsInStock) > 0) {

            $order = new Order();
            $order->orderId = Order::generateOrderNumber();
            $order->customer_id = auth()->user()->id;
            // $order->customer_id = 1;
            // $order->created_by = auth()->user()->id;
            // $order->updated_by = auth()->user()->id;
            $order->comments = null;
            $order->status = 'incomplete';
            $order->shippingDate = null;
            $order->save();

            $orderTrack = new OrderTrack();
            $orderTrack->content = 'created';
            $orderTrack->order_id = $order->id;
            $orderTrack->orderable_type = 'customer';
            $orderTrack->orderable_id = Auth::id();
            $orderTrack->save();

            foreach ($moreProductsInStock as $key => $value) {
                foreach ($cart_products as $product) {
                    if ($value->productId == $product['prodId']) {
                        $orderProduct = new OrderProduct();

                        $orderProduct->order_Id = $order->id;
                        $orderProduct->product_Id = $value->id;
                        $orderProduct->lineItemsNo = $key + 1;
                        $orderProduct->priceEach = $value->price;
                        $orderProduct->quantity = $product['qty'];
                        // $orderProduct->created_by = auth()->user()->id;
                        // $orderProduct->updated_by = auth()->user()->id;
                        $orderProduct->status = "incomplete";

                        $orderProduct->save();
                    }
                }
            }

            foreach ($newProductQuantities as $key => $product) {
                Product::where('id', $product['id'])->update(['quantity' => $product['newQuantity']]);
            }

            return response()->json(['success' => 'success']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function show(checkout $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function edit(checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function destroy(checkout $checkout)
    {
        //
    }
}
