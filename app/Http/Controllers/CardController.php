<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CardCategory;
use App\Models\Category;
use App\Models\Designer;
use App\Models\FreelancerCard;
use App\Models\FreelancerCategory;
use App\Models\Rating;
use App\Models\Saved;
use Illuminate\Http\Request;

class CardController extends Controller
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
            $c->applied= 0;
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

        return response()->json(['length'=>sizeof($cards), 'status'=>200, 'cards'=>$cards]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request){
        $cati = $request->category;
        $accepted = FreelancerCard::where('freelancer_id', auth('user')->user()->id)->get();
        $cards = Card::with('categories.category')->get();
        $designerRat = Designer::with('ratings')->get();
        $savedCards = Saved::where('freelancer_id', auth('user')->user()->id)->get();

        $cardCategories = [];

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
            $c->applied = 0;
            $c->posts;
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
            for ($i = 0; $i<sizeof($c->users); $i++)
                $count++;
            $c->applicants = $count;
            foreach($c->categories as $cat){
                if(in_array($cat->category->id, $cati)){
                    array_push($cardCategories, $c);
                }
            }
        }

        return response()->json(['length'=>sizeof(array_unique($cardCategories)), 'status'=>200, 'cards'=>array_unique($cardCategories)]);
    }

    public function getJobs(){
        $jobs = Card::with('posts', 'users.freelancer.posts', 'designer.ratings', 'categories.category')->where('designer_id', auth('designer')->user()->id)->get();

        foreach ($jobs as $j){
            $count = 0;
            foreach ($j->users as $user) {
                $count++;
            }
            $j->applicants = $count;
            $sum = 0;
            foreach ($j->designer->ratings as $r) {
                    $sum += $r->rating;
            }
            if (($sum / sizeof($j->designer->ratings) - floor($sum / sizeof($j->designer->ratings)) >= 0.75)) {
                $j->designer->rating = ceil($sum / sizeof($j->designer->ratings));
            } else {
                $j->designer->rating = floor($sum / sizeof($j->designer->ratings));
            }
        }

        return response()->json(['length'=>sizeof($jobs), 'status'=>200, 'jobs'=>$jobs]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function accepted()
    {
        $designerRat = Designer::with('ratings')->get();
        $savedCards = Saved::where('freelancer_id', auth('user')->user()->id)->get();
        $accepted = FreelancerCard::where('freelancer_id', auth('user')->user()->id)->get();
        $cards = Card::with('users', 'categories.category', 'posts', 'designer')->get();
        $acc = [];

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
            } else {
                $d->rating = 0;
            }
        }

        foreach ($cards as $c) {
            $count = 0;
            $c->saved = 0;
            $c->accepted = 0;
            $c->applied = 0;
            foreach ($savedCards as $s) {
                if ($c->id == $s->card_id) {
                    $c->saved = 1;
                }
            }
            foreach ($accepted as $a) {
                if ($c->id == $a->card_id) {
                    $c->accepted = $a->accepted;
                }
                if($c->id == $a->card_id){
                    $c->applied = 1;
                }
            }
            foreach ($designerRat as $d) {
                if ($d->id == $c->designer->id) {
                    $c->designer->rating = $d->rating;
                }
            }
            foreach ($c->categories as $cat) {
                $cat->category;
            }

            for ($i = 0; $i < sizeof($c->users); $i++)
                $count++;
            $c->applicants = $count;
            if($c->accepted == 1) {
                array_push($acc, $c);
            }
        }

        return response()->json(['length' => sizeof($acc), 'status' => 200, 'cards' => $acc]);
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
