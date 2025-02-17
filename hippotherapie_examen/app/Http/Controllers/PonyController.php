<?php

namespace App\Http\Controllers;

use App\Http\Requests\PonyRequest;
use App\Models\Pony;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PonyController extends Controller
{
    public function index(): View
    {
        $ponies = Pony::all();
        return view ('pony.index', compact('ponies'));
    }

    public function store(PonyRequest $request): RedirectResponse
    {
        $data = $request->except('_token');
        Pony::create($data);
        return redirect()->route('pony.index');  
    }

    public function edit(Pony $pony): View
    {
        return view ('pony.edit', compact('pony'));   
    }

    public function create(): View
    {
        return view ('pony.create');
    }

    public function update(PonyRequest $request, Pony $pony): RedirectResponse
    {
        $data = $request->except('_token');
        $pony->update($data);
        return redirect()->route('pony.index');
    }

    public function destroy(Pony $pony): RedirectResponse
    {
        $pony->delete();
        return redirect()->route('pony.index');
    }
}
