<?php

namespace App\Observers;

use App\Models\Pasien;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class PasienObserver
{
    public function created(Pasien $pasien)
    {
        $this->logActivity('created', 'Pasien', $pasien->id, $pasien->toArray());
    }

    public function updated(Pasien $pasien)
    {
        $changes = $pasien->getChanges();
        $this->logActivity('updated', 'Pasien', $pasien->id, $changes);
    }

    public function deleted(Pasien $pasien)
    {
        $this->logActivity('deleted', 'Pasien', $pasien->id, $pasien->toArray());
    }

    private function logActivity($action, $model, $modelId, $changes)
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model' => $model,
                'model_id' => $modelId,
                'changes' => $changes,
            ]);
        }
    }
}