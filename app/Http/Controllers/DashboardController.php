<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Order;
use Carbon\Carbon;
use App\OrderProduct;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function __construct()
    {

        // $this->middleware('auth:admin');

        $this->firstDay = new Carbon('first day of this month');
        $this->lastDay = new Carbon('last day of this month');
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
    public function summaries()
    {
        $customers = Customer::count();
        $sales = OrderProduct::whereBetween('created_at', [$this->firstDay->subDay(), $this->lastDay])->sum('quantity');
        $orders = Order::whereBetween('created_at', [$this->firstDay->subDay(), $this->lastDay])->count();

        // return $this->firstDay->subDay();
        // return response()->json(['customers' => auth()->id()]);
        return response()->json(['customers' => $customers, 'sales' => $sales, 'orders' => $orders]);
    }

    public function products()
    {

        // $orders = Order::whereBetween('created_at', [$this->firstDay, $this->lastDay])->count();

        $products = DB::table('order_products')
            ->join('products', 'products.id', '=', 'order_products.product_id')
            ->select(
                'products.id',
                'title',
                'products.quantity',
                DB::raw('sum(order_products.quantity) as `totalSales`')
            )
            ->groupBy('product_id')
            ->get();
        // return $products;

        $originalQuantity = [];
        $sales = [];
        $title = [];

        foreach ($products as $value) {
            $originalQuantity[] = $value->quantity;
            $sales[] = $value->totalSales;
            $title[] = $value->title;
        }

        $data = [
            'quantity' => $originalQuantity,
            'sales' => $sales,
            'products' => $title
        ];

        return $data;
    }

    public function sales()
    {
        // $sales = OrderProduct::whereBetween('created_at', [$this->firstDay, $this->lastDay])->sum('lineItemsNo');
        /* $sales = SELECT SUM(`quantity`), `product_id`,  MONTH(created_at) FROM order_products
        GROUP BY product_id, MONTH(created_at) ORDER BY MONTH(created_at) DESC; */
        $sales = DB::table('order_products')
            ->select(
                'product_id',
                DB::raw('sum(quantity) as `totals`'),
                DB::raw('MONTH(created_at) month')
            )
            ->groupBy('month')
            ->get();

        $months = [];
        $totals = [];
        // $products = [];

        foreach ($sales as $value) {
            $months[] = date("F", mktime(0, 0, 0, $value->month, 10));
            $totals[] = $value->totals;
            // $products[] = $value->product_id;
        }

        $data = [
            'months' => $months,
            'totals' => $totals,
            // 'products' => $products
        ];

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}