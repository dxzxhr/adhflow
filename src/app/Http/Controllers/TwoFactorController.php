<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    /** Страница с QR-кодом и формой ввода */
   public function show()
    {
        $google2fa = app('pragmarx.google2fa');
        $secret    = $google2fa->generateSecretKey();
    
        $otpUri = $google2fa->getQRCodeUrl(
            config('app.name'),
            Auth::user()->email,
            $secret
        );
    
        // ✅ новый URL
        $qr = 'https://quickchart.io/qr?size=200&text=' . urlencode($otpUri);
    
        session(['2fa_secret' => $secret]);
    
        return view('auth.2fa', compact('qr'));
    }


    /** Проверяем 6-значный код и сохраняем секрет */
    public function enable(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $google2fa = app('pragmarx.google2fa');
        $secret    = session('2fa_secret');

        if (! $google2fa->verifyKey($secret, $request->code)) {
            return back()->withErrors(['code' => 'Неверный код, попробуйте ещё раз']);
        }

        $request->user()->forceFill([
            'two_factor_secret' => encrypt($secret),
        ])->save();

        return redirect('/admin')->with('status', 'Двухфакторка включена');
    }
}
