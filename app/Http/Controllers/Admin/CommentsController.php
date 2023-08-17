<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddReplyRequest;
use App\Models\Comment;
use App\Models\CommentAttachment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Ticket $ticket)
    {
        $comments = Comment::where('ticket_id', $ticket->id)->with(['user:id,name,role', 'attachments'])->get();

        return Inertia::render('Admin/Comments/Index', [
            'comments' => $comments,
            'ticket' => $ticket->load(['status:id,name_en', 'category:id,name_en', 'priority:id,name_en',
                'project:id,name', 'createdBy:id,name'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Ticket $ticket)
    {
        return Inertia::render('Admin/Comments/Create', [
            'ticket' => $ticket->load(['status:id,name_en', 'category:id,name_en', 'priority:id,name_en',
                'project:id,name', 'createdBy:id,name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Ticket $ticket, AddReplyRequest $request)
    {
        $comment = $ticket->comments()->create($request->input() + ['user_id' => auth()->id()]);
        // Attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                CommentAttachment::create([
                    'file_name' => pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME),
                    'type' => $attachment->extension() ?: 'pdf', 'comment_id' => $comment->id,
                    'uploaded_by' => auth()->id(),
                    'path' => $attachment->store('tickets/ticket-'.$ticket->id.'/replies', 'public')]);
            }
        }

        return redirect()->route('tickets.comments.index', $ticket->id)->with('message', 'Added Successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
