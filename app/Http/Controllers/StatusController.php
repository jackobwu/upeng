<?php

namespace App\Http\Controllers;

use App\Status;

class StatusController extends Controller
{
    public function index()
    {
        $cursor = (request()->has('cursor') ? ['id' => request('cursor')] : []);

        $ids = auth()->user()->friends()->pluck('id')->push(auth()->id());

        $statuses = Status::topLevel()
            ->whereIn('user_id', $ids)
            ->cursorPaginate(5, $cursor, 'desc');
        
        return response()->json($statuses);
    }
    
    public function store()
    {
        
        $data = request()->validate(['body' => 'required | max:300'], [], ['body' => 'status']); 

        if (request()->hasFile('image')) {
            $path = request()->file('image')->store('public');
            $imageName = explode("/", $path);
            $data['image'] = $imageName[1];
        }

        $status = auth()->user()->statuses()->create($data)->load('user');

        $flash = 'Status posted.';

        return response()->json(compact('status', 'flash'));
    }

    public function destroy($id)
    {
        $status = Status::find($id);
        
        if ($status->user_id !== auth()->id()) {
            return response()->json(['flash' => 'Invalid operation'], 401);
        } 

        $status->delete();

        return response()->json(['flash' => 'Status deleted']);
    
    }
    
}
