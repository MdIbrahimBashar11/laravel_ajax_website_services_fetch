<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class SiteController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function getServices(Request $request)
    {
        $urls = $request->input('urls');

        $results = [];

        foreach ($urls as $url) {
            $services = $this->parseSiteServices($url);
          
            $result = [
                'url' => $url,
                'services' => $services,
            ];

            $results[] = $result;
        }

        return view('services', compact('services'));
    }

    private function parseSiteServices($url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
    
        $services = $crawler->filter('h1')->each(function ($node) {
            return $node->text();
        });
    
        return $services;
    }
}
