<?php


namespace App\Http\Controllers;


use BitTorrent\Decoder;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class TorrentController extends Controller
{
    private string $torrentUrl = "http://localhost:8001";
    private CookieJar $jar;
    private Client $client;

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
        $result['files'] = $this->parseFile($torrentLink);
        return $result;
    }

    public function parseFile(string $url)
    {
        $decoder = new Decoder();
        $response = Http::get($url);
        $lol = $response->body();
        $df = $decoder->decode($lol);
        return $this->isNormVideo($df['info']['files']);
    }

    private function isNormVideo(array $files) {
        $out = [];
        foreach ($files as $file) {
            $revert = strrev($file['path'][0]);
            switch (substr($revert, 0, 4)) {
                case "vgo.":
                case "4pm.":
                    $out[] = $file['path'][0];
                    $file['path'][0];
                    break;
                default:
                    break;
            }
        }
        return $out;
    }
}
