@can(('can_edit_hcps'))
<a href="{{ route('hcp.show', $data->id) }}">
    <i class="fa fa-edit"></i>
</a>
@endcan
@can(('can_delete_hcps'))
<a href="{{ route('hcp.delete', $data->id) }}" class="text-danger" onclick="return confirm('are you sure you want to delete this item?')">
    <i class="fa fa-trash"></i>
</a>
@endcan