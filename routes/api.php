<?php

use App\Models\Tenders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->post('/tender', function (Request $request) {
    $tender = new Tenders();
    $tender->code = $request->input('code');
    $tender->number = $request->input('number');
    $tender->name = $request->input('name');
    $tender->status = $request->input('status');
    $tender->save();
    return $tender->id;
});

Route::middleware('auth:sanctum')->get('/tender/{code}', function ($code) {
    return (new Tenders())->get_data_json(['code' => $code]);
});

Route::middleware('auth:sanctum')->get('/tenders', function (Request $request) {
    $filter = [];
    if ($request->query('name')) {
        $filter['name'] = $request->query('name');
    }
    if ($request->query('date')) {
        $filter['updated_at'] = $request->query('date');
    }
    return (new Tenders())->get_data_json($filter);
});
