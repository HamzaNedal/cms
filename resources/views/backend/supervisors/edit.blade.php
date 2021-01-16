@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-blod text-primary">Edit supervisor</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.supervisors.index') }}" class="btn btn-primary">
                     <span class="icon text-white-50">
                         <i class="fa fa-home"></i>
                     </span>
                     <span class="text">Supervisors</span>
                </a>
             </div>
        </div>
        <div class="card-body">
            
            @include('backend.supervisors.fields',['route' => route('admin.supervisors.update',$user->id),'method'=>"put"])
        </div>
    </div>
</div>
@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" />
@endpush
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $('.summernote').summernote({
        tabsize: 2,
        height: 300,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    });

    $("#user_image").fileinput(
        {
            theme: "fa",
            maxFileCount: 1,
            allowedFileTypes: ['image'],
            showCancel: true,
            showRemove: true,
            showUpload: false,
            overwriteInitial: false,

            initialPreview:[
                @if($user->user_image)
                    "{{ asset('assets/users/'.$user->user_image) }}",
                @endif
            ],
            initialPreviewAsData:true,
            initialPreviewFileType:'image',
            initialPreviewConfig:[
                @if($user->user_image)
                        {caption:"{{ $user->user_image }}",width:"120px",url:"{{ route('admin.user.media.destroy',[$user->id,'_token'=>csrf_token()]) }}",key:"{{ $user->id }}"},
                @endif
                
            
            ],
        }
    );
    $('#permissions').select2({
        minimumResultsForSearch:Infinity,
        tags:true,
        closeOnSelect:false
    });
</script>
@endpush
@endsection