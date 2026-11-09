<x-layout title="Edit Hearing">
    <h1 class="text-2xl font-bold mb-1">Edit Hearing</h1>
    <p class="text-sm text-gray-500 mb-4">{{ $hearing->incident->blotter_no }}</p>

    <form action="{{ route('official.hearings.update', $hearing) }}" method="POST"
          class="bg-white border border-gray-200 rounded-lg p-6">
        @csrf
        @method('PUT')

        <x-hearing-fields :hearing="$hearing" />

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save Changes</button>
        <a href="{{ route('official.cases.show', $hearing->incident) }}" class="ml-3 text-sm text-gray-600 hover:underline">Cancel</a>
    </form>
</x-layout>
