<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Billing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ @$book ? route("book.save", [$book->_id]) : route("book.save") }}" method="post">
                        @csrf
                        <div>
                            <x-label for="bookNumber" :value="__('Book Number')" />
                            <x-input id="bookNumber" class="block mt-1 w-full" type="text" name="number" :value="old('number', @$book->number)" required autofocus />
                        </div>

                        <div>
                            <x-label for="name" :value="__('Name')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', @$book->name)" required/>
                        </div>

                        <div>
                            <x-label for="release" :value="__('Release Date')" />
                            <x-input id="release" class="block mt-1 w-full" type="date" name="release" :value="old('release', @$book->release)" />
                        </div>

                        <x-button class="mt-5">
                            {{ __('Save') }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
