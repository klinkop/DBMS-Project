<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h2 class="text-lg font-bold mb-4">Create New Group</h2>
        <form action="{{ route('groups.store') }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <textarea id="name" name="name"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <x-primary-button class="mt-4">{{ __('Add Group') }}</x-primary-button>
        </form>
    </div>
</x-app-layout>
