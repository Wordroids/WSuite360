<x-app-layout>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col" x-data="getData">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold">Project Users</h3>
                <p class="text-sm text-gray-600">{{$project->name}}</p>
            </div>
            <button @click="showAddUserModal = true" class="bg-indigo-700 hover:bg-indigo-600 text-white p-3 rounded text-sm">Add User</button>
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
                    <template x-for="user in projectUsers.data">
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
            <p class="text-sm" x-text="`Page ${projectUsers.current_page} of ${projectUsers.last_page}`">Page 1 of 3</p>

            <div class="flex justify-end gap-2">
                <template x-for="(link, index) in projectUsers.links">
                    <button
                        class="p-1 text-sm text-center border transition-colors border-gray-200 bg-white hover:bg-gray-600 hover:text-white rounded"
                        :class="{'bg-gray-600 text-white': link.active}"
                        x-text="`0${index}`"
                    >
                        0
                    </button>
                </template>
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
                                <p class="text-sm text-gray-600">{{$project->name}}</p>
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

        <!-- Change role modal -->
        <div class="relative z-10" x-show="showChangeRoleModal" x-cloak aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full justify-center p-4 text-center items-center">
                    <div class="relative transform rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all w-1/3" @click.outside="showChangeRoleModal = false">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <h3 class="text-lg font-semibold" x-text="changeRoleUser.name">N/A</h3>
                                <select class="rounded" x-model="changeRoleValue">
                                    <option value="member">Member</option>
                                    <option value="tester">Tester</option>
                                    <option value="developer">Developer</option>
                                    <option value="project_manager">Project Manager</option>
                                </select>
                            </div>
                            <div>
                                <button class="border border-gray-600 hover:bg-gray-600 hover:text-white p-3 rounded text-sm" @click="updateUser()">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const getData = {
        project: @json($project),
        csrfToken: "{{ csrf_token() }}",
        showAddUserModal: false,
        showChangeRoleModal: false,
        changeRoleUser: [],
        changeRoleValue: 'member',
        projectUsers: [],
        users: [1, 2],
        searchTerm: '',

        init: function (){
            this.fetchProjectUsers()
            this.fetchUsers()
        },

        changeRole(user) {
            this.changeRoleUser = user;
            this.showChangeRoleModal = true;
        },

        fetchProjectUsers: function (){
            fetch(`/api/projects/${this.project.id}/users`, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                }
            })
                .then(response => response.json())
                .then(data => {
                    this.projectUsers = data?.users ?? []
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
            fetch(`/api/projects/${this.project.id}/users`, {
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
                        this.fetchProjectUsers()
                    }

                    alert(data.message);
                })
                .catch(error => {
                    alert("Failed to add user: ", error.message)
                    console.error('Error:', error)
                });
        },

        updateUser: function () {
            fetch(`/api/projects/${this.project.id}/users/${this.changeRoleUser.id}`, {
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
                        this.fetchProjectUsers()
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
            fetch(`/api/projects/${this.project.id}/users/${user}`, {
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
                        this.fetchProjectUsers()
                    }
                })
                .catch(error => {
                    alert("Failed to remove user: ", error.message)
                    console.error('Error:', error)
                });
        },
    }
</script>