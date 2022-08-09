<?php 
       $link ='http://wara.phpmawaqaa.com/en/booking/280613';


         //TinyUrl
         $curlbit = curl_init();

         curl_setopt_array($curlbit, array(
             CURLOPT_URL => 'https://api.tinyurl.com/create',
             CURLOPT_RETURNTRANSFER => true,
             CURLOPT_ENCODING => '',
             CURLOPT_MAXREDIRS => 10,
             CURLOPT_TIMEOUT => 0,
             CURLOPT_FOLLOWLOCATION => true,
             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
             CURLOPT_CUSTOMREQUEST => 'POST',
             CURLOPT_POSTFIELDS =>'{
  "url":"'.$link.'" ,
   "domain": "tiny.one",
   "alias": "",
   "tags": ""
 }',
             CURLOPT_HTTPHEADER => array(
                 'Authorization:  Bearer '.config('app.BITLY_ACCESS_TOKEN'),
                 'Content-Type: application/json'
             ),
         ));

         $response = curl_exec($curlbit);
         $response = json_decode($response);
         curl_close($curlbit);
         $link = $response->data->tiny_url;

?>