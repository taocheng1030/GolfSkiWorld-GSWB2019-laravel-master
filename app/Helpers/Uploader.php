<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('ImageUploadS3')) 
{
    function ImageUploadS3($image, $folder, $asArray = false)
    {
        $mt = microtime(true);
        $micro = sprintf("%06d",($mt - floor($mt)) * 1000000);
        $timestamp = date('Y-m-d.H-i-s', time()) . "." . $micro;

        $s3_url = env('S3_URL', '');
        $bucket = env('S3_BUCKET', '');
        $image_folder = env('S3_IMAGE_FOLDER', '');
        $image_filename = $timestamp . '.' . $image->getClientOriginalExtension();
        $file_path = $image_folder . $folder . $image_filename;

        if (env('S3_ENABLE', false)) {
            Storage::disk('s3')->put($file_path, fopen($image->getRealPath(), 'r+'), 'public');
        }

        $url = ($asArray) ? [
            'name' => $timestamp,
            'path' => $url = $s3_url . $bucket . $image_folder . $folder,
            'ext'  => $image->getClientOriginalExtension()
        ] : $s3_url . $bucket . $file_path;

        return $url;
    }
}
 
if (!function_exists('ImageUploadS3Base64')) 
{
    function ImageUploadS3Base64($image, $folder, $asArray = false)
    {
        $mt = microtime(true);
        $micro = sprintf("%06d",($mt - floor($mt)) * 1000000);
        $timestamp = date('Y-m-d.H-i-s', time()) . "." . $micro;

        $s3_url = env('S3_URL', '');
        $bucket = env('S3_BUCKET', '');
        $image_folder = env('S3_IMAGE_FOLDER', '');
        $image_filename = $timestamp . '.' . substr(mime_content_type($image), 6);
        $file_path = $image_folder . $folder . $image_filename;

        if (env('S3_ENABLE', false)) {
            Storage::disk('s3')->put($file_path, file_get_contents($image), 'public');
        }

        $url = ($asArray) ? [
            'name' => $timestamp,
            'path' => $url = $s3_url . $bucket . $image_folder . $folder,
            'ext'  => substr(mime_content_type($image), 6)
        ] : $s3_url . $bucket . $file_path;

        return $url;
    }
}

if (!function_exists('MovieUploadS3')) 
{
    function MovieUploadS3($movie, $folder, $asArray = false)
    {
        $mt = microtime(true);
        $micro = sprintf("%06d",($mt - floor($mt)) * 1000000);
        $timestamp = date('Y-m-d.H-i-s', time()) . "." . $micro;
        
        $s3_url = env('S3_URL', '');
        $bucket = env('S3_BUCKET', '');
        $movie_folder = env('S3_MOVIE_FOLDER', '');
        $movie_filename = $timestamp . '.' . $movie->getClientOriginalExtension();
        $file_path = $movie_folder . $folder . $movie_filename;

        if (env('S3_ENABLE', false)) {
            Storage::disk('s3')->put($file_path, fopen($movie->getRealPath(), 'r+'), 'public');
        }

        $url = ($asArray) ? [
            'name' => $timestamp,
            'path' => $url = $s3_url . $bucket . $movie_folder . $folder,
            'ext'  => $movie->getClientOriginalExtension()
        ] : $s3_url . $bucket . $file_path;

        return $url;
    }
}

if (!function_exists('MovieUploadS3Base64')) 
{
    function MovieUploadS3Base64($movie, $folder, $asArray = false)
    {
        $mt = microtime(true);
        $micro = sprintf("%06d",($mt - floor($mt)) * 1000000);
        $timestamp = date('Y-m-d.H-i-s', time()) . "." . $micro;

        $s3_url = env('S3_URL', '');
        $bucket = env('S3_BUCKET', '');
        $movie_folder = env('S3_MOVIE_FOLDER', '');
        $movie_filename = $timestamp . '.' . substr(mime_content_type($movie), 6);
        $file_path = $movie_folder . $folder . $movie_filename;

        if (env('S3_ENABLE', false)) {
            Storage::disk('s3')->put($file_path, file_get_contents($movie), 'public');
        }

        $url = ($asArray) ? [
            'name' => $timestamp,
            'path' => $url = $s3_url . $bucket . $movie_folder . $folder,
            'ext'  => substr(mime_content_type($movie), 6)
        ] : $s3_url . $bucket . $file_path;

        return $url;
    }
}

if (!function_exists('GetUploadToken')) 
{
    function GetUploadToken()
    {
        // important variables that will be used throughout this example
        $bucket = env('S3_BUCKET', '');

        // these can be found on your Account page, under Security Credentials > Access Keys
        $aws_key = env('S3_KEY', '');
        $aws_secret = env('S3_SECRET', '');

        $policy = base64_encode(
            json_encode(
                array(
                    // ISO 8601 - date('c'); generates uncompatible date, so better do it manually
                    'expiration' => date('Y-m-d\TH:i:s.000\Z', strtotime('+1 day')), 
                    'conditions' => array(
                        array('bucket' => $bucket),
                        array('acl' => 'public-read'),
                        array('content-length-range', 0, 1024*1024*1024), // max 1 gig
                        array('starts-with', '$Content-Type', ''), // accept all files
                        // Plupload internally adds name field, so we need to mention it here
                        array('starts-with', '$name', ''), 
                        // One more field to take into account: Filename - gets silently sent by FileReference.upload() in Flash
                        // http://docs.amazonwebservices.com/AmazonS3/latest/dev/HTTPPOSTFlash.html
                        array('starts-with', '$Filename', ''),
                    )
                )
            )
        );

        $signature = base64_encode(hash_hmac('sha256', $policy, $aws_secret, true));

        $token = array(
            'policy' => $policy,
            'signature' => $signature,
            'key' => $aws_key
        );

        return $token;
    }
}