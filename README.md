********************************************************************************************************************
                                                     microSitio 
********************************************************************************************************************

Este proyecto es un pequeño sistema web desarrollado en Laravel con las tecnologías de HTML, CSS, Ajax, Bootstrap 4 y MySQL, el sistema cuenta con un sección para crear usuarios, estos no tendrán acceso al dashboard porque no cuentan con el permiso necesario solo la cuenta principal que se ha creado por defecto "Usuario=admin@admin.com Contraseña=contraseña" tiene los permisos para acceder al dashboard y desde ahí se pueden cambiar los permisos de los nuevos usuarios, el sistema tiene otras secciones para las empresas y colaboradores con su respectivo CRUD y también cuenta con una lección para administrar el perfil de usuario.

********************************************************************************************************************

Desarrollado por
Elvis Xavier Godoy

xaviergodoyortega@gmail.com
99287403

********************************************************************************************************************

Como empesar
● Clonar el repositiorio master
● Crear la base de datos con el nombre microSitio

● Ejecutar migraciones con el comando php artisan migrate --seed
● Ejecutar el comando php artisan storage:link para poder acceder a las imagenes por la carpeta public

● Ejecutar el servidor con php artisan serve                                                      
!todos los comandos anteriores se ejecutaran en la terminal del proyecto!

● Iniciar sesión con:
Usuario: admin@admin.com
Contraseña: contraseña
