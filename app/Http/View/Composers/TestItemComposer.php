<?php

namespace App\Http\View\Composers;

use App\TestItem;
use Illuminate\View\View;
use Illuminate\Support\Arr;

class TestItemComposer
{
    /**
     * The testitem model.
     *
     * @var \App\TestItem
     */
    protected $testitem;

    /**
     * Create a new testitem composer.
     *
     * @param  testitem  $competencies
     * @return void
     */
    public function __construct(TestItem $testitem)
    {
        // Dependencies automatically resolved by service container...
        $this->testitem = $testitem;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $types = $this->testitem::TYPES;

        $pages = [
            10, 25, 50
        ];

        $view->with('types', $types);
        $view->with('enums', json_encode(['types' => $types]));
        $view->with('pages', json_encode($pages));

        $request = json_encode(Arr::except(request()->old(), '_token'));
        $view->with('request', $request);
    }
}
