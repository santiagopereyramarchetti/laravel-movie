<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index(Request $request){
        $perPage = $request->perPage ?? 5;
        $tags = Tag::when($request->search, function($tagsList, $search) {
            $tagsList->where('tag_name', 'like', "%{$search}%");
        })->paginate($perPage)
        ->withQueryString();
        /*
            The when() method only execute a function if his first argument its true or exists. The function to execute in his first argument
            have the collection from the query and the second argument its the value of the first argument.

            whitQueryString method its a method for paginate which going to send the paginate get parameters and the query get parametrs.
            In this example going to send the input search wich come with the request. If we didnt add this mehtod we going to loose
            that search input
        */
        $filters = $request->only('search', 'perPage');
        return Inertia::render('Tags/Index', compact('tags', 'filters'));
    }

    public function create(){
        return Inertia::render('Tags/Create');
    }

    public function store(Request $request){        
        Tag::create([
            'tag_name' => $request->tagName,
            'slug' => Str::slug($request->tagName)
        ]);
        return Redirect::route('admin.tags.index')->with('flash.banner', 'Tag Created');
    }

    public function edit(Tag $tag){
        return Inertia::render('Tags/Edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag){
        $tag->update([
            'tag_name' => $request->tagName,
            'slug' => Str::slug($request->tagName)
        ]);
        return Redirect::route('admin.tags.index')->with('flash.banner', 'Tag Updated');
    }

    public function destroy(Tag $tag){
        $tag->delete();
        return Redirect::route('admin.tags.index')->with('flash.banner', 'Tag Deleted');
    }
}
