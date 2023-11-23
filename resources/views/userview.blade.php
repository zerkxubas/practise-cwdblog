<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Uploaded Files') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 mb-10">
                    <p class="text-gray-900 mb-5">My Images</p>
                    <div class="flex justify-between flex-wrap gap-2">
                    @if ($images->count() != 0)
                        @foreach ($images as $myimg)
                            <img loading="lazy" src="{{ $myimg->getSignedUrl(now()->addMinutes(5)) }}" alt="" height="400"
                                width="400" class="border-blue-300 border-2 rounded">
                        @endforeach
                    @else
                        <p class="text-red-700">No Images available.</p>
                    @endif
                </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
