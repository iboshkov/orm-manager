<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield("title") - ORM Manager</title>
    <link rel="stylesheet" href="/css/app.css" />
    <script src="https://use.fontawesome.com/0735c4fb7b.js"></script>
    <style>
        .fade-enter-active, .fade-leave-active {
            transition: opacity .5s
        }
        .fade-enter, .fade-leave-active {
            opacity: 0
        }
    </style>
</head>
<body>
<div id="app">
    <transition>
        <router-view></router-view>
    </transition>
</div>

</body>
<script>
    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
    ]); ?>
</script>

<script src="/js/app.js"></script>

</html>