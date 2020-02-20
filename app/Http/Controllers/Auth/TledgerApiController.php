<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TledgerApiController extends Controller
{
    const REGISTRATION_API = "auth/registration";
    const LOGIN_API = "auth/login";
    const ME_API = "auth/me";
    const WALLETS = "wallets";
    const DASHBOARD = "dashboard";
    const SEND_MONEY = "wallets/send-money";

    /**
     * @var bool
     */
    public $error = false;

    /**
     * @var bool
     */
    public $connectionError = false;

    /**
     * @var
     */
    public $errors;

    /**
     * @var
     */
    public $accessToken;


    /**
     * @var Client
     */
    private $client;

    /**
     * TledgerApiController constructor.
     */
    public function __construct()
    {
        try {
            $this->client = new Client(['base_uri' => env("TLEDGER_API_URL")]);
            $this->client->request('GET',env("TLEDGER_API_URL")."spec");
        }catch (\GuzzleHttp\Exception\ConnectException $e) {
            $this->connectionError = true;
        }catch(\GuzzleHttp\Exception\ServerException $e){
            $this->connectionError = true;
        }
    }



    /***
     * @param Request $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function register(Request $request)
    {
        try {
            $response = $this->client->request('POST', self::REGISTRATION_API, [
                'form_params' => [
                    'email' => $request['email'],
                    'password' => $request['password'],
                    'phoneNumber' => $request['phone'],
                    'firstName' => $request['first_name'],
                    'lastName' => $request['name'],
                    'confirmPassword' => $request['password_confirmation'],
                ]
            ]);
            $body = json_decode($response->getBody(), true);
            $this->accessToken = $body['data']['accessToken'];
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $body = (string)$response->getBody();
            $decode = json_decode($body);
            $this->error = true;
            $this->errors = $decode->errors;
        }catch(\GuzzleHttp\Exception\ServerException $e){
            $this->connectionError = true;
        }
    }


    /**
     * @param Request $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login(Request $request)
    {

        try {
            $response = $this->client->request('POST', self::LOGIN_API, [
                'form_params' => [
                    'email' => $request['email'],
                    'password' => $request['password'],
                ]
            ]);
            $body = json_decode($response->getBody(), true);
            $this->accessToken = $body['data']['accessToken'];
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $body = (string)$response->getBody();
            $decode = json_decode($body);
            $this->error = true;
            $this->errors = $decode->errors;
        }catch(\GuzzleHttp\Exception\ServerException $e){
            $this->connectionError = true;
        }
    }


    /**
     * @param $token
     */
    public function getUserData($token)
    {

        try {
            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ];
            $response = $this->client->request('GET', self::ME_API, [
                'headers' => $headers
            ]);
            $body = json_decode($response->getBody(), true);
            return $body;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $body = (string)$response->getBody();
            $decode = json_decode($body);
            $this->error = true;
            $this->errors = $decode->errors;
        }catch(\GuzzleHttp\Exception\ServerException $e){
            $this->connectionError = true;
        }
    }

    /**
     * @param $token
     * @return mixed|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserWallets($token)
    {

        try {
            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ];
            $response = $this->client->request('GET', self::WALLETS, [
                'headers' => $headers
            ]);
            $body = json_decode($response->getBody(), true);
            return $body;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $body = (string)$response->getBody();
            $decode = json_decode($body);
            $this->error = true;
            $this->errors = $decode->errors;
        }catch(\GuzzleHttp\Exception\ServerException $e){
            $this->connectionError = true;
        }
    }

    /**
     * @param $token
     * @return mixed|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserDashboard($token)
    {

        try {
            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ];
            $response = $this->client->request('GET', self::DASHBOARD, [
                'headers' => $headers
            ]);
            $body = json_decode($response->getBody(), true);
            return $body;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $body = (string)$response->getBody();
            $decode = json_decode($body);
            $this->error = true;
            $this->errors = $decode->errors;
        }catch(\GuzzleHttp\Exception\ServerException $e){
            $this->connectionError = true;
        }
    }

    /**
     * @param $amount
     * @param $receiverWalletId
     * @return mixed|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendMoney($amount, $receiverWalletId)
    {

        try {
            $request= new Request(['email' => env("ADMIN_LOGIN"),"password"=>env("ADMIN_PASSWORD")]);
            $this->login($request);
            $headers = [
                'Authorization' => "Bearer {$this->accessToken}",
                'Accept' => 'application/json',
            ];
            $data = [
                "token" => "SUF",
                'amount' => $amount,
                'receiverWalletId' => $receiverWalletId
            ];
             $response = $this->client->request('POST', self::SEND_MONEY, [
                'headers' => $headers,
                'form_params' => $data
            ]);
            $body = json_decode($response->getBody(), true);
            return $body;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $body = (string)$response->getBody();
            $decode = json_decode($body);
            $this->error = true;
            $this->errors = $decode->errors;
        }catch(\GuzzleHttp\Exception\ServerException $e){
            $this->connectionError = true;
        }
    }
}
