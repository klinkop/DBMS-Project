<?php

// app/Http/Controllers/EmailTemplateController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailTemplate;

class EmailTemplateController extends Controller
{
    public function index() {
        $templates = EmailTemplate::all();
        return view('email_templates.index', compact('templates'));
    }

    public function create() {
        return view('email_templates.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string'
        ]);

        EmailTemplate::create([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return redirect()->route('email_templates.index')->with('success', 'Template created successfully');
    }
}
