<x-layout>
    <x-nav />

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-wrench me-2"></i>Mechanic Management
                </h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Specialization</th>
                                <th>Experience</th>
                                <th>Rating</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mechanics as $mechanic)
                                <tr>
                                    <td>{{ $mechanic->id }}</td>
                                    <td>{{ $mechanic->name }}</td>
                                    <td>{{ $mechanic->email }}</td>
                                    <td>{{ $mechanic->specialization ?? 'N/A' }}</td>
                                    <td>{{ $mechanic->experience ?? 'N/A' }} years</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">{{ number_format($mechanic->rating, 1) }}</span>
                                            <div class="text-warning">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $mechanic->rating)
                                                        <i class="fas fa-star"></i>
                                                    @elseif($i <= $mechanic->rating + 0.5)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.mechanics.show', $mechanic) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No mechanics found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                <div class="mt-4">
                    {{ $mechanics->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layout>
