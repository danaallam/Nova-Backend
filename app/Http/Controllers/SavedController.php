<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Designer;
use App\Models\FreelancerCard;
use App\Models\FreelancerCategory;
use App\Models\Saved;
use Illuminate\Http\Request;

class SavedController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $designerRat = Designer::with('ratings')->get();
        $savedCards = Saved::where('freelancer_id', auth('user')->user()->id)->get();
        $accepted = FreelancerCard::where('freelancer_id', auth('user')->user()->id)->get();
        $cards = Card::with('users', 'categories.category', 'posts', 'designer')->get();
        $saved = [];
        $savCard = [];
        foreach ($savedCards as $s){
            array_push($savCard, $s->card_id);
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
            $c->saved = 0;
            $c->accepted = 0;
            foreach ($savedCards as $s) {
                if($c->id == $s->card_id){
                    $c->saved = 1;
                }
            }
            foreach ($accepted as $a) {
                if($c->id == $a->card_id){
                    $c->accepted = $a->accepted;
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

        foreach ($cards as $card){
            if(in_array($card->id, $savCard)){
                array_push($saved, $card);
            }
        }

        return response()->json(['length'=>sizeof($saved), 'status'=>200, 'savedCards'=>$saved]);
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $savedCard = Saved::where('card_id', $id)->where('freelancer_id', auth('user')->user()->id)->first();
        if($savedCard) {
            $savedCard->delete();
            return response()->json([
                'status' => '200',
                'message' => 'Card removed from saved'
            ]);
        }
        return response()->json([
            'status' => '200',
            'message' => 'Card not found'
        ]);
    }
}
