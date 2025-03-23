<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'content',
        'like_count',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $withCount = ['likes'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
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

    protected static function boot()
    {
        parent::boot();

        static::created(function ($comment) {
            if (!$comment->parent_id) {
                $comment->user->addPoints(5, '댓글 작성');
            } else {
                $comment->user->addPoints(3, '답글 작성');
            }
        });

        static::deleted(function ($comment) {
            if (!$comment->parent_id) {
                $comment->user->addPoints(-5, '댓글 삭제');
            } else {
                $comment->user->addPoints(-3, '답글 삭제');
            }
        });
    }
} 