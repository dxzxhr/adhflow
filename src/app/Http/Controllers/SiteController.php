<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function index(): View
    {
        $sites = Site::where('user_id', auth()->id())
                     ->latest()->paginate(10);

        return view('sites.index', compact('sites'));
    }

    public function create(): View
    {
        return view('sites.create');
    }

    public function store(StoreSiteRequest $request): RedirectResponse
    {
        auth()->user()->sites()->create($request->validated());

        return redirect()->route('sites.index')
                         ->with('status', 'Site submitted for review');
    }

    public function edit(Site $site): View
    {
        $this->authorize('update', $site);   // optional policy
        return view('sites.edit', compact('site'));
    }

    public function update(UpdateSiteRequest $request, Site $site): RedirectResponse
    {
        $this->authorize('update', $site);
        $site->update($request->validated());

        return back()->with('status', 'Updated');
    }

    public function destroy(Site $site): RedirectResponse
    {
        $this->authorize('delete', $site);
        $site->delete();

        return redirect()->route('sites.index')
                         ->with('status', 'Deleted');
    }

    /* ---------- модерация (доступ только админу) ---------- */
    public function approve(Site $site): RedirectResponse
    {
        $site->update(['status' => 'active']);
        // TODO: отправить уведомление вебмастеру
        return back();
    }

    public function reject(Site $site): RedirectResponse
    {
        $site->update(['status' => 'rejected']);
        return back();
    }
}
