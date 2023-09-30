<?php

namespace App\Http\Controllers;

use App\Models\TermsConditions;
use Illuminate\Http\Request;

class TermsConditionsController extends Controller
{
    public function createTermsConditions(Request $request){
        $user = $request->user();
        if($user->type == 'moderator' || $user->type == 'admin'){
            $fields = $request->validate([
                'terms_conditions' => 'string',
                'privacy_policy' => 'string',
                'shipping_policies' => 'string',
                'returns_policies' => 'string',
            ]);

            $termsConditions = TermsConditions::create([
                'terms_conditions' => $fields['terms_conditions'],
                'privacy_policy' => $fields['privacy_policy'],
                'shipping_policies' => $fields['shipping_policies'],
                'returns_policies' => $fields['returns_policies'],
            ]);
            return response()->json(['termsAndConditions' => $termsConditions]);
        }
        else{
            return response()->json(['message' => 'not authorized'],401);
        }
    }
    public function getTermsConditions(){
        $termsConditions = TermsConditions::get();
        return response()->json(['termsAndConditions' => $termsConditions]);
    }
    public function updateTermsConditions(Request $request , $id){
        $user = $request->user();
        if($user->type == 'moderator' || $user->type == 'admin'){
            $TermsConditions = TermsConditions::find($id);
            $fields = $request->validate([
                'terms_conditions' => 'string',
                'privacy_policy' => 'string',
                'shipping_policies' => 'string',
                'returns_policies' => 'string',
            ]);
            $TermsConditions->update($fields);
            return response()->json(['termsAndConditions' => $TermsConditions]);
        }
        else{
            return response()->json(['message' => 'not authorized'],401);
        }
    }
}
