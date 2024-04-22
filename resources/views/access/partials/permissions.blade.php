@foreach ($row->permissions as $permission)
    <span class="badge bg-primary">
        {{ str_replace('_', ' ',$permission->name) }}
    </span>
@endforeach