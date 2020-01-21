<?php

namespace App\Api\V1\Controllers;

use App\Models\Contact;
use App\User;
use App\Traits\Controllers;
use App\Traits\Validation;
use App\Repositories\ContactRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

class ContactApiController extends Controller
{
    use Helpers, Validation, Controllers;

    private $contact;
    private $request;

    private $perPage;

    public function __construct(ContactRepository $contact, Request $request)
    {
        $this->middleware('jwt.auth', ['only' => ['create', 'get', 'delete']]);

        $this->contact = $contact;
        $this->contact->request = $this->request = $request;
    }

    public function create()
    {
        $rules = [
            'contact_id' => "required",
        ];
        $request = $this->validateCredentials($this->request, $rules);
        $request["user_id"] = $this->user->id;

        $contact = $this->contact->create($request);
        if (is_null($contact)) {
            return $this->response->error("Contact is already existed", 400);
        }
        return ['contact' => $contact];
    }

    public function get()
    {
        $this->request->user_id = $this->user->id;
        $contacts = $this->contact->get($this->request);
        foreach ($contacts as $contact) {
            $contact->contact = User::where('id', $contact->contact_id)->first();
        }

        return ['contacts' => $contacts];
    }

    public function delete($id)
    {
        $status  = Contact::find($id)->forceDelete();
        return ['status' => $status];
    }
}
