<?php

namespace App\Http\Controllers;

use App\Mail\Notification;
use App\Model;
use App\Zip;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FormController extends Controller
{
    /**
     * @param null $slug
     * @return Application|Factory|RedirectResponse|View|void
     */
    public function index($slug = null)
    {
        // Redirect to form if some data not isset
        if(!$slug) {
            return redirect()->route('form', ['slug' => 'form']);
        } else if($slug === 'form') {
            Session::forget('data');
        } else if ($slug === 'form1') {
            if(!Session::has('data') || !Session::has('data.to') || !Session::has('data.from')) {
                return redirect()->route('form', ['slug' => 'form']);
            }
            Session::forget('data.vehicles');
        } else if ($slug === 'form2') {
            if(!Session::has('data') || !Session::has('data.to') || !Session::has('data.from')) {
                return redirect()->route('form', ['slug' => 'form']);
            } else if (!Session::has('data.vehicles')) {
                return redirect()->route('form', ['slug' => 'form1']);
            }
            Session::forget('data.trailer_type');
        } else if ($slug === 'form3') {
            if(!Session::has('data') || !Session::has('data.to') || !Session::has('data.from')) {
                return redirect()->route('form', ['slug' => 'form']);
            } else if (!Session::has('data.vehicles')) {
                return redirect()->route('form', ['slug' => 'form1']);
            } else if (!Session::has('data.date')) {
                return redirect()->route('form', ['slug' => 'form2']);
            }
            Session::forget('data.date');
        } else if ($slug === 'form4') {
            if(!Session::has('data') || !Session::has('data.to') || !Session::has('data.from')) {
                return redirect()->route('form', ['slug' => 'form']);
            } else if (!Session::has('data.vehicles')) {
                return redirect()->route('form', ['slug' => 'form1']);
            } else if (!Session::has('data.date')) {
                return redirect()->route('form', ['slug' => 'form2']);
            } else if (!Session::has('data.name') || !Session::has('data.email') || !Session::has('data.phone')) {
                return redirect()->route('form', ['slug' => 'form3']);
            }
            Session::forget('data.name');
            Session::forget('data.email');
            Session::forget('data.phone');
        } else if ($slug === 'form5') {
            /**
             * Send Email
             * ToDo query email
             */
            foreach (config('getcarrier.sendTo') as $recipient) {
                Mail::to($recipient)->send(new Notification(Session::get('data')));
            }
            Session::forget('data');
        }

        return view()->exists($slug ?? 'form') ? view($slug ?? 'form') : abort(404);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchZip(Request $request): JsonResponse
    {
        $search = $request->get('search');
        if(strlen($search) > 2) {
            // If zip or city contains in string
            $result = Zip::get()->filter(function($value) use ($search) {
                return (Str::contains($value->zip, $search) || Str::contains($value->city, Str::ucfirst($search)) || Str::contains($value->city, $search));
            })->take(5)->values()->toArray();
            return response()->json($result);
        } else {
            return response()->json([]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchMake(Request $request): JsonResponse
    {
        $search = $request->get('search');
        if(strlen($search) > 2) {
            // If model_make_id contains in string (in lowercase)
            $result = Model::get()->filter(function($value) use ($search) {
                return (Str::contains($value->model_make_id, Str::lower($search)) || Str::contains($value->model_make_id, $search));
            })->unique('model_make_id')->take(5)->values()->toArray();
            return response()->json($result);
        } else {
            return response()->json([]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchModel(Request $request): JsonResponse
    {
        $id = $request->get('id');
        // Get model_names by model_make_id sorted by model_name
        return response()->json(Model::get()->filter(function($value) use ($id) {
            return $value->model_make_id === $id;
        })->unique('model_name')->sortBy('model_name')->values()->toArray());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function request(Request $request): JsonResponse
    {
        $form = $request->get('form');
        $data = $request->get('data');
        if($form === 1) {
            // Validation
            $request->validate([
                'data.from' => 'required',
                'data.to' => 'required'
            ], [
                'data.from.required' => __('validation.required'),
                'data.to.required' => __('validation.required'),
            ], [
                'data.from' => 'Delivery From',
                'data.to' => 'Delivery To'
            ]);
            // Session put from and to
            Session::put('data.from', $data['from']);
            Session::put('data.to', $data['to']);
            return response()->json(['redirect' => 'form1']);
        } else if ($form === 2) {
            // Validation
            $request->validate([
                'data.vehicles.*.year' => 'required',
                'data.vehicles.*.make' => 'required',
                'data.vehicles.*.model' => 'required',
                'data.vehicles.*.run' => 'required'
            ], [
                'data.vehicles.*.year.required' => __('validation.required'),
                'data.vehicles.*.make.required' => __('validation.required'),
                'data.vehicles.*.model.required' => __('validation.required'),
                'data.vehicles.*.run.required' => __('validation.required')
            ], [
                'data.vehicles.*.year' => 'Year',
                'data.vehicles.*.make' => 'Make',
                'data.vehicles.*.model' => 'Model',
                'data.vehicles.*.run' => 'Run'
            ]);
            // Session put vehicles
            Session::put('data.vehicles', $data['vehicles']);
            return response()->json(['redirect' => 'form2']);
        } else if ($form === 3) {
            // Validation
            $request->validate([
                'data.trailer_type' => 'required'
            ], [
                'data.trailer_type.required' => __('validation.required')
            ], [
                'data.trailer_type' => 'Trailer Type'
            ]);
            // Session put trailer_type
            Session::put('data.trailer_type', $data['trailer_type']);
            return response()->json(['redirect' => 'form3']);
        } else if ($form === 4) {
            // Validation
            $request->validate([
                'data.date' => 'required'
            ], [
                'data.date.required' => __('validation.required')
            ], [
                'data.date' => 'Date'
            ]);
            Session::put('data.date', date("m/d/Y", strtotime($data['date'])));
            return response()->json(['redirect' => 'form4']);
        } else if ($form === 5) {
            // Validation
            $request->validate([
                'data.name' => 'required',
                'data.email' => 'required|email',
                'data.phone' => 'required'
            ], [
                'data.name.required' => __('validation.required'),
                'data.email.required' => __('validation.required'),
                'data.email.email' => __('validation.email'),
                'data.phone.required' => __('validation.required')
            ], [
                'data.name' => 'Name',
                'data.email' => 'Email',
                'data.phone' => 'Phone',
            ]);
            // Session put name, email and phone
            Session::put('data.name', $data['name']);
            Session::put('data.email', $data['email']);
            Session::put('data.phone', $data['phone']);
            return response()->json(['redirect' => 'form5']);
        }
    }
}
