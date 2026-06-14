<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactPage;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'organization' => 'nullable|string|max:255',
            'stakeholder' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactSubmission::create($validated);

        $contactSettings = ContactPage::singleton();

        // You can now send an email to the admin address defined in the Contact Page settings.
        // Mail::to($contactSettings->email)->send(new \App\Mail\ContactSubmission($validated));

        return back()->with('success', 'Your message has been sent successfully to our team.');
    }

    public function submissions()
    {
        $submissions = ContactSubmission::latest()->paginate(20);
        return view('admin.content.viewcontact', compact('submissions'));
    }

    public function destroySubmission(ContactSubmission $submission)
    {
        $submission->delete();
        return back()->with('success', 'Submission deleted successfully.');
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
