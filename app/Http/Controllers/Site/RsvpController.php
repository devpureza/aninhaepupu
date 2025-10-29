<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Rsvp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RsvpController extends Controller
{
    public function index()
    {
        return view('rsvp');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'attending' => ['required', Rule::in(['1', '0'])],
            'companions' => ['nullable', 'integer', 'min:0', 'max:10'],
            'dietary_notes' => ['nullable', 'string', 'max:500'],
            'honeypot' => ['nullable', 'size:0'],
        ], [
            'honeypot.size' => 'Ops! Algo deu errado.',
        ]);

        $companions = $data['attending'] === '1' ? (int) ($data['companions'] ?? 0) : 0;

        DB::transaction(function () use ($data, $companions) {
            $guest = Guest::firstOrNew(['email' => $data['email']]);
            $guest->fill([
                'name' => $data['name'],
                'phone' => $data['phone'] ?? null,
                'rsvp_status' => $data['attending'] === '1' ? 'confirmed' : 'declined',
                'companions_allowed' => max($guest->companions_allowed ?? 0, $companions),
                'companions_confirmed' => $companions,
            ]);

            if (! $guest->invite_code) {
                $guest->invite_code = Guest::generateInviteCode();
            }

            $guest->save();

            Rsvp::updateOrCreate(
                ['guest_id' => $guest->id],
                [
                    'attending' => $data['attending'] === '1',
                    'companions' => $companions,
                    'dietary_notes' => $data['dietary_notes'] ?? null,
                ],
            );
        });

        return back()->with('success', 'Obrigada por confirmar! Em breve entraremos em contato com mais detalhes.');
    }
}
