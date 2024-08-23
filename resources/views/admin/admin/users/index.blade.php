@extends('layouts.main')

@section('title', 'Daftar Pengguna')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Daftar Pengguna</h4>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createUserModal">
                            Tambah Pengguna
                        </button>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="userTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="admin-tab" data-bs-toggle="tab" href="#admin" role="tab"
                                    aria-controls="admin" aria-selected="true">Admin</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="teacher-tab" data-bs-toggle="tab" href="#teacher" role="tab"
                                    aria-controls="teacher" aria-selected="false">Teacher</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="user-tab" data-bs-toggle="tab" href="#user" role="tab"
                                    aria-controls="user" aria-selected="false">User</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content mt-3">
                            <!-- Admin Tab -->
                            <div class="tab-pane fade show active" id="admin" role="tabpanel"
                                aria-labelledby="admin-tab">
                                <div class="table-responsive">
                                    <table class="table table-xl">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>NIS</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users->where('role.name', 'admin') as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->role->name }}</td>
                                                    <td>{{ $user->nis }}</td>
                                                    <td class="text-nowrap">
                                                        <div class="dropdown dropup">
                                                            <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                                type="button" id="dropdownMenuButton-{{ $user->id }}"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bi bi-three-dots-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton-{{ $user->id }}">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                                        onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', {{ $user->role_id }}, '{{ $user->nis }}')">Ubah</a>
                                                                </li>
                                                                <li>
                                                                    <form
                                                                        action="{{ route('add-users.destroy', $user->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item">Hapus</button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Teacher Tab -->
                            <div class="tab-pane fade" id="teacher" role="tabpanel" aria-labelledby="teacher-tab">
                                <div class="table-responsive">
                                    <table class="table table-xl">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>NIS</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users->where('role.name', 'teacher') as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->role->name }}</td>
                                                    <td>{{ $user->nis }}</td>
                                                    <td class="text-nowrap">
                                                        <div class="dropdown dropup">
                                                            <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                                type="button" id="dropdownMenuButton-{{ $user->id }}"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bi bi-three-dots-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton-{{ $user->id }}">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                                        onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', {{ $user->role_id }}, '{{ $user->nis }}')">Ubah</a>
                                                                </li>
                                                                <li>
                                                                    <form
                                                                        action="{{ route('add-users.destroy', $user->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item">Hapus</button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- User Tab -->
                            <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                                <div class="table-responsive">
                                    <table class="table table-xl">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>NIS</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users->where('role.name', 'user') as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->role->name }}</td>
                                                    <td>{{ $user->nis }}</td>
                                                    <td class="text-nowrap">
                                                        <div class="dropdown dropup">
                                                            <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                                type="button"
                                                                id="dropdownMenuButton-{{ $user->id }}"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bi bi-three-dots-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton-{{ $user->id }}">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                                        onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', {{ $user->role_id }}, '{{ $user->nis }}')">Ubah</a>
                                                                </li>
                                                                <li>
                                                                    <form
                                                                        action="{{ route('add-users.destroy', $user->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item">Hapus</button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createUserForm" method="POST" action="{{ route('add-users.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="createName" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="createName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="createEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="createEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="createPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="createPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="createRole" class="form-label">Role</label>
                            <select class="form-select" id="createRole" name="role_id" required
                                onchange="toggleNisField('create')">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3" id="createNisField">
                            <label for="createNis" class="form-label">NIS</label>
                            <input type="text" class="form-control" id="createNis" name="nis">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editUserId" name="id">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="editPassword" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="editRole" class="form-label">Role</label>
                            <select class="form-select" id="editRole" name="role_id" required
                                onchange="toggleNisField('edit')">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3" id="editNisField">
                            <label for="editNis" class="form-label">NIS</label>
                            <input type="text" class="form-control" id="editNis" name="nis">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleNisField(modalType) {
            var roleSelect = document.getElementById(modalType + 'Role');
            var nisField = document.getElementById(modalType + 'NisField');
            var selectedRole = roleSelect.value;

            if (selectedRole == 2) {
                nisField.style.display = 'block';
            } else {
                nisField.style.display = 'none';
            }
        }

        function openEditModal(id, name, email, roleId, nis) {
            document.getElementById('editName').value = name;
            document.getElementById('editEmail').value = email;
            document.getElementById('editRole').value = roleId;
            document.getElementById('editNis').value = nis;
            document.getElementById('editUserId').value = id;
            document.getElementById('editUserForm').action = 'add-users/' + id;

            toggleNisField('edit');

            var myModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            myModal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleNisField('create');
            toggleNisField('edit');
        });
    </script>
@endpush
