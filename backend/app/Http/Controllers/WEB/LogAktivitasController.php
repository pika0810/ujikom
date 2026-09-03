<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Resources\LogAktivitasResource;
use App\Models\LogAktivitas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(): JsonResponse
    {
        $Logs = LogAktivitas::with('user')->latest()->get();

        return response()->json([
            'message' => 'Seluruh catatan loh aktivitas berhasil diambil.',
            'total_data' => $logs->count(),
            'data' => LogAktivitasResource::collection($logs)
        ]);
    }
}
