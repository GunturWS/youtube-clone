<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YouTubeController extends Controller
{
    public function index()
    {
        return view('youtube.index');
    }

    public function search(Request $request)
    {
        // nanti isi API
        return view('youtube.index');
    }

public function show($videoId)
    {
        return view('youtube.watch', [
            'videoId' => $videoId
        ]);
    }
}
