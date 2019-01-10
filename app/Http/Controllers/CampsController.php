<?php

namespace App\Http\Controllers;

use App\Camp;
use Illuminate\Http\Request;

class CampsController extends Controller
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
        $camps = Camp::where('user_id', auth()->id())->paginate(10);

        return view('camps.index', compact('camps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('camps.create');
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
            'name' => ['required']
        ]);

        $data['user_id'] = auth()->id();

        $camp = Camp::create($data);

        return redirect($camp->path())
            ->with('flash', 'New camp added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Camp  $camp
     * @return \Illuminate\Http\Response
     */
    public function show(Camp $camp)
    {
        $this->authorize('update', $camp);

        return view('camps.show', compact('camp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Camp  $camp
     * @return \Illuminate\Http\Response
     */
    public function edit(Camp $camp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Camp  $camp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Camp $camp)
    {
        $this->authorize('update', $camp);

        $data = $request->validate([
            'name' => ['required']
        ]);

        $camp->update($data);

        return $camp;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Camp  $camp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Camp $camp)
    {
        $this->authorize('update', $camp);

        $camp->delete();

        if(request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/camps')
            ->with('flash', 'Camp has been removed!');
    }
}
