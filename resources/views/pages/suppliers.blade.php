@extends('main')

@section('title', 'Suppliers')

@section('content')
        <h1>Suppliers</h1>
        <br>
        <x-modal title="Add Item">
            <x-slot name="trigger">
                <x-Button>Add</x-Button>
            </x-slot>
            <x-slot name="content">
                <form action="{{route('suppliers.store')}}" method="POST">
                    @csrf
                    <div class="space-y-2">
                        <label for="name">Supplier Name</label>
                        <input type="text" name="name" id="name" class="border rounded p-2 w-full" autocomplete="off">
                    </div>
                    <div class="flex justify-end mt-4 gap-3">
                        <x-Button type="Submit">Save</x-Button>
                        <x-Button @click="open = false" variant="danger">close</x-Button>
                    </div>
                </form>
            </x-slot>
        </x-modal>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 uppercase text-gray-700">
                <tr>
                    <th class="px-6 py-3 border">Supplier No.</th>
                    <th class="px-6 py-3 border">Supplier Name</th>
                    <th class="px-6 py-3 border">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($suppliers as $supplier)
                    <tr>
                        <td class="px-6 py-4 border">{{$supplier->id}}</td>
                        <td class="px-6 py-4 border">{{$supplier->name}}</td>
                        <td class="px-6 py-4 border">
                            <span class="flex gap-2 ">
                            <x-modal title="Edit Item">
                                <x-slot name="trigger">
                                    <x-Button variant="secondary">Edit</x-Button>
                                </x-slot>

                                <x-slot name="content">
                                    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="space-y-2">
                                            <label for="name">Supplier Name</label>
                                            <input 
                                                type="text"
                                                name="name"
                                                value="{{ old('name', $supplier->name) }}"
                                                class="border rounded p-2 w-full"
                                                autocomplete="off"
                                            >
                                            @error('name')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="flex justify-end mt-4 gap-3">
                                            <x-Button @click="window.location.reload()" variant="secondary">Reset</x-Button>
                                            <x-Button type="submit" variant="primary">Update</x-Button>
                                            <x-Button @click="open=false" variant="danger">Close</x-Button>
                                        </div>
                                    </form>
                                </x-slot>
                            </x-modal>
                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <x-Button type="submit" variant="danger">Delete</x-Button>
                            </form>
                            </span>
                        </td>
                    </tr>                    
                @endforeach
            </tbody>
        </table>
@endsection     