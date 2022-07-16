<x-layout>
    <x-dashboard>
        <div class="p-2">
            <h2>Applications</h2>
            <hr>
            <div class="card">
                <div class="card-body">
                    @foreach ($applications as $app)
                        <span class="application-name"><strong>{{ $app->name }}</strong></span>
                        <span class="actions mx-2">
                            <a href="{{ route('admin.applications.show', ['id' => $app->id]) }}" class="btn btn-primary">View</a>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </x-dashboard>
</x-layout>
