<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Thread;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = Thread::paginate(15);
        return view('thread.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create');
        return view('thread.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validate($request,[
          'subject'=>'required|min:5',
           'type' => 'required',
           'thread'=>'required',
       ]);

       auth()->user()->threads()->create($request->all());

       return back()->withMessage('Thread  Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
        return view ('thread.single', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        return view ('thread.edit', compact('thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        $this->authorize('update');

        if(auth()->user()->id !== $thread->user_id){

            return redirect()->back()->withMessage('no access');
        }
        $this->validate($request,[
            'subject'=>'required|min:5',
            'type' => 'required',
            'thread'=>'required',
        ]);

        $thread->update($request->all());

        return redirect()->route('thread.show',$thread->id)->withMessage('Thread was updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        $this->authorize('delete');
        if(auth()->user()->id !== $thread->user_id){

            return redirect()->back()->withMessage('no access');
        }

        $thread->delete();

        return redirect('thread')->withMessage('Tread was deleted');
    }
}
