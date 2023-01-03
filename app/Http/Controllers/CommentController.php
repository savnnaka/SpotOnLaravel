<?php

namespace App\Http\Controllers;
use App\Models\Comment;

use Illuminate\Http\Request;


class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web'); //only for users
    }


    /**
     * stores a newly made comment
     */
    public function store()
    {
        $data = request()->validate([
            'content' => 'required',
            'event_id' => 'integer|required',
        ]);

        // save comment through user (get user_id automatically):
        $comment = auth()->user()->comments()->create($data);
        $event_id = request('event_id');
        return redirect("/event/{$event_id}");    
    }


    /**
     * no new edit view, render events.show according to which comment should be edited
     */
    public function edit(Comment $comment)
    {
        // can only be updated by the user who wrote the comment
        $this->authorize('update', $comment);

        // comment that should be edited
        $toEdit = $comment->id;

        $event = $comment->event;
        $likesCount = count($event->likes);
        $like = (auth()->user()->likings->contains($event->id) ? $like = 'Unlike' : $like = 'Like');
        $comments = $event->comments;
        
        return view('events.show', compact('event', 'likesCount', 'like', 'comments', 'toEdit'));
    }


    /**
     * updates comment
     */
    public function update(Comment $comment)
    {
        // can only be updated by the user who wrote the comment
        $this->authorize('update', $comment);

        $data = request()->validate([
            'content' => 'required',
            'event_id' => 'integer|required',
        ]);

        // update comment through user (get user_id automatically):
        auth()->user()->comments()->where('id', $comment->id)->update($data);
        
        $event_id = request('event_id');
        return redirect("/event/{$event_id}");    
    }

    /**
     * deletes a comment
     */
    public function destroy(Comment $comment)
    {
        // can only be deleted by the user who wrote the comment
        $this->authorize('update', $comment);

        $comment->delete();
        
        $event_id = request('event_id');
        return redirect("/event/{$event_id}");
    }
}
