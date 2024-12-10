<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;


class UserController extends Controller
{
    public function exportExcel() 
    {
        return Excel::download(new UserExport, 'rekap-user.xlsx');
    }
    public function index(Request $request)
    {
        //compact(): mengirim data ke view (isinya sama dengan $)
        $users = User::where('name', 'LIKE' , '%' . $request->search_user . '%')->orderby('name' , 'ASC')->simplepaginate(7)->appends($request->all());
        return view('user.index', compact('users'));
    }

    public function ShowLogin(){
        return view('pages.login');
    }

    public function loginAuth(Request $request){
        $request ->validate([
            'email' => 'required',
            'password' => 'required',
            ]);

            $users = $request->only(['email', 'password']);
            if (Auth::attempt($users)) {
                return redirect()->route('landing_page')->with('success', 'Login berhasil.');
            } else {
                return redirect()->back()->with('failed', 'Login gagal');
            }
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect()->route('login.auth')->with('success', 'Logout Berhasil');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'nullable',
            'role' => 'required',
        ]);
        // Cek apakah
        $password = $request->password;
        // Buat user baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->$password),
            'role' => $request->role,  // Pastikan role ada di request
        ]);
    
        return redirect()->route('user.login')->with('success', 'Akun berhasil dibuat.');
    }
    


    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $users = User::findOrFail($id); // Gunakan findOrFail untuk mengecek ada ga $id
        return view('user.edit', compact('users'));
    }
    
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=> 'required',
            'email'=> 'required',
            'role'=> 'required',
            ]);
            User::findOrFail ($id)->update([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=> bcrypt($request->password),
                'role'=> $request->role,
                ]);
                return redirect()->route('user.login')->with('success', 'Data berhasil diubah');

    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteData = User::where('id' , $id)->delete();

        if($deleteData){
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } else{
            return redirect()->back()->with('error', 'Data gagal dihapus');
        }
    }
}
