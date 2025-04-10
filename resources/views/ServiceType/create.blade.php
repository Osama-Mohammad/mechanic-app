<x-layout>
    <x-nav />
    <form action="{{ route('service-type.store') }}" method="POST">
        @csrf
        <label for="">Service Type Name:</label>
        <input type="text" name="name" id="name" placeholder="Enter Service Type Name">
        <br>
        <button type="submit">Create Service Type</button>
    </form>
</x-layout>
