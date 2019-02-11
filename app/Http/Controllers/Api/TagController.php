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

        if (isset($request->textInput)) {
            $filteredTags = $tags->filter(function ($tag) use ($request) {
                $substring = substr($tag->name, 0, strlen($request->textInput));
                return $substring == $request->textInput;
            });

            $tags = $filteredTags;
        }

        return TagResource::collection($tags);
    }
}
