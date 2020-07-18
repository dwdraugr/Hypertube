<?php

namespace App\Http\Controllers;

use App\Video;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class YtsController extends Controller
{
    /**
     * @var Client
     */
    private Client $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function index(Request $request)
    {
        return response()->json(json_decode($this->httpClient->get('https://yts.mx/api/v2/list_movies.json', [
            'query' => [
                'limit' => '50',
                'page' => $request->get('page') ?? '1',
                'quality' => $request->get('quality') ?? 'all',
                'minimum_rating' => $request->get('minimum_rating') ?? '0',
                'genre' => $request->get('genre') ?? 'all',
                'sort_by' => $request->get('sort_by') ?? 'date_added',
                'order_by' => $request->get('order_by') ?? 'desc',
                'query_term' => $request->get('query') ?? '0',
            ],
        ])->getBody()));
    }

    public function show(int $id)
    {
        $video = $this->httpClient->get('https://yts.mx/api/v2/movie_details.json', [
            'query' => [
                'movie_id' => $id,
                'with_images' => 'true',
                'with_cast' => 'true',
            ],
        ]);
        Video::saveNewVideo(json_decode($video->getBody())->data->movie);
        return $video;
    }

}
