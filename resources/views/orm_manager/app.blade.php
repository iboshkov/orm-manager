<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield("title") - ORM Manager</title>
    <link rel="stylesheet" href="/css/app.css" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/0735c4fb7b.js"></script>
    <style>

    </style>
</head>
<body>
<div id="app">
    <router-view></router-view>
</div>

</body>
<script>
    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
    ]); ?>
</script>

<script src="/js/app.js"></script>

</html>
