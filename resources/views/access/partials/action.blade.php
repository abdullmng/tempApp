@can(('can_edit_roles'))
<a href="{{ route('access.show_role', $row->id) }}">
    <i class="fa fa-edit"></i>
</a>
@endcan
@can(('can_delete_roles'))
<a href="{{ route('access.delete_role', $row->id) }}" class="text-danger" onclick="return confirm('are you sure you want to delete this item?')">
    <i class="fa fa-trash"></i>
</a>
@endcan