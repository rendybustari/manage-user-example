<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\GeneralRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class KomdaService
{
    private $generalRepository;
    private $userRepository;

    public function __construct(
        GeneralRepository $generalRepository,
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
        $this->generalRepository = $generalRepository;
    }

    public function create($data,$userID)
    {
        $data['password'] = Hash::make($data['password']);
        $area = $this->userRepository->findUserArea($userID);
        return $this->userRepository->createDapendPengurus($data,$area->province_id);
    }

    public function list($userID)
    {
        $area = $this->userRepository->findUserArea($userID);
        $data = $this->userRepository->listDapendPengurus($area->province_id);

        return $data->map(function ($item) {
            $level = "DAPEN";
            if($item->role_id == User::ROLE_PENGURUS){
                $level = "PENGURUS";
            }
            return [
                'id' => $item->id,
                'name' => $item->name,
                'email' => $item->email,
                'fullname' => $item->fullname,
                'phone_number' => $item->phone_number,
                'level' => $level
            ];
        });
    }

    public function findUser($userID){
        return $this->userRepository->findUser($userID);
    }

    public function edit($data, $userID){
        return $this->userRepository->editKomda($data, $userID);
    }

    public function delete($userID){
        return $this->userRepository->deleteUser($userID);
    }
}
