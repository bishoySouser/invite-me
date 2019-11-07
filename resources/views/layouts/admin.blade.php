
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Meeting Event | Admin</title>

<link rel="stylesheet" href="/css/app.css">
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body class="hold-transition sidebar-mini">
<div id="app" class="wrapper">

  @yield('content')
  
<script src="/js/app.js"></script>
</body>
</html>
