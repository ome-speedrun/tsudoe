<x-layout>
    <x-dashboard>
        <style>
        </style>
        <div class="p-2">
            <h2>Applications - {{ $application->name }}</h2>
            <hr>
            <div class="card">
                <div class="card-body">
                    <h3>Bearer token</h3>
                    <div class="container-fluid">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 align-items-center">
                            @foreach ($tokens as $token)
                            <div class="col mx-2">
                                <div class="card">
                                    <div class="card-body">
                                        <p>{{ $token->name }}</p>
                                        <p>created at - {{ $token->created_at }}</p>
                                        <form class="m-0" action="{{ route('admin.applications.tokens.revoke', ['applicationId' => $application->id]) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $token->id }}" />
                                            <button class="btn btn-info" type="submit">
                                                Revoke
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="col token-col">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('admin.applications.tokens.generate', ['applicationId' => $application->id]) }}" class="btn btn-primary">
                                        Generate
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-dashboard>
</x-layout>
