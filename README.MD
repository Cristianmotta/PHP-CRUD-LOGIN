# 🧾 CRUD de Usuarios en PHP (MVC)

## 📌 Descripción del proyecto

Este proyecto consiste en el desarrollo de un sistema web tipo CRUD (Crear, Leer, Actualizar y Eliminar) utilizando PHP con arquitectura MVC, conexión a base de datos MySQL mediante PDO y buenas prácticas de seguridad.

El sistema permite la gestión de usuarios a través de un panel administrativo, incluyendo autenticación de usuarios, manejo de sesiones y una interfaz moderna con Bootstrap.

---

## 🚀 Funcionalidades principales

* 🔐 Inicio de sesión seguro (Login)
* 👤 Registro de usuarios
* 📋 Listado de usuarios
* ✏️ Edición de usuarios
* 🗑️ Eliminación de usuarios con confirmación
* 🔒 Protección de rutas mediante sesiones
* 🎨 Interfaz moderna con Bootstrap
* 📊 Tabla dinámica con DataTables
* 📈 Visualización de datos con gráficas (Chart.js)

---

## 🧱 Tecnologías utilizadas

* PHP (POO)
* MySQL
* PDO (conexión segura a base de datos)
* HTML5 / CSS3
* JavaScript
* Bootstrap 5
* DataTables
* Chart.js
* SweetAlert2

---

## 📁 Estructura del proyecto

```
crud_project/
│
├── config/         # Configuración de conexión a base de datos
├── model/          # Lógica de datos (clases)
├── controller/     # Controladores (procesamiento)
├── view/           # Vistas (interfaz)
├── public/         # Recursos públicos y base de datos
├── reports/        # Generación de reportes (PDF)
├── uploads/        # Archivos subidos
└── index.php       # Punto de entrada
```

---

## ⚙️ Instalación y uso

1. Clonar o descargar el proyecto
2. Colocar la carpeta en:

```
C:\xampp\htdocs\
```

3. Iniciar Apache y MySQL desde XAMPP
4. Importar la base de datos en phpMyAdmin
5. Acceder desde el navegador:

```
http://localhost/crud_project
```

---

## 🗄️ Base de datos

La base de datos utilizada es `planCrud`, la cual contiene la tabla `usuarios` con los campos necesarios para el funcionamiento del sistema.

👉 **Nota:** En la carpeta `public` se encuentra la base de datos lista para importar y probar el sistema en XAMPP.

---

## 🔐 Seguridad implementada

* Uso de `password_hash()` y `password_verify()`
* Prepared Statements (PDO)
* Validación de datos
* Manejo seguro de sesiones
* Protección de rutas

---

## 🎯 Objetivo del proyecto

Aplicar conocimientos de desarrollo web backend con PHP, estructuración de proyectos con MVC, conexión a bases de datos y buenas prácticas de seguridad, logrando un sistema funcional y escalable.

---

## 👨‍💻 Autor

Proyecto desarrollado en un entorno académico enfocado en el desarrollo de aplicaciones web.

Atte: CMT-Disigner
---
