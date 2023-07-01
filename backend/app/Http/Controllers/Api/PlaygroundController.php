<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Playground;
use Illuminate\Http\Request;
// use Validator;
use Illuminate\Support\Facades\Validator;

class PlaygroundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        // $playground = Playground::all();
        // return response()->json($playground, 200);
        return response()->json(Playground::where('status','<>',"pending")->get(), 200);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'location' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'price' => 'required',
            'size' => 'required',
            'type' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $img = $request->file('image');
        $img_name = time() . '.' . $img->extension();
        $img->move(public_path('images'), $img_name);
        // $request->image = $img_name;
        $playground = Playground::create(
            [
                'name' => $request->name,
                'location' => $request->location,
                'description' => $request->description,
                'image' => $img_name,
                'price' => $request->price,
                'size' => $request->size,
                'type' => $request->type,
                'user_id' => $request->user_id,
            ]
        );

        return response()->json([
            'message' => 'Great success! New playground created',
            'playground' => $playground
        ], 201);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $playground = Playground::find($id);
        if(!$playground){
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        return response()->json($playground, 200);
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
        return $request;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'location' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'price' => 'required',
            'size' => 'required',
            'type' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'error' => $validator->errors()
            ], 400);
        }
        $playground = Playground::find($id);
        if (!$playground) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        $playground->update($request->all());
        return response()->json([
            'message' => 'Playground updated',
            'playground' => $playground
        ], 200);
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
        $playground = Playground::destroy($id);

        if (!$playground) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        // if ($playground->image) {
        //     unlink(public_path('images') . '/' . $playground->image);
        // }
        return response()->json([
            'message' => 'Playground deleted'
        ], 200);
    }

    public function search(Request $request)
    {
        
        $playground = Playground::query();

        // if($request->has('type')){
        //     $playground->where('type', $request->type);
        // }
        if($request->input('type')){
            $playground->where('type', $request->input('type'));                               
            // $playground->where([
                // ['type',$request->input('type')],
                // ['status','<>',"pending"],
            // ])->get();
        }

        if($request->input('location')){
            $playground->where('location', $request->input('location'));
            // $playground->where([
                // ['location',$request->input('location')],
                // ['status','<>',"pending"],
            // ])->get();
        }

        if($request->input('price_from') && $request->input('price_to')){
            $playground->whereBetween('price', [$request->input('price_from'), $request->input('price_to')]);
            
        }
        if($request->input('price_below')){
            $playground->where('price', '<', $request->input('price_below'));
            // $playground->where([
                // ['price','<',$request->input('price_below')],
                // ['status','<>',"pending"],
            // ])->get();
        }
        if($request->input('price_above')){
            $playground->where('price', '>', $request->input('price_above'));
            // $playground->where([
                // ['price','>',$request->input('price_above')],
                // ['status','<>',"pending"],
            // ])->get();
            
        }
        return response()->json($playground->get(), 200);
    }





    public function pending()// for admin interface
    {
        return response()->json(Playground::where('status',"pending")->get(), 200);
    }



    public function changeStates(Request $request,Playground $playground)
    {

    $playground->status = "done";
        $playground->save();
        return response()->json([
            'message' => 'Playground updated',
            'playground' => $playground
        ], 200);
    }


    public function getPlaygroundsByLocation(Request $request)
{
    $validator = Validator::make($request->all(), [
        'location' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    $playgrounds = Playground::where('location', $request->input('location'))->get();

    return response()->json($playgrounds, 200);
}

}


