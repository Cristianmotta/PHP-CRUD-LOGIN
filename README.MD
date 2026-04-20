# PHP CRUD LOGIN

## Descripción del Proyecto

Este proyecto es un sistema CRUD desarrollado en PHP con arquitectura organizada por módulos, enfocado en la gestión de usuarios, categorías y productos.

El sistema permite:

* Registro de usuarios
* Inicio de sesión seguro
* Dashboard principal
* CRUD completo de categorías
* CRUD completo de productos
* Búsqueda de productos por nombre y precio
* Estadísticas de productos mediante gráficas
* Validaciones visuales con alertas
* Confirmaciones de eliminación con JavaScript

El objetivo principal fue construir una aplicación funcional, limpia y profesional utilizando buenas prácticas en PHP y MySQL.

---

## Tecnologías Utilizadas

### Backend

* PHP (Programación Orientada a Objetos)
* MySQL / MariaDB
* PDO para conexión segura a base de datos
* Arquitectura MVC básica

### Frontend

* HTML5
* CSS3
* JavaScript
* Bootstrap 5.3

### Diseño Visual

El diseño visual de la plataforma fue desarrollado utilizando:

* Bootstrap 5.3
* JavaScript
* CSS personalizado

aplicando una interfaz moderna, limpia e innovadora, inspirada y mejorada con apoyo visual de Gemini para lograr una experiencia más profesional, intuitiva y atractiva para el usuario.

---

## Estructura del Proyecto

```text
PHP-CRUD-LOGIN/
│
├── config/
│   └── conexion.php
│
├── controller/
│   ├── LoginController.php
│   ├── UsuarioController.php
│   ├── CategoriaController.php
│   └── ProductoController.php
│
├── model/
│   ├── usuario.php
│   ├── categoria.php
│   └── producto.php
│
├── view/
│   ├── login.php
│   ├── registro.php
│   ├── dashboard.php
│   ├── crear-categoria.php
│   ├── crear-producto.php
│   ├── listar-producto.php
│   └── editar-producto.php
│
└── public/
    └── plancrud.sql
```

---

## Explicación del Código PHP

### Conexión a Base de Datos

El archivo `conexion.php` implementa el patrón Singleton para evitar múltiples conexiones innecesarias a la base de datos.

Esto permite:

* una sola conexión activa
* mejor rendimiento
* mayor seguridad
* uso de PDO con manejo de errores

---

### Login de Usuario

El sistema valida:

* correo
* contraseña encriptada con `password_hash()`

y verifica el acceso mediante:

```php
password_verify()
```

Si las credenciales son correctas:

* se crea la sesión
* se redirige al dashboard

Si son incorrectas:

* aparece una alerta visual con barra de tiempo automática

---

### Registro de Usuario

El usuario puede crear una cuenta desde `registro.php`.

Se valida:

* nombre
* correo único
* contraseña
* fecha de nacimiento

Si el correo ya existe:

* se captura el error SQL
* se muestra un mensaje amigable al usuario

---

### CRUD de Categorías

Permite:

* crear categoría
* listar categorías
* eliminar categoría

Si una categoría tiene productos relacionados:

* no puede eliminarse
* aparece una alerta explicativa usando SweetAlert

Esto protege la integridad referencial de la base de datos.

---

### CRUD de Productos

Permite:

* crear producto
* listar productos
* editar producto
* eliminar producto

Cada producto está relacionado con una categoría mediante clave foránea:

```sql
id_categoria
```

El sistema carga automáticamente la categoría actual al editar.

---

### Búsqueda de Productos

El usuario puede buscar productos por:

* nombre
* precio aproximado

Si no existe coincidencia:

* aparece un mensaje informativo

Esto mejora la usabilidad del sistema.

---

### Estadísticas de Productos

Se implementó una gráfica usando Chart.js para visualizar:

* productos registrados
* precios
* distribución visual de información

Esto permite una mejor interpretación de los datos.

---

### Alertas y Confirmaciones

Se utilizaron:

* SweetAlert2
* JavaScript

para:

* confirmar eliminación
* mostrar errores
* mensajes de éxito
* validaciones visuales
* alertas temporales con barra de progreso

Esto mejora considerablemente la experiencia del usuario.

---

## Base de Datos

La base de datos utilizada se encuentra dentro de la carpeta:

```text
public/
```

Archivo:

```text
plancrud.sql
```

Este archivo puede importarse directamente en XAMPP (phpMyAdmin) para probar el proyecto completo.

---

## Autor

Proyecto desarrollo académico enfocado en:

* PHP
* MySQL
* Bootstrap
* JavaScript
* diseño de interfaces modernas
* buenas prácticas de desarrollo web

con una estructura profesional y funcional orientada a proyectos reales.

Atte: CMT-Disigner

## 

