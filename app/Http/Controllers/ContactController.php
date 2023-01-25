<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\StoreContactRequest;
use App\Models\User;
use App\Models\Contact;
use App\Services\CurlNode;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        try {
            $contact1 = new Contact;
            $contact2 = new Contact;
            if(auth()->user()->address) {
                if(auth()->user()->address == $request->address) {
                    return response()->json([
                        'status' => view('ajax.error', ['error' => 'Can\'t add yourself as your contact :)'])->render(),
                        'error' => true
                    ]);
                };
                if(Contact::where(['user_id' => auth()->user()->id, 'address' => $request->address])->count() > 0) {
                    return response()->json([
                        'status' => view('ajax.error', ['error' => 'Can\'t add contact. ' . $request->address . ' is already in your contact list.'])->render(),
                        'error' => true
                    ]);
                };
                $response = Curlnode::post('/addcontact', [
                    'user' => auth()->user()->address,
                    'address' => $request->address,
                ]);
                if(!session('connect_error')) {
                    $user = User::firstWhere('address', $request->address);
                    $contact1->address = $request->address;
                    $contact2->address = auth()->user()->address;
                    $contact1->email = $user->email;
                    $contact2->email = auth()->user()->email;
                    $contact1->name = $user->name;
                    $contact2->name = auth()->user()->name;
                    $contact1->user_id = auth()->user()->id;
                    $contact2->user_id = $user->id;
                    $contact1->save();
                    $contact2->save();
                    return response()->json([
                        'view' => view('ajax.contact.store', ['contact' => $contact1])->render(),
                        'status' => view('ajax.success', ['success' => 'New Contact (' . $contact1->name . ') has been added successfully.'])->render(),
                        'success' => true
                    ]);
                } else {
                    throw new Exception("Error: " . session('connect_error_message'));
                }
            } else {
                throw new Exception("Error: You have no blockchain account. Contact admin.");
            }
        }
        catch(Exception $e) {
            return response()->json([
                'status' => view('ajax.error', ['error' => $e->getMessage()])->render(),
                'error' => false
            ]);
        }
    }
    
    /**
     * Controller method for route to redirect to on failed validation
     *
     * @return \Illuminate\Http\Response
     */
    public function error()
    {
        return response()->json([
            'status' => view('ajax.validation-error')->render()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreContactRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreContactRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
