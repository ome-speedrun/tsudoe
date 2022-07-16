<x-layout>
    <x-dashboard>
        <h2>Confirm token - {{ $application->name }}</h2>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="mb-2">
                    <label for="tokenName" class="form-label">Make sure to note token! This is not show again, if you lose this you must revoke later.</label>
                    <input type="text" name="name" id="tokenName" class="form-control" value="{{ $newToken }}" readonly />
                </div>
                <a href="{{ route('admin.applications.show', ['id' => $application->id]) }}" class="btn btn-warning">
                    OK! I note this token safety!
                </a>
            </div>
        </div>
    </x-dashboard>
</x-layout>
