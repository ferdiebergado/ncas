<?php

namespace App\Http\Controllers;

use App\Competency;
use Illuminate\Http\Request;
use App\Http\Requests\CompetencyRequest;

class CompetencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('competency.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('competency.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CompetencyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompetencyRequest $request)
    {
        $competency = Competency::create($request->validated());

        return redirect()->route('competencies.show', compact('competency'))->with('success', __('app.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Competency  $competency
     * @return \Illuminate\Http\Response
     */
    public function show(Competency $competency)
    {
        return view('competency.show', compact('competency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Competency  $competency
     * @return \Illuminate\Http\Response
     */
    public function edit(Competency $competency)
    {
        return view('competency.edit', compact('competency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CompetencyRequest  $request
     * @param  \App\Competency  $competency
     * @return \Illuminate\Http\Response
     */
    public function update(CompetencyRequest $request, Competency $competency)
    {
        $competency->update($request->validated());

        return redirect()->route('competencies.show', $competency->fresh())->with('success', __('app.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Competency  $competency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competency $competency, Request $request)
    {
        $competency->delete();

        if ($request->wantsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('competencies.index')->with('success', __('app.success'));
    }
}
