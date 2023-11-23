<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kreait\Firebase\Storage;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','image_path','type',];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSignedUrl($expiration)
    {
        $defaultBucket = app('firebase.storage')->getBucket();
        $file = $defaultBucket->object($this->image_path);

        return $file->signedUrl($expiration);
    }
}
