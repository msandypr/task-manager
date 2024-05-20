<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, TaskUserManager;

    protected $fillable = ['title', 'description', 'due', 'assigneduser_id', 'status', 'taskcreator_id', 'slug'];

    protected $attributes = [
        'status' => 'ongoing', // Atur nilai default jika diperlukan
    ];

    public function formatDate()
    {
        return $this->getDates();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeFilter($query)
    {
        if (request('search')) {
            $query
                ->where('due', 'like', '%' . request('search') . '%')
                ->orWhere('created_at', 'like', '%' . request('search') . '%')
                ->orWhere('title', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%');
        }

        if (request('searchbody')) {
            $query
                ->orWhere('title', 'like', '%' . request('searchbody') . '%')
                ->orWhere('description', 'like', '%' . request('searchbody') . '%');
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
