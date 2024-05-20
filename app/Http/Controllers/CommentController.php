<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Task $task)
    {
        $attributes = $request->validate([
            'body' => 'required'
        ]);

        // Dapatkan ID pengguna yang saat ini masuk
        $userId = Auth::id();

        // Pastikan ID pengguna ada
        if ($userId) {
            $attributes['task_id'] = $task->id;
            $attributes['user_id'] = $userId;

            Comment::create($attributes);
        } else {
            // Tindakan jika ID pengguna tidak tersedia
            // Misalnya, kembalikan pesan kesalahan atau lakukan tindakan lain
        }

        return back();
    }
}
