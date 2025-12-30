<?php

namespace App\Observers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function created(User $user)
    {
        // Log only if not self-creating (avoid recursion)
        if (Auth::check() && Auth::id() !== $user->id) {
            $this->logActivity('created', 'User', $user->id, ['name' => $user->name, 'email' => $user->email, 'role' => $user->role]);
        }
    }

    public function updated(User $user)
    {
        if (Auth::check()) {
            $changes = $user->getChanges();
            unset($changes['password']); // Don't log password changes
            if (!empty($changes)) {
                $this->logActivity('updated', 'User', $user->id, $changes);
            }
        }
    }

    public function deleted(User $user)
    {
        if (Auth::check()) {
            $this->logActivity('deleted', 'User', $user->id, ['name' => $user->name, 'email' => $user->email]);
        }
    }

    private function logActivity($action, $model, $modelId, $changes)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model' => $model,
            'model_id' => $modelId,
            'changes' => $changes,
        ]);
    }
}