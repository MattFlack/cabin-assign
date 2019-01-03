<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        $data = $request->validate([
            'camper_id' => ['required'],
            'friend_id' => ['required', new UniqueFriendship($request->camper_id)],
        ]);

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
     * @param  \App\Friendship  $friend
     * @return \Illuminate\Http\Response
     */
    public function destroy(Friendship $friend)
    {
        //
    }
}
