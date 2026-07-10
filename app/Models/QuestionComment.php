<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Question;

class QuestionComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'user_id',
        'comment'
    ];
    protected $appends = ['date'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class,'question_id');
    }

    public function getDateAttribute()
    {
        $d =new Carbon($this->created_at);
        return $d->diffForHumans();
    }
}
