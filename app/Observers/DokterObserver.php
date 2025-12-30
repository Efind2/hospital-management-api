<?php

namespace App\Observers;

use App\Models\Dokter;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class DokterObserver
{
    public function created(Dokter $dokter)
    {
        $this->logActivity('created', 'Dokter', $dokter->id, $dokter->toArray());
    }

    public function updated(Dokter $dokter)
    {
        $changes = $dokter->getChanges();
        $this->logActivity('updated', 'Dokter', $dokter->id, $changes);
    }

    public function deleted(Dokter $dokter)
    {
        $this->logActivity('deleted', 'Dokter', $dokter->id, $dokter->toArray());
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