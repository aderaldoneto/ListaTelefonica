<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Contact extends Model
{

    /** @use HasFactory<\Database\Factories\ContactFactory> */
    use HasFactory, Notifiable;
    use SoftDeletes;
    protected $fillable = ['user_id','name','email','phone','image_path'];
    protected $appends = ['image_url'];
    protected $hidden = ['image_path'];

    /**
     * @return BelongsTo<self, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string|null
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path
            ? Storage::url($this->image_path)
            : null;
    }
}
