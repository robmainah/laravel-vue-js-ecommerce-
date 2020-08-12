<?php

namespace App\Http\Controllers;

// use App\customer;
use Illuminate\Http\Request;
// use App\Http\Requests\CustomersRequest;
use DB;
use App\Order;
use Auth;
// use App\OrderProduct;
// use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\OrderProduct;

class CustomerController extends Controller
{

    use AuthenticatesUsers;

    //  protected $guard = 'customer';

    // protected $redirectTo = '/home';

    public function __construct()
    {
        // $this->middleware('guest')->except(['show', 'logout', 'checkAuthentication']);
        // $this->middleware('guest');
        $this->middleware('auth')->except(['index', 'checkAuth', 'products']);
    }

    public function index()
    {
        return view('index');
    }

    public function products()
    {
        //get data for the client side
        $product = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'productId',
                'title',
                'slug',
                'description',
                'price',
                'quantity',
                'image',
                'products.updated_at',
                'category_name as category'
            )
            ->whereNull('products.deleted_at')
            ->get();

        $categories = DB::table('categories')
            ->select(
                'category_name'
            )
            ->whereNull('categories.deleted_at')
            ->get();

        return response()->json(['products' => $product, 'categories' => $categories]);
    }

    public function checkAuth(Request $request)
    {
        if (Auth::check()) {
            return $this->sendLoginResponse($request);
        }

        return $this->login($request);
    }

    public function myAccount()
    {
        return view('index');
    }

    public function purchaseHistory()
    {
        $user = Auth::id();
        $orderProduct = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->join('products', 'order_products.product_id', '=', 'products.id')
            ->join('order_tracks AS tracks', 'orders.id', '=', 'tracks.order_id')
            ->select(
                'priceEach as price',
                'order_products.id as prod_id',
                'order_products.quantity as qty',
                'products.image',
                'products.title',
                'orders.orderId as orderNo',
                'orders.status',
                'orders.shippingDate',
                'orders.comments',
                'orders.updated_at',
                DB::raw('SUM(order_products.priceEach * order_products.quantity) as totals') //, 'orders.price * orders.quantity'
            )
            // ->where('order_products.created_by', $user)
            ->where('tracks.orderable_id', $user)
            ->whereIn('orders.status', ['complete', 'cancelled'])
            ->whereNull('orders.deleted_at')
            ->whereNull('order_products.deleted_at')
            ->groupBy('order_products.id')
            ->latest('order_products.updated_at')
            ->get();

        return response()->json(['orders' => $orderProduct]);
    }

    public function currentBasket()
    {
        $user = Auth::id();
        // $order = Order::select('id', 'orderId', 'status', 'comments', 'shippingDate', 'updated_at')
        //     ->where('created_by', $user)
        //     ->with('orderProducts')
        //     ->get();
        // $orderProduct = OrderProduct::select('id', 'order_id', 'product_id', 'priceEach', 'quantity', 'updated_at')
        //     ->where('created_by', $user)->with('orders')->with('products')->get();
        $orderProduct = DB::table('order_products')
            ->join('orders AS ord', 'order_products.order_id', '=', 'ord.id')
            ->join('products AS prod', 'order_products.product_id', '=', 'prod.id')
            ->join('order_tracks AS tracks', 'ord.id', '=', 'tracks.order_id')
            ->select(
                'priceEach as price',
                'order_products.quantity as qty',
                'order_products.id as prod_id',
                'prod.image',
                'prod.title',
                'ord.orderId as orderNo',
                'ord.status',
                'ord.shippingDate',
                'ord.updated_at',
                // DB::raw('orders.price * orders.quantity as totals'), //, 'orders.price * orders.quantity'
                DB::raw('SUM(order_products.priceEach * order_products.quantity) as totals') //, 'orders.price * orders.quantity'
            )
            ->where('tracks.orderable_id', $user)
            // ->where('tracks.orderable_id', $user)
            ->where('ord.status', 'incomplete')
            ->whereNull('ord.deleted_at')
            ->whereNull('order_products.deleted_at')
            ->groupBy('order_products.id')
            ->latest('order_products.updated_at')
            ->get();

        return response()->json(['orders' => $orderProduct]);
    }

    public function cancelOrder(Request $request)
    {
        $id = Order::getOrderId($request->order);
        $order = Order::where('id', $id)->update(['status' => 'cancelled']);

        return response()->json(['cancelled' => true]);
    }

    public function destroyOrder(Request $request)
    {
        // return $request->product;
        // $id = OrderProduct::getOrderId($request->product);
        $order = OrderProduct::destroy($request->product);

        return response()->json(['deleted' => true]);
    }
}