<?php

namespace App\Http\Controllers;

use App\Cabin;
use App\Camp;
use Illuminate\Http\Request;

class CabinsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Camp $camp)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Camp $camp)
    {
        $this->authorize('update', $camp);

        return view('cabins.create', compact('camp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Camp $camp, Request $request)
    {
        $this->authorize('update', $camp);

        $data = $request->validate([
           'name' => ['required'],
           'capacity' => ['required']
        ]);

        $data['camp_id'] = $camp->id;

        Cabin::create($data);

        return redirect($camp->path() . '/cabins/create')
            ->with('flash', 'New cabin added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cabin  $cabin
     * @return \Illuminate\Http\Response
     */
    public function show(Cabin $cabin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cabin  $cabin
     * @return \Illuminate\Http\Response
     */
    public function edit(Cabin $cabin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cabin  $cabin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cabin $cabin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cabin  $cabin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cabin $cabin)
    {
        //
    }
}
