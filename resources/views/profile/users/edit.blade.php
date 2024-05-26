@extends('layouts.template')
@section('header_title')
    Modifier Utilisateurs
@endsection

@section('content')
    <div class="card p-4">
        <div class="row card p-2 text-info">
            <h3>Modification {{ $user->name }}</h3>
        </div>
        <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row row-cols-sm-2 row-cols-1">
                <div class="mb-3">
                    <label class="form-label" for="Username">Nom</label>
                    <input type="text" value="{{ $user->name ?? old('name') }}" id="name" name="name"
                        class="form-control">
                    @error('name')
                        <div class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label class="form-label" for="FullName">Nom Complet
                    </label>
                    <input type="text" value="{{ $user->fullName ?? old('fullName') }}" id="fullName" name="fullName"
                        class="form-control">
                    @error('fullName')
                        <div class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="Email">Email</label>
                    <input type="email" value="{{ $user->email ?? old('email') }}" name="email" id="email"
                        class="form-control">
                    @error('email')
                        <div class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="web-url">Numero Phone</label>
                    <input type="text" value="{{ $user->phoneNumber ?? old('phoneNumber') }}" id="phoneNumber"
                        name="phoneNumber" class="form-control">

                </div>

                <div class="mb-3">
                    <label class="form-label" for="Password">Password</label>
                    <input type="password" placeholder="" id="password" name="password" class="form-control">
                    @error('password')
                        <div class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="RePassword">Re-Password</label>
                    <input type="password" placeholder="" id="password_confirmation" name="password_confirmation"
                        class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label" for="Password">Photo Profile</label>
                    <input type="file" placeholder="" id="profilePath" name="profilePath" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label" for="RePassword">Adresse</label>
                    <input type="text" placeholder="" value="{{ $user->adresse ?? old('adresse') }}" id="adresse"
                        name="adresse" class="form-control">
                </div>
                <div class="mb-6">
                    <label class="form-label" for="roles">Role</label>
                    <select name="roles" id="roles" class="form-control">
                        <option value="">Selectionner Role</option>
                        @foreach ($roles as $role)
                            <option {{ $user->roles()->get()[0]->id == $role->id ? 'selected' : '' }}
                                value="{{ $role->id }}">{{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-6 mt-2">
                    <label class="form-label" for="roles">Banni</label>
                    <div class="form-check h4 form-switch">
                        <input type="checkbox" name="banned" {{ $user->isBanned == 1 ? 'checked' : '' }}
                            value="{{ $user->isBanned == 1 ? 'yes' : 'non' }}" class="form-check-input" id="customSwitch1">
                        <label class="form-check-label" for="customSwitch1"><span class="text-danger">NON</span> / <span
                                class="text-info">OUI</span></label>
                    </div>
                </div>
                <div class="col-sm-12 mt-2 mb-3">
                    <label class="form-label" for="AboutMe">A Propos de Moi
                        {{ old('aboutMe') }}</label>
                    <textarea style="height: 125px;" id="aboutMe" name="aboutMe" class="form-control">{{ $user->aboutMe ?? old('aboutMe') }}</textarea>
                </div>
            </div>
            <button class="btn btn-primary" type="submit"><i class="ri-save-line me-1 lh-1"></i> Modifier
                {{ $user->fullName }}</button>
        </form>
    </div>
@endsection

@section('js_content')
@endsection
