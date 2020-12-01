<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Provider;
use App\Models\ProviderMeta;
use App\Rules\VideoDuration;
use FFMpeg;
use Illuminate\Http\Request;
use Storage;

class ProvidersController extends Controller
{

	/**
	 * Fetch a list of providers
	 *
	 * @return JSON
	 * @author 
	 **/
	public function list(Request $request)
	{
		$all = Provider::with('meta')->get();
		return response()->json(['response' => $all]);
	}

	/**
	 * Fetch all uploaded files
	 *
	 * @return JSON
	 * @author 
	 **/
	public function uploaded(Request $request)
	{
		$all = File::orderBy('id', 'desc')->get();
		return response()->json(['response' => $all]);
	}

    /**
     * Upload image to server.
     *
     * @return JSON
     * @author 
     **/
    public function image(Request $request)
    {
    	$v_init = \Validator::make($request->all(), [
    		'name' => 'required',
    		'provider' => 'required|exists:providers,id',
    		'image_file' => 'required|file'
    	]);

    	if ($v_init->fails()) {
		    return response()->json($v_init->errors(), 400);
		}

		// Fetch the provider_id
		$provider = $request->get('provider');

		$l_providers = ProviderMeta::where(['provider_id' => $provider, 'type' => $request->file('image_file')->getMimeType()])->first();

		// Check if File Type is supported by this provider
		if(!$l_providers){
			return response()->json(["error" => "{$request->file('image_file')->getMimeType()} is not supported"], 400);
		}

    	// validate mime-type: image/jpeg, gif
    	// if valid, then try to validate on length
    	$validator = \Validator::make($request->all(), [
    		'image_file' => $l_providers->rule
    	]);

    	if ($validator->fails()) {
		    return response()->json($validator->errors(), 400);
		}

		$image = $request->file('image_file')->store('images');

		$image_path_split = explode('/', $image);

		$file = File::create([
			'title' => $request->get('name'),
			'original_name' => $request->file('image_file')->getClientOriginalName(),
			'disk' => reset($image_path_split),
			'path' => end($image_path_split),
		]);

		return response()->json(['response' => $file]);
    }

    /**
     * Upload Video to server
     *
     * @return JSON
     * @author 
     **/
    public function video(Request $request)
    {
    	$v_init = \Validator::make($request->all(), [
    		'name' => 'required',
    		'provider' => 'required|exists:providers,id',
    		'video_file' => 'required|file'
    	]);

    	if ($v_init->fails()) {
		    return response()->json($v_init->errors(), 400);
		}

		// Fetch the provider_id
		$provider = $request->get('provider');

		$l_providers = ProviderMeta::where(['provider_id' => $provider, 'type' => $request->file('video_file')->getMimeType()])->first();

    	// validate mime-type: video/mp4, mp3
    	// if valid, then try to validate on length
    	$validator = \Validator::make($request->all(), [
    		'video_file' => [new VideoDuration($duration = $l_providers->rule_length), $l_providers->rule]
    	]);

    	if ($validator->fails()) {
		    return response()->json($validator->errors(), 400);
		}

		$video = $request->file('video_file')->store('videos');

		$video_path_split = explode('/', $video);
		// dd($video_path_split);

		$file = File::create([
			'title' => $request->get('name'),
			'original_name' => $request->file('video_file')->getClientOriginalName(),
			'disk' => reset($video_path_split),
			'path' => end($video_path_split),
		]);

		// Thumbnail grabber can be moved to a queue. Not doing due to time limitation
		$media = FFMpeg::fromDisk(reset($video_path_split))
					->open(end($video_path_split));

		$frame = $media->getFrameFromSeconds($media->getDurationInSeconds()/2)
						->export()
						->toDisk('thumbnails')
						->save("{$file->path}.png");
		
		return response()->json(['response' => $file]);
    }
}
