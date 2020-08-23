<?php

namespace App\Http\Controllers\API;

use App\Competency;
use App\Services\CompetencyService;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompetencyRequest;
use App\Http\Requests\CompetencyIndexRequest;

class CompetencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CompetencyIndexRequest $request, CompetencyService $competencyService)
    {
        $validated = $request->validated();

        return Competency::whereQualificationId($validated['qualification_id'])->get(['competency_id', 'title']);

        // return $competencyService->getData($validated, true, ['id', 'title', 'category_id', 'level_id', 'created_at']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompetencyRequest $request)
    {
        return Competency::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Competency  $competency
     * @return \Illuminate\Http\Response
     */
    public function show(Competency $competency)
    {
        return response()->json(['data' => $competency]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Competency  $competency
     * @return \Illuminate\Http\Response
     */
    public function update(CompetencyRequest $request, Competency $competency)
    {
        $competency->update($request->validated());

        return response()->json(['message' => 'Operation successful']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Competency  $competency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competency $competency)
    {
        $competency->delete();

        return response()->json(null, 204);
    }
}
