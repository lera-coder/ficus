<?php

namespace App\Models;

use App\Observers\InterviewObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interview extends ParentModel
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'link',
        'interview_time',
        'sending_time',
        'description',
        'interviewer_id',
        'status_id'
    ];

    /**
     * @return BelongsTo
     */
    public function interviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'interviewer_id');
    }

    /**
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(InterviewStatus::class, 'status_id');
    }

    /**
     * @return BelongsToMany
     */
    public function applicants(): BelongsToMany
    {
        return $this->belongsToMany(Applicant::class, 'applicants_interviews');
    }


//    public static function creating($callback)
//    {
//        DB::table('users')->insert(["name"=>"lera"]);
////        dd('succeess');
//        event(InterviewCreated::class);
//        static::registerModelEvent('created', $callback);
//    }


}
