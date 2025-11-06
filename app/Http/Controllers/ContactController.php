<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{

    public function index()
    {
        $contacts = Contact::query()
            ->where('user_id', auth()->id())
            ->when(request('q'), fn($q) =>
                $q->where(function($qq){
                    $qq->where('name','like','%'.request('q').'%')
                       ->orWhere('email','like','%'.request('q').'%')
                       ->orWhere('phone','like','%'.request('q').'%');
                })
            )
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Contacts/Index', [
            'contacts' => $contacts,
            'filters'  => ['q' => request('q')],
        ]);
    }

    public function create()
    {
        return Inertia::render('Contacts/Create');
    }

    public function store(StoreContactRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('contacts', 'public');
        }

        Contact::create($data);
        return to_route('contacts.index')->with('success','Contato criado!');
    }

    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);

        return Inertia::render('Contacts/Show', [
            'contact' => [
                'id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'image_url' => $contact->image_path ? Storage::url($contact->image_path) : null,
                'created_at' => $contact->created_at->toDateTimeString(),
            ],
        ]);
    }

    public function edit(Contact $contact)
    {
        $this->authorize('update', $contact);

        return Inertia::render('Contacts/Edit', [
            'contact' => [
                'id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'image_url' => $contact->image_path ? Storage::url($contact->image_path) : null,
            ],
        ]);
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $this->authorize('update', $contact);

        $data = $request->validated();

        // atualizar imagem
        if ($request->boolean('_remove_image') && $contact->image_path) {
            Storage::disk('public')->delete($contact->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            if ($contact->image_path) {
                Storage::disk('public')->delete($contact->image_path);
            }
            $data['image_path'] = $request->file('image')->store('contacts', 'public');
        }

        $contact->update($data);
        return to_route('contacts.index')->with('success','Contato atualizado!');
    }

    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        if ($contact->image_path) {
            Storage::disk('public')->delete($contact->image_path);
        }
        $contact->delete();

        return back()->with('success','Contato removido!');
    }
}
