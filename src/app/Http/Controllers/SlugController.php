<?php namespace App\Http\Controllers;

use Request;
use App\Slug;
use \Exception;
use Hashids\Hashids;

class SlugController extends Controller {

    // Hashids instance
    private $hashids;

    // Application Key
    private $appKey;


    public function __construct()
    {
        // Set application key
        $appKey = env('APP_KEY');

        // All caps hashing alphabet
        // following keys removed to prevent misreading:
        // 1, I, 2, Z, O, 0, Q
        $alphabet = 'ABCDEFGHJKLMNPRSTUVWXY3456789';
        
        // Hashids instance
        // Use APP_KEY enviroment variable as hashing salt
        $this->hashids = new Hashids($appKey, 4, $alphabet);

        //
        // TODO: the instantiation above should be a service provider

        // TODO: use a simple security measure
        // i.e. require APP_KEY to be sent and matches with this app's key
        // e.g. X-APP-KEY should be a good header name choice for the sake of simplicity
    }


    public function redirect($hash)
    {
        // Case-insensitive URIS
        $hash = strtoupper($hash);

        try {
            // Find the slug
            $slug = Slug::where(['hash' => $hash])->firstOrFail();
        } catch (Exception $e){
            // Return error if slug couldn't found
            return response('Not Found', 404);
        }

        if (Request::input('detail', false) !== false) {
            return $slug;
        }

        // Icrement slug visit count by 1
        $slug->increment('visit');
        // Redirect to target url
        return redirect($slug->url);
    }


    public function create()
    {
        
        // TODO: Verify URL
        $url        = Request::input('url');

        $customHash = Request::input('hash', false);

        // Fetch existing slug or create one
        // 
        if (is_string($customHash)) {
            $hash = strtoupper($customHash);
            $slug = Slug::firstOrNew(['hash' => $hash]);
            $slug->url = $url;
        } else {
            // Create a random unique id        
            // TODO: Better way to create a unique id
            // 
            $numberToHash = (int)(Slug::count() . rand(10, 99));
            $hash = $this->hashids->encode($numberToHash);
            $slug = new Slug(['hash' => $hash, 'url' => $url]);
        }

        $slug->save();
        
        // Add created / modified short url to result
        // TODO: domain (tin.st) shouldn't be hardcoded
        // 
        $arr = $slug->toArray();
        $arr['shortUrl'] = sprintf('http://tin.st/%s', $slug->hash);

        return $arr;
    }

    public function index()
    {
        return Slug::paginate(20);
    }
}
