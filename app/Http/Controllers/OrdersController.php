<?php

namespace App\Http\Controllers;

use DB;
use App\Order;
use Illuminate\Http\Request;
use App\OrderProduct;
use App\Http\Requests\OrdersRequest;

// use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
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
        /* used to list all the orders */

        $order = DB::table('orders')
            ->join('order_products', 'orders.id', '=', 'order_products.order_id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->select(
                'orders.id',
                'orderId',
                'orders.status',
                'orders.shippingDate',
                'orders.comments',
                'orders.updated_at',
                // DB::raw('orders.price * orders.quantity as totals'), //, 'orders.price * orders.quantity'
                DB::raw('SUM(order_products.priceEach * order_products.quantity) as totals'), //, 'orders.price * orders.quantity'
                'customers.name as user_name'
            )
            ->whereNull('orders.deleted_at')
            ->groupBy('orders.orderId')
            ->latest('orders.updated_at')
            ->get();
        // return "hello";
        return $order;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /* public function store(Request $request)
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
            // $order->customer_id = auth()->guard('customer')->user()->id;
            $order->customer_id = 1;
            $order->updated_by = 1;
            $order->comments = null;
            $order->status = 'incomplete';
            $order->shippingDate = null;
            $order->save();

            foreach ($moreProductsInStock as $key => $value) {
                foreach ($cart_products as $product) {
                    if ($value->productId == $product['prodId']) {
                        $orderProduct = new OrderProduct();

                        $orderProduct->order_Id = $order->id;
                        $orderProduct->product_Id = $value->id;
                        $orderProduct->lineItemsNo = $key + 1;
                        $orderProduct->priceEach = $value->price;
                        $orderProduct->quantity = $product['qty'];
                        $orderProduct->updated_by = 1;
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
    } */

    /**
     * Display the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($order)
    {
        // used to shown the products in a single order

        $getOrder = DB::table('orders')
            ->join('order_products', 'orders.id', '=', 'order_products.order_id')
            ->join('products', 'order_products.product_id', '=', 'products.id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->select(
                'orders.id',
                'orderId',
                'orders.status',
                'orders.shippingDate',
                'orders.updated_at',
                'products.title as productTitle',
                'order_products.priceEach as price',
                'order_products.quantity',
                'order_products.status as order_status',
                DB::raw('order_products.priceEach * order_products.quantity as totals'),
                'customers.name as user_name'
            )
            ->where('orders.orderId', '=', $order)
            ->get();

        return $getOrder;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrdersRequest $request)
    {
        // return $request;
        $order = Order::find($request->id);

        $order->comments = $request->comments;
        $order->status = $request->status;
        $order->shippingDate = $request->shippingDate;

        $order->save();

        return response()->json(['success' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($order)
    {
        // return "hee";
        $order = Order::destroy(explode(",", $order));

        return response()->json(['success' => "Deleted successfully !!!!"]);
    }
    // public function generateOrderNumber()
    // {
    //     $random_id = "OR" . rand(1, 5);
    //     $checkExistence = DB::table('orders')->select('id')->where('orderId', 'OR1')->get();

    //     return $checkExistence;
    // }
}