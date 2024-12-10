<?php

namespace App\Http\Controllers;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MedicineExport;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function exportExcel() 
     {
         return Excel::download(new MedicineExport, 'rekap-obat.xlsx');
     }
    public function index(Request $request)
    {
        //all() : mengambil semua data
        //orderby() : mengurutkan
        //ASC : A-Z, 0-9
        //DEC : z-a, 9-0
        //kalau ambil semua data tp ada proses filter sebelumnya, all nya ganti jadi get
        //simplepaginate() : memisahkan data dengan pagination, angka-5 meunjukkan jumlah data perhalaman
        //eloquent array assosiatif menggunakan first()

        //membuat stock agar bisa berurutan dari terkecil hingga terbsear
        $orderStock =  $request->short_stock ? 'stock' : 'name';
        $medicines = Medicine::where('name', 'LIKE' , '%' . $request->search_obat . '%')->orderby($orderStock , 'ASC')->simplepaginate(5)->appends($request->all());
        //compact(): mengirim data ke view (isinya sama dengan $)
        return view('medicine.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicine.create');
    }

    /**
     * Store a newly created resource in storage.
     * Request $request untuk
     */
    public function store(Request $request)
    {
       $request->validate([
           'name' => 'required|max:100',
           'type' => 'required|min:3',
           'price' => 'required|numeric',
           'stock' => 'required|numeric'
       ],[
        'name.required' => 'nama obat harus diisi',
        'name.max' => 'nama obat maximal 100 karakter',
        'type.required' => 'jenis obat harus diisi',
        'type.min' => 'jenis obat minimal 3',
        'price.required' => 'harga obat harus diisi',
        'price.numeric' => 'isi hanya angka',
        'stock.required' => 'stok obat harus diisi',
       ]);

       /**
       *create : elquem
       *'name' diambil dari migration $request->name : di inputan
       **/
       Medicine::create([
        'name' => $request->name,
        'type' => $request->type,
        'price' => $request->price,
        'stock' => $request->stock
       ]);

       /**
        * kembali ke halaman awal form dengan pesan
       */
       return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $medicine = Medicine::where('id' , $id)->first();
        return view('medicine.edit' , compact('medicine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price' => 'required',
        ]);
        Medicine::where('id' , $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
        ]);
        return redirect()->route('obat.data')->with('success', 'Data berhasil diubah');
    }

    public function updateStock(Request $request, $id){
        $dataSebelumnya = Medicine::where('id', $id)->first();
        if(isset($request->stock) == FALSE){
            return redirect()->back()->with([
                'failed' => 'Stock tidak boleh kosong',
                'id' => $id,
                'stock' => $dataSebelumnya->stock,
                ]);

        }
            //jika tidak kosong , langsung update stock
        Medicine::where('id', $id)->update([
        'stock' => $request->stock,
        ]);
        return redirect()->back()->with('success' , 'Berhasil mengupdate stock obat');
        }
    public function destroy($id)
    {
        $deleteData = Medicine::where('id' , $id)->delete();

        if($deleteData){
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } else{
            return redirect()->back()->with('error', 'Data gagal dihapus');
        }
    }
}
