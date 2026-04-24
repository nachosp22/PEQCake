<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MonthlyOrdersExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $from = $request->string('from')->toString();
        $to = $request->string('to')->toString();

        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $from)) {
            $from = now()->startOfMonth()->format('Y-m-d');
        }
        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $to)) {
            $to = now()->endOfMonth()->format('Y-m-d');
        }

        return view('admin.reports.index', [
            'from' => $from,
            'to' => $to,
        ]);
    }

    public function exportOrders(Request $request): BinaryFileResponse
    {
        $validated = $request->validate([
            'from' => ['required', 'date', 'date_format:Y-m-d'],
            'to' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:from'],
        ]);

        $from = $validated['from'];
        $to = $validated['to'];
        $fileName = sprintf('informe_PEQ_desde_%s_hasta_%s.xlsx', $from, $to);

        return Excel::download(new MonthlyOrdersExport($from, $to), $fileName);
    }
}
