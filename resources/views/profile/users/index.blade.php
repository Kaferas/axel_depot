@extends('layouts.template')
@section('header_title')
    Listes des Utilisateurs
@endsection
@section('content')
    @canany(['is_daf', 'is_logistique', 'is_fournisseur', 'is_rh', 'is_comptabilite','is_stagiaire'])
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="profile-bg-picture" style="background-image:url('assets/images/cover.jpg')">
                        <span class="picture-bg-overlay"></span>
                        <!-- overlay -->
                    </div>
                    <!-- meta -->
                    <div class="profile-user-box">
                        <div class="row">
                            <div class="col-sm-6">
                                @if (Auth::user()->profilePath)
                                    <div class="profile-user-img"><img src="{{ asset('profiles/' . Auth::user()->profilePath) }}"
                                            alt="" class="avatar-lg rounded-circle"></div>
                                @else
                                    <div class="profile-user-img"><img src="{{ asset('images/avatar.png') }}" alt=""
                                            class="avatar-lg rounded-circle"></div>
                                @endif

                                <div class="">
                                    <h4 class="mt-4 fs-17 ellipsis">{{ strtoupper(Auth::user()->name) }}</h4>
                                    <p class="font-13 text-info"><i> {{ Auth::user()->roles[0]->name }}</i></p>
                                    <b class="text-muted mb-0"><small>{{ Auth::user()->adresse }}</small></b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ meta -->
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card p-0">
                        <div class="card-body p-0">
                            <div class="profile-content">
                                <ul class="nav nav-underline nav-justified gap-0">
                                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#aboutme" type="button" role="tab" aria-controls="home"
                                            aria-selected="true" href="#aboutme">Profile</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" data-bs-target="#edit-profile"
                                            type="button" role="tab" aria-controls="home" aria-selected="true"
                                            href="#edit-profile"> Editer Profile</a></li>
                                    {{-- <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#user-activities" type="button" role="tab" aria-controls="home"
                                        aria-selected="true" href="#user-activities">Profile</a></li> --}}

                                    {{-- <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" data-bs-target="#projects"
                                        type="button" role="tab" aria-controls="home" aria-selected="true"
                                        href="#projects">Projects</a></li> --}}
                                </ul>

                                <div class="tab-content m-0 p-4">
                                    <div class="tab-pane active" id="aboutme" role="tabpanel" aria-labelledby="home-tab"
                                        tabindex="0">
                                        <div class="profile-desk">
                                            <h5 class="text-uppercase fs-17 text-dark">{{ strtoupper(Auth::user()->name) }}</h5>
                                            <div class="designation mb-4 ">Roles:
                                                <i class="text-info">{{ Auth::user()->roles[0]->name }}</i>
                                            </div>
                                            <p class="text-muted fs-16">
                                                {{ Auth::user()->aboutMe }}
                                            </p>

                                            <h5 class="mt-4 fs-17 text-dark">Contact Personnel</h5>
                                            <table class="table table-condensed mb-0 border-top">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">Email</th>
                                                        <td>
                                                            <a href="#" class="ng-binding">
                                                                {{ Auth::user()->email }}
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Phone</th>
                                                        <td class="ng-binding">{{ Auth::user()->phoneNumber }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Adresse</th>
                                                        <td>
                                                            <a href="#" class="ng-binding">
                                                                {{ Auth::user()->adresse }}
                                                            </a>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div> <!-- end profile-desk -->
                                    </div> <!-- about-me -->



                                    <!-- settings -->
                                    <div id="edit-profile" class="tab-pane">
                                        <div class="user-profile-content">
                                            <form method="POST" action="{{ route('users.update', Auth::user()->id) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row row-cols-sm-2 row-cols-1">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="Username">Nom</label>
                                                        <input type="text" value="{{ Auth::user()->name }}" id="name"
                                                            name="name" class="form-control">
                                                        @error('name')
                                                            <div
                                                                class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label" for="FullName">Nom Complet
                                                        </label>
                                                        <input type="text"
                                                            value="{{ Auth::user()->fullName ?? old('fullName') }}"
                                                            id="fullName" name="fullName" class="form-control">
                                                        @error('fullName')
                                                            <div
                                                                class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="Email">Email</label>
                                                        <input type="email" value="{{ Auth::user()->email }}" name="email"
                                                            id="email" class="form-control">
                                                        @error('email')
                                                            <div
                                                                class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="web-url">Numero Phone</label>
                                                        <input type="text"
                                                            value="{{ Auth::user()->phoneNumber ?? old('phoneNumber') }}"
                                                            id="phoneNumber" name="phoneNumber" class="form-control">

                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="Password">Password</label>
                                                        <input type="password" placeholder="6 - 15 Characters" id="password"
                                                            name="password" class="form-control">
                                                        @error('password')
                                                            <div
                                                                class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="RePassword">Re-Password</label>
                                                        <input type="password" placeholder="6 - 15 Characters"
                                                            id="password_confirmation" name="password_confirmation"
                                                            class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="Password">Photo Profile</label>
                                                        <input type="file" placeholder="" id="profilePath"
                                                            name="profilePath" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="RePassword">Adresse</label>
                                                        <input type="text" placeholder=""
                                                            value="{{ Auth::user()->adresse ?? old('adresse') }}"
                                                            id="adresse" name="adresse" class="form-control">
                                                    </div>
                                                    <div class="col-sm-12 mb-3">
                                                        <label class="form-label" for="AboutMe">A Propos de Moi
                                                            {{ Auth::user()->aboutMe }}</label>
                                                        <textarea style="height: 125px;" id="aboutMe" name="aboutMe" class="form-control">{{ Auth::user()->aboutMe ?? old('aboutMe') }}</textarea>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="ri-save-line me-1 lh-1"></i> Modifier</button>
                                            </form>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

        </div>
    @endcan
    @can('is_admin')
        <div class="card">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">Gestion des Utilisateurs</h4>
                            <p class="text-muted mb-0">
                                Listes des Utilisateurs
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-2 mb-2 mb-sm-0">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                        aria-orientation="vertical">
                                        <a class="nav-link active show" id="v-pills-home-tab" data-bs-toggle="pill"
                                            href="#v-pills-home" role="tab" aria-controls="v-pills-home"
                                            aria-selected="true">
                                            Utilisateurs
                                        </a>
                                        <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                            href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                                            aria-selected="false">
                                            Nouveau
                                        </a>
                                        <a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill"
                                            href="#v-pills-settings" role="tab" aria-controls="v-pills-settings"
                                            aria-selected="false">
                                            Profile
                                        </a>
                                    </div>
                                </div> <!-- end col-->

                                <div class="col-sm-9">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel"
                                            aria-labelledby="v-pills-home-tab">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="header-title">Utilisateurs Systeme</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive-sm">
                                                                <table class="table table-centered mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Name</th>
                                                                            <th>Phone Number</th>
                                                                            <th>Role</th>
                                                                            <th>Email</th>
                                                                            <th>Status</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($users as $item)
                                                                            @if ($item->isBanned == 0)
                                                                                <?php
                                                                                $color = 'text text-info';
                                                                                ?>
                                                                            @else
                                                                                <?php
                                                                                $color = 'text text-danger';
                                                                                ?>
                                                                            @endif
                                                                            <tr>
                                                                                <td>{{ $item->name }} -
                                                                                    {{ $item->fullName }}
                                                                                </td>
                                                                                <td>{{ $item->phoneNumber }}</td>
                                                                                <td class="text-info">
                                                                                    {{ $item->roles[0]->name }}</td>
                                                                                <td>{{ $item->email }}</td>
                                                                                <td class="{{ $color }}">
                                                                                    {{ $item->isBanned == 0 ? 'Active' : 'Banni' }}
                                                                                </td>
                                                                                <td>
                                                                                    <div class="row">
                                                                                        <a href="{{ route('users.edit', $item->id) }}"
                                                                                            title="Modifier"
                                                                                            class="col-4 btn btn-sm btn-primary"><i
                                                                                                class="ri-quill-pen-line"></i>
                                                                                        </a>
                                                                                        &nbsp;
                                                                                        <button
                                                                                            data-url="{{ route('users.destroy', $item->id) }}"
                                                                                            onclick="banned(this,'{{ $item->id }}')"
                                                                                            {{ $item->isBanned == 1 ? 'disabled' : '' }}
                                                                                            class="col-4 btn btn-sm btn-danger"
                                                                                            title="Supprimer"><i
                                                                                                class="ri-handbag-fill"></i></button>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->

                                                        </div> <!-- end card body-->
                                                    </div> <!-- end card -->
                                                </div><!-- end col-->


                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                            aria-labelledby="v-pills-profile-tab">
                                            <div class="card p-3 h4 text-info">
                                                Nouveau Utilisateur
                                            </div>
                                            <div class="user-profile-content card p-3">
                                                <form method="POST" action="{{ route('users.store') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="container mb-3">
                                                        <label for="">Utilisateur</label>
                                                        <select name="userId" id="" class="form-control">
                                                            <option value="">Selectionner Employee</option>
                                                            @foreach ($employees as $item)
                                                                <option value="{{ $item->employee_id }}">
                                                                    {{ $item->first_name }} {{ $item->last_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="Email">Email</label>
                                                        <input type="email" value="{{ old('email') }}" name="email"
                                                            id="email" class="form-control">
                                                        @error('email')
                                                            <div
                                                                class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    {{-- <div class="row row-cols-sm-2 row-cols-1">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="Username">Nom</label>
                                                                <input type="text" value="{{ old('name') }}" id="name"
                                                                    name="name" class="form-control">
                                                                @error('name')
                                                                    <div
                                                                        class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-2">
                                                                <label class="form-label" for="FullName">Nom Complet
                                                                </label>
                                                                <input type="text" value="{{ old('fullName') }}"
                                                                    id="fullName" name="fullName" class="form-control">
                                                                @error('fullName')
                                                                    <div
                                                                        class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="web-url">Numero Phone</label>
                                                                <input type="text" value="{{ old('phoneNumber') }}"
                                                                    id="phoneNumber" name="phoneNumber" class="form-control">

                                                            </div> --}}

                                                    <div class="mb-3">
                                                        <label class="form-label" for="Password">Password</label>
                                                        <input type="password" placeholder="6 - 15 Characters" id="password"
                                                            name="password" class="form-control">
                                                        @error('password')
                                                            <div
                                                                class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="RePassword">Re-Password</label>
                                                        <input type="password" placeholder="6 - 15 Characters"
                                                            id="password_confirmation" name="password_confirmation"
                                                            class="form-control">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label" for="Password">Photo Profile</label>
                                                        <input type="file" placeholder="" id="profilePath"
                                                            name="profilePath" class="form-control">
                                                    </div>
                                                    {{-- <div class="mb-2">
                                                        <label class="form-label" for="RePassword">Adresse</label>
                                                        <input type="text" placeholder="" value="{{ old('adresse') }}"
                                                            id="adresse" name="adresse" class="form-control">
                                                    </div> --}}
                                                    <div class="mb-6">
                                                        <label class="form-label" for="roles">Role</label>
                                                        <select name="roles" id="roles" class="form-control">
                                                            <option value="">Selectionner Role</option>
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->id }}">{{ $role->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-12 mt-2 mb-3">
                                                        <label class="form-label" for="AboutMe">A Propos de Moi
                                                            {{ old('aboutMe') }}</label>
                                                        <textarea style="height: 125px;" id="aboutMe" name="aboutMe" class="form-control">{{ Auth::user()->aboutMe ?? old('aboutMe') }}</textarea>
                                                    </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="ri-save-line me-1 lh-1"></i> Ajouter</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                        aria-labelledby="v-pills-settings-tab">

                                        <div class="row">

                                            <div class="col-sm-12">

                                                <div class="card p-0">

                                                    <div class="card-body p-0">


                                                        <div class="profile-content">
                                                            <ul class="nav nav-underline nav-justified gap-0">
                                                                <li class="nav-item"><a class="nav-link active"
                                                                        data-bs-toggle="tab" data-bs-target="#aboutme"
                                                                        type="button" role="tab" aria-controls="home"
                                                                        aria-selected="true" href="#aboutme">Profile</a>
                                                                </li>
                                                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                                                        data-bs-target="#edit-profile" type="button"
                                                                        role="tab" aria-controls="home"
                                                                        aria-selected="true" href="#edit-profile"> Editer
                                                                        Profile</a></li>
                                                                {{-- <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                                                        data-bs-target="#user-activities" type="button" role="tab" aria-controls="home"
                                                                        aria-selected="true" href="#user-activities">Profile</a></li> --}}

                                                                {{-- <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" data-bs-target="#projects"
                                                                        type="button" role="tab" aria-controls="home" aria-selected="true"
                                                                        href="#projects">Projects</a></li> --}}
                                                            </ul>

                                                            <div class="tab-content m-0 p-4">
                                                                <div class="tab-pane active" id="aboutme" role="tabpanel"
                                                                    aria-labelledby="home-tab" tabindex="0">
                                                                    <div class="profile-desk">
                                                                        <h5 class="text-uppercase fs-17 text-dark">
                                                                            {{ strtoupper(Auth::user()->name) }}</h5>
                                                                        <div class="designation mb-4 ">Roles:
                                                                            <i
                                                                                class="text-info">{{ Auth::user()->roles[0]->name }}</i>
                                                                        </div>
                                                                        <p class="text-muted fs-16">
                                                                            {{ Auth::user()->aboutMe }}
                                                                        </p>

                                                                        <h5 class="mt-4 fs-17 text-dark">Contact Personnel
                                                                        </h5>
                                                                        <table class="table table-condensed mb-0 border-top">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th scope="row">Email</th>
                                                                                    <td>
                                                                                        <a href="#" class="ng-binding">
                                                                                            {{ Auth::user()->email }}
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <th scope="row">Phone</th>
                                                                                    <td class="ng-binding">
                                                                                        {{ Auth::user()->phoneNumber }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="row">Adresse</th>
                                                                                    <td>
                                                                                        <a href="#" class="ng-binding">
                                                                                            {{ Auth::user()->adresse }}
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>

                                                                            </tbody>
                                                                        </table>
                                                                    </div> <!-- end profile-desk -->
                                                                </div> <!-- about-me -->



                                                                <!-- settings -->
                                                                <div id="edit-profile" class="tab-pane">
                                                                    <div class="user-profile-content">
                                                                        <form method="POST"
                                                                            action="{{ route('users.update', Auth::user()->id) }}"
                                                                            enctype="multipart/form-data">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="row row-cols-sm-2 row-cols-1">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label"
                                                                                        for="Username">Nom</label>
                                                                                    <input type="text"
                                                                                        value="{{ Auth::user()->name }}"
                                                                                        id="name" name="name"
                                                                                        class="form-control">
                                                                                    @error('name')
                                                                                        <div
                                                                                            class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="mb-2">
                                                                                    <label class="form-label"
                                                                                        for="FullName">Nom Complet
                                                                                    </label>
                                                                                    <input type="text"
                                                                                        value="{{ Auth::user()->fullName ?? old('fullName') }}"
                                                                                        id="fullName" name="fullName"
                                                                                        class="form-control">
                                                                                    @error('fullName')
                                                                                        <div
                                                                                            class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label class="form-label"
                                                                                        for="Email">Email</label>
                                                                                    <input type="email"
                                                                                        value="{{ Auth::user()->email }}"
                                                                                        name="email" id="email"
                                                                                        class="form-control">
                                                                                    @error('email')
                                                                                        <div
                                                                                            class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label class="form-label"
                                                                                        for="web-url">Numero Phone</label>
                                                                                    <input type="text"
                                                                                        value="{{ Auth::user()->phoneNumber ?? old('phoneNumber') }}"
                                                                                        id="phoneNumber" name="phoneNumber"
                                                                                        class="form-control">

                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label class="form-label"
                                                                                        for="Password">Password</label>
                                                                                    <input type="password" placeholder=""
                                                                                        id="password" name="password"
                                                                                        class="form-control">
                                                                                    @error('password')
                                                                                        <div
                                                                                            class="mt-2 alert alert-danger text-bg-info bg-warning border-0 fade show">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label class="form-label"
                                                                                        for="RePassword">Re-Password</label>
                                                                                    <input type="password" placeholder=""
                                                                                        id="password_confirmation"
                                                                                        name="password_confirmation"
                                                                                        class="form-control">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label class="form-label"
                                                                                        for="Password">Photo
                                                                                        Profile</label>
                                                                                    <input type="file" placeholder=""
                                                                                        id="profilePath" name="profilePath"
                                                                                        class="form-control">
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label class="form-label"
                                                                                        for="RePassword">Adresse</label>
                                                                                    <input type="text" placeholder=""
                                                                                        value="{{ Auth::user()->adresse ?? old('adresse') }}"
                                                                                        id="adresse" name="adresse"
                                                                                        class="form-control">
                                                                                </div>
                                                                                <div class="col-sm-12 mb-3">
                                                                                    <label class="form-label" for="AboutMe">A
                                                                                        Propos de Moi
                                                                                        {{ Auth::user()->aboutMe }}</label>
                                                                                    <textarea style="height: 125px;" id="aboutMe" name="aboutMe" class="form-control">{{ Auth::user()->aboutMe ?? old('aboutMe') }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                            <button class="btn btn-primary" type="submit"><i
                                                                                    class="ri-save-line me-1 lh-1"></i>
                                                                                Modifier</button>
                                                                        </form>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end tab-content-->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row-->
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        </div>
    @endcan
@endsection


@section('js_content')
    <script>
        function banned(th, id) {
            let url = $(th).attr('data-url');
            if (confirm('Voulez-vous Bannir')) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {

                    },

                });
            }
        }
    </script>
@endsection
