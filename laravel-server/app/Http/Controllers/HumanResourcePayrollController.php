<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class HumanResourcePayrollController extends Controller
{
     public function payroll(Request $request)
    {
        $age = $request->age;
        $message = "Your age is: " . $age;

        return response()->json([
            'age' => $age,
            'message' => $message
        ]);
    }
}
