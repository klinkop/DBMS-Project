<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Receipient;
use App\Models\SubFolder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
{
    $query = $request->input('squery');

    if ($query) {
        $campaigns = Campaign::with(['user', 'receipients']) // Eager load recipients
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('status', 'like', '%' . $query . '%');
            })
            ->latest()
            ->get();
    } else {
        $campaigns = Campaign::with(['user', 'receipients']) // Eager load recipients
            ->latest()
            ->get();
    }

    return view('campaigns.index', [
        'campaigns' => $campaigns,
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject',
            'design',
        ]);

        $validated['status'] = 'Draft';

        $request->user()->campaigns()->create($validated);

        return redirect(route('campaigns.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        $receipients = $campaign->receipients;
        $contactLists = collect();

        foreach ($receipients as $receipient) {
            $subFolder = $receipient->subFolder;
            if ($subFolder) {
                $contactLists = $contactLists->merge($subFolder->contactLists);
            }
        }

        // Remove duplicates from the contact lists
        $uniqueContactLists = $contactLists
            ->filter(function($contactLists) {
                return !is_null($contactLists->email);
            })
        ->unique('email');

        return view('campaigns.show', [
            'campaign' => $campaign,
            'receipients' => $receipients,
            'contactLists' => $uniqueContactLists,
        ]);
    }

    /**
     * Add  a new recipient to the campaign.
     */
    // public function addReceipient(Campaign $campaign): View
    // {
    //     // $subFolders = SubFolder::all();

    //     return view('campaigns.addReceipient', [
    //         'campaign' => $campaign,
    //         // 'subFolders' => $subFolders,
    //     ]);
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign): View
    {
        Gate::authorize('update', $campaign);

        return view('campaigns.edit', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign): RedirectResponse
    {
        Gate::authorize('update', $campaign);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject',
            'design',
            'status',
            // 'subject' => 'required|string|max:255',
            // 'design' => 'required|string',
            // 'status' => 'required|string|max:255',
        ]);

        $campaign->update($validated);

        return redirect(route('campaigns.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign): RedirectResponse
    {
        Gate::authorize('delete', $campaign);

        $campaign->delete();

        return redirect(route('campaigns.index'));
    }

    public function addReceipient(Campaign $campaign): View
    {
        $subFolders = SubFolder::all();

        $receipients = Receipient::with('subFolder')->where('campaign_id', $campaign->id)->get();

        return view('campaigns.addReceipient', [
            'campaign' => $campaign,
            'subFolders' => $subFolders,
            'receipients' => $receipients,
        ]);
    }

    public function storeReceipient(Request $request, Campaign $campaign):RedirectResponse
    {
        $validated = $request->validate([
            'sub_folder_id' => 'required|integer|exists:sub_folders,id',
        ]);

        // Check if the receipient already exists with the same campaign and subfolder
        $existingReceipient = Receipient::where('campaign_id', $campaign->id)
            ->where('sub_folder_id', $validated['sub_folder_id'])
            ->first();

        if (!$existingReceipient) {
            $receipient = new Receipient();
        $receipient->campaign()->associate($campaign);
        $receipient->subFolder()->associate(SubFolder::find($validated['sub_folder_id']));
        $receipient->save();

        return redirect()->back()->with('alert', 'Receipients Added Succesfully!');
        } else {
            return redirect()->back()->with('alert', 'The subfolder already exists for this receipient.');
        }
    }

    public function deleteReceipient($campaignId, $receipientId)
{
    // Find the recipient by ID and delete it
    $receipient = Receipient::findOrFail($receipientId);
    $receipient->delete();

    // Redirect back with a success message
    return redirect()->back()->with('alert', 'Recipient deleted successfully.');
}
}
