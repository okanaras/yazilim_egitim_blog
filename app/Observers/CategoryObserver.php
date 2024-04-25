<?php

namespace App\Observers;

use App\Models\Category;
use App\Traits\Loggable;

class CategoryObserver
{
    use Loggable;

    public function __construct()
    {
        $this->model = Category::class;
    }


    /**
     * Handle the Category "created" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        $this->log('create', $category->id, $category->toArray(), $this->model);
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        $this->updateLog($category, $this->model);
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        $this->log('delete', $category->id, $category->toArray(), $this->model);

    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        $this->log('restore', $category->id, $category->toArray(), $this->model);

    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        $this->log('force delete', $category->id, $category->toArray(), $this->model);

    }

}