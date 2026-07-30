<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportPinController extends Controller
{
    public function show()
    {
        return view('reports.pin');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'pin' => 'required'
        ]);

        $correctPin = env('REPORT_PIN', '123456');

        if ($request->pin === (string) $correctPin) {
            session(['report_pin_verified' => true]);
            return redirect()->route('reports.index');
        }

        return back()->withErrors(['pin' => 'PIN salah! Silakan coba lagi.']);
    }
}
