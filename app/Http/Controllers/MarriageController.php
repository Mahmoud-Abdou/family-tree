<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarriageRequest;
use App\Http\Requests\UpdateMarriageRequest;
use App\Models\Marriage;

class MarriageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:marriages.read')->only(['index', 'show']);
        $this->middleware('permission:marriages.create')->only(['create', 'store']);
        $this->middleware('permission:marriages.update')->only(['edit', 'update']);
        $this->middleware('permission:marriages.delete')->only('destroy');
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
     * @param  \App\Http\Requests\StoreMarriageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMarriageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marriage  $marriage
     * @return \Illuminate\Http\Response
     */
    public function show(Marriage $marriage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marriage  $marriage
     * @return \Illuminate\Http\Response
     */
    public function edit(Marriage $marriage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMarriageRequest  $request
     * @param  \App\Models\Marriage  $marriage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMarriageRequest $request, Marriage $marriage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marriage  $marriage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marriage $marriage)
    {
        //
    }
}
