<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Test Upload') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="py-12">
            <div class="mx-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm">
                    <div class="p-6 text-green-700">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="py-12">
            <div class="mx-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm">
                    <div class="p-6 text-red-700">
                        {{ session('error') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @error('picture')
                        <p class="text-red-600">{{ $message }}</p>
                    @enderror
                    <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="picture">Upload Your Picture</label>
                        <input type="file" name="picture" id="picture">
                        <x-primary-button class="px-5 my-2" type="submit">Save On Cloud</x-primary-button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
