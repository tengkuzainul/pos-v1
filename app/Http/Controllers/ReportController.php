<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::selectRaw('SUM(total_price) as income, COUNT(*) as total_transaction');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->has('filter_by')) {
            switch ($request->filter_by) {
                case 'day':
                    $query->selectRaw('DATE(created_at) as date')
                        ->groupBy('date');
                    break;
                case 'month':
                    $query->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as date')
                        ->groupBy('date');
                    break;
                case 'year':
                    $query->selectRaw('YEAR(created_at) as date')
                        ->groupBy('date');
                    break;
            }
        } else {
            $query->selectRaw('DATE(created_at) as date')
                ->groupBy('date');
        }

        $day = $query->orderBy('date', 'desc')->get();

        return view('dashboard.report.index', compact('day'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
