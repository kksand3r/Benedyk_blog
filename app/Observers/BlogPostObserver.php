<?php

namespace App\Observers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BlogPostObserver
{
    /**
     * @param  BlogPost  $blogPost
     * @return void
     */
    public function updating(BlogPost $blogPost): void
    {
        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);
        $this->setHtml($blogPost);
        $this->setUser($blogPost);
    }

    /**
     * @param  BlogPost  $blogPost
     * @return void
     */
    public function creating(BlogPost $blogPost): void
    {
        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);
        $this->setHtml($blogPost);

        if (empty($blogPost->user_id)) {
            $blogPost->user_id = auth()->id() ?? 1;
        }
    }

    /**
     * @param BlogPost $blogPost
     * @return void
     */
    protected function setPublishedAt(BlogPost $blogPost): void
    {
        if ($blogPost->is_published && empty($blogPost->published_at)) {
            $blogPost->published_at = Carbon::now();
        }

        elseif (!$blogPost->is_published && !empty($blogPost->published_at)) {
            $blogPost->published_at = null; // Обнуляємо дату публікації
        }
    }

    /**
     * @param BlogPost $blogPost
     * @return void
     */
    protected function setSlug(BlogPost $blogPost): void
    {
        if (empty($blogPost->slug)) {
            $blogPost->slug = Str::slug($blogPost->title);
        }
    }

    /**
     * Встановлюємо значення полю content_html з поля content_raw.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    protected function setHtml(BlogPost $blogPost): void
    {
        if ($blogPost->isDirty('content_raw')) {
            $blogPost->content_html = $blogPost->content_raw;
        }
    }

    /**
     * Якщо user_id не вказано, то встановимо юзера 1 (UNKNOWN_USER).
     *
     * @param BlogPost $blogPost
     * @return void
     */
    protected function setUser(BlogPost $blogPost): void
    {
        $blogPost->user_id = auth()->id() ?? BlogPost::UNKNOWN_USER;
    }
}
