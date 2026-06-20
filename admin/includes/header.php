<?php
session_start();
include('config/dbcon.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link id="pagestyle" href="assets/css/material-dashboard.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <link
    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
    rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />

  <style>
    .form-control {
      border: 1px solid #b3a1a1 !important;
      padding: 8px 10px;
    }

    .msg .alert {
      position: relative;
      top: 10;
      left: 0;
      width: auto;
      height: auto;
      padding: 10px;
      margin: 10px;
      line-height: 1.8;
      border-radius: 12px;
      align-items: center;
      background-color: #2196F3;
      border: 1px solid #DDD;
      color: #fff;
    }


    .msg .alert .closebtn {
      margin-left: 15px;
      color: #fff;
      font-weight: bold;
      float: right;
      font-size: 22px;
      line-height: 20px;
      cursor: pointer;
      transition: .3s;
    }

    #togglePassword{
      float: right;
      margin-left: -25px;
      margin-top: -30px;
      right: 10px;
      position: relative;
      z-index: 2;
      cursor: pointer;
    }
  </style>

  <title>Admin Dashboard</title>
</head>

<body>