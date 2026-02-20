<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Lab Test</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.lab-tests.update', $labTest) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    @include('lab_orders.admin.lab_tests.partials.form', ['labTest' => $labTest])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
