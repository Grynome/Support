<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function update(Request $request)
    {
        session()->put('sidebarThemeSettings', $request->sidebarThemeSettings);

        return response()->json([
            'status' => 'success'
        ]);
    }
}
