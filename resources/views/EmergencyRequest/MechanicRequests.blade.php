<x-layout>
    <x-nav />

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card bg-dark text-white">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title text-center">
                            <i class="fas fa-tools"></i> Requests For Mechanic: {{ $mechanic->name }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Date of Report</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                    <tr id="row-{{ $request->id }}">
                                        <td>{{ $request->description }}</td>
                                        <td>{{ $request->location }}</td>
                                        <td>
                                            {{-- {{ route('updateStatus', $request->id) }} --}}

                                            <div class="d-flex align-items-center gap-2">
                                                <select name="status"
                                                    class="form-select form-select-sm bg-dark text-white w-auto"
                                                    id="status-{{ $request->id }}">
                                                    <option value="pending"
                                                        {{ $request->status === 'pending' ? 'selected' : '' }}>Pending
                                                    </option>
                                                    <option value="inprogress"
                                                        {{ $request->status === 'inprogress' ? 'selected' : '' }}>In
                                                        Progress</option>
                                                    <option value="completed"
                                                        {{ $request->status === 'completed' ? 'selected' : '' }}>
                                                        Completed</option>
                                                    <option value="canceled"
                                                        {{ $request->status === 'canceled' ? 'selected' : '' }}>Canceled
                                                    </option>
                                                </select>
                                                <button class="btn btn-warning btn-sm px-3 BtnSave"
                                                    data-id="{{ $request->id }}">
                                                    <i class="fas fa-save"></i> Save
                                                </button>
                                            </div>

                                        </td>
                                        <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <button type="submit" class="btn btn-danger btn-sm BtnDelete"
                                                data-id="{{ $request->id }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Dynamically Update the Status Without Having to reload the page
            $(document).on('click', '.BtnSave', function() {
                let id = $(this).data('id');
                let status = $('#status-' + id).val();

                // Confirmation prompt
                if (!confirm("Are you sure you want to update this request?")) {
                    return; // Stop execution if user cancels
                }

                $.ajax({
                    url: '{{ route('MechanicUpdateRequestReport') }}',
                    type: 'POST',
                    data: {
                        'id': id,
                        'status': status,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        alert(data.msg);
                        $('#status-' + data.report.id).val(data.report.status);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Failed to update request');
                    }
                });
            });

            $(document).on('click', '.BtnDelete', function() {
                let id = $(this).data('id');

                // Confirmation prompt
                if (!confirm(
                        "Are you sure you want to delete this request? This action cannot be undone.")) {
                    return; // Stop execution if user cancels
                }

                $.ajax({
                    url: '{{ route('MechanicDeleteRequestReport') }}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id
                    },
                    success: function(data) {
                        alert(data.msg);
                        $('#row-' + data.id).remove();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Failed to delete request');
                    }
                });
            });
        });
    </script>
</x-layout>
