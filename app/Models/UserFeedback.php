<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFeedback extends Model
{
    use HasFactory;

    protected $table = 'user_feedback';  // Opzionale, solo se il nome della classe e la tabella non coincidono

    protected $fillable = [
        'target_user_id',
        'feedback_user_id',
        'rating',
        'comment'
    ];

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function feedbackUser()
    {
        return $this->belongsTo(User::class, 'feedback_user_id');
    }
}
