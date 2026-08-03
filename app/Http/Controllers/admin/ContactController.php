<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\HomeSettings;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $settings = HomeSettings::firstOrCreate([]);
        $messages = ContactMessage::orderByDesc('created_at')->paginate(15);
        $unreadCount = ContactMessage::where('is_read', false)->count();

        return view('content.dashboard.admin.contact.index', compact('settings', 'messages', 'unreadCount'));
    }

    public function updateSettings(Request $request)
    {
        $settings = HomeSettings::firstOrCreate([]);

        $settings->update($request->validate([
            'contact_phone' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_address' => 'nullable|string|max:255',
            'contact_hours' => 'nullable|string|max:255',
            'contact_website' => 'nullable|string|max:255',
        ]));

        return back()->with('success', 'Contact information updated.');
    }

    public function show(ContactMessage $contact)
    {
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('content.dashboard.admin.contact.show', [
            'message' => $contact,
        ]);
    }

    public function destroy(ContactMessage $contact)
    {
        $contact->delete();

        return redirect()
            ->route('admin.contact.index')
            ->with('success', 'Message deleted.');
    }

    public function markRead(ContactMessage $contact)
    {
        $contact->update(['is_read' => true]);

        return back()->with('success', 'Marked as read.');
    }
}
