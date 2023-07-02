<?php
namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function fetchServices(Request $request)
    {
        $urls = explode(" ", $request->input('urls'));

        $services = [];
        foreach ($urls as $url) {
            $data = $this->fetchServiceData($url);
            $services[] = [
                'url' => $url,
                'services' => $data,
            ];
        }

        $urlCount = count($urls);
        $siteCount = count(array_filter($services, function ($item) {
            return !empty($item['services']);
        }));

        return response()->json([
            'urlCount' => $urlCount,
            'siteCount' => $siteCount,
            'services' => $services,
        ]);
    }

    private function fetchServiceData($url)
    {
        $ch = curl_init();
    
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
        // Execute the cURL request
        $response = curl_exec($ch);
    
        // Close cURL resource
        curl_close($ch);
    
        // Process the response and extract the desired service data
        $services = [];
    
        // Example: Extract title from HTML response
        preg_match('/<title>(.*?)<\/title>/', $response, $titleMatches);
        if (isset($titleMatches[1])) {
            $services['title'] = $titleMatches[1];
        } else {
            $services['title'] = null;
        }
    
        // Example: Extract meta description from HTML response
        preg_match('/<meta name="description" content="(.*?)"/', $response, $descriptionMatches);
        if (isset($descriptionMatches[1])) {
            $services['description'] = $descriptionMatches[1];
        } else {
            $services['description'] = null;
        }
    
        // You can add more service extraction logic as per your requirements
    
        return $services;
    }
}
