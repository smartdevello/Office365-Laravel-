<?php
namespace App\Model;


class TokenCache {
    public function storeTokens($response){
        $response = json_decode($response);

        session()->put('token_type', $response->token_type);
        session()->put('expires_in', $response->expires_in + time());
        session()->put('ext_expires_in', $response->ext_expires_in);
        session()->put('access_token', $response->access_token);

    }
    public function clearTokens() {

        session()->forget('token_type');
        session()->forget('expires_in');
        session()->forget('ext_expires_in');
        session()->forget('access_token');
    }

    public function getAccessToken(){

        $need_refresh = false;
        if (!session()->has('access_token') ||
            !session()->has('expires_in')) {
            $need_refresh = true;

        }

        $now = time() + 300;
        if (session('expires_in') <= $now) {

            $need_refresh = true;

        }

        if ($need_refresh){
            $curl = curl_init();

            $client_id = env('Azure_ClientID');
            $client_secret = env('Azure_ClientSecret');

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://login.microsoftonline.com/'. env('Azure_TenantID').'/oauth2/v2.0/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'grant_type=client_credentials&client_id='.$client_id.'&client_secret='. $client_secret .'&scope=https%3A%2F%2Fgraph.microsoft.com%2F.default',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded',
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $this->storeTokens($response);

        }
        return session('access_token');
    }
}
?>

