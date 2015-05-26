<?php namespace App\Http\Controllers;

use Request;
use App\Slug;
use \Exception;
use Hashids\Hashids;

class SlugController extends Controller {

    // Hashids instance
    private $hashids;

    // APP_KEY
    private $key;


    public function __construct()
    {
        // Hashids instance
        $this->hashids = new Hashids($key, 4);

        // TODO: use a simple security measure
        // 
        $this->key = env('APP_KEY');
    }

    public function redirect($hash)
    {
        try {
            // Find the slug
            $slug = Slug::where('hash', '=', $hash)->firstOrFail();
        } catch (Exception $e){
            // Return error if slug couldn't found
            return response('Not Found', 404);
        }
        // Icrement slug visit count by 1
        $slug->increment('visit');
        // Redirect to target url
        return redirect($slug->url);
    }

    public function create()
    {
        
        // TODO: Verify URL
        // 
        $url  = Request::input('url');

        // TODO: Better way to create a unique id
        // 
        $hash = $this->hashids->encode(time());


        // Create a new slug
        $slug = new Slug([
            'hash' => $hash,
            'url'  => $url,
        ]);

        // save and return
        $slug->save();
        return $slug;
    }

    public function update($hash)
    {
        return 'Hash to update: ' . $hash;
    }

}
