<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Course Templates') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y ...">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 ...">Course Title</th>
                                    <th class="px-6 py-3 ...">Category</th>
                                    <th class="px-6 py-3 text-right ...">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($programs as $program)
                                    <tr>
                                        <td class="px-6 py-4 font-medium">{{ $program->title }}</td>
                                        <td class="px-6 py-4 text-sm">{{ $program->category->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            <a href="{{ route('admin.programs.edit', $program) }}" class="text-indigo-600 hover:underline">Edit</a>
                                            <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" class="inline-block ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No course templates found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>