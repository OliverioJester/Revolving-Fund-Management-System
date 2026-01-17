@extends('main')

@section('title', 'Employees ')

@section('content')
<div>

    <h1 class="mb-8 title">Employees</h1>
    <x-modal title="Add employee">
        <x-slot name="trigger">
            <x-Button>Add</x-Button>
        </x-slot>
        <x-slot name="content">
            <form action="{{route('employees.store')}}" method="POST">
                @csrf
                <div class="space-y-2">
                    <label for="name">Employee Name</label>
                    <input type="text" id="name" name="name" class="border rounded p-2 w-full">
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

    <div class="overflow-x-auto" >
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-100 uppercase text-gray-700">
            <tr>
                <th class="px-6 py-3 border">Employee No.</th>
                <th class="px-6 py-3 border">Employee Name</th>
                <th class="px-6 py-3 border">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($employees as $employee)
                <tr>
                    <td class="px-6 py-4 border">{{ $employee->id }}</td>
                    <td class="px-6 py-4 border">{{ $employee->name }}</td>
                    <td class="px-6 py-4 border">
                        <span class="flex gap-2">
                        <x-modal title="Edit employee">
                            <x-slot name="trigger">
                                <x-Button variant="secondary" class="no-print">Edit</x-Button>
                            </x-slot>

                            <x-slot name="content">
                                <form action="{{  route('employees.update', $employee->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="space-y-2">
                                        <label for="name">Employee Name</label>
                                        <input 
                                            type="text" 
                                            id="name" 
                                            name="name" 
                                            value="{{ old('name', $employee->name) }}" 
                                            class="border rounded p-2 w-full "
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
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <x-Button type="submit" variant="danger" class="no-print">Delete</x-Button>
                        </form>
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>    
@endsection     