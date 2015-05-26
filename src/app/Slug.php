<?php namespace App;

use Eloquent;

class Slug extends Eloquent {

    protected $table = 'slugs';

    protected $fillable = ['hash', 'url'];

    protected $attributes = [
        'visit' => 0,
    ];

}
    
