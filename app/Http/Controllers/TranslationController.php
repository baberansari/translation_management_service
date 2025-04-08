<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class TranslationController extends Controller
{
   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:translations,key,NULL,id,locale,' . $request->locale,
            'locale' => 'required|string|max:10',
            'value' => 'required|string',
            'tags' => 'nullable|array'
        ]);

        $translation = Translation::create($validated);
        Cache::forget("translations_{$validated['locale']}");
        
        return response()->json($translation, 201);
    }

    public function update(Request $request, Translation $translation)
    {
        $validated = $request->validate([
            'value' => 'required|string',
            'tags' => 'nullable|array'
        ]);

        $translation->update($validated);
        Cache::forget("translations_{$translation->locale}");
        
        return response()->json($translation);
    }

    public function show(Translation $translation)
    {
        return response()->json($translation);
    }

    public function search(Request $request)
    {
       
       $request->validate([
        'key' => 'nullable|string',
        'locale' => 'nullable|string',
        'content' => 'nullable|string',
        'tags' => 'nullable|array'
        ]);

    $query = Translation::query()
        ->when($request->key, fn($q) => $q->where('key', 'like', "%{$request->key}%"))
        ->when($request->locale, fn($q) => $q->where('locale', $request->locale))
        ->when($request->content, fn($q) => $q->where('value', 'like', "%{$request->content}%"))
        ->when($request->tags, fn($q) => $q->whereJsonContains('tags', $request->tags));

    return response()->json($query->paginate(50));
    }

    public function export(Request $request)
    {
        $locale = $request->query('locale', 'en');
        
        return Cache::remember("translations_{$locale}", 3600, function () use ($locale) {
            $translations = Translation::where('locale', $locale)
                ->select('key', 'value')
                ->cursor()
                ->pluck('value', 'key')
                ->all();

            return Response::json($translations)
                ->header('Cache-Control', 'public, max-age=3600')
                ->header('Content-Type', 'application/json');
        });
    }
}