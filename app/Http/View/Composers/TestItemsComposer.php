<?php

namespace App\Http\View\Composers;

use App\TestItem;
use Illuminate\View\View;
use App\Repositories\CompetencyCachedRepository;

class TestItemsComposer
{
    /**
     * The competency model.
     *
     * @var \App\Repositories\CompetencyCachedRepository
     */
    protected $competencies;

    /**
     * Create a new testitems composer.
     *
     * @param  \App\Repositories\CompetencyCachedRepository  $competencyCachedRepository
     * @return void
     */
    public function __construct(CompetencyCachedRepository $competencyCachedRepository)
    {
        $this->competencies = $competencyCachedRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $route = '/api/testitems';

        $view->with('route', $route);

        $key = 'orderBy.title.get.uuid.title';

        $competencies = $this->competencies->cacheRemember($key, function () {
            return $this->competencies->orderBy('title')->get(['id', 'uuid', 'title']);
        });

        $columns = [
            [
                'name' => 'id',
                'label' => 'ID',
                'width' => '10%',
                'centered' => true
            ],
            [
                'name' => 'type',
                'label' => 'Type',
                'width' => '10%',
                'values' => TestItem::TYPES
            ],
            [
                'name' => 'competency_uuid',
                'label' => 'Competency',
                'width' => '10%',
                'values' => $competencies,
            ],
            [
                'name' => 'question',
                'label' => 'Question',
                'width' => '25%'
            ],
            [
                'name' => 'options',
                'label' => 'Options',
                'width' => '20%',
            ],
            [
                'name' => 'answer',
                'label' => 'Answer',
                'width' => '15%',
            ],
            [
                'name' => 'timeout',
                'label' => 'Timeout',
                'width' => '10%',
                'centered' => true
            ],
        ];

        $view->with('columns', json_encode($columns));
    }
}
