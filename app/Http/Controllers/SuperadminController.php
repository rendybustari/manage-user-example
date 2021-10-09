<?php

namespace App\Http\Controllers;

use App\Services\GeneralService;
use App\Services\SuperadminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuperadminController extends Controller
{
    private $generalService;
    private $superadminService;

    public function __construct(
        GeneralService $generalService,
        SuperadminService $superadminService
    ) {
        $this->generalService = $generalService;
        $this->superadminService = $superadminService;
    }

    public function dashboard()
    {
        $data = [
            'users' => $this->superadminService->list()
        ];

        return view('dashboard.index',$data);
    }

    public function formAdd()
    {
        $data = [
            'provinces' => $this->generalService->provinces()
        ];

        return view('dashboard.create', $data);
    }

    public function add(Request $request)
    {
        $rules = [
            'username' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'fullname' => 'required',
            'phone' => 'required',
            'area' => 'required',
        ];

        $messages = [
            'username.required'     => 'Username wajib diisi',
            'username.unique'       => 'Username sudah terdaftar',
            'email.required'        => 'Email wajib diisi',
            'email.unique'          => 'Email sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
            'fullname.required'     => 'Nama Lengkap wajib diisi',
            'phone.required'        => 'No Handphone Lengkap wajib diisi',
            'area.required'  => 'Wilayah Lengkap wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $statusCreateUser = $this->superadminService->create($request->all());
        if ($statusCreateUser == false) {
            return redirect()->route('superadminDashboard')
                ->with('danger', 'Gagal menambahkan Komda baru');
        } else {
            return redirect()->route('superadminDashboard')
                ->with('success', 'Berhasil menambhkan Komda baru');
        }
    }

    public function formEdit($userID){
        $user = $this->superadminService->findUser($userID);

        if(!$user){
            return redirect()->route('superadminDashboard')
                ->with('danger', 'Data User tidak ditemukan');
        }
        $data = [
            'user' => $user,
            'provinces' => $this->generalService->provinces()
        ];
        return view('dashboard.edit', $data);

    }

    public function edit(Request $request, $userID){
        $rules = [
            'fullname' => 'required',
            'phone' => 'required',
            'area' => 'required',
        ];

        $messages = [
            'fullname.required'     => 'Nama Lengkap wajib diisi',
            'phone.required'        => 'No Handphone Lengkap wajib diisi',
            'area.required'  => 'Wilayah Lengkap wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $statusUpdateUser = $this->superadminService->edit($request->all(), $userID);
        if ($statusUpdateUser == false) {
            return redirect()->route('superadminDashboard')
                ->with('danger', 'Gagal mengubah data Komda');
        } else {
            return redirect()->route('superadminDashboard')
                ->with('success', 'Berhasil mengubah data Komda');
        }
    }

    public function delete($userID){
        $statusDeleteUser = $this->superadminService->delete($userID);
        if ($statusDeleteUser == false) {
            return redirect()->route('superadminDashboard')
                ->with('danger', 'Gagal menghapus data Komda');
        } else {
            return redirect()->route('superadminDashboard')
                ->with('success', 'Berhasil menghapus data Komda');
        }
    }
}
