<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Camp;


class AllocatedBedsController extends Controller
{

    /**
     * Assign cabins to campers.
     *
     * @param Camp $camp
     */
    public function store(Camp $camp)
    {
//        dd('Made it');

        // Authorise
        $this->authorize('update', $camp);
//        dd('Made it');
        // Validate enough beds

        $camp->allocateCabins();

//        return $camp->cabins()->with('campers')->get();
//        $cabins = Cabin::where('camp_id', $camp->id)->with('allocatedBeds')->get();
//        return $cabins;
//        return $camp->cabins->with('allocatedBeds');
    }

    /**
     * Deallocate cabins from campers.
     *
     * @param Camp $camp
     */
    public function destroy(Camp $camp)
    {
        $this->authorize('update', $camp);

        $camp->deallocateCabins();

//        return back();
    }


}
