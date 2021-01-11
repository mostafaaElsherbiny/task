<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function order(Request $request){
        // $validator = Validator::make($request->all(), [
        //
        // ]);

        // if($validator->fails()){
        //     return response()->json($validator->errors()->toJson(), 400);
        // }






                    $products =json_decode($request->product_ids);
                    $quantitys=json_decode($request->quantitys);
                   if(count($products)!=count($quantitys)){
                    throw new Exception('Error the quantity count not equal to product ids and the prices');
                   }

                   $total=0;
                   $tax=.14;
                foreach ($products as $key=>$value)
            {

                $product = Product::where('id',$value)->first();
                if(!$product){
                    throw new Exception('No Products found with that id '.$value);
                }
                if($product->quantity==0){
                    throw new Exception('this product quantity is zero ');
                }

                if($product->quantity<$quantitys[$key]){

                    throw new Exception('this product quantity is less than order quantity ');
                }

                $total+=$product->price*$quantitys[$key];


            }
             $taxes=$total*$tax;
            $totalAfterTax=$total+$taxes;


return response()->json(['taxes'=>$taxes,'total'=>$total,'totalAfterTax'=>$totalAfterTax]);





                // return response()->json(['data'=>$order,'message'=>'success in making order','error'=>false]);






    }
}
