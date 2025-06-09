<?php

namespace App\Observers;

use App\Models\BlogCategory;
use Illuminate\Support\Str;
class BlogCategoryObserver
{
    /**
     * @param  BlogCategory  $blogCategory
     * @return void
     */
    public function creating(BlogCategory $blogCategory): void
    {
        $this->setSlug($blogCategory);
    }

    /**
     * @param  BlogCategory  $blogCategory
     * @return void
     */
    public function updating(BlogCategory $blogCategory): void
    {
        $this->setSlug($blogCategory);
    }

    /**
     * @param BlogCategory  $blogCategory
     * @return void
     */
    protected function setSlug(BlogCategory $blogCategory): void
    {
        if (empty($blogCategory->slug)) {
            $blogCategory->slug = Str::slug($blogCategory->title);
        }
    }
}
