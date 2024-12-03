<!doctype html>
<html lang="es">
<head><meta charset="utf-8">

    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Nuevo socio registrado</title>
</head>
<body>
<p>El socio {{$user['name']}} con número {{$user['number']}} se registró exitosamente.</p>
<p>Favor de revisar y validar la información para aprobar o eliminar el usuario lo antes posible.</p>
<p>Para realizar esto, sigue los siguientes pasos:</p>
<ul>
    <li>ingresa al cotizador con tu cuenta.</li>
    <li>Expande el submenú "Admin" en el menú izquierdo e ingresa a la opción de "Usuarios".</li>
    <li>Busca el número de socio en la lista o ingresa su número de socio en el formato de arriba y presiona buscar.</li>
    <li>En la columna de acciones, da click al lápiz verde para editar el nuevo usuario.</li>
    <li>Busca la opción "Rol" (4ta opción), estará asignado como "No Autorizado". Selecciona la opción "Usuario" y da click en "Guardar"</li>
</ul>
</body>
</html>
