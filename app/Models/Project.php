<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'uid',
        'title',
        'short_description',
        'start_date',
        'end_date',
        'phase',
    ];

    /**
     * Attribute casting for automatic date handling.
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /**
     * Relationship: each project belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'uid');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS (Computed Attributes)
    |--------------------------------------------------------------------------
    | These give you clean, reusable values in Blade:
    | {{ $project->formatted_start_date }}
    | {{ $project->formatted_end_date }}
    | {{ $project->is_overdue }}
    | {{ $project->status_label }}
    |--------------------------------------------------------------------------
    */

    /**
     * Human‑friendly start date.
     */
    public function getFormattedStartDateAttribute()
    {
        return $this->start_date
            ? $this->start_date->format('d M Y')
            : 'N/A';
    }

    /**
     * Human‑friendly end date.
     */
    public function getFormattedEndDateAttribute()
    {
        return $this->end_date
            ? $this->end_date->format('d M Y')
            : 'N/A';
    }

    /**
     * Whether the project is overdue.
     */
    public function getIsOverdueAttribute()
    {
        return $this->end_date &&
               $this->end_date->isPast() &&
               $this->phase !== 'complete';
    }

    /**
     * A clean, readable label for the phase.
     */
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->phase);
    }
}
