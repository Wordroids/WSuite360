<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project Details') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h3 class="text-lg font-semibold">Project Name: {{ $project->name }}</h3>
        <p><strong>Client:</strong> {{ $project->client->name }}</p>
        <p><strong>Description:</strong> {{ $project->description ?? 'No description provided' }}</p>
        <p><strong>Start Date:</strong> {{ $project->start_date ?? 'Not set' }}</p>
        <p><strong>End Date:</strong> {{ $project->end_date ?? 'Not set' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($project->status) }}</p>

        <!-- Assigned Project Managers -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold">Project Managers</h3>
            @if($projectManagers->isEmpty())
                <p class="text-gray-500">No Project Managers assigned.</p>
            @else
                <ul class="list-disc ml-5">
                    @foreach($projectManagers as $member)
                        <li>{{ $member->user->name }} ({{ $member->user->email }})</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Assigned Developers -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold">Developers</h3>
            @if($developers->isEmpty())
                <p class="text-gray-500">No Developers assigned.</p>
            @else
                <ul class="list-disc ml-5">
                    @foreach($developers as $member)
                        <li>{{ $member->user->name }} ({{ $member->user->email }})</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Assigned Employees -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold">Assigned Employees</h3>
            @if($employees->isEmpty())
                <p class="text-gray-500">No Employees assigned.</p>
            @else
                <ul class="list-disc ml-5">
                    @foreach($employees as $member)
                        <li>{{ $member->user->name }} ({{ $member->user->email }})</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Assign User Form -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold">Assign Users</h3>
            <form action="{{ route('projects.assign', $project->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Select User</label>
                    <select name="user_id" id="user_id" class="mt-1 p-2 w-full border rounded-lg">
                        @foreach($unassignedEmployees as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }} ({{ $user->email }}) - {{ ucfirst(optional($user->role)->name ?? 'No Role') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Assign User
                </button>
            </form>
        </div>

        <div class="mt-6">
            <a href="{{ route('projects.index') }}" class="text-blue-500">Back to Projects</a>
        </div>
    </div>
</x-app-layout>
