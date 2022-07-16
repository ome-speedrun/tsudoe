<?php

namespace App\Http\Controllers\Admin;

use App\Models\Administrator;
use Illuminate\Http\Request;

trait AuthenticateAdmin
{
    public function administrator(
        Request $request
    ): Administrator {
        return $request->user();
    }
}
