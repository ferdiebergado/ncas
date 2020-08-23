<?php

namespace Tests\Browser;

use App\User;
use App\Competency;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Browser\Pages\Competency\CompetencyCreatePage;
use Tests\Browser\Components\CompetencyDatatableComponent;
use Tests\Browser\Pages\Competency\CompetencyDataTablePage;

class CompetencyDataTableTest extends DuskTestCase
{
    use DatabaseMigrations, WithFaker;

    protected static $count = 10;
    protected $user;
    protected $competencies;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    private function createCompetency($data)
    {
        $this->browse(function (Browser $browser) use ($data) {
            $browser->loginAs($this->user)->visit(new CompetencyCreatePage)->createCompetency($data);
        });
    }

    private function createCompetencies($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $this->createCompetency($this->_data());
        }
    }

    private function _data()
    {
        return [
            'title' => $this->faker->words(2),
            'level_id' => array_rand(Competency::LEVELS),
            'category_id' => array_rand(Competency::CATEGORIES)
        ];
    }

    /**
     * Test search returns a result.
     *
     * @return void
     */
    public function testSearchReturnsAResult()
    {
        $this->browse(function (Browser $browser) {
            $search = 'agnis';
            $competency = array_merge($this->_data(), ['title' => $search]);
            $this->createCompetency($competency);
            $browser
                ->visit(new CompetencyDataTablePage)
                ->within(new CompetencyDatatableComponent, function ($browser) use ($search) {
                    $browser->type('search', $search);
                    $browser->click('@btn-search');
                })->pause(1000)->assertSee($search);
        });
    }

    /**
     * Test search returns no data when search is not found.
     *
     * @return void
     */
    public function testSearchReturnsNoDataWhenSearchIsNotFound()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit(new CompetencyDataTablePage);
            $search = Str::random(8);
            $browser->within(new CompetencyDatatableComponent, function ($browser) use ($search) {
                $browser->type('search', $search);
                $browser->click('@btn-search');
            })->pause(1000)->assertSee('No data');
        });
    }

    /**
     * Test sort by.
     *
     * @return void
     */
    public function testSortByContainsFieldsToSort()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit(new CompetencyDataTablePage);
            $options = [
                'id',
                'title',
                'level_id',
                'category_id'
            ];
            $browser->within(new CompetencyDatatableComponent, function () {
            })->assertSelectHasOptions('order', $options);
        });
    }

    /**
     * Test sort order.
     *
     * @return void
     */
    public function testSortOrderContainsOrderToSort()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->user)
                ->visit(new CompetencyDataTablePage)
                ->within(new CompetencyDatatableComponent, function ($browser) {
                    $options = [
                        'asc',
                        'desc',
                    ];
                    $browser->assertSelectHasOptions('direction', $options);
                });
        });
    }

    /**
     * Test sort.
     *
     * @return void
     */
    public function testSort()
    {
        $this->createCompetencies(static::$count);

        $this->browse(function (Browser $browser) {

            $browser->visit(new CompetencyDataTablePage);

            $browser->within(new CompetencyDatatableComponent, function ($browser) {
                $browser->select('order', 'id');
                $browser->select('direction', 'asc');
                $browser->click('@btn-sort');
            })->pause(2000)->assertSeeIn('td#id0', 1);

            $browser->within(new CompetencyDatatableComponent, function ($browser) {
                $browser->select('order', 'id');
                $browser->select('direction', 'desc');
                $browser->click('@btn-sort');
            })->pause(2000)->assertSeeIn('td#id0', 10);
        });
    }

    /**
     * Test level filter.
     *
     * @return void
     */
    public function testLevelFilter()
    {
        $this->createCompetencies(static::$count);
        $this->browse(function (Browser $browser) {
            $browser->visit(new CompetencyDataTablePage);
            $levels = Competency::LEVELS;
            $browser->within(new CompetencyDatatableComponent, function ($browser) use ($levels) {
                $browser->select('level', $levels[1]);
            })->pause(2000);

            for ($i = 0; $i < static::$count; $i++) {
                $selector = 'td#id' . $i;
                $browser->assertDontSeeIn($selector, $levels[2]);
                $browser->assertDontSeeIn($selector, $levels[3]);
            }
        });
    }

    /**
     * Test category filter.
     *
     * @return void
     */
    public function testCategoryFilter()
    {
        $this->createCompetencies(static::$count);
        $this->browse(function (Browser $browser) {
            $categories = Competency::CATEGORIES;
            $category = 1;
            $browser
                ->visit(new CompetencyDataTablePage)
                ->within(new CompetencyDatatableComponent, function ($browser) use ($categories, $category) {
                    $browser->select('level', $categories[$category]);
                })->pause(2000);

            $category++;

            for ($j = $category; $j <= count($categories); $j++) {
                for ($i = 0; $i < static::$count; $i++) {
                    $selector = 'td#id' . $i;
                    $browser->assertDontSeeIn($selector, $categories[$j]);
                }
            }
        });
    }

    /**
     * Test reset clears all filters.
     *
     * @return void
     */
    public function testResetClearsAllFilters()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->user)
                ->visit(new CompetencyDataTablePage)
                ->within(new CompetencyDatatableComponent, function ($browser) {
                    $browser->type('search', 'agnis')
                        ->select('direction', 1)
                        ->select('order', 1)
                        ->select('level', 1)
                        ->select('category', 1)
                        ->click('@btn-reset')
                        ->pause(1000)
                        ->assertValue('@search', '')
                        ->assertValue('@order', '')
                        ->assertValue('@direction', '')
                        ->assertValue('@level', '')
                        ->assertValue('@category', '');
                });
        });
    }

    /**
     * Test export.
     *
     * @return void
     */
    public function testExport()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit(new CompetencyDataTablePage);

            $browser->within(new CompetencyDatatableComponent, function ($browser) {
                $url = '/competencies/export?search=agnis&category_id=1&level_id=1&order_by=id&dir=asc&export=';
                $browser->type('search', 'agnis')
                    ->select('direction', 'asc')
                    ->select('order', 'id')
                    ->select('level', '1')
                    ->select('category', '1')
                    ->click('@btn-export')
                    ->assertSee('PDF')
                    ->assertSee('Excel')
                    ->assertSee('Print')
                    ->assertAttribute('@pdf', 'href', url($url . 'pdf'))
                    ->assertAttribute('@excel', 'href', url($url . 'excel'));
            });
        });
    }
}
