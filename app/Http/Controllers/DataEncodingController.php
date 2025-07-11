<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DataEncodingController extends Controller
{
    /**
     * Display the data encoding page.
     */
    public function index(): View
    {
        return view('data-encoding.index');
    }

    /**
     * Store encoded data.
     */
    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required|string|max:1000',
            'encoding_type' => 'required|in:base64,url,html',
        ]);

        $data = $request->input('data');
        $encodingType = $request->input('encoding_type');

        $encodedData = match($encodingType) {
            'base64' => base64_encode($data),
            'url' => urlencode($data),
            'html' => htmlspecialchars($data, ENT_QUOTES, 'UTF-8'),
            default => $data,
        };

        return back()->with([
            'success' => 'Data encoded successfully!',
            'original_data' => $data,
            'encoded_data' => $encodedData,
            'encoding_type' => $encodingType,
        ]);
    }

    /**
     * Decode data.
     */
    public function decode(Request $request)
    {
        $request->validate([
            'encoded_data' => 'required|string|max:1000',
            'encoding_type' => 'required|in:base64,url,html',
        ]);

        $encodedData = $request->input('encoded_data');
        $encodingType = $request->input('encoding_type');

        $decodedData = match($encodingType) {
            'base64' => base64_decode($encodedData),
            'url' => urldecode($encodedData),
            'html' => htmlspecialchars_decode($encodedData, ENT_QUOTES),
            default => $encodedData,
        };

        return back()->with([
            'success' => 'Data decoded successfully!',
            'encoded_data' => $encodedData,
            'decoded_data' => $decodedData,
            'encoding_type' => $encodingType,
        ]);
    }
}
