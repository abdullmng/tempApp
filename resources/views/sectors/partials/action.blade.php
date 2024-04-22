@can(('can_edit_sectors'))
<a href="{{ route('sector.show', $data->id) }}">
    <i class="fa fa-edit"></i>
</a>
@endcan
@can(('can_delete_sectors'))
<a href="{{ route('sector.delete', $data->id) }}" class="text-danger" onclick="return confirm('are you sure you want to delete this item?')">
    <i class="fa fa-trash"></i>
</a>
@endcan