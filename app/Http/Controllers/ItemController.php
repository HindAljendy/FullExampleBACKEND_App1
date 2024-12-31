<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();
        return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //? 1 Validate from request  :
        $data = $request->validate([
            'name'=>'required|string',
            'price'=>'required|string|integer',
            'image'=>'required|image',
        ]);

        //? create new item in DB : 
        $item =  new Item;
        $item->name = $data['name'];
        $item->price = $data['price'];

        /*    "السيرفر" تتخزن في المشروع file الصورة لما بتوصلني بتوصل ملف  */
        /* و  في المشروعpuplic  و لحتى اي شخص بيقدر يوصل للصور منحطن بمجلد ال  */
        /* نغير اسم الصورة المرسلة و نخزنها في المجلد بالمشروع و في قلعدة البيانات بالاسم الجديد */

        if($data["image"]){
            /* حفظ الصورة بمتغير */
            $image = $data["image"];

            /* تغيير اسم الصورة */
            $imageName= time() . "." . $image->getClientOriginalExtension();

            /*  images in public folder with new name  تخزينها في مجلد  */
            $image->move(public_path('imagesItems'),$imageName);

            /* تخزينها في قاعدة البيانات باسمها الجديد */
            $item->image =$imageName;
        }

        $item ->save();

        //? 3  response : */
        return response(["message"=> "item created Successfully" , "item"=> $item], 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        /* ($id) 
        $item = Item::where("id", $id)->first();
        Route : get       /items/{id}
        */
        if($item){
            return response()->json(["message"=>"Successfully", "item" =>$item] , 200);
        }
        return response()->json(["message"=>"not found"], 404); /* Solve with use Id or EXception */

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //? 1 Validate from request  :
        $data = $request->validate([
            'name'=>'required|string',
            'price'=>'required|string|integer',
            'image'=>'image|nullable',
        ]);
        
          //? 2 update the Item in DB :
          if($item){
            if($data["image"]){
                $image = $data["image"];
                $imageName= time() . "." . $image->getClientOriginalExtension();
                $image->move(public_path('imagesItems'),$imageName);
                /* و ممكن مسح الصورة السابقة */

                $image =$imageName;
            }
            else{
                $image = $item->image;
            }

            $item->update([
                "name" => $data["name"],
                "price" =>$data["price"],
                "image" => $image
            ]);

          //? 3 response :
        return response(["message"=> "item updated Successfully"], 200);

        }
        return response(["message"=> "item didn't exist"], 401);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        if($item){
            $item->delete();
            return response()->json(["message"=>"Successfully"] , 200);
        }
        return response()->json(["message"=>"not found"], 404);
    }
}
