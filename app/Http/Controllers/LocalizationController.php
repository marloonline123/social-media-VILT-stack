<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LocalizationController extends Controller
{
    public function index(Request $request)
    {
        $locale = $request->input('locale', config('app.locale'));

        // Load translations from JSON file
        $path = resource_path("lang/{$locale}.json");
        $translations = File::exists($path) ? json_decode(File::get($path), true) : [];

        return response()->json([
            'locale' => $locale,
            'translations' => $translations,
        ]);
    }

    public function switchLocale($locale)
    {
        if (!in_array($locale, ['en', 'ar'])) {
            return response()->json(['success' => false], 400);
        }

        session(['locale' => $locale]);
        app()->setLocale($locale);

        return response()->json(['success' => true]);
    }

}
