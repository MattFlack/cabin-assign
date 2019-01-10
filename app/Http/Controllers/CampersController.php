<?php

namespace App\Http\Controllers;

use App\Camper;
use App\Camp;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
//        $this->authorize('update', $camp);
//
//        return response($camp->campers()->paginate(10), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Camp $camp)
    {
        $this->authorize('update', $camp);

        $camp['campers_count'] = $camp->campers->count();

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

        Camper::create($data);

        return redirect($camp->path() . '/campers/create')
            ->with('flash', 'New camper added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Camper  $camper
     * @return \Illuminate\Http\Response
     */
    public function show(Camp $camp, Camper $camper)
    {
        $this->authorize('update', $camp);

        return view('campers.show', compact('camper'));
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
    public function destroy(Camp $camp, Camper $camper)
    {
        $this->authorize('update', $camp);

        $camper->delete();

        if(request()->wantsJson()) {
            return response([], 204);
        }

        return redirect($camp->path());
    }
}
