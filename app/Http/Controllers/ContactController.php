<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'message' => 'required|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Contact::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Votre message a bien été envoyé',
        ], 200);
    }
}
