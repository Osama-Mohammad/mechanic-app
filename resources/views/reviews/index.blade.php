<x-layout>
    <x-nav />
    <h1>Reviews Done By Customer : {{ Auth::guard('customer')->user()->name }}</h1>

    <table>
        <th>Request ID</th>
        <th>Date of Request</th>
        <th> Action </th>
        @foreach ($reviews as $review)
            <tr>
                <td>{{ $review->service_request_id }}</td>
                <td>{{ $review->date }}</td>
                <td><a href="#">Leave a review</a></td>
            </tr>
        @endforeach
    </table>

</x-layout>
