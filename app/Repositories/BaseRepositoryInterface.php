<?php

namespace App\Repositories;

use App\AbstractBaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * Create a new model instance
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    // /**
    //  * Update a model instance
    //  * @param array $attributes
    //  * @param int $id
    //  * @return mixed
    //  */
    // public function update(array $attributes, int $id);

    // /**
    //  * Return all model rows
    //  * @param array $columns
    //  * @param string $orderBy
    //  * @param string $sortBy
    //  * @return mixed
    //  */
    // public function all($columns = array('*'), string $orderBy = 'id', string $sortBy = 'desc');

    // /**
    //  * Find one by ID
    //  * @param int $id
    //  * @return mixed
    //  */
    // public function find(int $id);

    // /**
    //  * Find one by ID or throw exception
    //  * @param int $id
    //  * @return mixed
    //  */
    // public function findOneOrFail(int $id);

    // /**
    //  * Find based on a different column
    //  * @param array $data
    //  * @return mixed
    //  */
    // public function findBy(array $data);

    // /**
    //  * Find one based on a different column
    //  * @param array $data
    //  * @return mixed
    //  */
    // public function findOneBy(array $data);

    // /**
    //  * Find one based on a different column or through exception
    //  * @param array $data
    //  * @return mixed
    //  */
    // public function findOneByOrFail(array $data);

    // /**
    //  * Delete one by Id
    //  * @param int $id
    //  * @return mixed
    //  */
    // public function delete(int $id);

    /**
     * Perform filter on the model
     *
     * @param array $filteredFields
     * @param string $orderBy
     * @param string $dir
     * @return mixed
     */
    public function filter(array $filteredFields, string $orderBy, string $dir);

    /**
     * Begin querying a model with eager loading.
     *
     * @param  array|string  $relations
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function with($relations);
}
