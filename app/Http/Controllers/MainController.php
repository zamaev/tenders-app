<?php

namespace App\Http\Controllers;

use App\Models\Tenders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function register(Request $request)
    {
        $valid = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $user = User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user->api_token = explode('|', $user->createToken('Token')->plainTextToken)[1];;
        $user->save();

        Auth::login($user);

        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function update()
    {
        $path = storage_path('app/test_task_data.csv');
        $rows = $this->readCSV($path, ',');
        array_shift($rows);
        foreach ($rows as $row) {
            $tender = new Tenders();
            $tender->code = $row[0];
            $tender->number = $row[1];
            $tender->status = $row[2];
            $tender->name = $row[3];
            $tender->created_at = strtotime($row[4]);
            $tender->updated_at = strtotime($row[4]);
            $tender->save();
        }
        return redirect()->route('update');
    }

    public function readCSV($file, $delimiter)
    {
        $f = fopen($file, 'r');
        while (!feof($f)) {
            $line[] = fgetcsv($f, 0, $delimiter);
        }
        fclose($f);
        return $line;
    }
}
