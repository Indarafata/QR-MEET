<?php

function sendWA($phone, $message)
{
    if(!isNotifEnabled()){
        return;
    }
    $p = null;
    try {
        $url = "https://sisi.teluklamong.co.id/index.php/wsouth?wsdl";
        $client = new SoapClient($url);
        $p = $client->kirim_WA([
            "xUser"     => 'raka',
            "xpassword" => 'rakar',
            "xNoHP"     => $phone,
            "xText"     => $message,
            "Xidapp"    => 54
        ]);
        return true;
    } catch (\Throwable $th) {
        return false;
    }
}

function sendEmail($email, $message, $subject = null)
{
    if(!isNotifEnabled()){
        return;
    }
    try {
        $url = "https://sisi.teluklamong.co.id/index.php/wsouth?wsdl";
        $client = new SoapClient($url);

        $p = $client->kirimEmail([
            "xUser" => 'raka',
            "xpassword" => 'rakar',
            "xEmailPenerima" => $email,
            "xJudul" => "[NO-REPLY]" . ($subject ? " $subject" : " Notification Alert MONIC !!!"),
            "xBody" => $message,
        ]);
        return true;
    } catch (\Throwable $th) {
        //throw $th;
        return false;
    }
}

function isNotifEnabled()
{
    return true;
}