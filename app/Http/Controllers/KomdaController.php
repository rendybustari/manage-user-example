<?php

namespace App\Http\Controllers;

use App\Services\GeneralService;
use App\Services\KomdaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KomdaController extends Controller
{
    private $generalService;
    private $komdaService;

    public function __construct(
        GeneralService $generalService,
        KomdaService $komdaService
    ) {
        $this->generalService = $generalService;
        $this->komdaService = $komdaService;
    }

    public function dashboard()
    {
        $data = [
            'users' => $this->komdaService->list(Auth::id())
        ];

        return view('komda.index', $data);
    }

    public function formAdd()
    {
        return view('komda.create');
    }

    public function add(Request $request)
    {
        $rules = [
            'username' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'fullname' => 'required',
            'phone' => 'required',
            'level' => 'required',
        ];

        $messages = [
            'username.required'     => 'Username wajib diisi',
            'username.unique'       => 'Username sudah terdaftar',
            'email.required'        => 'Email wajib diisi',
            'email.unique'          => 'Email sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
            'fullname.required'     => 'Nama Lengkap wajib diisi',
            'phone.required'        => 'No Handphone Lengkap wajib diisi',
            'level.required'  => 'Level Lengkap wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $statusCreateUser = $this->komdaService->create($request->all(), Auth::id());
        if ($statusCreateUser == false) {
            return redirect()->route('komdaDashboard')
                ->with('danger', 'Gagal menambahkan User baru');
        } else {
            return redirect()->route('komdaDashboard')
                ->with('success', 'Berhasil menambhkan User baru');
        }
    }

    public function formEdit($userID)
    {
        $user = $this->komdaService->findUser($userID);

        if (!$user) {
            return redirect()->route('komdaDashboard')
                ->with('danger', 'Data User tidak ditemukan');
        }
        $data = [
            'user' => $user,
            'provinces' => $this->generalService->provinces()
        ];
        return view('komda.edit', $data);
    }

    public function edit(Request $request, $userID)
    {
        $rules = [
            'fullname' => 'required',
            'phone' => 'required',
        ];

        $messages = [
            'fullname.required'     => 'Nama Lengkap wajib diisi',
            'phone.required'        => 'No Handphone Lengkap wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $statusUpdateUser = $this->komdaService->edit($request->all(), $userID);
        if ($statusUpdateUser == false) {
            return redirect()->route('komdaDashboard')
                ->with('danger', 'Gagal mengubah data Komda');
        } else {
            return redirect()->route('komdaDashboard')
                ->with('success', 'Berhasil mengubah data Komda');
        }
    }

    public function delete($userID)
    {
        $statusDeleteUser = $this->komdaService->delete($userID);
        if ($statusDeleteUser == false) {
            return redirect()->route('komdaDashboard')
                ->with('danger', 'Gagal menghapus data Komda');
        } else {
            return redirect()->route('komdaDashboard')
                ->with('success', 'Berhasil menghapus data Komda');
        }
    }
}
