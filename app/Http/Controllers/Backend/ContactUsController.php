<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\auth()->user()->ability('admin', 'manage_contact_us,show_contact_us')) {
            return redirect('admin/index');
        }
        return view('backend.contact_us.index');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact_u)
    {
        if (!\auth()->user()->ability('admin', 'display_contact_us')) {
            return redirect('admin/index');
        }
        $contact_u->status = 1;
        $contact_u->save();
        return view('backend.contact_us.show', compact('contact_u'));
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact_u)
    {
        if (!auth()->user()->ability('admin','delete_contact_us')) {
            return abort(403);
        }
        $contact_u->delete();

        return redirect()->route('admin.contact_us.index')->with([
            'message' => 'Post deleted successfully',
            'alert-type' => 'success',
        ]);
    }
    public function datatable()
    {
        if (!auth()->user()->ability('admin','manage_contact_us,show_contact_us')) {
            return abort(403);
        }
        $contact_us = Contact::query();
        return DataTables::of($contact_us)
            ->editColumn('title', function ($contact) {
                return "<a href='".route("admin.contact_us.show",$contact->id)."'>$contact->title</a>";
            })
            ->editColumn('status', function ($contact) {
                return $contact->status();
            })
            ->editColumn('created_at', function ($contact) {
                return $contact->created_at->format('d-m-Y h:i a');
            })
            ->editColumn('actions', function ($contact) {
                $contact->route = 'contact_us';
                $contact->edit = 'disabled';
                return view('backend.datatables.actions')->with(['model' => $contact]);
            })->startsWithSearch()
            ->rawColumns(['title'])
            ->toJson();
    }
}
