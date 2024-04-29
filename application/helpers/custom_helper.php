<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// function to transform camelcase to pascal
if ( ! function_exists('camelcase_to_pascal')) {
  function camelcase_to_pascal($input = '') {
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
  }
}

if ( ! function_exists('curl_get')) {
  function curl_get($url){
    $ch = curl_init(); 

    // set url 
    curl_setopt($ch, CURLOPT_URL, $url);

    // return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // $output contains the output string 
    $output = curl_exec($ch); 

    // tutup curl 
    curl_close($ch);      

    // menampilkan hasil curl
    return $output;
  }
}