<a href="{{ route("admin.$model->route.edit", $model->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
<a href="#" onclick="if(confirm('Are you sure ? ')){document.getElementById('{{ $model->route }}-delete-{{ $model->id }}').submit(); }else {return false;}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
<form action="{{ route("admin.$model->route.destroy",$model->id) }}" method="post" class="d-none" id="{{ $model->route }}-delete-{{ $model->id }}">
    @csrf
    @method('delete')
</form>