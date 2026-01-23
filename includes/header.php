<?php
if (!defined('MYSITE')) {
  header('location: ../index.php');
  die();
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- After Sass custom variable new BOOTSTRAP-->
  <link rel="stylesheet" href="<?= $css_directory ?> ">
  <link rel="stylesheet" href="<?= $css_directory2 ?> ">

  <!-- fontawedom icon link -->
  <link rel="stylesheet" href="https://kit.fontawesome.com/ab8cb4ecd9.css" crossorigin="anonymous">

  <!-- Bootstrap CSS -->
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> -->

  <title> <?php echo $title; ?> - Hyper Local Service Provider</title>

  <!-- PWA Manifest & Meta -->
  <link rel="manifest" href="manifest.json">
  <meta name="theme-color" content="#0A2647">
  <link rel="apple-touch-icon" href="img/icon-192.png">

  <!-- Service Worker Registration -->
  <script>
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', () => {
        navigator.serviceWorker.register('service-worker.js')
          .then(registration => {
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
          }, err => {
            console.log('ServiceWorker registration failed: ', err);
          });
      });
    }
  </script>
  <style>
    html,
    body {
      overflow-x: hidden;
      width: 100%;
      max-width: 100%;
    }
  </style>
</head>