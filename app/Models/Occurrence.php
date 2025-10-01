<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Occurrence extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'occurred_at',
        'location',
        'status',
        'latitude',
        'longitude',
        'images',
        'views_count',
        'rating',
        'rating_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'occurred_at' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'images' => 'array',
        'rating' => 'decimal:2',
    ];

    /**
     * Get the user that owns the occurrence.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the comments for the occurrence.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the ratings for the occurrence.
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(OccurrenceRating::class);
    }

    /**
     * Scope a query to only include verified occurrences.
     */
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    /**
     * Scope a query to only include pending occurrences.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to filter by location.
     */
    public function scopeInLocation($query, $location)
    {
        return $query->where('location', 'like', "%{$location}%");
    }

    /**
     * Get the occurrence types.
     */
    public static function getTypes(): array
    {
        return [
            'Assalto' => 'Assalto',
            'Furto' => 'Furto',
            'Roubo' => 'Roubo',
            'Vandalismo' => 'Vandalismo',
            'Tráfico' => 'Tráfico de Drogas',
            'Violência' => 'Violência Doméstica',
            'Outros' => 'Outros',
        ];
    }

    /**
     * Get the occurrence statuses.
     */
    public static function getStatuses(): array
    {
        return [
            'pending' => 'Pendente',
            'verified' => 'Verificado',
            'rejected' => 'Rejeitado',
        ];
    }

    /**
     * Increment the views count.
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
