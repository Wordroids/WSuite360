<x-app-layout>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col" x-data="getData">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold">Task Users</h3>
                <p class="text-sm text-gray-600">{{$task->title}} - {{$task->project->name}}</p>
            </div>
            <button @click="showAddUserModal = true" class="bg-indigo-700 hover:bg-indigo-600 text-white p-3 rounded text-sm">Add User</button>
        </div>

        <!-- Users Table -->
        <div class="overflow-x-auto rounded-lg mt-6">
            <table class="min-w-full border-collapse border border-gray-200">
                <thead class="bg-gray-50">
                    <th class="w-1/4 px-6 py-3 text-left text-sm font-medium text-gray-700">Name</th>
                    <th class="w-1/4 px-6 py-3 text-left text-sm font-medium text-gray-700">Email</th>
                    <th class="w-1/4 px-6 py-3 text-left text-sm font-medium text-gray-700">Role</th>
                    <th class="w-1/4 text-end px-6 py-3 text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-50">
                    <template x-for="user in taskUsers.data">
                        <tr class="bg-white border-t">
                            <td class="px-6 py-4 text-sm text-gray-500 font-bold whitespace-nowrap" x-text="user.name">N/A</td>
                            <td class="px-6 py-4 text-sm text-gray-800" x-text="user.email">N/A</td>
                            <td class="px-6 py-4 text-sm text-gray-800" x-text="user.pivot.role">N/A</td>
                            <td class="px-6 py-4 text-sm text-gray-800 flex space-x-2 justify-end">
                                <!-- Action Buttons -->
                                <button type="button" @click="changeRole(user)" class="whitespace-nowrap text-xs border border-gray-600 px-3 py-1 rounded hover:bg-gray-500 hover:text-white transition-colors">
                                    Change Role
                                </button>
                                <button
                                    @click="removeUser(user.id)"
                                    type="button"
                                    class="whitespace-nowrap text-xs border border-red-600 px-3 py-1 rounded hover:bg-red-500 hover:text-white transition-colors"
                                >
                                    Remove
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-6">
            <p class="text-sm" x-text="`Page ${taskUsers.current_page} of ${taskUsers.last_page}`">Page 1 of 3</p>

            <div class="flex justify-end gap-2">
                <button
                    class="p-1 text-sm text-center border transition-colors border-gray-200 bg-white hover:bg-gray-600 hover:text-white rounded disabled:bg-gray-300 disabled:text-black"
                    x-bind:disabled="taskUsers.current_page == 1"
                    @click="changePage(taskUsers.current_page - 1)"
                >
                    Prev
                </button>
                <template x-for="i in taskUsers.last_page">
                    <button
                        class="p-1 text-sm text-center border transition-colors border-gray-200 bg-white hover:bg-gray-600 hover:text-white rounded disabled:bg-gray-300 disabled:text-black"
                        x-bind:disabled="taskUsers.current_page == i"
                        x-text="String(i).padStart(2,0)"
                        @click="changePage(i)"
                    >
                        00
                    </button>
                </template>
                <button
                    class="p-1 text-sm text-center border transition-colors border-gray-200 bg-white hover:bg-gray-600 hover:text-white rounded disabled:bg-gray-300 disabled:text-black"
                    x-bind:disabled="taskUsers.current_page == taskUsers.last_page"
                    @click="changePage(taskUsers.current_page + 1)"
                >
                    Next
                </button>
            </div>
        </div>

        <!-- Add user modal -->
        <div class="relative z-10" x-show="showAddUserModal" x-cloak aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full justify-center p-4 text-center items-center">
                    <div class="relative transform rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all w-1/2" @click.outside="showAddUserModal = false">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">Add Users</h3>
                                <p class="text-sm text-gray-600">{{$task->name}}</p>
                            </div>
                            <div>
                                <input x-model="searchTerm" type="text" class="placeholder:text-gray-600 p-3 rounded text-sm" placeholder="Search" />
                                <button @click="fetchUsers" class="border border-indigo-700 bg-indigo-700 hover:bg-indigo-600 text-white p-3 rounded text-sm">Search</button>
                                <button class="border border-gray-600 hover:bg-gray-600 hover:text-white p-3 rounded text-sm" @click="showAddUserModal = false">Close</button>
                            </div>
                        </div>

                        <table class="mt-6 min-w-full table-auto border-collapse border border-gray-200">
                            <thead class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Email</th>
                                <th class="w-[20%] text-end px-6 py-3 text-sm font-medium text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="user in users">
                                    <tr class="bg-white border-t">
                                        <td class="px-6 py-4 text-sm text-gray-500 font-bold" x-text="user.name"></td>
                                        <td class="px-6 py-4 text-sm text-gray-800" x-text="user.email"></td>
                                        <td class="px-6 py-4 text-sm text-gray-800 flex space-x-2 justify-end items-center">
                                            <!-- Action Buttons -->
                                            <button
                                                @click="addUser(user.id)"
                                                type="button"
                                                class="text-xs border border-gray-600 px-3 py-1 rounded hover:bg-gray-500 hover:text-white transition-colors"
                                            >
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
    </div>
</x-app-layout>

<script>
    const getData = {
        task: @json($task),
        csrfToken: "{{ csrf_token() }}",
        showAddUserModal: false,
        showChangeRoleModal: false,
        changeRoleUser: [],
        changeRoleValue: 'member',
        taskUsers: [],
        users: [1, 2],
        searchTerm: '',
        currentPage: 1,

        init: function (){
            this.fetchTaskUsers()
            this.fetchUsers()
        },

        changeRole(user) {
            this.changeRoleUser = user;
            this.showChangeRoleModal = true;
        },

        changePage(page) {
            this.currentPage = page;
            this.fetchTaskUsers();
        },

        fetchTaskUsers: function (){
            fetch(`/api/tasks/${this.task.id}/users?page=${this.currentPage}`, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                }
            })
                .then(response => response.json())
                .then(data => {
                    this.taskUsers = data?.users ?? []
                })
                .catch(error => {
                    console.error('Error:', error)
                });
        },

        fetchUsers: function () {
            fetch(`/api/users?search=${this.searchTerm}`, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                }
            })
                .then(response => response.json())
                .then(data => {
                    this.users = data?.users ?? []
                })
                .catch(error => {
                    console.error('Error:', error)
                });
        },

        addUser: function (user) {
            fetch(`/api/tasks/${this.task.id}/users`, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify({
                    'user_id': user
                })
            })
                .then(response => response.json())
                .then(data => {
                    if(data.success){
                        this.fetchTaskUsers()
                    }

                    alert(data.message);
                })
                .catch(error => {
                    alert("Failed to add user: ", error.message)
                    console.error('Error:', error)
                });
        },

        updateUser: function () {
            fetch(`/api/tasks/${this.task.id}/users/${this.changeRoleUser.id}`, {
                method: 'PUT',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify({
                    'role': this.changeRoleValue
                })
            })
                .then(response => response.json())
                .then(data => {
                    if(data.success){
                        this.fetchTaskUsers()
                    }
                })
                .catch(error => {
                    alert("Failed to update user: ", error.message)
                    console.error('Error:', error)
                })
                .finally(() => {
                    this.showChangeRoleModal = false;
                    this.changeRoleUser = [];
                });
        },

        removeUser: function (user) {
            fetch(`/api/tasks/${this.task.id}/users/${user}`, {
                method: 'DELETE',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
            })
                .then(response => response.json())
                .then(data => {
                    if(data.success){
                        this.fetchTaskUsers()
                    }
                })
                .catch(error => {
                    alert("Failed to remove user: ", error.message)
                    console.error('Error:', error)
                });
        },
    }
</script>