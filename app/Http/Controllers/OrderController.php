<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;
use App\Models\Medicine;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function exportExcel() 
    {
        return Excel::download(new OrderExport, 'rekap-pembelian.xlsx');
    }
    public function index(Request $request)
    {
        $search_day = $request->search_day ? $request->search_day . '%' : '%';
        $orders = Order::where('user_id', Auth::user()->id)->where('created_at', 'like', $search_day)->simplePaginate(5);
        return view("order.kasir.kasir", compact("orders"));
    }

    public function indexAdmin(Request $request)
    {
        $search_day = $request->search_day ? $request->search_day . '%' : '%';
        $orders = Order::with('user')->where('created_at', 'like', $search_day)->simplePaginate(5);
        return view("order.admin.data", compact("orders"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicines= Medicine::all();
        return view('order.kasir.form',compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi dara request
        $request->validate([
            'name_customer'=> 'required',
            'medicines'=> 'required',
        ]);

        //mencari values array yang datanya sama
        $arrayValues = array_count_values($request->medicines);
        //membuat array kosong untuk menampung nilai format array yang baru
        $arrayNewMedicines = [];
        //looping array data duplikat
        foreach($arrayValues as $key => $value){
            //Mencari data obat bedasarkan id yang dipilih
            $medicine = Medicine::where('id', $key)->first();
            //buat kondisi jika stok obat 
            if($medicine['stock'] < $value){
                $valueBefore = [
                    "name_costumer"=> $request->name_costumer,
                    "medicines" => $request->medicines
                ];
                $msg = 'stock obat' . $medicine['name_costumer'] . 'tidak mencukupi';
                return redirect()->back()->withInput()->with(['failed'=> $msg , "valuBefore" => $valueBefore]);
            }else{
                $medicine['stock'] -= $value;
                $medicine->save();
            }

            //Untuk mentotalkan Harga Medicine
            $totalPrice = $medicine['price'] * $value;
            //format membuat array baru (strukturnya)
            $arrayItem= [
                "id" => $key,
                "name_medicine" => $medicine['name'],
                "qty"=> $value,
                "price" => $medicine['price'],
                "total_price" => $totalPrice
            ];
            array_push($arrayNewMedicines, $arrayItem);
        }
        //Untuk menghitung total
        $total = 0;
        //looping data array dari array format baru
        foreach($arrayNewMedicines as $key => $value){
            //Mentotal price sebelum ppn dari medicine kedalam variabel total
            //$total += $item['totqal_price'];
            $total += $value['total_price'];
        }

        //merubaha total dikali dengan ppn sebesar 10%
        $ppn = $total + ($total * 0.1);

        //tambahkan result kedalam database order
        $orders = Order::create([
            'user_id' => Auth::user()->id,
            'medicines' => $arrayNewMedicines,
            'name_costumer' => $request->name_customer,
            'total_price' => $ppn
        ]);

        if($orders){
            //jika tambah orders berhasil, ambil data order berdasarkan kasir yang sedang login (where),
            //dengan tanggal paling baru (orderby), ambil hanya satu data(first)
            $result = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
            return redirect()->route('pembelian.print', $result['id'])->with('success', 'Data berhasil ditambahkan');
        }else{
            return redirect()->back()->with('failed', 'Data gagal ditambahkan');
        }

    }

    /**
     * Display the specified resource.
     */
        public function show(order $order, $id)
        {
        $orders = Order::where('id', $id)->first();
            $medicines = Medicine::all();
            return view('order.kasir.print', compact('orders', 'medicines'));
        }

        public function user(order $order)
        {
            return $this->belongsTo(User::class);
        }

        public function order()
        {
            return $this->hasMany(Order::class);
        }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order)
    {
        //
    }

    public function downloadPDF($id){
        //ambil data order berdasarkan id
        $order = Order::where('id',$id)->first()->toArray();
        //nama variabel yg akan digunakan di pdf
        view()->share('orders', $order);
        //panggil file blade yg akan di ubah menjadi pdf
        $pdf = PDF::loadView('order.kasir.pdf', $order);
        //proses download dan nama filenya 
        return $pdf->download('struk-pembelian.pdf');
    }
}
