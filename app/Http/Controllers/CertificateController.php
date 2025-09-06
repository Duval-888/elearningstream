<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Download certificate
     */
    public function download(Certificate $certificate)
    {
        $user = auth()->user();

        // Check if user owns the certificate or is admin
        if ($certificate->user_id !== $user->id && !$user->isAdmin()) {
            abort(403, 'Vous n\'êtes pas autorisé à télécharger ce certificat.');
        }

        // If file doesn't exist, generate it
        if (!$certificate->file_path || !Storage::exists($certificate->file_path)) {
            $this->generateCertificate($certificate);
        }

        return Storage::download($certificate->file_path, 
            "Certificat_{$certificate->certificate_number}.pdf");
    }

    /**
     * Generate certificate PDF
     */
    private function generateCertificate(Certificate $certificate)
    {
        // This is a simplified version - you would integrate with a PDF library
        // like TCPDF, DomPDF, or similar to generate actual certificates
        
        $content = "
        CERTIFICAT DE RÉUSSITE
        
        Ceci certifie que {$certificate->user->name}
        a terminé avec succès le cours
        '{$certificate->course->title}'
        
        Délivré le: {$certificate->issued_at->format('d/m/Y')}
        Numéro de certificat: {$certificate->certificate_number}
        ";

        $filename = "certificates/certificate_{$certificate->certificate_number}.txt";
        Storage::put($filename, $content);
        
        $certificate->update(['file_path' => $filename]);
    }

    /**
     * Issue certificate for completed course
     */
    public function issue(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'final_score' => 'nullable|numeric|min:0|max:100'
        ]);

        // Check if certificate already exists
        $existingCertificate = Certificate::where('user_id', $validated['user_id'])
                                        ->where('course_id', $validated['course_id'])
                                        ->first();

        if ($existingCertificate) {
            return back()->with('error', 'Un certificat a déjà été délivré pour ce cours.');
        }

        $certificate = Certificate::create($validated);

        return back()->with('success', 'Certificat délivré avec succès!');
    }
}