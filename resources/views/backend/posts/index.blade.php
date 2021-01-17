@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Posts</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Add new post</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered"  width="100%" cellspacing="0" id="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Title</th>
                            <th>Comments</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th>User</th>
                            <th>Created at</th>
                            <th class="text-center" style="width:30px">Actions</th>
                        </tr>
                    </thead>
                   {{-- <tfoot>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                   </tfoot> --}}
                </table>
            </div>
        </div>
    </div>

</div>
@push('css')
<link href="{{ asset('backend') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
@endpush

@push('js')
        <!-- Page level plugins -->
        <script src="{{ asset('backend') }}/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ asset('backend') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
        <!-- Page level custom scripts -->
        <script src="{{ asset('backend') }}/js/demo/datatables-demo.js"></script>
        <script>
       table =  $('#table').DataTable({
              order:[6,'desc'],
              processing: true,
              serverSide: true,
            
              ajax: '{!! route('admin.posts.datatable') !!}',
              columns: [
                  {data: null},
                  { data: 'title'  ,name: 'title'} ,
                  { data: 'comments' ,name: 'comment_able'} ,
                  { data: 'status',name: 'status'} ,
                  { data: 'category.name',name: 'category.name'} ,
                  { data: 'user.name',name: 'user.name'} ,
                  { data: 'created_at',name: 'created_at'} ,
                  { data: 'actions',  orderable: false, searchable: false},
                 

              ],

              columnDefs: [ {
                    targets: 0,
                    defaultContent: '',
                    orderable: false,
                    className: 'select-checkbox'
                } ],
              select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
        //       initComplete: function () {
        //     // Apply the search
        //     this.api().columns().every( function () {
        //         var that = this;
 
        //         $( 'input', this.footer() ).on( 'keyup change clear', function () {
        //             if ( that.search() !== this.value ) {
        //                 that
        //                     .search( this.value )
        //                     .draw();
        //             }
        //         } );
        //     } );
        // },

          });

          table.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                var data = table.rows( indexes ).data().pluck( 'id' );
                console.log(data[0]);
                // do something with the ID of the selected items
            }
        } );
        //   $('#table tfoot th').each( function () {
        //         var title = $(this).text();
        //         $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        //     } );
        </script>
@endpush

@endsection