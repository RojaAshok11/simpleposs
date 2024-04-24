@if ($type == 'normal')
    <th>{{ $name }}</th>
@elseif($type == 'sortby')
    <th wire:click="sortBy('{{ $sortname }}')">{{ $name }} <i
            class="bi bi-arrow-{{ $sortColumnName === $sortname && $this->sortDirection === 'asc' ? 'up' : 'down' }}-short"></i>
    </th>
@endif
