<?php


namespace App\Http\Controllers;


use BitTorrent\Decoder;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class TorrentController extends Controller
{
    private string $torrentUrl = "http://qbit:8888";
    private CookieJar $jar;
    private Client $client;
    private array $compVideoFormats = ['ogg', 'ogv', 'mp4', 'webm'];

    public function __construct()
    {
        $this->jar = new CookieJar();
    }

    private function auth()
    {
        $this->client = new Client(['base_uri' => $this->torrentUrl]);
        $this->client->get('/api/v2/auth/login', [
            'query' => [
                'username' => 'admin',
                'password' => 'adminadmin',
            ],
            'cookies' => $this->jar
        ]);
    }
    public function startDownload(Request $request)
    {
        $torrentLink = $request->get('torrentLink');
        if (!$torrentLink) {
            return response()->json([
                'error' => '"torrentLink" params not found'
            ], 400);
        }
        $this->auth();
        $result = [];
        $result['status'] =  $this->client->post('/api/v2/torrents/add', [
            'multipart' => [
                [
                    'name' => 'urls',
                    'contents' => $torrentLink
                ],
            ],
            'cookies' => $this->jar,
        ])->getStatusCode();
        return view('video', $this->parseFile($torrentLink));
    }

    public function parseFile(string $url)
    {
        $torrentData = (new Decoder())->decode((Http::get($url))->body())['info'];
        $folder = $torrentData['name'];
        $videos = [];
        $subtitles = [];
        foreach ($torrentData['files'] as $td) {
            $file = $td['path'][0];
            $type = strrev(explode('.', strrev($file))[0]);
            if (in_array($type, $this->compVideoFormats)) {
                $videos[$type] = 'files/' . $folder . '/' . $file;
            } elseif ('$type' === 'srt') {
                $subtitles[] = 'files/' . $folder . '/' . $file;
            }
        }
        return [
            'videos' => $videos,
            'subtitles' => $subtitles
        ];
    }

}
