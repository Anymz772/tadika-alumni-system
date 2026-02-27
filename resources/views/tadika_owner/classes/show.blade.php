<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Class Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $class->class_name }}</h3>
                            <p class="text-gray-500">{{ $class->academic_year }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('tadika.classes.edit', $class->class_id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Edit
                            </a>
                            <a href="{{ route('tadika.classes.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-2">Information</h4>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Level</dt>
                                    <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $class->level }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Teacher</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $class->teacher_name ?? 'Not Assigned' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Graduation Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $class->graduation_date ? \Carbon\Carbon::parse($class->graduation_date)->format('d M Y') : '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $class->is_active ? 'Active' : 'Archived' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-2">Description</h4>
                            <p class="text-sm text-gray-600">{{ $class->description ?? 'No description provided.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>