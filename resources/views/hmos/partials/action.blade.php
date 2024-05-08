@can(('can_edit_hcps'))
<a href="{{ route('hmo.show', $data->id) }}">
    <i class="fa fa-edit"></i>
</a>
@endcan
@can(('can_delete_hcps'))
<a href="{{ route('hmo.delete', $data->id) }}" class="text-danger" onclick="return confirm('are you sure you want to delete this item, this action will delete organisations under this HMO proceed with caution?')">
    <i class="fa fa-trash"></i>
</a>
@endcan