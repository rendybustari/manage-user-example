<?php

namespace App\Http\Controllers;

use App\Services\GeneralService;
use App\Services\PengurusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class pengurusController extends Controller
{
    private $generalService;
    private $pengurusService;

    public function __construct(
        GeneralService $generalService,
        PengurusService $pengurusService
    ) {
        $this->generalService = $generalService;
        $this->pengurusService = $pengurusService;
    }

    public function dashboard()
    {
        $data = [
            'users' => $this->pengurusService->list(Auth::id())
        ];

        return view('pengurus.index', $data);
    }

    public function formAdd()
    {
        return view('pengurus.create');
    }

    public function add(Request $request)
    {
        $rules = [
            'username' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'fullname' => 'required',
            'phone' => 'required'
        ];

        $messages = [
            'username.required'     => 'Username wajib diisi',
            'username.unique'       => 'Username sudah terdaftar',
            'email.required'        => 'Email wajib diisi',
            'email.unique'          => 'Email sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
            'fullname.required'     => 'Nama Lengkap wajib diisi',
            'phone.required'        => 'No Handphone Lengkap wajib diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $statusCreateUser = $this->pengurusService->create($request->all(), Auth::id());
        if ($statusCreateUser == false) {
            return redirect()->route('pengurusDashboard')
                ->with('danger', 'Gagal menambahkan User baru');
        } else {
            return redirect()->route('pengurusDashboard')
                ->with('success', 'Berhasil menambhkan User baru');
        }
    }

    public function formEdit($userID)
    {
        $user = $this->pengurusService->findUser($userID);

        if (!$user) {
            return redirect()->route('pengurusDashboard')
                ->with('danger', 'Data User tidak ditemukan');
        }
        $data = [
            'user' => $user,
            'provinces' => $this->generalService->provinces()
        ];
        return view('pengurus.edit', $data);
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

        $statusUpdateUser = $this->pengurusService->edit($request->all(), $userID);
        if ($statusUpdateUser == false) {
            return redirect()->route('pengurusDashboard')
                ->with('danger', 'Gagal mengubah data pengurus');
        } else {
            return redirect()->route('pengurusDashboard')
                ->with('success', 'Berhasil mengubah data pengurus');
        }
    }

    public function delete($userID)
    {
        $statusDeleteUser = $this->pengurusService->delete($userID);
        if ($statusDeleteUser == false) {
            return redirect()->route('pengurusDashboard')
                ->with('danger', 'Gagal menghapus data pengurus');
        } else {
            return redirect()->route('pengurusDashboard')
                ->with('success', 'Berhasil menghapus data pengurus');
        }
    }
}
