<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $orders = Order::where('user_id', Auth::user()->id)->simplePaginate(5);
        return view('order.kasir.kasir', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $medicines =Medicine::all();
        return view("order.kasir.create" , compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      //
      $request->validate([
        'name_customer' => 'required|max:100',
        'medicines' => 'required'
    ], [
        'name_customer.required' => 'Nama harus diisi',
        'medicines.required' => 'Obat harus diisi'
    ]);
    // mencari values array yang datanya sama
    // array_count_values digunakan untuk menghitung value yang terdapat di array
    $arrayValues = array_count_values($request->medicines);
    $arrayNewMedicines = [];
    foreach ($arrayValues as $key => $value) 
    {
        $medicine = Medicine::where('id', $key)->first();
        $jumlah_total = $medicine['price'] * $value;

        if($medicine['stock'] < $value) {
            $valueFormBefore = [
                'name_customer' => $request->name_customer,
                'medicines' => $request->medicines
            ];
            $msg = 'Stok Obat' . $medicine['name'] . 'Tidak Cukup.Tersisa' . $medicine ['stock'];
            return redirect()->back()->with([
                'failed' => $msg,
                'valueFormBefore' => $valueFormBefore
            ]);
        } 
        $arrayItem = [
            'id' => $key,
            'name_medicine' => $medicine['name'],
            'qty' => $value,
            'price' => $medicine['price'],
            'total_price' => $jumlah_total
        ];

        array_push($arrayNewMedicines, $arrayItem);
    }

    $total= 0;
    foreach ($arrayNewMedicines as $item){
        $total += (int)$item['total_price'];
    }

    $ppn = $total + ($total * 0.1);

    $neworders = Order::create([
        'user_id' => auth()->user()->id,
        'medicines' => $arrayNewMedicines,
        'name_customer' => $request->name_customer,
        'total_price' => $ppn,
    ]);

    foreach ($arrayNewMedicines as $key => $value) {
        $stockBefore = Medicine::where('id', $value['id'])->value('stock');
        Medicine::where('id', $value['id'])->update([
            'stock' => $stockBefore - $value['qty']
        ]);
    }

    if ($neworders) {
        // jika tambah order berhasil maka ambil data berdasarkan kasir yang sedang login menggunakan where, dengan tanggal paling baru (OrderBy), ambil hanya satu data mengguanakn (first)


        return redirect()->route('kasir.print', $neworders['id'])->with('success', 'Berhasil Order!');
        return redirect()->route('kasir.print', $neworders['id'])->with('success', 'Berhasil Order!');
    } else {
        return redirect()->back()->with('failed', 'Gagal Menambah Order!');
    }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $order = Order::find($id);
        return view('order.kasir.print', compact('order'));
    }

    public function downloadPDF($id)
    {
        $order = Order::where('id', $id)->first()->toArray();
        view()->share('order', $order);
        $pdf = Pdf::loadView('order.kasir.cetak-pdf', $order);
        return $pdf->download('struk-pembelian.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
