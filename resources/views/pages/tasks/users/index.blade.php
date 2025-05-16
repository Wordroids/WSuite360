
<x-app-layout>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col" x-data="taskUserData">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold">Task Users</h3>
                <p class="text-sm text-gray-600">{{ $task->name }}</p>
            </div>
            <button @click="showAddUserModal = true"
                class="bg-indigo-700 hover:bg-indigo-600 text-white p-3 rounded text-sm">Add User</button>
        </div>

        <!-- Users Table -->
        <div class="overflow-x-auto rounded-lg mt-6">
            <table class="min-w-full table-auto border-collapse border border-gray-200">
                <thead class="bg-gray-50">
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Role</th>
                    <th class="text-end px-6 py-3 text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="user in taskUsers.data" :key="user.id">
                        <tr class="bg-white border-t">
                            <td class="px-6 py-4 text-sm text-gray-500 font-bold whitespace-nowrap"
                                x-text="user.name">N/A</td>
                            <td class="px-6 py-4 text-sm text-gray-800" x-text="user.email">N/A</td>
                            <td class="px-6 py-4 text-sm text-gray-800" x-text="user.pivot.role">N/A</td>
                            <td class="px-6 py-4 text-sm text-gray-800 flex space-x-2 justify-end">
                                <!-- Action Buttons -->
                                <button type="button" @click="changeRole(user)"
                                    class="whitespace-nowrap text-xs border border-gray-600 px-3 py-1 rounded hover:bg-gray-500 hover:text-white transition-colors">
                                    Change Role
                                </button>
                                <button @click="removeUser(user.id)" type="button"
                                    class="whitespace-nowrap text-xs border border-red-600 px-3 py-1 rounded hover:bg-red-500 hover:text-white transition-colors">
                                    Remove
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>




<!-- Pagination -->
<div class="flex justify-end gap-2">
    <template x-for="(link, index) in taskUsers.links">
        <button
            class="p-1 text-sm text-center border transition-colors border-gray-200 bg-white hover:bg-gray-600 hover:text-white rounded"
            :class="{ 'bg-gray-600 text-white': link.active }"
            x-text="formatPaginationLabel(link.label)"
            @click="fetchTaskUsers(link.url.split('page=')[1])"
            :disabled="!link.url">
        </button>
    </template>
</div>


        <!-- Add user modal -->
        <div class="relative z-10" x-show="showAddUserModal" x-cloak aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full justify-center p-4 text-center items-center">
                    <div class="relative transform rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all w-1/2"
                        @click.outside="showAddUserModal = false">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">Add Users to Task</h3>
                                <p class="text-sm text-gray-600">{{ $task->name }}</p>
                            </div>
                            <div>
                                <input x-model="searchTerm" type="text"
                                    class="placeholder:text-gray-600 p-3 rounded text-sm" placeholder="Search" />
                                <button @click="fetchAvailableUsers"
                                    class="border border-indigo-700 bg-indigo-700 hover:bg-indigo-600 text-white p-3 rounded text-sm">Search</button>
                                <button
                                    class="border border-gray-600 hover:bg-gray-600 hover:text-white p-3 rounded text-sm"
                                    @click="showAddUserModal = false">Close</button>
                            </div>
                        </div>

                        <table class="mt-6 min-w-full table-auto border-collapse border border-gray-200">
                            <thead class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Email</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Role</th>
                                <th class="w-[20%] text-end px-6 py-3 text-sm font-medium text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="user in availableUsers" :key="user.id">
                                    <tr class="bg-white border-t">
                                        <td class="px-6 py-4 text-sm text-gray-500 font-bold" x-text="user.name"></td>
                                        <td class="px-6 py-4 text-sm text-gray-800" x-text="user.email"></td>
                                        <td class="px-6 py-4 text-sm text-gray-800">
                                            <select x-model="user.role" class="rounded">
                                                <option value="member">Member</option>
                                                <option value="developer">Developer</option>
                                                <option value="reviewer">Reviewer</option>
                                            </select>
                                        </td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 flex space-x-2 justify-end items-center">
                                            <!-- Action Buttons -->
                                            <button @click="addUser(user.id, user.role)" type="button"
                                                class="text-xs border border-gray-600 px-3 py-1 rounded hover:bg-gray-500 hover:text-white transition-colors">
                                                Add
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change role modal -->
        <div class="relative z-10" x-show="showChangeRoleModal" x-cloak aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full justify-center p-4 text-center items-center">
                    <div class="relative transform rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all w-1/3"
                        @click.outside="showChangeRoleModal = false">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <h3 class="text-lg font-semibold" x-text="changeRoleUser.name">N/A</h3>
                                <select class="rounded" x-model="changeRoleValue">
                                    <option value="member">Member</option>
                                    <option value="developer">Developer</option>
                                    <option value="reviewer">Reviewer</option>
                                </select>
                            </div>
                            <div>
                                <button
                                    class="border border-gray-600 hover:bg-gray-600 hover:text-white p-3 rounded text-sm"
                                    @click="updateUser()">Save</button>
                                <button
                                    class="border border-gray-600 hover:bg-gray-600 hover:text-white p-3 rounded text-sm"
                                    @click="showChangeRoleModal = false">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('taskUserData', () => ({
            task: @json($task),
            csrfToken: "{{ csrf_token() }}",
            showAddUserModal: false,
            showChangeRoleModal: false,
            changeRoleUser: null,
            changeRoleValue: 'member',
            taskUsers: @json($task->members()->paginate(5)),
            availableUsers: @json($availableUsers),
            searchTerm: '',
            isLoading: false,



            changeRole(user) {
                this.changeRoleUser = user;
                this.changeRoleValue = user.pivot.role;
                this.showChangeRoleModal = true;
            },

            async fetchTaskUsers(page = 1) {
                try {
                    this.isLoading = true;
                    const response = await fetch(`/tasks/${this.task.id}/users?page=${page}`);
                    const data = await response.json();
                    this.taskUsers = data.users;
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    this.isLoading = false;
                }
            },

            async fetchAvailableUsers() {
                try {
                    this.isLoading = true;
                    const response = await fetch(
                        `/tasks/${this.task.id}/users/available?search=${this.searchTerm}`);
                    const data = await response.json();
                    this.availableUsers = data.users.map(user => ({
                        ...user,
                        role: 'member'
                    }));
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    this.isLoading = false;
                }
            },

            async addUser(userId, role) {
                try {
                    this.isLoading = true;
                    const response = await fetch(`/tasks/${this.task.id}/users`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken
                        },
                        body: JSON.stringify({
                            user_id: userId,
                            role: role
                        })
                    });

                    const data = await response.json();

                    if (data.success) {

                        const addedUser = this.availableUsers.find(u => u.id === userId);
                        if (addedUser) {
                            // Add to task users
                            this.taskUsers.data = [{
                                ...addedUser,
                                pivot: {
                                    role: role
                                }
                            }, ...this.taskUsers.data];

                            // Remove from available users
                            this.availableUsers = this.availableUsers.filter(u => u.id !==
                                userId);
                        }

                        this.showAddUserModal = false;
                    }

                    alert(data.message);
                } catch (error) {
                    alert("Failed to add user: " + error.message);
                    console.error('Error:', error);
                } finally {
                    this.isLoading = false;
                }
            },

            async updateUser() {
                try {
                    this.isLoading = true;
                    const response = await fetch(
                        `/tasks/${this.task.id}/users/${this.changeRoleUser.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken
                            },
                            body: JSON.stringify({
                                role: this.changeRoleValue
                            })
                        });

                    const data = await response.json();

                    if (data.success) {

                        const userIndex = this.taskUsers.data.findIndex(u => u.id === this
                            .changeRoleUser.id);
                        if (userIndex !== -1) {
                            this.taskUsers.data[userIndex].pivot.role = this.changeRoleValue;
                        }

                        this.showChangeRoleModal = false;
                        this.changeRoleUser = null;
                    }

                    alert(data.message);
                } catch (error) {
                    alert("Failed to update user: " + error.message);
                    console.error('Error:', error);
                } finally {
                    this.isLoading = false;
                }
            },

            async removeUser(userId) {
                if (!confirm('Are you sure you want to remove this user from the task?')) {
                    return;
                }

                try {
                    this.isLoading = true;
                    const response = await fetch(`/tasks/${this.task.id}/users/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken
                        }
                    });

                    const data = await response.json();

                    if (data.success) {

                        const removedUser = this.taskUsers.data.find(u => u.id === userId);
                        if (removedUser) {
                            // Remove from task users
                            this.taskUsers.data = this.taskUsers.data.filter(u => u.id !==
                                userId);

                            // Add back to available users
                            this.availableUsers.push({
                                id: removedUser.id,
                                name: removedUser.name,
                                email: removedUser.email,
                                role: removedUser.pivot.role
                            });
                        }
                    }

                    alert(data.message);
                } catch (error) {
                    alert("Failed to remove user: " + error.message);
                    console.error('Error:', error);
                } finally {
                    this.isLoading = false;
                }
            },
formatPaginationLabel(label) {
    if (label.includes('Previous')) {
        return '‹ Previous';
    }
    if (label.includes('Next')) {
        return 'Next ›';
    }
    return label;
},

        }));

    });
</script>
