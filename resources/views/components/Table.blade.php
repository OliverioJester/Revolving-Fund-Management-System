@props(['columns' => [], 'rows' => []])

<div class="overflow-x-auto bg-white rounded-lg shadow p-2">
    <table class="min-w-full divide-y divide-gray-200 text-sm text-left text-gray-700 ">
        {{-- Table Head --}}
        <thead class="bg-gray-100 text-gray-700  uppercase">
            <tr>
                @foreach($columns as $col)
                    <th class="px-6 py-3 border">
                        {{ $col }}
                    </th>
                @endforeach
            </tr>
        </thead>

        {{-- Table Body --}}
        <tbody class="divide-y divide-gray-100">
            @forelse($rows as $row)
                <tr class="hover:bg-gray-50">
                    @foreach($columns as $key => $label)
                        <td class="px-6 py-4">
                            {{ is_array($row) ? ($row[$key] ?? '') : ($row->$key ?? '') }}
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) }}" class="px-6 py-4 text-center text-gray-500">
                        No data available
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
