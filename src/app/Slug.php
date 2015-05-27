<?php namespace App;

use Eloquent;
use \Exception;

class Slug extends Eloquent {

    protected $table = 'slugs';

    protected $fillable = ['hash', 'url'];

    protected $attributes = [
        'visit' => 0,
    ];


    public function setUrlAttribute($value)
    {
        $url = parse_url($value);

        if ($url === FALSE) {
            throw new Exception("Hata. URL ayrıştırılamadı.", 1);
        }

        $scheme   = isset($url['scheme'])   ? $url['scheme'].'://' : 'http://';
        $host     = isset($url['host'])     ? $url['host']         : '';
        $port     = isset($url['port'])     ? ':'.$url['port']     : '';
        $path     = isset($url['path'])     ? $url['path']         : '';
        $query    = isset($url['query'])    ? '?'.$url['query']    : '';
        $fragment = isset($url['fragment']) ? '#'.$url['fragment'] : '';

        $this->attributes['url'] = $scheme.$host.$port.$path.$query.$fragment;
    }

}
    
