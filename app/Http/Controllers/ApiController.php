<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\NewsApi;
use Illuminate\Support\Facades\DB;

use GuzzleHttp\Client;
use Carbon\Carbon;
class ApiController extends Controller
{
    // public function storeData() {
    //     $getdata = Http::get('https://newsapi.org/v2/everything?q=apple&from=2022-09-18&to=2022-09-18&sortBy=popularity&apiKey=90b85e2c2ddc4d888b86b7f8a9807060'); // Pass the third parameter as an array if you have to set headers
    //     $response = $getdata->json();

    //     $data = collect($response); 
    //     $data->map(function ($item) {
    //         NewsApi::create([
    //             'id' => $item['id'],
    //             'name' => $item['name'],
    //             'author' => $item['author'],
    //             'title' => $item['title'],
    //             'description' =>  $item['description'],
    //             'url' =>  $item['url'],
    //             'urlToImage' => $item['urlToImage'],
    //             'publishedAt' => $item['publishedAt'],
    //             'content' => $item['content']
    //         ]);


            
        // $getData = Http::get('https://newsapi.org/v2/everything?q=apple&from=2022-09-18&to=2022-09-18&sortBy=popularity&apiKey=90b85e2c2ddc4d888b86b7f8a9807060');
        // $jsonResponse = $getData->json();

        //     foreach ($jsonResponse['items'] as $mp) {

        //         $mp = new NewsApi([
        //             'id' => $mp['id'],
        //             'name' => $mp['name'],
        //             'author' => $mp['author'],
        //             'title' => $mp['title'],
        //             'description' =>  $mp['description'],
        //             'url' =>  $mp['url'],
        //             'urlToImage' => $mp['urlToImage'],
        //             'publishedAt' => $mp['publishedAt'],
        //             'content' => $mp['content']
        
        //         ]);
        
        //         $mp->save();
        //     }
        
    //         return view('/')->with('success', 'data was successfully add.');
    //     });
    // }

    public function index(Request $request, Source $source) {
        $client = new Client();
        $req = $client->request('GET','https://newsapi.org/v2/everything', [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
            'query' => [
                'source'       => $source->id,
                'apiKey'       => env('90b85e2c2ddc4d888b86b7f8a9807060'),
            ],
        ]);

        $stream   = $req->getBody();
        $contents = json_decode($stream->getContents());
        $articles = collect($contents->articles);

        $articles->each(function ($article) use ($source) {
            $ng_article = NewsApi::updateOrCreate(['url' => $article->url],
            [
                'source_id'      => $source->id,
                'author'         => $article->author,
                'title'          => $article->title,
                'description'    => $article->description,
                'url'            => $article->url,
                'urlToImage'     => $article->urlToImage,
                'publishedAt'    => Carbon::parse($article->publishedAt),
                'NG_Description' => 'www',
                'NG_Review'      => 'zzz',
            ]);
        });


        return NewsApi::where('source_id', $source->id)->get();
    }

    public function show(Request $request, Source $source, Article $article) {
        return $article;
    }

}
