<?php namespace App\Http\Controllers;

use Request;

class SlugController extends Controller {

    public function redirect($hash)
    {

        return response('Hash to redirect: ' . $hash);
    }

    public function create()
    {
        return Request::all();
    }

    public function update($hash)
    {
        return 'Hash to update: ' . $hash;
    }

}
