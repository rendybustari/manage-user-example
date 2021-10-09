<?php

namespace App\Repositories;

use App\Models\MemberArea;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository{

    public function createKomda($data){
        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $data['username'];
            $user->email = $data['email'];
            $user->password = $data['password'];
            $user->role_id = User::ROLE_KOMDA;
            $user->save();

            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->fullname = $data['fullname'];
            $profile->phone_number = $data['phone'];
            $profile->save();

            $memberArea = new MemberArea();
            $memberArea->user_id = $user->id;
            $memberArea->province_id = $data['area'];
            $memberArea->save();

            DB::commit();
            $success = true;
        } catch (\Exception $e) {

            DB::rollback();
            $success = false;
        }

        return $success;
    }

    public function listKomda(){
        return User::select('users.id','users.name','users.email','member_profiles.fullname','member_profiles.phone_number','member_areas.province_id')
                    ->join('member_profiles','member_profiles.user_id','users.id')
                    ->join('member_areas','member_areas.user_id','users.id')
                    ->where('users.role_id',User::ROLE_KOMDA)
                    ->get();
    }

    public function editKomda($data,$userID){

        $user = $this->findUser($userID);

        if(!$user){
            return false;
        }

        try {
            DB::beginTransaction();
            $profile = Profile::where('user_id',$userID)->first();
            $profile->fullname = $data['fullname'];
            $profile->phone_number = $data['phone'];
            $profile->save();

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            $success = false;
        }

        return $success;
    }

    public function findUser($userID){
        return User::select('users.id','users.name','users.email','member_profiles.fullname','member_profiles.phone_number','member_areas.province_id')
                    ->join('member_profiles','member_profiles.user_id','users.id')
                    ->join('member_areas','member_areas.user_id','users.id')
                    ->where('users.id',$userID)
                    ->first();
    }

    public function findUserArea($userID){
        return MemberArea::where('user_id',$userID)->first();
    }

    public function deleteUser($userID){
        $user = $this->findUser($userID);

        if(!$user){
            return false;
        }

        $user->delete();
        return true;
    }

    public function createDapendPengurus($data, $areaID){
        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $data['username'];
            $user->email = $data['email'];
            $user->password = $data['password'];
            $user->role_id = $data['level'];
            $user->save();

            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->fullname = $data['fullname'];
            $profile->phone_number = $data['phone'];
            $profile->save();

            $memberArea = new MemberArea();
            $memberArea->user_id = $user->id;
            $memberArea->province_id = $areaID;
            $memberArea->save();

            DB::commit();
            $success = true;
        } catch (\Exception $e) {

            DB::rollback();
            $success = false;
        }

        return $success;
    }

    public function listDapendPengurus($province_id){
        return User::select('users.id','users.name','users.email','users.role_id','member_profiles.fullname','member_profiles.phone_number','member_areas.province_id')
                    ->join('member_profiles','member_profiles.user_id','users.id')
                    ->join('member_areas','member_areas.user_id','users.id')
                    ->where('member_areas.province_id',$province_id)
                    ->whereIn('users.role_id',[User::ROLE_DAPEN,User::ROLE_PENGURUS])
                    ->get();
    }

    public function listDapen($province_id){
        return User::select('users.id','users.name','users.email','member_profiles.fullname','member_profiles.phone_number','member_areas.province_id')
                    ->join('member_profiles','member_profiles.user_id','users.id')
                    ->join('member_areas','member_areas.user_id','users.id')
                    ->where('member_areas.province_id',$province_id)
                    ->where('users.role_id',User::ROLE_DAPEN)
                    ->get();
    }

    public function createDapen($data, $areaID){
        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $data['username'];
            $user->email = $data['email'];
            $user->password = $data['password'];
            $user->role_id = User::ROLE_DAPEN;
            $user->save();

            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->fullname = $data['fullname'];
            $profile->phone_number = $data['phone'];
            $profile->save();

            $memberArea = new MemberArea();
            $memberArea->user_id = $user->id;
            $memberArea->province_id = $areaID;
            $memberArea->save();

            DB::commit();
            $success = true;
        } catch (\Exception $e) {

            DB::rollback();
            $success = false;
        }

        return $success;
    }
}
