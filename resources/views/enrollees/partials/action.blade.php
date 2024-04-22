@can(('can_edit_enrollees'))
<a href="{{ route('user.enrollee', $data->id) }}">
    <i class="fa fa-edit"></i>
</a>
@endcan
@can(('can_delete_enrollees'))
<a href="#" class="text-danger">
    <i class="fa fa-trash"></i>
</a>
@endcan