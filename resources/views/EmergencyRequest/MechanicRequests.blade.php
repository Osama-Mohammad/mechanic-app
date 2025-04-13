<x-layout>
    <x-nav />

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="card bg-dark text-white">
                    <div class="card-header bg-primary">
                        <h3 class="card-title text-center">
                            <i class="fas fa-wrench"></i> Pending Requests For Mechanic: {{ $mechanic->name }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-toolbox"></i> Description</th>
                                    <th><i class="fas fa-calendar-check"></i> Appointment Time</th>
                                    <th><i class="fas fa-info-circle"></i> Location</th>
                                    <th><i class="fas fa-user"></i> Customer</th>
                                    <th><i class="fas fa-cogs"></i> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($RegularRequests as $request)
                                    @if ($request->status === 'pending')
                                        <tr id="pending-row-{{ $request->id }}">
                                            <td>{{ $request->serviceType->name }}</td>
                                            <td> {{ $request->date }} At {{ $request->time }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    {{ $request->customer?->location ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td>{{ $request->customer->name }}</td>
                                            <td>
                                                <button type="submit"
                                                    class="btn btn-success btn-sm BtnAcceptRegularRequest"
                                                    data-id="{{ $request->id }}">
                                                    <i class="fas fa-check"></i> Accept
                                                </button>
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm BtnRejectRegularRequest"
                                                    data-id="{{ $request->id }}">
                                                    <i class="fas fa-trash"></i> Reject
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>



                <!-- Emergency Requests -->
                <div class="card bg-dark text-white mb-4">
                    <div class="card-header bg-danger">
                        <h3 class="card-title text-center">
                            <i class="fas fa-exclamation-triangle"></i> Emergency Requests For Mechanic:
                            {{ $mechanic->name }}
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
                                    @if ($request->status == 'pending')
                                        <tr id="row-{{ $request->id }}">
                                            <td>{{ $request->description }}</td>
                                            <td>{{ $request->location }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <p>Pending : Waiting to press the button to Accept or Decline</p>
                                                </div>
                                            </td>
                                            <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <button type="submit"
                                                    class="btn btn-success btn-sm BtnAcceptEmergencyRequest"
                                                    data-id="{{ $request->id }}">
                                                    <i class="fas fa-check"></i> Accept
                                                </button>
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm BtnRejectEmergencyRequest"
                                                    data-id="{{ $request->id }}">
                                                    <i class="fas fa-trash"></i> Reject
                                                </button>
                                            </td>
                                        </tr>
                                    @else
                                        <tr id="row-{{ $request->id }}">
                                            <td>{{ $request->description }}</td>
                                            <td>{{ $request->location }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <select name="status"
                                                        class="form-select form-select-sm bg-dark text-white w-auto"
                                                        id="status-{{ $request->id }}">
                                                        <option value="inprogress"
                                                            {{ $request->status === 'inprogress' ? 'selected' : '' }}>
                                                            <i class="fas fa-tools"></i> In Progress
                                                        </option>
                                                        <option value="completed"
                                                            {{ $request->status === 'completed' ? 'selected' : '' }}><i
                                                                class="fas fa-check-circle"></i> Completed</option>
                                                        <option value="canceled"
                                                            {{ $request->status === 'canceled' ? 'selected' : '' }}><i
                                                                class="fas fa-times-circle"></i> Canceled</option>
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
                                    @endif
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
                        <table class="table table-dark table-hover" id="regular-requests-table">
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
                                    @if ($request->status != 'pending' && $request->status != 'canceled')
                                        <tr id="regular-row-{{ $request->id }}">
                                            <td>{{ $request->serviceType->name }}</td>
                                            <td> {{ $request->date }} At {{ $request->time }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <select name="status"
                                                        class="form-select form-select-sm bg-dark text-white w-auto"
                                                        id="regular-status-{{ $request->id }}">

                                                        <option value="inprogress"
                                                            {{ $request->status === 'inprogress' ? 'selected' : '' }}>
                                                            <i class="fas fa-tools"></i> In Progress
                                                        </option>
                                                        <option value="completed"
                                                            {{ $request->status === 'completed' ? 'selected' : '' }}><i
                                                                class="fas fa-check-circle"></i> Completed</option>
                                                        <option value="canceled"
                                                            {{ $request->status === 'canceled' ? 'selected' : '' }}><i
                                                                class="fas fa-times-circle"></i> Canceled</option>
                                                    </select>
                                                    <button class="btn btn-warning btn-sm px-3 BtnSaveRegularRequest"
                                                        data-id="{{ $request->id }}">
                                                        <i class="fas fa-save"></i> Save
                                                    </button>
                                                </div>
                                            </td>
                                            <td>{{ $request->customer->name }}</td>
                                            <td>
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm BtnDeleteRegularRequest"
                                                    data-id="{{ $request->id }}">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
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
                    url: '{{ route('mechanic.emergency.update') }}',
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

                if (!confirm(
                        "Are you sure you want to delete this request? This action cannot be undone.")) {
                    return;
                }

                $.ajax({
                    url: '{{ route('mechanic.emergency.delete') }}',
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

                if (!confirm(
                        "Are you sure you want to Update this request?")) {
                    return;
                }

                $.ajax({
                    url: '{{ route('mechanic.service.update') }}',
                    type: 'POST',
                    data: {
                        'id': id,
                        'status': status,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        alert(data.msg);
                        $('#regular-status-' + data.report.id).val(data.report.status);
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Failed to update request');
                    }
                });
            });

            $(document).on('click', '.BtnDeleteRegularRequest', function() {
                let id = $(this).data('id');

                if (!confirm(
                        "Are you sure you want to delete this request? This action cannot be undone.")) {
                    return;
                }

                $.ajax({
                    url: '{{ route('mechanic.service.delete') }}',
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

            $(document).on('click', '.BtnAcceptRegularRequest', function() {
                let id = $(this).data('id');

                if (!confirm("Are you sure you want to accept this request?")) {
                    return;
                }

                $.ajax({
                    url: '{{ route('mechanic.service.accept') }}',
                    type: 'POST',
                    data: {
                        'id': id,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        alert(data.msg);

                        // Remove the pending row
                        $('#pending-row-' + id).remove();

                        if (data.request) {
                            let newRow = `
                                <tr id="regular-row-${data.request.id}">
                                    <td>${data.request.serviceType?.name || 'N/A'}</td>
                                    <td>${data.request.date || 'N/A'} At ${data.request.time || 'N/A'}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <select name="status" class="form-select form-select-sm bg-dark text-white w-auto" id="regular-status-${data.request.id}">
                                                <option value="inprogress" ${data.request.status === 'inprogress' ? 'selected' : ''}>
                                                    <i class="fas fa-tools"></i> In Progress
                                                </option>
                                                <option value="completed" ${data.request.status === 'completed' ? 'selected' : ''}>
                                                    <i class="fas fa-check-circle"></i> Completed
                                                </option>
                                                <option value="canceled" ${data.request.status === 'canceled' ? 'selected' : ''}>
                                                    <i class="fas fa-times-circle"></i> Canceled
                                                </option>
                                            </select>
                                            <button class="btn btn-warning btn-sm px-3 BtnSaveRegularRequest" data-id="${data.request.id}">
                                                <i class="fas fa-save"></i> Save
                                            </button>
                                        </div>
                                    </td>
                                    <td>${data.request.customer?.name || 'N/A'}</td>
                                    <td>
                                        <button type="submit" class="btn btn-danger btn-sm BtnDeleteRegularRequest" data-id="${data.request.id}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            `;

                            $('#regular-requests-table tbody').append(newRow);
                        } else {
                            console.error('Request data missing in response:', data);
                            alert('Request accepted, but could not update table.');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Failed to accept request');
                    }
                });
            });

            $(document).on('click', '.BtnRejectRegularRequest', function() {
                let id = $(this).data('id');

                if (!confirm("Are you sure you want to reject this request?")) {
                    return;
                }

                $.ajax({
                    url: '{{ route('mechanic.service.reject') }}',
                    type: 'POST',
                    data: {
                        'id': id,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        alert(data.msg);

                        // Remove the pending row
                        $('#pending-row-' + id).remove();

                        // Optionally, you can also remove the row from the regular requests table if it exists
                        $('#regular-row-' + id).remove();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Failed to reject request');
                    }
                });
            });

            $(document).on('click', '.BtnAcceptEmergencyRequest', function() {
                let id = $(this).data('id');
                let $row = $(this).closest('tr');
                let description = $row.find('td:eq(0)').text();
                let location = $row.find('td:eq(1)').text();
                let date = $row.find('td:eq(3)').text();

                if (!confirm("Are you sure you want to accept this request?")) {
                    return;
                }

                $.ajax({
                    url: '{{ route('mechanic.emergency.accept') }}',
                    type: 'POST',
                    data: {
                        'id': id,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        alert(data.msg);

                        // Remove from pending section
                        $row.remove();

                        // Add to active section
                        let newRow = `
                <tr id="row-${id}">
                    <td>${description}</td>
                    <td>${location}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <select name="status"
                                class="form-select form-select-sm bg-dark text-white w-auto"
                                id="status-${id}">
                                <option value="inprogress" selected>
                                    <i class="fas fa-tools"></i> In Progress
                                </option>
                                <option value="completed">
                                    <i class="fas fa-check-circle"></i> Completed
                                </option>
                                <option value="canceled">
                                    <i class="fas fa-times-circle"></i> Canceled
                                </option>
                            </select>
                            <button class="btn btn-warning btn-sm px-3 BtnSave"
                                data-id="${id}">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </td>
                    <td>${date}</td>
                    <td>
                        <button type="submit" class="btn btn-danger btn-sm BtnDelete"
                            data-id="${id}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            `;

                        // Append to the emergency requests table (find the correct tbody)
                        $('.card-body table tbody').append(newRow);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Failed to accept request');
                    }
                });
            });
        });

        $(document).on('click', '.BtnRejectEmergencyRequest', function() {
            let id = $(this).data('id');

            if (!confirm("Are you sure you want to reject this request?")) {
                return;
            }

            $.ajax({
                url: '{{ route('mechanic.emergency.reject') }}',
                type: 'POST',
                data: {
                    'id': id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    alert(data.msg);
                    $('#row-' + data.id).remove();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Failed to reject request');
                }
            });
        });
    </script>
</x-layout>
