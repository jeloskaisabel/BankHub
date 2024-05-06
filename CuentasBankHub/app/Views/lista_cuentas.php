<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Cuentas Bancarias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">Cuentas Bancarias</h1>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Titular</th>
                <th>Tipo de Cuenta</th>
                <th>Saldo</th>
                <th>Moneda</th>
                <th>Transacciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cuentas as $cuenta): ?>
            <tr>
                <td><?= $cuenta['id']; ?></td>
                <td><?= $cuenta['nombre'] . ' ' . $cuenta['apellido']; ?></td>
                <td><?= $cuenta['tipo_cuenta']; ?></td>
                <td><?= $cuenta['saldo']; ?></td>
                <td><?= $cuenta['moneda']; ?></td>
                <td>
                    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#transacciones<?= $cuenta['id']; ?>" aria-expanded="false" aria-controls="transacciones<?= $cuenta['id']; ?>">
                        Mostrar Transacciones
                    </button>
                    <div class="collapse" id="transacciones<?= $cuenta['id']; ?>">
                        <ul class="list-group mt-2">
                            <?php if (count($cuenta['transacciones']) > 0): ?>
                                <?php foreach ($cuenta['transacciones'] as $transaccion): ?>
                                    <li class="list-group-item">Monto: <?= $transaccion['monto']; ?>, Fecha: <?= $transaccion['fecha_transaccion']; ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="list-group-item">Sin transacciones</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </td>
                <td>
                    <a href="<?= site_url('cuentas/eliminar/' . $cuenta['id']); ?>" class="btn btn-danger btn-sm">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
