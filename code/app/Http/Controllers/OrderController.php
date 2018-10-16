<?php

namespace App\Http\Controllers;

use App\Distance;
use App\Orders;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //$start  int
    //$limit  int
    public function orders(Request $request)
    {
        if(!isset($request->limit))
            $limit = 10;
        else
            $limit = $request->limit;

        if(!isset($request->page))
            $offset = 0;
        else
            $offset = $request->page * $limit;

        $orders = DB::table('orders')->skip($offset)->take($limit)->get();

        if (!$orders) {
            return response()->json(['message' => 'No_DATA_FOUND'], 400);
        }

        return response()->json($orders, 200);
    }

//  $request post_data
    public function store(Request $request)
    {
        if(!isset($request->origin) || !isset($request->destination)) {
            return response()->json([
                'code' => 500,
                'message' => 'Cannot process request source / destination missing',
            ], 500);
        }

        $startLatitude = $request->origin[0];
        $endLatitude = $request->destination[0];
        $startLongitude = $request->origin[1];
        $endLongitude = $request->destination[1];

        $distanceData = DB::table('distance')->where([
                    ['start_latitude', '=', $startLatitude],
                    ['start_longitude', '=', $startLongitude],
                    ['end_latitude', '=', $endLatitude],
                    ['end_longitude', '=', $endLongitude],
                ])->get();

//      validating to get data from google api with existing records
        if(empty($distanceData)) {
            $origin = $startLatitude .",". $startLongitude;
            $destination = $endLatitude .",". $endLongitude;
            $totalDis = $this->getDistance($origin, $destination);
        } else {
            $totalDis = $distanceData[0]->distance;
        }

//      inserting data in distance table
        $distance = new Distance;
        $distance->start_latitude = $startLatitude;
        $distance->start_longitude = $startLongitude;
        $distance->end_latitude = $endLatitude;
        $distance->end_longitude = $endLongitude;
        $distance->distance = $totalDis;
        $distance->save();

//      inserting data in orders table
        $order = new Orders;
        $order->status = 0;
        $order->distance = $totalDis;

        if ($order->save()) {
            return response()->json([
                'id' => $order->id,
                'distance' => $totalDis,
                'status' => 'UNASSIGN'
            ], 200);
        }

        return response()->json(['error' => 'INVALID_DATA'], 500);
    }

//  $request request_data
//  $id order_id
    public function update(Request $request, $id)
    {
        if (!isset($request->status) || 'taken' !== $request->status) {
            return response()->json(['error' => 'STATUS_IS_INVALID'], 500);
        }

        $order = DB::table('orders')->where([
                    ['id', '=', $id],
                ])->get();

        if(empty($order)) {
            return response()->json(['message' => 'INVALID_ID'], 500);
        }

        if (1 === $order[0]->status) {
           return response()->json(['error' => 'ORDER_ALREADY_BEEN_TAKEN'], 409);
        }

        DB::table('orders')
        ->where([
            ["orders.id", '=', $id],
            ['status', '=', '0'],
        ])
        ->update(['orders.status' => '1']);

        return response()->json(['status' => 'SUCCESS'], 200);
    }

//  $id order_id
    public function delete($id)
    {
        if (!$id) {
            return response()->json(['message' => 'INVALID_ID'], 200);
        }
        $order = Orders::find($id);
        $order->delete();
        return response()->json(['message' => 'Order deleted',], 200);
    }
}
