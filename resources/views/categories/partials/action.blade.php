@can(('can_edit_categories'))
<a href="{{ route('category.show', $data->id) }}">
    <i class="fa fa-edit"></i>
</a>
@endcan
@can(('can_delete_categories'))
<a href="{{ route('category.delete', $data->id) }}" class="text-danger" onclick="return confirm('are you sure you want to delete this item?')">
    <i class="fa fa-trash"></i>
</a>
@endcan