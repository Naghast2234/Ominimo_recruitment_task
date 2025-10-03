<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model {
    
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'content',
        'created_at'
    ];
    
    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function getJsonString() {
        $data = [
            'content' => $this->content,
            'title' => $this->title
        ];

        return json_encode($data);
    }
}
