<?php

namespace App\Http\Controllers;

use App\Models\FreelancerCard;
use Illuminate\Http\Request;

class FreelancerCardController extends Controller
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
        $userCard = new FreelancerCard();
        $userCard->resume = $request->file('resume')->store('resume');
        if($request->file('coverLetter') != null)
            $userCard->coverLetter = $request->file('coverLetter')->store('coverLetter');
        $userCard->accepted = 0;
        $userCard->freelancer_id = auth('user')->user()->id;
        $userCard->card_id = $inputs['card_id'];
        $userCard->save();
        return response()->json(['message'=>'Application pending', 'userCard'=>$userCard]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FreelancerCard  $freelancerCard
     * @return \Illuminate\Http\Response
     */
    public function show(FreelancerCard $freelancerCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FreelancerCard  $freelancerCard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FreelancerCard $freelancerCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FreelancerCard  $freelancerCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(FreelancerCard $freelancerCard)
    {
        //
    }
}
