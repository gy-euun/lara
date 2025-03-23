<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'category',
        'user_id',
        'view_count',
        'like_count',
        'is_notice',
        'is_private',
        'tags',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'is_notice' => 'boolean',
        'is_private' => 'boolean',
        'tags' => 'array',
    ];

    protected $withCount = ['comments', 'likes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function views()
    {
        return $this->hasMany(PostView::class);
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function incrementViewCount(User $user, $ip)
    {
        $view = $this->views()->firstOrCreate([
            'user_id' => $user->id,
            'ip_address' => $ip,
        ]);

        if ($view->wasRecentlyCreated) {
            $this->increment('view_count');
        }
    }

    public function toggleLike(User $user)
    {
        $like = $this->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
            $this->decrement('like_count');
            return false;
        } else {
            $this->likes()->create(['user_id' => $user->id]);
            $this->increment('like_count');
            return true;
        }
    }

    public function scopePublic($query)
    {
        return $query->where('is_private', false);
    }

    public function scopeNotice($query)
    {
        return $query->where('is_notice', true);
    }

    public function scopePopular($query)
    {
        return $query->where('created_at', '>=', now()->subDays(7))
                    ->orderBy('view_count', 'desc')
                    ->orderBy('like_count', 'desc');
    }

    public function getExcerptAttribute()
    {
        return str_limit(strip_tags($this->content), 200);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            $post->user->addPoints(10, '게시글 작성');
        });

        static::deleted(function ($post) {
            $post->user->addPoints(-10, '게시글 삭제');
        });
    }
}
