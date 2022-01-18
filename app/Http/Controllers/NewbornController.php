<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewbornRequest;
use App\Http\Requests\UpdateNewbornRequest;
use App\Models\Newborn;

class NewbornController extends Controller
{
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
     * @param  \App\Http\Requests\StoreNewbornRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewbornRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Newborn  $newborn
     * @return \Illuminate\Http\Response
     */
    public function show(Newborn $newborn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Newborn  $newborn
     * @return \Illuminate\Http\Response
     */
    public function edit(Newborn $newborn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNewbornRequest  $request
     * @param  \App\Models\Newborn  $newborn
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewbornRequest $request, Newborn $newborn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Newborn  $newborn
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newborn $newborn)
    {
        //
    }
}
