<?php

namespace App\Http\Controllers;

use App\Camper;
use App\Camp;
use Illuminate\Http\Request;

class CampersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // TODO: Move this to a proper API route/controller
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Camp $camp)
    {
        $this->authorize('update', $camp);

        return $camp->campers()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Camp $camp)
    {
        $this->authorize('update', $camp);

        return view('campers.create', compact('camp'));
    }

    // TODO: Move this to a proper API route/controller
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Camp $camp)
    {

        $this->authorize('update', $camp);

        $data = $request->validate([
            'name' => ['required']
        ]);

        $data['camp_id'] = $camp->id;

        $camper = Camper::create($data);


        return $camper;

//        return back()
//            ->with('flash', 'New camper added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Camper  $camper
     * @return \Illuminate\Http\Response
     */
    public function show(Camper $camper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Camper  $camper
     * @return \Illuminate\Http\Response
     */
    public function edit(Camper $camper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Camper  $camper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Camper $camper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Camper  $camper
     * @return \Illuminate\Http\Response
     */
    public function destroy(Camper $camper)
    {
        //
    }
}
