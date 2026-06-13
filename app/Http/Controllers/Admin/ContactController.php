<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactPage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contact = ContactPage::singleton();

        return view('pages.contact', compact('contact'));
    }

    public function edit()
    {
        $contact = ContactPage::singleton();

        return view('admin.content.contact', compact('contact'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_label' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string'],
            'form_title' => ['nullable', 'string', 'max:255'],
            'submit_button_text' => ['nullable', 'string', 'max:255'],
            'stakeholder_title' => ['nullable', 'string', 'max:255'],
            'stakeholders' => ['nullable', 'string'],
            'connect_title' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['stakeholders'] = collect(preg_split('/\r\n|\r|\n/', $validated['stakeholders'] ?? ''))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();

        ContactPage::singleton()->update($validated);

        return redirect()
            ->route('admin.content.contact')
            ->with('success', 'Contact page updated successfully.');
    }

    public function restore()
    {
        ContactPage::singleton()->update(ContactPage::defaults());

        return redirect()
            ->route('admin.content.contact')
            ->with('success', 'Contact page restored successfully.');
    }
}
