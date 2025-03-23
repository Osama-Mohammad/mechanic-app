<x-layout>
    <x-nav />

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Emergency Requests -->
                <div class="card bg-dark text-white mb-4">
                    <div class="card-header bg-danger">
                        <h3 class="card-title text-center">
                            <i class="fas fa-exclamation-triangle"></i> Emergency Requests For Mechanic: {{ $mechanic->name }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-align-left"></i> Description</th>
                                    <th><i class="fas fa-map-marker-alt"></i> Location</th>
                                    <th><i class="fas fa-info-circle"></i> Status</th>
                                    <th><i class="fas fa-calendar-alt"></i> Date of Report</th>
                                    <th><i class="fas fa-cogs"></i> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                    <tr id="row-{{ $request->id }}">
                                        <td>{{ $request->description }}</td>
                                        <td>{{ $request->location }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <select name="status" class="form-select form-select-sm bg-dark text-white w-auto" id="status-{{ $request->id }}">
                                                    <option value="pending" {{ $request->status === 'pending' ? 'selected' : '' }}><i class="fas fa-clock"></i> Pending</option>
                                                    <option value="inprogress" {{ $request->status === 'inprogress' ? 'selected' : '' }}><i class="fas fa-tools"></i> In Progress</option>
                                                    <option value="completed" {{ $request->status === 'completed' ? 'selected' : '' }}><i class="fas fa-check-circle"></i> Completed</option>
                                                    <option value="canceled" {{ $request->status === 'canceled' ? 'selected' : '' }}><i class="fas fa-times-circle"></i> Canceled</option>
                                                </select>
                                                <button class="btn btn-warning btn-sm px-3 BtnSave" data-id="{{ $request->id }}">
                                                    <i class="fas fa-save"></i> Save
                                                </button>
                                            </div>
                                        </td>
                                        <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <button type="submit" class="btn btn-danger btn-sm BtnDelete" data-id="{{ $request->id }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Regular Requests -->
                <div class="card bg-dark text-white">
                    <div class="card-header bg-primary">
                        <h3 class="card-title text-center">
                            <i class="fas fa-wrench"></i> Regular Service Requests For Mechanic: {{ $mechanic->name }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-toolbox"></i> Service Type</th>
                                    <th><i class="fas fa-calendar-check"></i> Appointment Time</th>
                                    <th><i class="fas fa-info-circle"></i> Status</th>
                                    <th><i class="fas fa-user"></i> Customer</th>
                                    <th><i class="fas fa-cogs"></i> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($RegularRequests as $request)
                                    <tr id="regular-row-{{ $request->id }}">
                                        <td>{{ $request->serviceType->name }}</td>
                                        <td>{{ $request->appointment_time }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <select name="status" class="form-select form-select-sm bg-dark text-white w-auto" id="regular-status-{{ $request->id }}">
                                                    <option value="pending" {{ $request->status === 'pending' ? 'selected' : '' }}><i class="fas fa-clock"></i> Pending</option>
                                                    <option value="inprogress" {{ $request->status === 'inprogress' ? 'selected' : '' }}><i class="fas fa-tools"></i> In Progress</option>
                                                    <option value="completed" {{ $request->status === 'completed' ? 'selected' : '' }}><i class="fas fa-check-circle"></i> Completed</option>
                                                    <option value="canceled" {{ $request->status === 'canceled' ? 'selected' : '' }}><i class="fas fa-times-circle"></i> Canceled</option>
                                                </select>
                                                <button class="btn btn-warning btn-sm px-3 BtnSaveRegularRequest" data-id="{{ $request->id }}">
                                                    <i class="fas fa-save"></i> Save
                                                </button>
                                            </div>
                                        </td>
                                        <td>{{ $request->customer->name }}</td>
                                        <td>
                                            <button type="submit" class="btn btn-danger btn-sm BtnDeleteRegularRequest" data-id="{{ $request->id }}">
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

                if (!confirm("Are you sure you want to update this request?")) {
                    return;
                }

                $.ajax({
                    url: '{{ route('MechanicUpdateRequestReportEmergency') }}',
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

                if (!confirm("Are you sure you want to delete this request? This action cannot be undone.")) {
                    return;
                }

                $.ajax({
                    url: '{{ route('MechanicDeleteRequestReportEmergency') }}',
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

            $(document).on('click', '.BtnSaveRegularRequest', function() {
                let id = $(this).data('id');
                let status = $('#regular-status-' + id).val();

                $.ajax({
                    url: '{{ route('MechanicUpdateRequestRegular') }}',
                    type: 'POST',
                    data: {
                        'id': id,
                        'status': status,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        alert(data.msg);
                        $('#regular-status-' + data.report.id).val(data.report.status);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Failed to update request');
                    }
                });
            });

            $(document).on('click', '.BtnDeleteRegularRequest', function() {
                let id = $(this).data('id');

                if (!confirm("Are you sure you want to delete this request? This action cannot be undone.")) {
                    return;
                }

                $.ajax({
                    url: '{{ route('MechanicDeleteRequestRegular') }}',
                    type: 'POST',
                    data: {
                        'id': id,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        alert(data.msg);
                        $('#regular-row-' + data.id).remove();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Failed to update request');
                    }
                });
            });
        });
    </script>
</x-layout>
