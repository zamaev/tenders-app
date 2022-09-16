<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTendersRequest;
use App\Http\Requests\StoreTendersRequest;
use App\Models\Tenders;

class TendersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Requests\IndexTendersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexTendersRequest $request)
    {
        return response()->json([
            'data' => ['tenders' => Tenders::getTenders($request->query())],
        ], 200);
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
     * @param  \Illuminate\Http\Requests\StoreTendersRequest  $request
     * @return \Illuminate\Http\Http\Response
     */
    public function store(StoreTendersRequest $request)
    {
        return response()->json([
            'message' => 'Tender was created.',
            'data' => ['tender' => Tenders::createTender($request->all())],
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tenders  $tender
     * @return \Illuminate\Http\Response
     */
    public function show(IndexTendersRequest $request, Tenders $tender)
    {
        return response()->json([
            'data' => ['tender' => $tender->changeStatusFormat()],
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tenders  $tenders
     * @return \Illuminate\Http\Response
     */
    public function edit(Tenders $tenders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\IndexTendersRequest  $request
     * @param  \App\Models\Tenders  $tenders
     * @return \Illuminate\Http\Response
     */
    public function update(IndexTendersRequest $request, Tenders $tender)
    {
        return response()->json([
            'message' => 'Tender was updated.',
            'data' => ['tender' => $tender->updateTender($request->all(), $tender)],
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tenders  $tenders
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tenders $tenders)
    {
        return response()->json([
            'message' => 'Delete not allowed',
        ], 405);
    }
}
