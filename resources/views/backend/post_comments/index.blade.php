@extends('layouts.admin')

@section('content')
@push('css')
<link href="{{ asset('backend') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Comments</h6>
            <div class="ml-auto">
                {{-- <a href="{{ route('admin.post_comments.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Add new Comment</span>
                </a> --}}
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered"  width="100%" cellspacing="0" id="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Auther</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Post</th>
                            <th>Created at</th>
                            <th class="text-center" style="width:30px">Actions</th>
                        </tr>
                    </thead>
                   
                </table>
            </div>
        </div>
    </div>

</div>
@push('js')
        <!-- Page level plugins -->
        <script src="{{ asset('backend') }}/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ asset('backend') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    
        <!-- Page level custom scripts -->
        <script src="{{ asset('backend') }}/js/demo/datatables-demo.js"></script>
        <script>
       table =  $('#table').DataTable({
              order:[5,'desc'],
              processing: true,
              serverSide: true,
              ajax: '{!! route('admin.post_comments.datatable') !!}',
              columns: [
                  { data: 'image'  ,name: 'image'} ,
                  { data: 'name' ,name: 'name'} ,
                  { data: 'comment',name: 'comment'} ,
                  { data: 'status',name: 'status'} ,
                  { data: 'post',name: 'post'} ,
                  { data: 'created_at',name: 'created_at'} ,
                  { data: 'actions',  orderable: false, searchable: false},
                 

              ],
              search: {
                    "regex": true
                },
          });
        </script>
@endpush

@endsection