<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    public function searchElems(Request $request)
    {
        $query = $request->get('query');
        if (!$query) {
            return response()->json([
                'error' => '"query" params not found'
            ], 400);
        }
        $scrape_response = Http::get('localhost:9000/crawl', [
            'query' => $request->get('query')
        ]);
        return $scrape_response->json();
    }
}
