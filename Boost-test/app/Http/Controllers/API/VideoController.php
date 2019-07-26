<?php

namespace App\Http\Controllers\API;

use App\Metadata;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{

    public function getVideoSize($username)
    {

        if (is_null($username)){
            $response = Response::json([
                'error' => [

                    'message' => 'The username field is required.'

                ]
            ], 404
            );
            return $response;
        }

        $user = User::where('name', $username)->first();

        $totalVideoSize = 0;
        foreach ($user->videos as $video){
            $videoSize = Metadata::where('video_id', $video->id)->first();
            $videoSize = $videoSize->videoSize;
            $totalVideoSize = $totalVideoSize + $videoSize;
        }

        $data = ['Total Video Size' => $totalVideoSize];
        $response = Response::json($data, 200);

        return $response;

    }

    public function getVideoMetadata($videoID)
    {

        if (!$videoID){
            $response = Response::json([
                'error' => [

                    'message' => 'The video ID field is required.'

                ]
            ], 404
            );
            return $response;
        }

        $videoMeta = Metadata::findorFail($videoID);

        $data = [
            'Video Size' => $videoMeta->videoSize,
            'Viewers' => $videoMeta->viewersCount,
            'Created by' => $videoMeta->video->user->name
        ];

        $response = Response::json($data, 200);

        return $response;

    }

    public function updateVideoMetadata($videoID, $newVideoSize, $newViewersCount)
    {

        if (empty($videoID) || empty($newVideoSize) || empty($newViewersCount)){
            $response = Response::json([
                'error' => [

                    'message' => 'The video ID field, new video size and new viewer count are required.'

                ]
            ], 404
            );
            return $response;
        }

        $videoMeta = Metadata::findorFail($videoID);
        $videoMeta->videoSize = $newVideoSize;
        $videoMeta->viewersCount = $newViewersCount;
        $videoMeta->save();

        $response = Response::json($videoMeta, 200);

        return $response;

    }
    
}
