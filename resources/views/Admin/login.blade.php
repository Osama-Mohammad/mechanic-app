<x-layout>
    <x-nav />
    <form action="/auth/register/store" method="POSt">
        <label for="">Email:</label>
        <input type="text" name="email"><br><br>
        @error('email')
            {{ $message }}
        @enderror

        <label for="">Password:</label>
        <input type="text" name="password"><br><br>
        @error('password')
            {{ $message }}
        @enderror
        <button type="submit">Log In</button>
    </form>
</x-layout>
