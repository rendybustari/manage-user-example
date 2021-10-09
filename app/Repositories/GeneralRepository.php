<?php

namespace App\Repositories;

use App\Models\Province;

class GeneralRepository{

    public function provinces(){
        return Province::all();
    }

    public function province($provinceID){
        return Province::find($provinceID);
    }

}
