<?php
header("Content-Type: application/json");

define("SUPABASE_URL", "https://xxymbobojijnczeyaykj.supabase.co");
define("SUPABASE_API_KEY","eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inh4eW1ib2JvamlqbmN6ZXlheWtqIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzkxODUzODksImV4cCI6MjA1NDc2MTM4OX0.E3-YNt8EO9Vyn63bWOk6lNtX9s4Z23Ay2ZQP3zjL_FQ");


if (!isset($_GET['userid']) || !isset($_GET['pass'])) {
    echo json_encode(["error" => "Missing userid or password_hash"]);
    exit;
}

$userid = $_GET['userid'];
$password_hash = $_GET['pass'];
$tableName = "users";

function getUsers($userid, $password_hash) {
    $url = SUPABASE_URL . "/rest/v1/users?userid=eq.$userid&password_hash=eq.$password_hash";

    $headers = [
        "apikey: " . SUPABASE_API_KEY,
        "Authorization: Bearer " . SUPABASE_API_KEY,
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
    
        $data = json_decode($response, true);
        
        if (count($data) > 0){
            if($data[0]['role'] == "admin"){
            
                        $ch = curl_init( SUPABASE_URL . "/rest/v1/users");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        $resp = curl_exec($ch);
                        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);
                        
                        if ($httpCode == 200) {
                                    $data_2 = json_decode($resp, true);
                                    return $data_2;
                        }else{return $data;}
            }else{
                return $data;
            }
        }else{
            return null;
        }
    } else {
        return null;
    }
}


// Get the role of the user
$data = getUsers($userid, $password_hash);

if (!$data) {
    echo json_encode(["error" => "Invalid credentials"]);
    exit;
}
echo json_encode($data, JSON_PRETTY_PRINT);
?>