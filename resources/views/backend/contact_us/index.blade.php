@extends('layouts.admin')

@section('content')
@push('css')
<link href="{{ asset('backend') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Contact Us</h6>
            <div class="ml-auto">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered"  width="100%" cellspacing="0" id="table">
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>title</th>
                            <th>Status</th>
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
              order:[3,'desc'],
              processing: true,
              serverSide: true,
            ajax: '{!! route('admin.contact_us.datatable') !!}',
              columns: [
                  { data: 'name',name: 'name'} ,
                  { data: 'title'  ,name: 'title'} ,
                  { data: 'status',name: 'status'} ,
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