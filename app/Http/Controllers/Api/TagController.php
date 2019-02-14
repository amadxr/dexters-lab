<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::all();

        if (isset($request->key)) {
            $key = $request->key;

            $filteredTags = $tags->filter(function ($tag) use ($key) {
                $substring = substr($tag->name, 0, strlen($key));
                return $substring == $key;
            });

            $tags = $filteredTags;
        }

        return TagResource::collection($tags);
    }
}
