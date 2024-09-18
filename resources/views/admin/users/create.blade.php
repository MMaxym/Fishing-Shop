@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 500px; margin: 0 auto; padding-bottom: 50px;">
        <div class="card">
            <div class="card-header" style="background-color: #d6d6d6;">
                <h2>Create New User</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" class="form-control" id="login" name="login" value="{{ old('login') }}" required>
                        @error('login')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" id="toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" id="toggle-password-confirmation">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="surname">Surname</label>
                        <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname') }}" required>
                        @error('surname')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                        @error('address')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select class="form-control" id="role_id" name="role_id" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', 2) == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Create User</button>
                        <button type="button" class="btn btn-warning" id="back-button">Back <-</button>
                    </div>

                    <script>
                        document.getElementById('back-button').addEventListener('click', function() {
                            window.location.href = "{{ route('admin.users.index') }}";
                        });

                        document.getElementById('toggle-password').addEventListener('click', function() {
                            const passwordField = document.getElementById('password');
                            const passwordFieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                            passwordField.setAttribute('type', passwordFieldType);

                            const icon = this.querySelector('i');
                            icon.classList.toggle('fa-eye');
                            icon.classList.toggle('fa-eye-slash');
                        });

                        document.getElementById('toggle-password-confirmation').addEventListener('click', function() {
                            const passwordConfirmationField = document.getElementById('password_confirmation');
                            const passwordFieldType = passwordConfirmationField.getAttribute('type') === 'password' ? 'text' : 'password';
                            passwordConfirmationField.setAttribute('type', passwordFieldType);

                            const icon = this.querySelector('i');
                            icon.classList.toggle('fa-eye');
                            icon.classList.toggle('fa-eye-slash');
                        });

                        document.addEventListener('DOMContentLoaded', function() {
                            const phoneInputField = document.querySelector("#phone");
                            if (phoneInputField) {
                                const iti = window.intlTelInput(phoneInputField, {
                                    initialCountry: "ua",
                                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
                                    nationalMode: false,
                                });

                                phoneInputField.addEventListener('input', function() {
                                    let maxDigits = 12;
                                    let digits = phoneInputField.value.replace(/\D/g, '');
                                    if (digits.length > maxDigits) {
                                        phoneInputField.value = phoneInputField.value.slice(0, maxDigits);
                                    }
                                });
                            }
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>
@endsection
