<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use GuzzleHttp\Client as HttpClient;
use App\Helpers\Shopify as ShopifyHelper;

class Auth extends Controller
{
    public function index(Request $request)
    {
        $config = config('shopify');

        // Auth request
        if ($request->query('code')) {

            // Check state
            if ($request->query('state' !== $this->nonce($request->query('shop')))) {
                return abort(403, 'Invalid request');
            }

            // Find shop
            $shop = Shop::firstOrNew([
                'domain' => $request->query('shop')
            ]);

            // Get access token
            $httpClient = new HttpClient;
            $postData = [
                'client_id' => $config['key'],
                'client_secret' => $config['secret'],
                'code' => $request->query('code')
            ];

            try {

                // Get token
                $response = $httpClient->request('POST', 'https://'.$request->query('shop').'/admin/oauth/access_token', [
                    'form_params' => $postData
                ]);

                $token = json_decode($response->getBody());

                // Save token to shop
                $shop->access_token = $token->access_token;
                $shop->scope = $token->scope;
                $shop->save();

                // Redirect back to shopify
                return redirect('https://'.$request->query('shop').'/admin/apps/'.$config['app_slug']);

            } catch (\Exception $e) {
                return abort(500, $e->getMessage());
            }

        } else { // Install request

            if (!$request->query('shop') or !$request->query('hmac')) {
                return abort(403);
            }

            return redirect('https://'.$request->query('shop').'/admin/oauth/authorize?client_id='.$config['key'].'&scope='.$config['scopes'].'&redirect_uri='.route('dashboard.index').'&state='.$this->nonce($request->query('shop')));

        }

        return response()->json($request->query());
    }

    private function nonce($shop)
    {
        return sha1(config('shopify.key').config('shopify.secret').$shop);
    }
}
