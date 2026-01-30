<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Data\User\UserData;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AdminUserController extends Controller
{
    public function index(): Response
    {
        $users = User::with('specialization')->get();

        return Inertia::render('admin/Users', [
            'users' => UserData::collect($users),
        ]);
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->withErrors(['cannotDeleteSelf' => 'Vous ne pouvez pas supprimer votre propre compte.']);
        }

        $user->delete();

        return redirect()->route('admin.users');
    }
}
