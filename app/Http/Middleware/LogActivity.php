<?php
// app/Http/Middleware/LogActivity.php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->user() && in_array($request->method(), ['POST', 'PUT', 'DELETE'])) {
            $this->logActivity($request);
        }

        return $response;
    }

    private function logActivity(Request $request)
    {
        $action = match($request->method()) {
            'POST' => 'created',
            'PUT' => 'updated',
            'DELETE' => 'deleted',
            default => 'viewed',
        };

        $model = $this->getModelFromUrl($request->path());

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => $action,
            'model' => $model,
            'model_id' => $request->route('id') ?? 0,
            'changes' => $request->all(),
        ]);
    }

    private function getModelFromUrl($path)
    {
        if (str_contains($path, 'dokter')) return 'Dokter';
        if (str_contains($path, 'pasien')) return 'Pasien';
        return 'Unknown';
    }
}