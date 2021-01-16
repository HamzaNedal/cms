<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateSupervisorRequest;
use App\Http\Requests\Backend\UpdateSupervisorRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
class SupervisorsController extends Controller
{


    public function index()
    {
        if (!\auth()->user()->ability('admin', 'manage_supervisors,show_supervisors')) {
            return redirect('admin/index');
        }

        // $keyword = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        // $status = (isset(\request()->status) && \request()->status != '') ? \request()->status : null;
        // $sort_by = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        // $order_by = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'desc';
        // $limit_by = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        // $users = User::whereHas('roles', function ($query) {
        //     $query->where('name', 'user');
        // });
        // if ($keyword != null) {
        //     $users = $users->search($keyword);
        // }
        // if ($status != null) {
        //     $users = $users->whereStatus($status);
        // }

        // $users = $users->orderBy($sort_by, $order_by);
        // $users = $users->paginate($limit_by);

        return view('backend.supervisors.index');
    }

    public function create()
    {
        if (!\auth()->user()->ability('admin', 'create_supervisors')) {
            return redirect('admin/index');
        }
        $permissions = Permission::pluck('display_name','id');
        return view('backend.supervisors.create',compact('permissions'));
    }

    public function store(CreateSupervisorRequest $request)
    {
        $data = $request->all();
        if ($user_image = $request->file('user_image')) {
            $filename = Str::slug($request->username).'.'.$user_image->getClientOriginalExtension();
            $path = public_path('assets/users/' . $filename);
            Image::make($user_image->getRealPath())->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            $data['user_image']  = $filename;
        }
        unset($data['permissions']);
   
        $user = User::create($data);
        $user->attachRole(Role::whereName('editor')->first()->id);
        if(isset($request->permissions) && 1>0){
            $user->permissions()->sync($request->permissions);
        }
        return redirect()->route('admin.supervisors.index')->with([
            'message' => 'Users created successfully',
            'alert-type' => 'success',
        ]);
    }

    public function show(User $user)
    {
        if (!\auth()->user()->ability('admin', 'display_supervisors')) {
            return redirect('admin/index');
        }

        // $user = User::whereId($id)->first();
        return view('backend.supervisors.show', compact('user'));

    }

    public function edit(User $supervisor)
    {
        
        if (!\auth()->user()->ability('admin', 'update_supervisors')) {
            return redirect('admin/index');
        }
        $permissions = Permission::pluck('display_name','id');
        $user = $supervisor;
        $user_permissions = UserPermissions::whereUserId($user->id)->pluck('permission_id')->toArray();
        // $user = User::whereId($id)->first();
        return view('backend.supervisors.edit', compact('user','permissions','user_permissions'));
    }

    public function update(UpdateSupervisorRequest $request, User $supervisor)
    {

        $data = $request->all();
        $user = $supervisor;
            if ($user_image = $request->file('user_image')) {
                if ($user->user_image != '') {
                    if (File::exists('assets/users/' . $user->user_image)) {
                        unlink('assets/users/' . $user->user_image);
                    }
                }
                $filename = Str::slug($request->username).'.'.$user_image->getClientOriginalExtension();
                $path = public_path('assets/users/' . $filename);
                Image::make($user_image->getRealPath())->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['user_image']  = $filename;
            }
            unset($data['permissions']);
            $user->update($data);
            if(isset($request->permissions) && 1 >0){
                $user->permissions()->sync($request->permissions);
            }
            return redirect()->route('admin.supervisors.index')->with([
                'message' => 'User updated successfully',
                'alert-type' => 'success',
            ]);

   
       
    }

    public function destroy(User $supervisor)
    {
        if (!\auth()->user()->ability('admin', 'delete_supervisors')) {
            return redirect('admin/index');
        }

            if ($supervisor->user_image != '') {
                if (File::exists('assets/users/' . $supervisor->user_image)) {
                    unlink('assets/users/' . $supervisor->user_image);
                }
            }
            $supervisor->delete();

            return redirect()->route('admin.supervisors.index')->with([
                'message' => 'Supervisor deleted successfully',
                'alert-type' => 'success',
            ]);
    }

    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('admin', 'delete_supervisors')) {
            return redirect('admin/index');
        }

        $user = User::whereId($request->key)->first();
        if ($user) {
            if (File::exists('assets/users/' . $user->user_image)) {
                unlink('assets/users/' . $user->user_image);
            }
            $user->user_image = null;
            $user->save();
            return 'true';
        }
        return 'false';
    }

    public function datatable()
    {
        if (!auth()->user()->ability('admin','manage_supervisors,show_supervisors')) {
            return abort(403);
        }
        // $users = User::query();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'editor');
        })->get();
        
        return DataTables::of($users)
        ->editColumn('name', function ($user) {
            return "<a href='".route("admin.supervisors.show",$user->id)."'>$user->name</a>";
        })
            ->editColumn('image', function ($user) {
                if($user->user_image){
                    return " <img src=".asset('assets/users/'.$user->user_image)." width='50px'>";
                }else{
                    return " <img src=".asset('assets/users/avatar.png')." width='50px'>";
                }
            })->editColumn('status', function ($user) {
                return $user->status();
            })
            ->editColumn('actions', function ($post) {
                $post->route = 'supervisors';
                return view('backend.datatables.actions')->with(['model' => $post]);
            })->editColumn('created_at', function ($post) {
                return $post->created_at->format('d-m-Y h:i a');
            })
            ->rawColumns(['image','name'])
            ->toJson();
    }
}
