<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use App\Models\Ujian;
use App\Models\User;
use App\Models\BankSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SoalsController extends Controller
{
    public function index()
    {
        $soals = Soal::with(['ujian', 'guru', 'bankSoal'])->get();
        $ujians = Ujian::all();
        $gurus = User::whereHas('role', function ($query) {
            $query->where('name', 'teacher');
        })->get();
        $bankSoals = BankSoal::all();

        return view('admin.teacher.soal.index', compact('soals', 'ujians', 'gurus', 'bankSoals'));
    }

    public function show($id)
    {
        $soal = Soal::with(['ujian', 'guru', 'bankSoal'])->findOrFail($id);
        return view('admin.teacher.soal.show', compact('soal'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->role->name !== 'teacher') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menambahkan soal.');
        }

        $validated = $request->validate([
            'ujian_id' => 'required|exists:ujians,id',
            'bank_soal_id' => 'nullable|exists:bank_soals,id',
            'pertanyaan' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'jawaban_benar' => 'required|in:A,B,C,D',
            'point' => 'required|integer|min:0',
        ]);

        $validated['guru_id'] = $user->id;

        function handleImages($htmlContent)
        {
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($htmlContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();

            $images = $dom->getElementsByTagName('img');
            foreach ($images as $key => $img) {
                $src = $img->getAttribute('src');
                if (strpos($src, 'data:image/') === 0) {
                    $data = base64_decode(explode(',', explode(';', $src)[1])[1]);
                    $image_name = "/upload/" . time() . $key . '.png';
                    file_put_contents(public_path() . $image_name, $data);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $image_name);
                }
            }

            return $dom->saveHTML();
        }

        $validated['pertanyaan'] = handleImages($request->pertanyaan);
        $validated['opsi_a'] = handleImages($request->opsi_a);
        $validated['opsi_b'] = handleImages($request->opsi_b);
        $validated['opsi_c'] = handleImages($request->opsi_c);
        $validated['opsi_d'] = handleImages($request->opsi_d);

        if ($validated['bank_soal_id']) {
            $bankSoal = BankSoal::find($validated['bank_soal_id']);
            $newTotalPoints = $bankSoal->total_poin + $validated['point'];

            if ($newTotalPoints > 100) {
                return redirect()->back()->with('warning', 'Total poin dalam Bank Soal ini telah melebihi batas maksimal 100 poin.');
            }

            $bankSoal->increment('total_poin', $validated['point']);
            $bankSoal->increment('total_soal');
        }

        $soal = Soal::create($validated);

        return redirect()->route('soals.index')->with('success', 'Soal berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if ($user->role->name !== 'teacher') {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit soal.');
        }

        $validated = $request->validate([
            'ujian_id' => 'required|exists:ujians,id',
            'bank_soal_id' => 'nullable|exists:bank_soals,id',
            'pertanyaan' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'jawaban_benar' => 'required|in:A,B,C,D',
            'point' => 'required|integer|min:0',
        ]);

        function handleImages($htmlContent)
        {
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($htmlContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();

            $images = $dom->getElementsByTagName('img');
            foreach ($images as $key => $img) {
                $src = $img->getAttribute('src');
                if (strpos($src, 'data:image/') === 0) {
                    $data = base64_decode(explode(',', explode(';', $src)[1])[1]);
                    $image_name = "/upload/" . time() . $key . '.png';
                    file_put_contents(public_path() . $image_name, $data);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $image_name);
                }
            }

            return $dom->saveHTML();
        }

        $validated['pertanyaan'] = handleImages($request->pertanyaan);
        $validated['opsi_a'] = handleImages($request->opsi_a);
        $validated['opsi_b'] = handleImages($request->opsi_b);
        $validated['opsi_c'] = handleImages($request->opsi_c);
        $validated['opsi_d'] = handleImages($request->opsi_d);

        $soal = Soal::findOrFail($id);

        if ($soal->bank_soal_id == $validated['bank_soal_id']) {
            $bankSoal = BankSoal::find($soal->bank_soal_id);
            $bankSoal->decrement('total_poin', $soal->point);
            $bankSoal->increment('total_poin', $validated['point']);
        } else {
            if ($soal->bank_soal_id) {
                $oldBankSoal = BankSoal::find($soal->bank_soal_id);
                $oldBankSoal->decrement('total_poin', $soal->point);
                $oldBankSoal->decrement('total_soal');
            }

            if ($validated['bank_soal_id']) {
                $newBankSoal = BankSoal::find($validated['bank_soal_id']);
                $newBankSoal->increment('total_poin', $validated['point']);
                $newBankSoal->increment('total_soal');
            }
        }

        $soal->update($validated);

        return redirect()->route('soals.index')->with('success', 'Soal berhasil diperbarui');
    }

    public function destroy($id)
    {
        $soal = Soal::findOrFail($id);

        $pointSoal = $soal->point;

        $bankSoal = BankSoal::findOrFail($soal->bank_soal_id);

        $bankSoal->total_poin -= $pointSoal;

        $bankSoal->save();

        $soal->delete();

        return redirect()->back()->with('success', 'Soal berhasil dihapus dan total point diperbarui.');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);

            $url = asset('uploads/' . $filename);
            return response()->json(['link' => $url]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
