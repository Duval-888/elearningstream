<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'certificate_number',
        'issued_at',
        'file_path',
        'final_score'
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($certificate) {
            if (empty($certificate->certificate_number)) {
                $certificate->certificate_number = 'CERT-' . strtoupper(Str::random(8));
            }
            if (empty($certificate->issued_at)) {
                $certificate->issued_at = now();
            }
        });
    }

    /**
     * Get the user that owns the certificate
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course that owns the certificate
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get download URL
     */
    public function getDownloadUrlAttribute()
    {
        return route('certificate.download', $this->id);
    }

    /**
     * Generate certificate file
     */
    public function generateFile()
    {
        // Logic to generate PDF certificate
        // This would integrate with a PDF library like TCPDF or DomPDF
    }
}