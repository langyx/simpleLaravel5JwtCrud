<?php

namespace App\Http\Controllers\Dashboard;

use App\Promo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

use App\Helpers\UserHelper;

class PromoController extends Controller
{
    public function __construct()
    {
        /**
         * Only logged can enter
         */
        $this->middleware('auth:api')->except([]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * All request will show $pageElem number of element
         * We can use paginate by reqOffset
         */
        $pageElem = 30;
        $reqOffset = empty($request->offset) ? 0 : ($request->offset * $pageElem);

        /**
         * Get the current logged user
         */
        $user = UserHelper::getJwtUser();


        /**
         * If user is admin display all promos
         * If user is modo  display all his promos
         * If user is user  display only his promo (default)
         */
        switch ($user->level)
        {
            case Config::get('constants.level.admin'):
                return response()->json(Promo::limit($pageElem)->offset($reqOffset)->get(), 200);
            case Config::get('constants.level.mod'):
                return response()->json(Promo::where('modo_id', $user->id)->offset($reqOffset)->limit($pageElem)->get(), 200);
            default :
                return response()->json($user->promo, 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create()
    {
        //
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function show(Promo $promo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    /*public function edit(Promo $promo)
    {
        //
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promo $promo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promo $promo)
    {
        //
    }
}
