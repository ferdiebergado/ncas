<?php

namespace App\Http\Controllers;

use App\Qualification;
use Illuminate\Http\Request;
use App\Services\QualificationService;
use App\Http\Requests\QualificationRequest;

class QualificationController extends Controller
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
        return view('qualification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QualificationRequest $request, QualificationService $qualificationService)
    {
        $qualification = $qualificationService->create($request->validated());

        return redirect()->route('qualifications.show', $qualification)->with('success', __('messages.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function show(Qualification $qualification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function edit(Qualification $qualification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Qualification $qualification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qualification $qualification)
    {
        //
    }
}
