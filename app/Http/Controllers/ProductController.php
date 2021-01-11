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
        $validator = Validator::make($request->all(), [
            'total'=> 'required',
            'payment_method'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

     try{

        $order=[];
            DB::transaction(function() use($request,&$order)
                   {

                    $total=0;
                    $products =json_decode($request->product_ids);
                    $quantitys=json_decode($request->quantitys);
                   if(count($products)!=count($quantitys)||count($products)){
                    throw new Exception('Error the quantity count not equal to product ids and the prices');
                   }


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


            }





                });


                return response()->json(['data'=>$order,'message'=>'success in making order','error'=>false]);


     }catch(Exception $e){
         return response()->json(['message'=>'Error in making this order repeat again','error'=>true]);
     }



    }
}
