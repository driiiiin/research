<tbody id="researchTableBody" class="bg-white divide-y divide-gray-200">
    @foreach($healthResearches as $healthResearch)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-4 whitespace-normal text-sm text-gray-900 break-words">
                {{ $healthResearch->accession_no }}
            </td>
            <td class="px-4 py-4 whitespace-normal text-sm text-gray-900 break-words">
                {{ $healthResearch->research_title }}
            </td>
            <td class="px-4 py-4 whitespace-normal text-sm text-gray-900 break-words">
                @if($healthResearch->relationLoaded('authors') || method_exists($healthResearch, 'authors'))
                    {{ $healthResearch->authors->map(fn($a) => $a->full_name)->implode(', ') }}
                @else
                    N/A
                @endif
            </td>
            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ $healthResearch->date_issued_from_year ?? 'N/A' }}
            </td>
            <td class="px-4 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $healthResearch->status === 'Available' ? 'bg-green-100 text-green-800' :
                       ($healthResearch->status === 'Maintenance' ? 'bg-yellow-100 text-yellow-800' :
                       ($healthResearch->status === 'Lost' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                    {{ $healthResearch->status }}
                </span>
            </td>
            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex space-x-2">
                    <a href="{{ route('research.health_researches.show', $healthResearch) }}"
                       class="text-blue-600 hover:text-blue-900">View</a>
                    <a href="{{ route('research.health_researches.edit', $healthResearch) }}"
                       class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    <form method="POST" action="{{ route('research.health_researches.destroy', $healthResearch) }}"
                          class="inline" onsubmit="return confirm('Are you sure you want to delete this health research?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
</tbody>
