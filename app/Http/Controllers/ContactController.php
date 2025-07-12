<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        // Kirim email (opsional, bisa dinonaktifkan saat dev)
        try {
            Mail::raw("Pesan dari: {$validated['name']} ({$validated['email']})\n\n" . $validated['message'], function ($message) use ($validated) {
                $message->to('warunggitar01@gmail.com') // Email penerima
                        ->subject('Pesan Baru dari Form Kontak');
            });
        } catch (\Exception $e) {
            // Log atau abaikan error email jika tidak penting
            logger()->error('Gagal mengirim email kontak: ' . $e->getMessage());
        }

        // Redirect kembali dengan notifikasi sukses
        return redirect()->route('contact')->with('success', 'Pesan Anda berhasil dikirim!');
    }
}
