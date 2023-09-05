<?php

namespace App\Http\Controllers\Store;

use App\Models\posts;
use App\Http\Requests\StorepostsRequest;
use App\Http\Requests\UpdatepostsRequest;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $advertisingSlider = posts::orderBy('id', 'DESC')
            ->where('status', 'PUBLISHED')
            ->where('advertising', 1)
            ->limit(7)
            ->get();


        $most_seen = posts::orderBy('id', 'DESC')
            ->where('status', 'PUBLISHED')
            ->where('level', 'most_seen')
            ->limit(20)
            ->get();

        $new_products = posts::orderBy('id', 'DESC')
            ->where('status', 'PUBLISHED')
            ->where('level', 'new_products')
            ->limit(20)
            ->get();

        $top_sales = posts::orderBy('id', 'DESC')
            ->where('status', 'PUBLISHED')
            ->where('level', 'top_sales')
            ->limit(20)
            ->get();

        $top_sales2 = posts::orderBy('id', 'ASC')
            ->where('status', 'PUBLISHED')
            ->where('level', 'top_sales')
            ->limit(40)
            ->get();


        $data = [
            'advertisingSlider' => $advertisingSlider,
            'most_seen' => $most_seen,
            'new_products' => $new_products,
            'top_sales' => $top_sales,
            'top_sales2' => $top_sales2,
        ];

        //echo  response()->json($data, 200);

        //dd($data);

        return response()->json($data, 200);
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
     * @param  \App\Http\Requests\StorepostsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorepostsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show(posts $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit(posts $posts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepostsRequest  $request
     * @param  \App\Models\posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepostsRequest $request, posts $posts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy(posts $posts)
    {
        //
    }
}
