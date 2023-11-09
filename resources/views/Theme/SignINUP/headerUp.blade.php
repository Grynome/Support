<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="{{ asset('assets') }}/images/favicon-hgt1.png" />
  <title>
    AppDesk Support HGT Services
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets-form-sign') }}/css/nucleo-icons.css" rel="stylesheet" />
  <link href="{{ asset('assets-form-sign') }}/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{ asset('assets-form-sign') }}/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets-form-sign') }}/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
  <style>
      input[type=number]::-webkit-inner-spin-button,
      input[type=number]::-webkit-outer-spin-button{
        -webkit-appearance: none;
        margin: 0;
      }
  </style>
</head>
<body class="g-sidenav-show  bg-gray-100">
    <section class="min-vh-100 mb-8">
        @yield('SignUp')
    </section>
@extends('Theme/SignINUP/footerUp')