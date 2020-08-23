<?php

namespace App\Http\Controllers;

use App\TestItem;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\TestItemRequest;

class TestItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TestItem $testItem)
    {
        $testitems = Cache::tags($testItem->getTable())->remember('all', now()->addMinutes(config('custom.cache.timeout')), function () use ($testItem) {
            return $testItem->all();
        });

        return view('test-items.index', compact('testitems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TestItem $testitem)
    {
        return view('test-items.create', compact('testitem'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TestItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestItemRequest $request)
    {
        $testitem = TestItem::create($request->validated());

        return redirect()->route('testitems.show', $testitem)->with('success', __('app.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TestItem  $testItem
     * @return \Illuminate\Http\Response
     */
    public function show(TestItem $testitem)
    {
        return view('test-items.show', compact('testitem'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TestItem  $testItem
     * @return \Illuminate\Http\Response
     */
    public function edit(TestItem $testitem)
    {
        return view('test-items.edit', compact('testitem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TestItemRequest  $request
     * @param  \App\TestItem  $testItem
     * @return \Illuminate\Http\Response
     */
    public function update(TestItemRequest $request, TestItem $testitem)
    {
        $testitem->update($request->validated());

        return redirect()->route('testitems.show', $testitem->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TestItem  $testItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestItem $testitem)
    {
        $testitem->delete();

        return redirect()->route('testitems.index')->with('success', __('app.success'));
    }
}
