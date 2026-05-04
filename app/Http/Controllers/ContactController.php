<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $contacts->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('contact', 'like', "%{$search}%");
            });
        }

        $contacts = $contacts->get();

        return view('contacts', compact('contacts'));
    }

    public function show(?int $id = null)
    {
        $contact = Contact::firstOrNew(['id' => $id]);
        return view('contact-form', compact('contact'));
    }

    public function save(SaveContactRequest $request)
    {
        $contact = Contact::updateOrCreate(
            ['id' => $request->input('id')],
            $request->validated()
        );

        return redirect()->route('contacts.index')->with('success', 'Contato salvo com sucesso!');
    }

    public function delete(?int $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contato deletado com sucesso!');
    }
}
