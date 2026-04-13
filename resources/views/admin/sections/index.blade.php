@extends('admin.layouts.app')

@section('title', 'Sections')
@section('page-title', 'Sections')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Sections</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Manage Sections</h1>
            <a href="{{ route('admin.content.sections.create') }}"
                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">
                <i class="fas fa-plus mr-2"></i>Add New Section
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Banner
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($sections as $section)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $section->order }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $section->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $section->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $section->type === 'product_slider' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ $section->type === 'product_slider' ? 'Product Slider' : 'Banner Section' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($section->banner)
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="text-sm text-gray-900">{{ $section->banner->title ?? 'Banner #' . $section->banner->id }}</span>
                                        @if (count($section->banner->images) > 0)
                                            <img src="{{ Storage::url($section->banner->images[0]) }}"
                                                class="h-8 w-8 object-cover rounded">
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400">No banner</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $section->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $section->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.content.sections.edit', $section) }}"
                                    class="text-primary hover:text-primary/80 mr-3">Edit</a>
                                <form action="{{ route('admin.content.sections.destroy', $section) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No sections found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
