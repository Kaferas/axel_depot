<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use App\Models\Role;
use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

use function App\Helpers\allowedStore;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->where('id', '!=', Auth::user()->id)->get();
        $roles = Role::all();
        $depots = Depot::whereNull("has_gerant")->whereNull("has_caissier")->get();
        return view("profile/index", ['users' => $users, 'roles' => $roles, 'depots' => $depots]);
    }


    public function getDePot()
    {
        $role = $_POST['name'];
        if ($role == "ADMIN") {
            $depots = Depot::whereNull("has_gerant")->whereNull("has_caissier")->get();
        } else if ($role == "CAISSIER") {
            $depots = Depot::whereNull("has_caissier")->get();
        } else {
            $depots = Depot::whereNull("has_gerant")->get();
        }
        return response()->json($depots);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if (!empty($request->profilePath)) {
            $path = public_path('profiles/');
            !is_dir($path) &&
                mkdir($path, 0777, true);
            $imageName = time() . '.' . $request->profilePath->extension();
            $request->profilePath->move($path, $imageName);
        }

        if (Auth::user()->isAdmin()) {
            $user = DB::table('users')->insertGetId(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' =>  Hash::make($request->password),
                    'fullName' => $request->fullName,
                    'aboutMe' => $request->aboutMe,
                    'depot' => $request->depot,
                    'phoneNumber' => $request->phoneNumber,
                    'profilePath' =>  $imageName ?? '',
                    'adresse' => $request->adresse
                ]
            );
            if ($request->roles == 2) {
                Depot::where("id", $request->depot)->update(['has_caissier' => 1]);
            }
            RoleUser::create([
                'user_id' => $user,
                'role_id' => $request->roles,
            ]);
            Session::flash('success', "Utilisateur Cree avec Success");
        }
        return redirect()->route('users.index');
    }


    public function changeworkingYear()
    {
        $selectYearId = $_POST['id'];
        $currentYearName = $_POST['store'];
        session(['currentStore' => $selectYearId]);
        session(['currentYearName' => $currentYearName]);
        return Response::json(['status' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('profile.users.edit', ['user' => $user, 'roles' => $roles]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (!empty($request->profilePath)) {
            $path = public_path('profiles/');
            !is_dir($path) &&
                mkdir($path, 0777, true);
            $imageName = time() . '.' . $request->profilePath->extension();
            $request->profilePath->move($path, $imageName);
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => !empty($request->password) ? Hash::make($request->password) : $user->password,
            'fullName' => $request->fullName,
            'aboutMe' => $request->aboutMe,
            'phoneNumber' => $request->phoneNumber,
            'profilePath' => !empty($request->profilePath) ? $imageName : $user->profilePath,
            'adresse' => $request->adresse,
            'isBanned' => isset($request->banned) ? '1' : '0'
        ]);
        Session::flash('update', "Profile Mise a Jour");
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->update([
            'isBanned' => 1
        ]);
        Session::flash('success', "Utilisateur Banni");
        return redirect()->route("users.index");
    }
}
