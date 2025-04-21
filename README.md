# AppSalon - Maqueta de un sitio para reserva de turno con elección de servicios.

## Tecnologías utilizadas  
HTML - CSS - Sass - JavaScript - PHP - Composer - Symfony - MySQL - MailTrap (desarrollo) - MVC  

Es un sitio web básico que tiene el objetivo de crear una cita con servicios agregados.  
El usuario puede crear una cuenta, recuperar y cambiar su contraseña.  
Al momento del deploy, esta funcionalidad no estará activa ya que la configuración utiliza MailTrap, que solo funciona en entornos de prueba.  

De todos modos, dejo un usuario y contraseña para realizar pruebas.  
También incluye un panel de administración para la gestión de citas y servicios.  

El sitio cumple con los criterios de un sitio web responsivo.  
La visualización se maneja casi por completo mediante JavaScript.  

## Instalación  
Para la instalación necesitas ejecutar:

```
npm install
```

Luego instalar los módulos de Node, Gulp y Composer:

```
npm i  
npm i -g gulp  
composer i
```

Para su ejecución a nivel local:

```
php -S localhost:3000
```

## Para una prueba, dejo el link con el deploy:  
https://barberia-appsalon.sao.dom.my.id/

Para ingresar podés usar:

```
usuario : correo@correo  
password : correocorreo
```

## Créditos  
**Proyecto basado en una idea original del curso "Desarrollo Web Completo con HTML5, CSS3, JS, AJAX, PHP y MySQL" (Udemy), con implementación y desarrollo propio.**
