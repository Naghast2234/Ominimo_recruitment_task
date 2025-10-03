<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model {
    
    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
        'created_at'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo {
        return $this->belongsTo(Post::class);
    }

    // public function getJsonString() {
    //     $data = [
    //         'comment' => $this->comment,
    //     ];
    //     return json_encode($data);
    // }
}
