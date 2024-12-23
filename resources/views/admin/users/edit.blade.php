@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 450px; margin: 0 auto; padding-bottom: 50px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: #d6d6d6;">
                <h2>Редагування користувача "{{$user->login}}"</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
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
                        <label for="login">Логін</label>
                        <input type="text" class="form-control" id="login" name="login" value="{{ old('login', $user->login) }}" required>
                        @error('login')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

{{--                    <div class="form-group">--}}
{{--                        <label for="password">Password (leave blank to keep current)</label>--}}
{{--                        <div class="input-group">--}}
{{--                            <input type="password" class="form-control" id="password" name="password">--}}
{{--                            <div class="input-group-append">--}}
{{--                                <button type="button" class="btn btn-outline-secondary" id="toggle-password">--}}
{{--                                    <i class="fas fa-eye"></i>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        @error('password')--}}
{{--                        <div class="text-danger">{{ $message }}</div>--}}
{{--                        @enderror--}}
{{--                    </div>--}}

{{--                    <div class="form-group">--}}
{{--                        <label for="password_confirmation">Confirm Password</label>--}}
{{--                        <div class="input-group">--}}
{{--                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">--}}
{{--                            <div class="input-group-append">--}}
{{--                                <button type="button" class="btn btn-outline-secondary" id="toggle-password-confirmation">--}}
{{--                                    <i class="fas fa-eye"></i>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        @error('password_confirmation')--}}
{{--                        <div class="text-danger">{{ $message }}</div>--}}
{{--                        @enderror--}}
{{--                    </div>--}}

                    <div class="form-group">
                        <label for="surname">Прізвище</label>
                        <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname', $user->surname) }}" required>
                        @error('surname')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Імʼя</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Електронна пошта</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <div>
                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" style="width: 378px;">
                            @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Адреса</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}">
                        @error('address')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role_id">Роль</label>
                        <select class="form-control" id="role_id" name="role_id" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-warning">Зберегти зміни</button>
                        <button type="button" class="btn btn-outline-dark mx-3" id="back-button">
                            <i class="fas fa-arrow-left"></i> Назад</button>
                    </div>

                    <script>
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

                        document.getElementById('back-button').addEventListener('click', function() {
                            window.location.href = "{{ route('admin.users.index') }}";
                        });

                        // document.getElementById('toggle-password').addEventListener('click', function() {
                        //     const passwordField = document.getElementById('password');
                        //     const passwordFieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                        //     passwordField.setAttribute('type', passwordFieldType);
                        //
                        //     const icon = this.querySelector('i');
                        //     icon.classList.toggle('fa-eye');
                        //     icon.classList.toggle('fa-eye-slash');
                        // });
                        //
                        // document.getElementById('toggle-password-confirmation').addEventListener('click', function() {
                        //     const passwordConfirmationField = document.getElementById('password_confirmation');
                        //     const passwordFieldType = passwordConfirmationField.getAttribute('type') === 'password' ? 'text' : 'password';
                        //     passwordConfirmationField.setAttribute('type', passwordFieldType);
                        //
                        //     const icon = this.querySelector('i');
                        //     icon.classList.toggle('fa-eye');
                        //     icon.classList.toggle('fa-eye-slash');
                        // });
                    </script>
                </form>
            </div>
        </div>
    </div>
@endsection
