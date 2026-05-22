<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function index()
    {
        $this->ensureAdmin();

        $members = Member::orderBy('name')->get();
        return view('members.index', compact('members'));
    }

    public function create()
    {
        $this->ensureAdmin();

        return view('members.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);

        Member::create($data);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        $this->ensureAdmin();

        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);

        $member->update($data);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        $this->ensureAdmin();

        $member->delete();

        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }

    public function show(Member $member)
    {
        // allow admin or the member themself
        if (! (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->member_id === $member->id))) {
            abort(403);
        }

        $loans = $member->loans()->with('book')->orderByDesc('borrowed_at')->paginate(10);

        return view('members.show', compact('member', 'loans'));
    }

    private function ensureAdmin(): void
    {
        abort_unless(Auth::check() && Auth::user()->isAdmin(), 403);
    }
}
