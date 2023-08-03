<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PayloadController extends Controller
{
    public static function comparePayloads(Request $request)
    {
        // Get the payload from the request
        $payload = $request->input();

        // if there is no first_payload session variable, 
        // assign the payload into first_payload session variable
        // otherwise, assign the payload into second_payload session variable
        // then start comparsion and return difference
        if (!Session::has('first_payload')) {
            // Store the first payload in the session
            Session::put('first_payload', $payload);

            //promt users to send the second payload
            return response("Please send the second payload for checking difference");
        } else {
            // Store the second payload in the session
            Session::put('second_payload', $payload);

            // Compare the payloads and generate the output
            $differences = PayloadController::array_diff_assoc_recursive(Session::get('first_payload'), Session::get('second_payload'));

            //unset seesion variables
            Session::forget('first_payload');
            Session::forget('second_payload');

            //  if there is no difference between first and second payload,
            //  return no difference massges
            //  otherwise, return the differences
            if (empty($differences)) {
                return response("There is no difference");
            } else {
                // Return the differences as a JSON response
                return response()->json(['differences from old record' => $differences]);
            }
        }
    }


    
    /**
     * Find difference between two multi-dimensional array
     */
    public static function array_diff_assoc_recursive($array1, $array2) {
        $difference = array();
        foreach ($array1 as $key => $value) {
            if (is_array($value)) {
                if (!isset($array2[$key]) || !is_array($array2[$key])) {
                    $difference[$key] = $value;
                } else {
                    $recursive_diff = PayloadController::array_diff_assoc_recursive($value, $array2[$key]);
                    if (count($recursive_diff) > 0) {
                        $difference[$key] = $recursive_diff;
                    }
                }
            } elseif (!array_key_exists($key, $array2) || $array2[$key] !== $value) {
                $difference[$key] = $value;
            }
        }
        return $difference;
    }

}
