<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use App\Models\FreelancerCard;
use App\Models\FreelancerCategory;
use App\Models\Saved;
use Illuminate\Http\Request;

class FreelancerCardController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $accepted = FreelancerCard::where('freelancer_id', auth('user')->user()->id)->get();
        $freecats = FreelancerCategory::with('category.cardCategory')->where("freelancer_id", auth('user')->user()->id)->orderBy('created_at')->get();
        $designerRat = Designer::with('ratings')->get();
        $savedCards = Saved::where('freelancer_id', auth('user')->user()->id)->get();
        $cards = [];

        foreach ($freecats as $c){
            foreach ($c->category->cardCategory as $one){
                array_push($cards, $one->card);
            }
        }

        foreach ($designerRat as $d) {
            if (sizeof($d->ratings) > 0) {
                $sum = 0;
                foreach ($d->ratings as $instance) {
                    $sum += $instance->rating;
                }
                if (($sum / sizeof($d->ratings) - floor($sum / sizeof($d->ratings)) >= 0.75)) {
                    $d->rating = ceil($sum / sizeof($d->ratings));
                } else {
                    $d->rating = floor($sum / sizeof($d->ratings));
                }
            }
            else{
                $d->rating = 0;
            }
        }

        foreach ($cards as $c) {
            $count = 0;
            $c->posts;
            $c->saved = 0;
            $c->accepted = 0;
            $c->applied = 0;
            foreach ($savedCards as $s) {
                if($c->id == $s->card_id){
                    $c->saved = 1;
                }
            }
            foreach ($accepted as $a) {
                if($c->id == $a->card_id){
                    $c->accepted = $a->accepted;
                }
                if($c->id == $a->card_id){
                    $c->applied = 1;
                }
            }
            foreach ($designerRat as $d) {
                if($d->id == $c->designer->id) {
                    $c->designer->rating = $d->rating;
                }
            }
            foreach($c->categories as $cat){
                $cat->category;
            }

            for ($i = 0; $i<sizeof($c->users); $i++)
                $count++;
            $c->applicants = $count;
        }

        return response()->json(['length'=>sizeof(array_unique($cards)), 'status'=>200, 'cards'=>array_unique($cards)]);
//        return response()->json(['length'=>sizeof(array_unique($cards)), 'status'=>200, 'cards'=>$accepted]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $userCard = new FreelancerCard();
        $userCard->resume = $inputs['resume'];
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
     * @param Request $request
     * @param $cid
     * @param $uid
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $inputs = $request->all();
        $card = FreelancerCard::where('card_id', $inputs['card_id'])->where('freelancer_id', $inputs['freelancer_id'])->first();
        if($card) {
            $card->accepted = 1;
            $card->save();
            return response()->json([
                'status' => '200',
                'card' => $card,
                'message' => 'Application accepted'
            ]);
        }
        return response()->json([
            'status' => '200',
            'message' => 'Application not found'
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $inputs = $request->all();
        $card = FreelancerCard::where('card_id', $inputs['card_id'])->where('freelancer_id', $inputs['freelancer_id'])->first();
        if($card) {
            $card->delete();
            return response()->json([
                'status' => '200',
                'message' => 'Application rejected'
            ]);
        }
        return response()->json([
            'status' => '200',
            'message' => 'Application not found'
        ]);
    }
}
