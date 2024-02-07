<?php
$data = array('Category name' => 'Front-end Technologies', 'total questions' => 10);
$options = array(
    'http' => array(
        'header'  => "Content-type: application/json",
        'method'  => "POST",
        'content' => json_encode($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents('http://localhost:5000/predict', false, $context);
if ($result === FALSE) {
    // Handle error
} else {
    $predictions = json_decode($result, true);
    print_r($predictions);
}
?>
