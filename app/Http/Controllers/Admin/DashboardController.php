<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function profilePhoto()
    {
        $user = auth()->user()->fresh();
        $photoUrl = asset('storage/photos/' . $user->photo);

        return response()->json(['photoUrl' => $photoUrl]);
    }

    
    public function __invoke(Request $request)
    {
        return view('admins.index');
    }
}
