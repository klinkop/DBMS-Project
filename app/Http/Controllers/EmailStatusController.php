<?php

namespace App\Http\Controllers;

use App\Models\EmailStatus;
use Illuminate\Http\Request;

class EmailStatusController extends Controller
{
    public function index()
    {
        $statuses = EmailStatus::with('campaign')->get();
        return view('email_statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('email_statuses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'recipient_email' => 'required|email',
            'status' => 'required|string',
        ]);

        EmailStatus::create($request->only('campaign_id', 'recipient_email', 'status'));

        return redirect()->route('email_statuses.index')->with('success', 'Email status created successfully.');
    }

    public function show(EmailStatus $emailStatus)
    {
        return view('email_statuses.show', compact('emailStatus'));
    }

    public function edit(EmailStatus $emailStatus)
    {
        return view('email_statuses.edit', compact('emailStatus'));
    }

    public function update(Request $request, EmailStatus $emailStatus)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'recipient_email' => 'required|email',
            'status' => 'required|string',
        ]);

        $emailStatus->update($request->only('campaign_id', 'recipient_email', 'status'));

        return redirect()->route('email_statuses.index')->with('success', 'Email status updated successfully.');
    }

    public function destroy(EmailStatus $emailStatus)
    {
        $emailStatus->delete();
        return redirect()->route('email_statuses.index')->with('success', 'Email status deleted successfully.');
    }
}
