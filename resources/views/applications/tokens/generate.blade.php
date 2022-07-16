<x-layout>
    <x-dashboard>
        <h2>Generate token - {{ $application->name }}</h2>
        <hr />
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.applications.tokens.generate', ['applicationId' => $application->id]) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label for="tokenName" class="form-label">Token Name (description)</label>
                        <input type="text" name="name" id="tokenName" class="form-control" />
                    </div>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </form>
            </div>
        </div>
    </x-dashboard>
</x-layout>
