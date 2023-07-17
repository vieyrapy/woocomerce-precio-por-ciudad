# Precios por Ciudad - Paraguay (Plugin para WooCommerce)

Este plugin permite mostrar precios correspondientes a ciudades de Paraguay en productos de WooCommerce. Los precios adicionales se basan en la ciudad geolocalizada del cliente y se muestran en la página de producto y en el carrito al agregar los productos.

## Características

- Permite agregar precios adicionales para cada ciudad de Paraguay en la página de edición de producto.
- Detecta la ciudad geolocalizada del cliente utilizando la base de datos GeoLite2-City de MaxMind.
- Oculta el precio normal y muestra el precio adicional correspondiente a la ciudad en la página de producto.
- Utiliza el precio adicional al agregar el producto al carrito y durante el proceso de pago.
- Permite cambiar las ciudades de Paraguay y sus precios adicionales desde el Dashboard del plugin.

## Instalación

1. Descarga el archivo ZIP del plugin desde [aquí](enlace-al-archivo-zip-del-plugin).
2. En tu sitio de WordPress, ve a **Plugins > Añadir nuevo** y haz clic en **Subir plugin**.
3. Selecciona el archivo ZIP descargado y haz clic en **Instalar ahora**.
4. Activa el plugin desde la página de plugins instalados.

## Configuración

1. En la página de edición de producto, verás un nuevo campo "Ciudad" en la sección de Precios.
2. Selecciona la ciudad correspondiente y agrega el precio adicional para esa ciudad.
3. Haz clic en **Actualizar** para guardar los cambios.

## Dependencias

Este plugin depende del uso del plugin "GeoIP Detect" junto con la base de datos de ciudades de MaxMind para la geolocalización a nivel de ciudad. Asegúrate de tener instalado y activado el plugin "GeoIP Detect" en tu sitio de WordPress. Puedes encontrar el plugin en el repositorio oficial de WordPress: [GeoIP Detect](https://es.wordpress.org/plugins/geoip-detect/).

Tener en cuenta configurar el Plugins de GeoIP en Maxmind GeoIP Lite City (Automatic download & update).


## Contribuciones

Si encuentras algún problema, tienes alguna sugerencia de mejora o deseas contribuir con código, ¡estamos abiertos a tus contribuciones! Puedes crear un Issue o enviar un Pull Request en el repositorio del plugin en GitHub.

## Licencia

Este plugin se distribuye bajo la Licencia MIT. Puedes consultar el archivo LICENSE para obtener más detalles.

## Créditos

Desarrollado por Hector Vieyra - https://www.linkedin.com/in/vieyrapy/
