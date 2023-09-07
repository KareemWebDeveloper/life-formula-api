<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactMailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $formData = $request->all();

        // Validate and process the form data if needed

        Mail::to('kareemdeveloper24@gmail.com')->send(new ContactFormMail($formData));
        return response()->json(['message' => 'Email sent successfully'],200);
    }
}
