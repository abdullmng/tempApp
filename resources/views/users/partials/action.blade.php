@can(('can_edit_users'))
<a href="{{ route('user.show', $data->id) }}">
    <i class="fa fa-edit"></i>
</a>
@endcan
@can(('can_delete_users'))
<a href="{{ route('user.delete', $data->id) }}" class="text-danger" onclick="return confirm('are you sure you want to delete this user? it\'s best you deactivate user account')">
    <i class="fa fa-trash"></i>
</a>
@endcan