<?php

namespace App\Models;

use App\Traits\ViewCountable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class News extends Model implements \App\Interfaces\Searchable, \App\Interfaces\ViewCountable
{
    use Searchable, ViewCountable;

    protected $table = 'news';

    protected $guarded = ['id'];

    public function scopeNotDraft($query) {
        return $query->where('is_draft', false);
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getLink()
    {
        return route('news.show', ['news' => $this->id]);
    }

    public function getDate()
    {
        return $this->created_at->format('Y-m-d H:i');
    }

    public function getModelName()
    {
        return 'სიახლე';
    }

    public function getSearchableColumns()
    {
        return ['title', 'content'];
    }

    public function getDescription()
    {
        $htmlFreeText = strip_tags($this->content);

        return mb_strlen($htmlFreeText) > 184 ? mb_substr($htmlFreeText, 0, 184).'...' : $htmlFreeText;
    }
}
