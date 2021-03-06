<?php

namespace App\Http\Controllers;

use App\Camp;
use App\Camper;
use App\Friendship;
use App\Rules\UniqueFriendship;
use Illuminate\Http\Request;

class FriendshipsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Camp $camp, Camper $camper, Request $request)
    {
        $data = $request->validate([
            'friend_id' => ['required', new UniqueFriendship($camper->id)],
        ]);

        $data['camp_id'] = $camp->id;
        $data['camper_id'] = $camper->id;

        Friendship::create($data);

        return back()
            ->with('flash', 'New friend added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Friendship  $friend
     * @return \Illuminate\Http\Response
     */
    public function show(Friendship $friend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Friendship  $friend
     * @return \Illuminate\Http\Response
     */
    public function edit(Friendship $friend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Friendship  $friend
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Friendship $friend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Friendship  $friendship
     * @return \Illuminate\Http\Response
     */
    public function destroy(Camp $camp, Camper $camper, Friendship $friendship)
    {
        $this->authorize('update', $camp);

        $friendship->delete();

        if(request()->wantsJson()) {
            return response([], 204);
        }

        return redirect($camper->path())
            ->with('flash', 'Friend has been removed!');
    }
}
