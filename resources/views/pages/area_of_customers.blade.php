@extends('main')

@section('title', 'Area of Customers')

@section('content')
    <h1 class="mb-8">Area of Customers</h1>
    
    <x-modal title="Add area of customer">
        <x-slot name="trigger">
            <x-Button>Add</x-Button>
        </x-slot>

        <x-slot name="content">
            <form action="{{route('area-of-customers.store')}}" method="POST">
                @csrf
                <div class="space-y-2">
                    <x-input label="Area Name" name="area" type="text" class="bg-gray-50 mb-8" required/>
                </div>
                <div class="flex justify-end mt-4 gap-3">
                    <x-Button type="submit">Save</x-Button>
                    <x-Button @click="open = false" variant="danger">Close</x-Button>
                </div> 
                
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-2 rounded mt-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif          
            </form>
        </x-slot>
    </x-modal>
    <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-100 uppercase text-gray-700">
            <tr>
                <th class="px-6 py-3 border">Area No.</th>
                <th class="px-6 py-3 border">Area Name</th>
                <th class="px-6 py-3 border">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($areacustomers as $areacustomer)
                <tr>
                    <td class="px-6 py-4 border">{{ $areacustomer->id }}</td>
                    <td class="px-6 py-4 border">{{ $areacustomer->area }}</td>
                    <td class="px-6 py-4 border">
                        <span class="flex gap-2">
                        <x-modal title="Edit Area">
                            <x-slot name="trigger">
                                <x-Button variant="secondary">Edit</x-Button>
                            </x-slot>

                            <x-slot name="content">
                                <form action="{{  route('area-of-customers.update', $areacustomer->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="space-y-2">
                                        <label for="area">Area Name</label>
                                        <input 
                                            type="text" 
                                            id="area" 
                                            name="area" 
                                            value="{{ old('area', $areacustomer->area) }}" 
                                            class="border rounded p-2 w-full"
                                        >
                                        @if ($errors->any())
                                            <div class="bg-red-100 text-red-700 p-2 rounded mt-4">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div> 
                                    <div class="flex justify-end mt-4 gap-3">
                                        <x-Button @click="window.location.reload()"  variant="secondary">Reset</x-Button>
                                        <x-Button type="submit" variant="primary">Update</x-Button>
                                        <x-Button @click="open = false" variant="danger">Close</x-Button>
                                    </div>                          
                                </form>
                            </x-slot>
                        </x-modal>
                        <form action="{{ route('area-of-customers.destroy', $areacustomer->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
    </div>
@endsection 