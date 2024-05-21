<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, TaskUserManager;

    protected $fillable = ['title', 'description', 'due', 'assigneduser_id', 'status', 'taskcreator_id', 'slug'];

    protected $attributes = [
        'status' => 'ongoing', // nilai default
    ];

    public function formatDate()
    {
        return $this->getDates();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['search'])) {
            $query->where(function ($query) use ($filters) {
                $query
                    ->where('due', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('created_at', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['searchbody'])) {
            $query->where(function ($query) use ($filters) {
                $query
                    ->orWhere('title', 'like', '%' . $filters['searchbody'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['searchbody'] . '%');
            });
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
    }

    public static function getStatusOptions()
    {
        return ['ongoing', 'fixing', 'delay', 'completed'];
    }

    public static function rules()
    {
        return [
            'title' => 'required',
            'due' => 'required',
            'description' => 'required',
            'assigneduser_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:' . implode(',', self::getStatusOptions())],
        ];
    }
}
