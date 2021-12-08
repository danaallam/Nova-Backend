<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FreelancerCategory;
use Illuminate\Http\Request;

class FreelancerCategoryController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = FreelancerCategory::where('freelancer_id', auth('user')->user()->id)->get();
        return response()->json(['status'=>200, 'categories'=>$categories]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $cat =  explode(", ", $inputs['category_id']);
        $size = sizeof($cat);
        $i = 0;
        while($size){
            $userCat = new FreelancerCategory();
            $userCat->freelancer_id = auth('user')->user()->id;
            $userCat->category_id = $cat[$i];
            $userCat->save();
            $i++;
            $size--;
        }
        return response()->json(['status'=>200, 'message'=>'Categories added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FreelancerCategory  $freelancerCategory
     * @return \Illuminate\Http\Response
     */
    public function show(FreelancerCategory $freelancerCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FreelancerCategory  $freelancerCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FreelancerCategory $freelancerCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FreelancerCategory  $freelancerCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(FreelancerCategory $freelancerCategory)
    {
        //
    }
}
