<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CuponCode;

class CuponeController extends Controller
{
    public function showCupones() {
        //$cupones = CuponCode::all();
        //return view('admin.cupones', ['cupones' => $cupones]);
        return view('admin.cupones', ['cupones' => CuponCode::all()]);
    }
    public function checkCupone($code) {
        $cupon = CuponCode::where('code', $code)->firstOrFail();
    }
    public function addCupone(Request $request) {
        $cupon = CuponCode::create([
            'code' => 'XXXX',
            'discount' => 0.00,
            'added_on' => NOW()
        ]);

        return redirect('/dashboard/cupons/'.$cupon->id);
    }
    public function showCupone(Request $request) {

        return view('admin.cupone', ['cupone' => CuponCode::where('id', $request->idcup)->first()]);
    }
    public function updateCupon(Request $request) {
        $cupon = CuponCode::where('id', $request->idcup)->first();
        $input = $request->all();
        $cupon->code = $input['kodapopusta'];
        $cupon->discount = $input['diskont'];
        $cupon->expires = $input['expires'];
        $cupon->save();

        return redirect()->back()->with('success', '');
    }
    public function deleteCupon(Request $request) {
        $cupon = CuponCode::where('id', $request->idcup)->first();
        $cupon->delete();

        return redirect('/dashboard/cupons')->with('delete-alert', 'Kupon: '.$cupon->code .' je uspešno izbrisan!');
    }
}
