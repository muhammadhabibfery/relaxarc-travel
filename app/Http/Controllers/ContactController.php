<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * show contact form
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.frontend.contact');
    }

    /**
     * send an email to the user who filled out the form
     *
     * @param  \App\Http\Requests\ContactRequest $request
     * @return \Illuminate\Http\Response
     */
    public function sendMail(ContactRequest $request)
    {
        $data = $request->validated();

        try {
            Mail::raw($data['message'], function ($message) use ($data) {
                $message->from($data['email'])
                    ->to(config('mail.from.address'))
                    ->subject('From Contact Page');
            });

            return back()->with('status', trans('Thank you, the email has been sent'))
                ->with('color', 'success');
        } catch (\Exception $e) {
            return back()->with('status', trans('Sorry, the email failed to send. Please try again'))
                ->with('color', 'danger');
        }
    }
}
