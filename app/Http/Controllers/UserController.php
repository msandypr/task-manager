<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            // field lainnya akan di update.
        ]);

        $user->update($data);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('user.profile')->with('success', 'Password updated successfully.');
    }


    public function adminDashboard()
    {

        return view('user.admin-dashboard', [
            'userCount' => User::latest()->count(),
            'users' => User::latest()->filter(['search'])->paginate(10),
            'tasks' => Task::latest()->get(),
            'taskCompleted' => Task::where('status', 'completed')->get()->count(), // Menghitung jumlah task yang selesai
            'taskDue' => Task::where('status', '!=', 'completed')->get()->count() // Menghitung jumlah task yang belum selesai
        ]);
    }

    public function userDashboard(User $user)
    {
        return view('user.dashboard', [
            'user' => $user,
            'tasks' => Task::where('taskcreator_id', $user->id)
                ->orWhere('assigneduser_id', $user->id)
                ->paginate(10)
        ]);
    }

}
