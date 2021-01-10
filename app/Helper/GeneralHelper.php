<?php

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
function get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}


function store_image_for_posts($post,Request $request){
    $i = 1;
    foreach ($request->images as $file) {
        $filename = $post->slug.'-'.time().'-'.$i.'.'.$file->getClientOriginalExtension();
        $file_size = $file->getSize();
        $file_type = $file->getMimeType();
        $path = public_path('assets/posts/' . $filename);
        Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path, 100);

        $post->media()->create([
            'file_name' => $filename,
            'file_size' => $file_size,
            'file_type' => $file_type,
        ]);
        $i++;
    }
}