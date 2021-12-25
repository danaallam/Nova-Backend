<?php

namespace App\Http\Controllers;

use App\Models\CardCategory;
use Illuminate\Http\Request;

class CardCategoryController extends Controller
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
        $cardCat = new CardCategory();
        $cardCat->card_id = $inputs['card_id'];
        $cardCat->category_id = $inputs['category_id'];;
        $cardCat->save();
        return response()->json(['status'=>200, 'cardCat'=>$cardCat]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CardCategory  $cardCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CardCategory $cardCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CardCategory  $cardCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CardCategory $cardCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CardCategory  $cardCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardCategory $cardCategory)
    {
        //
    }
}
