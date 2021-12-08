<?php

namespace App\Http\Controllers;

use App\Models\Saved;
use Illuminate\Http\Request;

class SavedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $saved = new Saved();
        $saved->freelancer_id = auth('user')->user()->id;
        $saved->card_id = $inputs['card_id'];
        $saved->save();
        return response()->json(['message'=>'Card saved', 'saved'=>$saved]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Saved  $saved
     * @return \Illuminate\Http\Response
     */
    public function show(Saved $saved)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Saved  $saved
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Saved $saved)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Saved  $saved
     * @return \Illuminate\Http\Response
     */
    public function destroy(Saved $saved)
    {
        //
    }
}
