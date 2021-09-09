<?php

function send_notification_FCM($notification_id, $img_url = '', $title = '', $message = '', $id = '', $type = '', $click_action = '', $data = '')
{
     //$accesstoken = env('FCM_KEY');
     $accesstoken = 'AAAAGTb5FMY:APA91bHuRpL14CMNjV9bi4dXNZKXOEAQXXCvelQD4Uy5DHwoMBNa7O9n_bSp0e9g9sVBogrb7HP1R0q0lSkjzgPYeJs_h7rT0zuc0Ur1t0Mzyqe4nQWanLLQn7oJT7Czd52jeKwauaKw';
     // dd($accesstoken);
     $URL = 'https://fcm.googleapis.com/fcm/send';
     $url_icon = 'https://hr.ekrutes.id/favicon/favicon-32x32.png';
     // $img_url = 'https://ekrutes.id/assets/img/img-logo-text-color.png';

     $datanya = array(
          'haha' => 'test'
     );

     $data_ = [
          "to" => $notification_id,
          "data" => $datanya,
          "notification" => [
               "body" => $message,
               "title" => $title,
               "type" => $type,
               "id" => $id,
               "message" => "",
               "icon" => $url_icon,
               "image" => $img_url,
               "sound" => "default",
               "click_action" => $click_action
          ]
     ];
     // dd($data_);
     $post_data = json_encode($data_);
     // print_r($post_data);

     $crl = curl_init();

     $headr = array();
     $headr[] = 'Content-type: application/json';
     $headr[] = 'Authorization:key=' . $accesstoken;
     curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

     curl_setopt($crl, CURLOPT_URL, $URL);
     curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);

     curl_setopt($crl, CURLOPT_POST, true);
     curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
     curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
     // dd($crl);
     $rest = curl_exec($crl);
     // dd($rest);
     if ($rest === false) {
          // throw new Exception('Curl error: ' . curl_error($crl));
          //print_r('Curl error: ' . curl_error($crl));
          $result_noti = 0;
     } else {

          $result_noti = 1;
     }

     //curl_close($crl);
     // print_r($result_noti);
     // die;
     return $result_noti;
}
