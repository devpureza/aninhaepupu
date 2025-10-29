<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class MessagesController extends Controller
{
    public function index()
    {
        $messages = Cache::remember('site.messages.approved', now()->addMinutes(2), function () {
            return Message::forWall()->take(30)->get();
        });

        return view('messages', compact('messages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:600'],
            'is_public' => ['nullable', Rule::in(['on', '1'])],
            'email' => ['nullable', 'email', 'max:255'],
            'honeypot' => ['nullable', 'size:0'],
        ], [
            'honeypot.size' => 'Ops! Algo deu errado.',
        ]);

        Message::create([
            'guest_name' => $data['guest_name'],
            'content' => $data['content'],
            'is_public' => isset($data['is_public']),
            'approved' => false,
        ]);

        Cache::forget('site.messages.approved');

        return back()
            ->with('success', 'Mensagem enviada com carinho! Assim que for aprovada, aparecerá no mural.')
            ->withInput();
    }
}
