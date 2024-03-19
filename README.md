<h1 align="center">
  Plantilla base basada en 
  arquitectura limpia
  
  Symfony 5.4, PHP 8.2 y Docker
</h1>

Plantilla base basada en arquitectura limpia adicionalmente se han seguido los consejos de los cursos de CodelyTv y su propio [repositorio](https://github.com/CodelyTV/php-ddd-example "repositorio") pero haciendolo más sencillo.

<h2>
Instalación
</h2>

El proyecto tiene configurado docker, por lo que para empezar a trabajar con el será más sencillo. Solo hay un contenedor configurado, este se llama `Apache` ya que está basado en ese servidor web.

La imagen base de docker está basada en PHP 8.2 con apache.
Se le ha añadido `composer`, `symfony-cli`, `node 18`, `npm`, `yarn`.

Para instalar docker en tu máquina Linux puedes seguir estas guias:
[Instalar Docker](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-22-04)
[Instalar Docker Compose](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-20-04)

Para iniciar el proyecto:

	sudo docker-compose up -d

Para entrar dentro del contenedor para usar las herramientas como `composer`, `symfony`, `yarn`, `npm`:

	sudo docker-compose exec apache bash

El proyecto actualmente tiene dos endpoints de ejemplo:

<h5>GET http://localhost/sales</h5>

<h5>POST http://localhost/order</h5>

- **user**: id del usuario
- **products**: array de los ids de los productos

<h2>
Introducción
</h2>

En este momento la plantilla contiene lo siguiente dentro de `src/`, vamos a explicar por partes.

```sh
├── Api (bounded context)
│   │
│   ├── Orders (module)
│   │   │
│   │   ├── Application (layer)
│   │   │   └── CreateOrder
│   │   │       ├── CreateOrderCommand.php
│   │   │       └── CreateOrderCommandHandler.php
│   │   │
│   │   ├── Domain (layer)
│   │   │   ├── Collection
│   │   │   │   ├── OrderLines.php
│   │   │   │   ├── Product.php
│   │   │   │   └── Users.php
│   │   │   ├── Entity
│   │   │   │   ├── OrderLine.php
│   │   │   │   ├── Product.php
│   │   │   │   └── User.php
│   │   │   ├── Exception
│   │   │   │   ├── OrderNotFoundException.php
│   │   │   │   ├── ProductNotFoundException.php
│   │   │   │   └── NotFoundException.php
│   │   │   └── Repository
│   │   │       ├── OrderRepository.php
│   │   │       ├── ProductRepository.php
│   │   │       └── UserRepositoryInterface.php
│   │   │
│   │   └── Infrastructure (layer)
│   │       ├── Controller
│   │       │   └── CreateOrderController.php
│   │       └── Persistence
│   │           ├── Doctrine
│   │           │   ├── OrderLine.orm.yml
│   │           │   ├── Product.orm.yml
│   │           │   └── User.orm.yml
│   │           └── Repository
│   │               ├── OrderRepository.php
│   │               ├── OrderRepositoryTest.php
│   │               ├── ProductRepository.php
│   │               ├── ProductRepositoryTest.php
│   │               ├── UserRepositoryInterface.php
│   │               └── UserRepositoryTest.php
│   │
│   ├── Sales (module)
│   │   │
│   │   ├── Application (layer)
│   │   │
│   │   ├── Domain (layer)
│   │   │   ├── Collection
│   │   │   ├── Entity
│   │   │   ├── Exception
│   │   │   └── Repository
│   │   │       └── OrderRepository.php
│   │   │
│   │   └── Infrastructure (layer)
│   │       │
│   │       ├── Controller
│   │       │   └── GetSalesFromAllOrdersController.php
│   │       │
│   │       └── Persistence
│   │           ├── Doctrine
│   │           └── Repository
│   │               ├── OrderRepository.php
│   │               └── OrderRepositoryTest.php
│   │
│   └── Shared (shared folder for modules)
│       │
│       ├── Domain (layer)
│       │   ├── Collection
│       │   │   └── Orders.php
│       │   └── Entity
│       │       └── Order.php
│       │
│       └── Infrastructure (layer)
│           └── Persistence
│               ├── ApiBlockchainDataSource
│               │   ├── DoctrineDataSource.php
│               │   └── InMemoryDataSource.php
│               └── Doctrine
│                   └── Order.orm.yml
│
└── Shared (shared folder for bounded contexts)
    │
    ├── Domain (layer)
    │   ├── Assert.php
    │   ├── Collection.php
    │   ├── DomainException.php
    │   ├── Entity.php
    │   └── UuidGenerator.php
    │
    └── Infrastructure (layer)
        └── UuidGenerator.php
```

<h3>
Bounded contexts
</h3>

Dentro de `src/` van los **Bounded Context** (BC), un bounded context, resumiendo, es una **aplicación independiente** o **servicio**.

Si tenemos una tienda online, el backoffice es un BC, el front de la página es otro BC, si tuvieramos una conexión API para sincronizar un ERP, podría ser otro BC.

Lo que define lo que es o no es un BC es la separación que vamos a querer tener en nuestra aplicación. Cuanta más separación más complejidad, ojo con eso.

Cada bounded context es independiente, si el front y el backoffice, (ejemplo de la tienda online), contienen pedidos, ambos bounded context tendrán su propia entidad `pedido`. Cada bounded context tendrá su sistema de base de datos, si ambos o todos, usan el mismo sistema, tendrán que tener separados los datos, por lo que si ambos usan mysql, habran las siguientes tablas: `front_orders`, `backoffice_orders`.

Para sincronizar los pedidos de ambos bounded context, tenemos que basarnos en `eventos`. Cuando un bounded context crea un pedido, registra un evento, el otro bounded context está escuchando dicho evento, y si se dispara, coge el evento, y si es necesario, replica los datos para crear su propia entidad de pedido.

La intención de los Bounded Context es para que en un futuro sea más fácil desacoplarlos como servicios independientes, los eventos pueden ejecutarse en un rabbitmq centralizado por ejemplo, y los bounded context en distintos servidores, pero seguiran sincronizandose. Si vas a crear solo una API, solo usaras un bounded context, y esta complejidad no la tendrás que añadir.

En el ejemplo del **arbol de carpetas**, podrás ver que en el primer nivel está `BC1` y `Shared`. (Luego explicaremos **shared**).

<h3>
Modules
</h3>

Los modulos son partes de la aplicación dentro de un bounded context, en el bounded context de backoffice de una tienda online podriamos tener: pedidos, catalogo, clientes, etc..

En el arbol de carpetas de arriba vemos que dentro del bounded context BC1 tenemos: `orders`, `sales` y `shared`

En cada uno de estos tendremos dentro las carpetas:
`Domain`, `Application`, `Infrastructure`.

En la carpeta **Infrastructure** tenemos nuestro punto de entrada de la aplicación, es el único sitio que podrémos usar código del framework (symfony). Aquí iran los controllers, los presenters, las implementaciones de los repositories o de las interfaces.. Si en otras capas necesitan utilidades de terceros, las capas de arriba usaran interfaces, y en infrastructure es donde se implementaran.

En la capa **Application** van los casos de uso, todas las interacciones que pueden generar los actores de nuestra aplicación. CreateOrder, CreateUser, CancelOrder, etc..

En la capa de **Domain** va nuestra lógica de negocio, todas las reglas de validaciones y formalización de las entidades va aquí.

Las capas siguen este orden: `Infrastructure -> Application -> Domain`.

Domain no puede saber de Application e Infrastructure.
Application solo puede saber de Domain pero no de Infrastructure.
Infrastructure puede ver a las otras dos.

En Domain cuando tienes una entidad generada, para guardarla llamaras a un repositorio, pero a una interfaz de repositorio, la implementación estará en Infrastructure. De esta forma Domain no conoce Infrastructure, pero Infrastructure puede añadir la implementación, si el día de mañana cambia la base de datos, no se toca el dominio, se toca infraestructura.

El dominio es la lógica de mi negocio, ¿tendría que cambiar la lógica de mi negocio en base a un cambio de infraestructura? no tiene sentido, por eso se separa así.

Si nos fijamos en el modulo Orders del bounded context BC1, en infrastructure tenemos controllers y dentro: `CreateOrderController.php `

Aquí entrara la aplicación (si entras en el endpoint de este controller), el controller tiene lo siguiente:

```
$orderId = Uuid::v4();

$this->CreateOrderCommandHandler->__invoke(
	new CreateOrderCommand(
		$orderId,
		$request->get('user'), 
		$request->get('products')
	)
);
```

Se inicializa CreateOrdeCommand que es un DTO donde se añade la información que se le pasará al caso de uso, luego se llama al caso de uso y se deja escalar.

Los casos de uso no deberian de retornar datos, precisamente el UUID se genera y se le pasa al caso de uso, desde Infrastructure, para no tener que esperar una respuesta. Esta llamada estará en un TryCatch, si hay una excepción sabremos que no se ha cumplido el caso de uso, pero si no hay error, continuamos.

Si despues del caso de uso necesitamos obtener los datos, podremos buscar con los repositorios el ID.

Esto nos permite en el futuro, que sea el frontend el que defina el UUID, permitiendo así aplicaciones offline en el móvil. Ejemplo:

Nuestra aplicación web genera una entidad de carrito, pero hasta que no lo crea el backend, no sabe el ID, por lo que no puede enviar las lineas de pedido. Sin estas no puede cerrar el pedido. Si usamos el UUID desde el front, el propio front sin internet puede generar el carrito, añadir los productos, cerrar el pedido (sin confirmar obviamente), cuando se reconecta enviar de golpe toda la información y entonces comprobar si el pedido estuvo correcto, y entonces sí, recuperar la factura u otros datos.

<h3>
Carpeta Shared
</h3>

Esta carpeta es un poco especial. Estará en varios lugares, al nivel de bounded context y al nivel de modules.

Esta carpeta normalmente tiene 2 carpetas dentro: Domain e Infrastructure.
Sirve para compartir entre bounded context o modules: clases, entidades, utilidades de terceros, cosas que varios sitios vayan a reutilizar.

En el caso de bounded context, en la carpeta `shared/domain` tendremos las clases o interfaces que reutilizaremos en todos los bounded context (incluyendo sus modules), por ejemplo, una clase base de **Entity** de la que luego heredan el resto de entidades de la aplicación. Tenemos **UuidGenerator** como interfaz, que luego se implementa en `shared/infrastructure`, al igual que se hubiera hecho en cualquier otro sitio.

En el caso de modules, es igual que el de arriba, pero lo más común que encontraremos serán entidades que se reutilicen en varios modulos del mismo bounded context, por ejemplo en el arbol de carpetas de arriba, tenemos en el bounded context `BC1` en la carpeta **shared**, la entidad Order que se usa tanto en el `modulo de Sales` como en el `modulo de Orders`.


<h3>
FAQ
</h3>

**Tengo un proyecto nuevo y no me gustaría añadir de inicio la complejidad de los bounded contexts y los eventos, ¿tengo otra alternativa?**

Sí, los modulos pueden ser promocionados a bounded contexts en un futuro, por lo que podemos usar otra organización para permitir que el día de mañana sean promocionados e iniciar sin la complejidad de bounded contexts.

Pongamos un ejemplo, tengo una tienda online, arriba dijimos que tiene dos bounded contexts, backoffice y frontend, dentro de backoffice tenemos los modulos: ventas, pedidos, catalogo, clientes. A su vez estos modulos tienen las carpetas Domain, Application e Infrastructure.

Esta sería la organización típica usando bounded contexts:

```sh
src
├── Shared (shared folder for bounded contexts)
├── Backoffice (bounded context)
│   ├── Ventas (module)
│   │   ├── Domain
│   │   ├── Application
│   │   ├── Infrastructure
│   ├── Pedidos (module)
│   │   ├── Domain
│   │   ├── Application
│   │   ├── Infrastructure
│   ├── Catalogo (module)
│   │   ├── Domain
│   │   ├── Application
│   │   ├── Infrastructure
│   ├── Clientes (module)
│   │   ├── Domain
│   │   ├── Application
│   │   ├── Infrastructure
│   ├──Shared (shared folder for modules)
│
├── Frontend (bounded context)
    ├── (etc)
```

Pero haciendolo teniendo en cuenta que los modulos pueden promocionar, quedaría así:

```sh
src
├── Shared (shared folder for bounded contexts)
├── OnlineStore (bounded contexts)
    ├── Shared (shared folder for modules)
    ├── Backoffice (module)
    │   ├── Ventas (submodule)
    │   │   ├── Domain
    │   │   ├── Application
    │   │   ├── Infrastructure
    │   ├── Pedidos (submodule)
    │   │   ├── Domain
    │   │   ├── Application
    │   │   ├── Infrastructure
    │   ├── Catalogo (submodule)
    │   │   ├── Domain
    │   │   ├── Application
    │   │   ├── Infrastructure
    │   ├── Clientes (submodule)
    │   │   ├── Domain
    │   │   ├── Application
    │   │   ├── Infrastructure
    │   ├──Shared
    │
    ├── Frontend (module)
        ├── (etc)
```

Solo hay un bounded context llamado OnlineStore, dentro habrían modulos como Backoffice y Frontend, y dentro submodulos de ventas, pedidos, catalogo...
Es lo mismo que el anterior pero moviendo todo a un nivel inferior. Importante a tener en cuenta, las carpetas shared de los modulos y submodulos al inicio estan vacias ya que ahí van las clases a compartir entre modulos o submodulos, pero es importante que la shared de la raiz de src/ siga manteniendo las clases de interfaces, clases abstractas basicas, utilidades, etc.

Si el día de mañana un modulo empieza a cobrar mucha importancia y hace falta promocionarlo a BoundedContext solamente habrá que subirlo un nivel de carpeta.

**Los casos de uso son acciones que están en la carpeta Application, ¿que hago si mi endpoint solo es un GET para obtener datos?**

- En el controller de infrastructure puedes llamar al repositorio directamente y obtener los datos que necesitas para pasarselos a la vista o json de respuesta.
- Otra opción es crear una carpeta llamada UI o Views en la carpeta de Application, donde añadir las solicitudes de datos.
- Otra opción es tratar estas vistas tambien como casos de uso: ejemplo GetUserOrdersQuery.

**Si una entidad la muevo de un modulo a la carpeta Shared, ¿qué más tendría que mover?**

Si movemos la entidad Order.php también moveriamos Order.orm.yml y la colección Orders.php.

**He creado una interfaz de repositorio y su implementación pero no funcionan, ¿que puede faltar?**

En el caso de que Symfony no sepa enlazarlos tendrás que especificarlo en el archivo services.yml

```
App\BC1\Orders\Domain\Repository\OrderRepository: '@App\BC1\Orders\Infrastructure\Persistence\Repository\OrderRepository'
```

**¿Qué sistemas de almacenamiento hay actualmente configuradas?**

Está preparado para usar Doctrine y una implementación casera en memoria basada en una variable estatica.

**¿En qué se diferencia la carpeta DataSource de los repositorios?**

Data source es para añadir las conexiones a distintos metodos de almacenamiento o recuperación de datos, ejemplo si tenemos varias API's o bases de datos.

Luego los repositorios usan los DataSource para hacer todas las peticiones o transacciones necesarias para completar la tarea.

**¿Si quiero hacer una transacción en Doctrine como lo haría?**

La transacción se añade en la implementación del repositorio.

El dominio en ningún momento tiene que saber sobre eso, es una logica de infraestructura, no del dominio. Se podría debatir si es responsabilidad de la logica de negocio asegurar una transacción, para no añadir complejidad, lo hacemos en infraestructura.

```php
    $this->doctrineDataSource->entityManager()->beginTransaction();

    $this->doctrineDataSource->persist($order);

    /** @var OrderLine $orderLine */
    foreach($orderLines->getIterator() as $orderLine)
    {
		$this->doctrineDataSource->persist($orderLine);
    }

    $this->doctrineDataSource->flush();

    $this->doctrineDataSource->entityManager()->commit();
```

**Quiero añadir paginación a una petición ¿como lo haría?**

La paginación viene desde infraestructura, el dominio no debe de preocuparse de paginar, por lo que en el repositorio tienes que añadir una nueva función añadiendo la paginación, y en infrastructure implementar esa función en el repositorio haciendo la paginación correspondiente.

Luego desde el controlador llamas al repositorio pasandole los datos necesarios.

(En un futuro se añadirá Criteria al proyecto, en la plantilla base.)

**Para sincronizar datos entre varios bounded context necesito usar eventos, ¿como lo hago?**

Actualmente la plantilla base aun no tiene el sistema de eventos añadido, puedes usar Messenger de Symfony para ayudarte, pero acuerdate de usar interfaces en el dominio, y la implementación de messenger la envuelves en infraestructura.

**Veo que hay un repo para la entidad de Order, Product y User, ¿porque de OrderLine no hay?**

En Symfony estamos acostumbrados a que cada entidad tenga un repositorio, porque estamos pensando en como se estructura en base de datos.
Esta perspectiva cambia cuando trabajamos en arquitecturas limpias. Primero modelamos el dominio y luego ya veremos como guardamos los datos.

La cantidad de repositorios que tengamos dependeran de los Aggregate Root (entidades principales).

Pongamos ejemplos:

Tenemos Order y OrderLine como entidades.
¿Cuantas veces accederemos directamente a OrderLine sin pasar por Order? practicamente nunca, siempre pasaremos por Order para obtener sus lineas de pedido.
¿Qué repositorios necesitamos? uno, el que gestiona el Aggregate Root de Order y sus subentidades.

Otro ejemplo:
Tenemos entidades como: Product, Category, ProductVariant... todas estas entidades están relacionadas de alguna forma con Product, en este caso Category no sería una subentidad,
porque en algunos casos, sí querremos obtener una categoria independientemente de los productos.

En este caso podrían haber 2 repositorios: ProductRepository y CategoryRepository. O si le damos otra vuelta, podría haber solo 1 repositorio: CatalogRepository, ya que tanto Product como Category, estan estrechamente relacionados. Y este repositorio tiene bastante sentido para funciones como:

``CatalogRepository->getProductsByCategoryId();``

``CatalogRepository->getCategoryFromProductId();``

``CatalogRepository->moveProductToCategory();``

``CatalogRepository->deleteCategory();``

Los repositorios se apoyan a su vez de los datasource para gestionar los datos.

Pongamos un ejemplo, podriamos tener 2 datasources, uno en doctrine para la base de datos principal, y un datasource que apunta a una api concreta, para obtener las categorias.

CatalogRepositoy se apoyará en ambos para construir sus datos, sacará los productos de su base de datos, pero las categorias las cargará desde la api.
Para eso también se creó la carpeta de data sources.

