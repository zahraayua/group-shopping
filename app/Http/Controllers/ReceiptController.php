<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Receipt;
use App\Models\ShoppingList; // Menggunakan model ShoppingList untuk menyimpan item hasil OCR

class ReceiptController extends Controller
{
    private function checkAdmin($groupId)
{
    $isAdmin = Group::findOrFail($groupId)
        ->members()
        ->where('user_id', auth()->id())
        ->wherePivot('role', 'admin')
        ->exists();

    abort_unless($isAdmin, 403, 'Hanya admin yang dapat melakukan aksi ini.');
}
    public function create(Request $request)
{
    $this->checkAdmin($request->group);

    return view(
        'receipts.create',
        [
            'groupId' => $request->group
        ]
    );
}

   public function store(Request $request)
{
    // Validasi
    $request->validate([
        'group_id' => 'required',
        'image' => 'required|image|mimes:jpg,jpeg,png|max:5120'
    ]);

    $this->checkAdmin($request->group_id);

    // Upload gambar
    $image = $request->file('image');
    $imageName = time() . '.' . $image->extension();

    $image->move(
        public_path('uploads/receipts'),
        $imageName
    );

    $fullImagePath = public_path('uploads/receipts/' . $imageName);

    // Simpan receipt
    $receipt = Receipt::create([
        'group_id' => $request->group_id,
        'image' => $imageName
    ]);

    try {

        // OCR menggunakan Tesseract
        $output = shell_exec(
            '"C:\Program Files\Tesseract-OCR\tesseract.exe" "'
            . $fullImagePath .
            '" stdout -l ind+eng 2>&1'
        );

        // Simpan hasil OCR mentah
        $receipt->update([
            'ocr_text' => $output
        ]);

        $lines = explode("\n", $output);

        foreach ($lines as $line) {

            $line = trim($line);

            if ($line == '') {
                continue;
            }

            // Lewati tulisan yang bukan barang
            if (preg_match(
                '/TOTAL|NON TUNAI|PPN|VC |HARGA JUAL|LAYANAN|KONTAK|BELANJA|ONGKIR|Estimating|CALL|BCA|DPP|KAB |JL |GBA|RISMA|PURCHASE/i',
                $line
            )) {
                continue;
            }

            preg_match_all('/\d[\d,.]*/', $line, $angka);

            if (count($angka[0]) < 2) {
                continue;
            }

            $qty = (int) $angka[0][0];

            $harga = (int) str_replace(
                ['.', ','],
                '',
                end($angka[0])
            );

            $nama = preg_replace(
                '/\s+\d.*$/',
                '',
                $line
            );

            if (
                strlen($nama) < 4 ||
                $harga < 100
            ) {
                continue;
            }

            ShoppingList::create([

                'group_id' => $request->group_id,

                'item_name' => $nama,

                'quantity' => $qty,

                'estimated_price' => $harga,

                'is_checked' => true

            ]);

        }

        $statusMessage = 'Struk berhasil dipindai dan daftar belanja berhasil dibuat.';

    } catch (\Exception $e) {

        \Log::error('OCR Error: ' . $e->getMessage());

        $statusMessage = 'Struk berhasil diupload, tetapi OCR gagal diproses.';
    }

    return redirect()
        ->route('groups.show', $request->group_id)
        ->with('success', $statusMessage);
}

    /**
     * Menampilkan pratinjau gambar struk secara penuh (Melihat Struk)
     */
    public function show(Receipt $receipt)
    {
        return view('receipts.show', compact('receipt'));
    }

    /**
     * Menghapus struk dari database beserta berkas gambarnya di server (FIXED)
     */
   public function destroy($id)
{
    try {
        // 1. Cari data struk berdasarkan ID
        $receipt = Receipt::findOrFail($id);
        $this->checkAdmin($receipt->group_id);

        // 2. Dapatkan path file gambar yang tersimpan di public
        $imagePath = public_path('uploads/receipts/' . $receipt->image);

        // 3. Hapus file fisik gambar dari storage jika ada
        if (\File::exists($imagePath)) {
            \File::delete($imagePath);
        }

        // 4. BARIS YANG BIKIN ERROR DIHAPUS/DI-KOMENTAR
        // ShoppingList::where('receipt_id', $receipt->id)->delete();

        // 5. Hapus baris data struk dari database secara permanen
        $receipt->delete();

        return redirect()->back()->with('success', 'Struk berhasil dihapus dari database.');
    } catch (\Exception $e) {
        \Log::error('Delete Receipt Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Gagal menghapus struk: ' . $e->getMessage());
    }
}
}