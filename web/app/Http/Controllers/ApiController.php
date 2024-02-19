<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Mtownsend\XmlToArray\XmlToArray;

class ApiController extends Controller
{
    function getTokenFromSFMC()
    {
        // Crea un'istanza del client Guzzle
        $client = new Client();

        // URL dell'API di destinazione
        $apiUrl = env('SFMC_URL_AUTH');

        // Dati da inviare nel corpo della richiesta POST
        $postData = [
            "grant_type" => env('GRANT_TYPE'),
            "client_id" => env('CLIENT_ID'),
            "client_secret" => env('CLIENT_SECRET'),
            "account_id" => env('ACCOUNT_ID')
        ];

        try {
            $response = $client->post($apiUrl, [
                'json' => $postData,
            ]);

            $data = (object) json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        $objInfo = $this->getObjectInformation($data);
        return response()->json(['obj' => $objInfo]);
    }

    function getObjectInformation($data)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('PACKAGE_SOAP_URL'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>
            '<s:Envelope xmlns:s="http://www.w3.org/2003/05/soap-envelope" xmlns:a="http://schemas.xmlsoap.org/ws/2004/08/addressing" xmlns:u="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                <s:Header>
                    <a:Action s:mustUnderstand="1">Retrieve</a:Action>
                    <a:To s:mustUnderstand="1">'.env('PACKAGE_SOAP_URL').'</a:To>
                    <fueloauth xmlns="http://exacttarget.com">' . $data->access_token . '</fueloauth>
                </s:Header>
                <s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                    <RetrieveRequestMsg xmlns="http://exacttarget.com/wsdl/partnerAPI">
                        <RetrieveRequest>
                            <ObjectType>DataExtensionObject [Customers]</ObjectType>
                            <Properties>PlayerID</Properties>
                            <Properties>Email</Properties>
                        </RetrieveRequest>
                    </RetrieveRequestMsg>
                </s:Body>
            </s:Envelope>',
            CURLOPT_HTTPHEADER => array(
                'content-type: text/xml; charset=utf-8',
                'SOAPAction:"Retrieve"'
            ),
        ));
        $response = curl_exec($curl);
        $array = XmlToArray::convert($response);
        curl_close($curl);

        if(array_key_exists('soap:Fault', $array['soap:Body'])){
            return response()->json([
                'response' => false,
                'error_msg' => $array['soap:Body']['soap:Fault']['faultstring'],
             ]);
        } else {
            foreach ($array['soap:Body']['RetrieveResponseMsg']['Results'] as $objResult) {
                dd($objResult);
            }
        }

        echo $response;
    }
}
