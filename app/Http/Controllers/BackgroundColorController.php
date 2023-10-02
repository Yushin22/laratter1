<?php

namespace App\Http\Controllers;

use App\BackgroundColor;
use Illuminate\Http\Request;

class BackgroundColorController extends Controller
{
    public function select()
    {
        $colors = BackgroundColor::all();
        return view('background_colors.select', compact('colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'color_id' => 'required|exists:background_colors,id'
        ]);

        return redirect()->back()->with('success', '背景色が選択されました！');
    }
  
}
