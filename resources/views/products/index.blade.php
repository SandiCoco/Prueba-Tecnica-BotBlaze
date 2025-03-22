<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        #products {
            max-width: 900px;
            margin: auto;
        } 

        .product {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .product:last-child {
            border-bottom: none;
        }
        

        .btn-danger,
        .btn-warning {
            margin-left: 10px;
        }
    </style>
</head>

<body>

    <div id="products1" class="container mt-4">
        <h1 class="mb-4 text-center">Gestión de Productos</h1>

        <div class="d-flex justify-content-end mb-4">
            @if(Auth::check())
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                </form>
            @endif
        </div>

        <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addProductModal">
            Agregar Producto
        </button>

        <button class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#inventoryModal">
            Actualizar Inventario
        </button>

        <button class="btn btn-info mb-4" data-bs-toggle="modal" data-bs-target="#inventoryLogsModal">
            Ver Historial
        </button>

         

        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Buscar producto" id="searchInput">
            <button class="btn btn-outline-secondary" type="button" id="searchButton">Buscar</button>
        </div>  
        
           
    </div>

        <!-- Modal para gestionar entradas/salidas de inventario -->
    <div class="modal fade" id="inventoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar Inventario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="inventoryForm">
                        <div class="mb-3">
                            <label for="productSelect" class="form-label">Producto:</label>
                            <select id="productSelect" class="form-select" required>
                                <option value="">Seleccionar producto</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipo de Movimiento:</label>
                            <select id="movementType" class="form-select" required>
                                <option value="entrada">Entrada</option>
                                <option value="salida">Salida</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Cantidad:</label>
                            <input type="number" id="quantity" class="form-control" min="1" required>
                        </div>

                        <button type="submit" class="btn btn-success">Actualizar Inventario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar los logs de inventario -->
    <div class="modal fade" id="inventoryLogsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Historial de Inventario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Tipo de Movimiento</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryLogsTable">
                            <!-- Aquí se insertarán los registros -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-3">
        <div class="row">
            <div class="col-md-4">
                <select id="sortOption" class="form-select">
                    <option value="">Ordenar por...</option>
                    <option value="price_desc">Precio: Alto a Bajo</option>
                    <option value="price_asc">Precio: Bajo a Alto</option>
                    <option value="stock_desc">Stock: Alto a Bajo</option>
                    <option value="stock_asc">Stock: Bajo a Alto</option>
                </select>
            </div>
            <div class="col-md-4">
                <button class="btn btn-outline-secondary" id="confirmFilter">Confirmar</button>
                <button class="btn btn-outline-danger" id="clearFilter">Limpiar Filtros</button>
            </div>
        </div>
    </div>
    

    <div id="products" class="container mt-4">
        
    </div>
    
    <!-- Modal para Confirmar Eliminación -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este producto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="confirmDeleteBtn" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Agregar Producto -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" id="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <input type="text" id="descripcion" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio:</label>
                            <input type="number" id="precio" class="form-control" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad:</label>
                            <input type="number" id="cantidad" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Guardar Producto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Producto -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        <input type="hidden" id="editProductId">
                        <div class="mb-3">
                            <label for="editNombre" class="form-label">Nombre:</label>
                            <input type="text" id="editNombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescripcion" class="form-label">Descripción:</label>
                            <input type="text" id="editDescripcion" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPrecio" class="form-label">Precio:</label>
                            <input type="number" id="editPrecio" class="form-control" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCantidad" class="form-label">Cantidad:</label>
                            <input type="number" id="editCantidad" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-warning">Actualizar Producto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let productIdToDelete = null;

        function getProducts() {
            axios.get('/api/productos')
                .then(response => {
                    const productsDiv = document.getElementById('products');
                    productsDiv.innerHTML = '';
                    response.data.forEach(product => {
                        productsDiv.innerHTML += `
                            <div class="product">
                                <h3>${product.nombre}</h3>
                                <p><strong>Descripción:</strong> ${product.descripcion}</p>
                                <p><strong>Precio:</strong> $${product.precio}</p>
                                <p><strong>Cantidad:</strong> ${product.cantidad}</p>
                                <button class="btn btn-warning" onclick="editProduct(${product.id}, '${product.nombre}', '${product.descripcion}', ${product.precio}, ${product.cantidad})">Editar</button>
                                <button class="btn btn-danger" onclick="showDeleteModal(${product.id})">Eliminar</button>
                            </div>
                        `;
                    });
                });
        }

        function editProduct(id, nombre, descripcion, precio, cantidad) {
            document.getElementById('editProductId').value = id;
            document.getElementById('editNombre').value = nombre;
            document.getElementById('editDescripcion').value = descripcion;
            document.getElementById('editPrecio').value = precio;
            document.getElementById('editCantidad').value = cantidad;
            new bootstrap.Modal(document.getElementById('editProductModal')).show();
        }

        document.getElementById('editProductForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('editProductId').value;
            const updatedProduct = {
                nombre: document.getElementById('editNombre').value,
                descripcion: document.getElementById('editDescripcion').value,
                precio: document.getElementById('editPrecio').value,
                cantidad: document.getElementById('editCantidad').value
            };
            axios.put(`/api/productos/${id}`, updatedProduct).then(() => {
                getProducts();
                bootstrap.Modal.getInstance(document.getElementById('editProductModal')).hide();
            });
        });

        // Mostrar el modal de confirmación para eliminar un producto
        function showDeleteModal(id) {
            productIdToDelete = id;
            const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            deleteModal.show();
        }

        // Eliminar un producto después de confirmar
        document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
            if (productIdToDelete) {
                axios.delete(`/api/productos/${productIdToDelete}`)
                    .then(() => {
                        getProducts();
                        productIdToDelete = null; // Limpiar la variable
                        bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal')).hide();
                    })
                    .catch(error => console.error("Error al eliminar el producto:", error));
            }
        });

        // Agregar un nuevo producto
        document.getElementById('addProductForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const newProduct = {
                nombre: document.getElementById('nombre').value,
                descripcion: document.getElementById('descripcion').value,
                precio: document.getElementById('precio').value,
                cantidad: document.getElementById('cantidad').value
            };

            axios.post('/api/productos', newProduct)
                .then(() => {
                    getProducts();
                    bootstrap.Modal.getInstance(document.getElementById('addProductModal')).hide();
                    e.target.reset(); // Limpiar el formulario
                })
                .catch(error => console.error("Error al crear el producto:", error));
        });
        
        document.getElementById('searchButton').addEventListener('click', () => {
            const searchInput = document.getElementById('searchInput').value;
            if (!searchInput) {
                getProducts();
                return;
            }
            axios.get(`/api/productos/buscar/${searchInput}`)
                .then(response => {
                    const productsDiv = document.getElementById('products');
                    productsDiv.innerHTML = '';
                    response.data.forEach(product => {
                        productsDiv.innerHTML += `
                            <div class="product">
                                <h3>${product.nombre}</h3>
                                <p><strong>Descripción:</strong> ${product.descripcion}</p>
                                <p><strong>Precio:</strong> $${product.precio}</p>
                                <p><strong>Cantidad:</strong> ${product.cantidad}</p>
                                <button class="btn btn-warning" onclick="editProduct(${product.id}, '${product.nombre}', '${product.descripcion}', ${product.precio}, ${product.cantidad})">Editar</button>
                                <button class="btn btn-danger" onclick="showDeleteModal(${product.id})">Eliminar</button>
                            </div>
                        `;
                    });
                });
        });

        // Función para aplicar los filtros
        document.getElementById('confirmFilter').addEventListener('click', () => {
            const sortOption = document.getElementById('sortOption').value;

            axios.get('/api/productos')
                .then(response => {
                    let products = response.data;

                    // Aplicar ordenamiento
                    if (sortOption === 'price_desc') {
                        products.sort((a, b) => b.precio - a.precio); // Precio de mayor a menor
                    } else if (sortOption === 'price_asc') {
                        products.sort((a, b) => a.precio - b.precio); // Precio de menor a mayor
                    } else if (sortOption === 'stock_desc') {
                        products.sort((a, b) => b.cantidad - a.cantidad); // Stock de mayor a menor
                    } else if (sortOption === 'stock_asc') {
                        products.sort((a, b) => a.cantidad - b.cantidad); // Stock de menor a mayor
                    }

                    renderProducts(products); // Mostrar los productos filtrados
                })
                .catch(error => console.error("Error al obtener productos:", error));
        });

        // Función para limpiar los filtros y mostrar todos los productos
        document.getElementById('clearFilter').addEventListener('click', () => {
            document.getElementById('sortOption').value = ""; 
            getProducts(); 
        });

        function renderProducts(products) {
            const productsDiv = document.getElementById('products');
            productsDiv.innerHTML = '';

            products.forEach(product => {
                productsDiv.innerHTML += `
                    <div class="product">
                        <h3>${product.nombre}</h3>
                        <p><strong>Descripción:</strong> ${product.descripcion}</p>
                        <p><strong>Precio:</strong> $${product.precio}</p>
                        <p><strong>Cantidad:</strong> ${product.cantidad}</p>
                        <button class="btn btn-warning" onclick="editProduct(${product.id}, '${product.nombre}', '${product.descripcion}', ${product.precio}, ${product.cantidad})">Editar</button>
                        <button class="btn btn-danger" onclick="showDeleteModal(${product.id})">Eliminar</button>
                    </div>
                `;
            });
        }

        // Cargar productos en el dropdown
        function loadProducts() {
            axios.get('/api/productos')
                .then(response => {
                    const select = document.getElementById('productSelect');
                    select.innerHTML = '<option value="">Seleccionar producto</option>';
                    response.data.forEach(product => {
                        select.innerHTML += `<option value="${product.id}">${product.nombre}</option>`;
                    });
                })
                .catch(error => console.error('Error al cargar productos:', error));
        }

        // Manejar el envío del formulario de inventario
        document.getElementById('inventoryForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const productId = document.getElementById('productSelect').value;
            const type = document.getElementById('movementType').value;
            const quantity = parseInt(document.getElementById('quantity').value, 10);

            if (!productId || quantity <= 0) return;

            axios.post('/api/inventario', {
                product_id: productId,
                operacion: type,
                cantidad: quantity
            })
            .then(() => {
                alert('Inventario actualizado correctamente');
                document.getElementById('inventoryForm').reset();
                bootstrap.Modal.getInstance(document.getElementById('inventoryModal')).hide();
                // cargar la lista de productos
                getProducts();
            })
            .catch(error => console.error('Error al actualizar el inventario:', error));
        });

        // Cargar logs de inventario
        function loadInventoryLogs() {
            axios.get('/api/inventario')
                .then(response => {
                    console.log(response.data);
                    const logsTable = document.getElementById('inventoryLogsTable');
                    logsTable.innerHTML = '';
                    response.data.forEach(log => {
                        logsTable.innerHTML += `
                            <tr>
                                <td>${log.product_id}</td>
                                <td>${log.operacion}</td>
                                <td>${log.cantidad}</td>
                                <td>${new Date(log.created_at).toLocaleString()}</td>
                            </tr>`;
                    });
                })
                .catch(error => console.error('Error al cargar los logs de inventario:', error));
        }

        // Cargar productos cuando se abre el modal
        document.getElementById('inventoryModal').addEventListener('shown.bs.modal', loadProducts);

        // Cargar logs cuando se abre el modal
        document.getElementById('inventoryLogsModal').addEventListener('shown.bs.modal', loadInventoryLogs);
            
        getProducts();
    </script>

</body>

</html>
