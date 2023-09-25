<!doctype html>
<html lang="es">
<head><meta charset="utf-8">

    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Pedido {{$order->id}} enviado a producción</title>
</head>
<body>
<p>Muchas gracias por su pedido, {{$user->name}}.</p>
<p>Su pedido con folio {{$order->id}} ha sido enviada a producción.</p>
<p>Tiene un total de <strong>24 horas hábiles</strong> para realizar cualquier aclaración, se revisarán existencias en ese tiempo y se le notificará el resultado lo antes posible.</p>
<p>Muchas gracias por su comprensión</p>
</body>
</html>
