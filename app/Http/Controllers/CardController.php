<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CardCategory;
use App\Models\Designer;
use App\Models\FreelancerCategory;
use App\Models\Rating;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $freecats = FreelancerCategory::with('category.cardCategory')->where("freelancer_id", auth('user')->user()->id)->get();
        $designerRat = Designer::with('ratings')->get();
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
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $card = new Card();
        $card->description = $inputs['description'];
        $card->designer_id = auth('designer')->user()->id;
        $card->save();
        return response()->json(['message'=>'Card posted', 'card'=>$card]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        //
    }
}
