<?php

namespace App\Observers;

use App\Models\Article;
use App\Traits\Loggable;

class ArticleObserver
{
    use Loggable;

    public function __construct()
    {
        $this->model = Article::class;
    }

    /**
     * Handle the Article "created" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function created(Article $article)
    {
        $this->log('create', $article->id, $article->toArray(), $this->model);
    }

    /**
     * Handle the Article "updated" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function updated(Article $article)
    {
        $this->updateLog($article, $this->model);
    }

    /**
     * Handle the Article "deleted" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function deleted(Article $article)
    {
        $this->log('delete', $article->id, $article->toArray(), $this->model);

    }

    /**
     * Handle the Article "restored" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function restored(Article $article)
    {
        $this->log('restore', $article->id, $article->toArray(), $this->model);

    }

    /**
     * Handle the Article "force deleted" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function forceDeleted(Article $article)
    {
        $this->log('force delete', $article->id, $article->toArray(), $this->model);

    }


}
