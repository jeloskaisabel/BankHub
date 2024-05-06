<?php
include 'db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

try {
    $conn = getConnection();
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        handleGet($conn);
        break;
    case 'POST':
        handlePost($conn);
        break;
    default:
        echo json_encode(['error' => 'Método no soportado']);
        break;
}

$conn = null; // Cerrar conexión

function handleGet($conn) {
    $table = isset($_GET['table']) ? $_GET['table'] : '';
    $id = isset($_GET['id']) ? $_GET['id'] : null; // Obtener el ID si está presente

    if (!in_array($table, ['personas', 'cuentas_bancarias', 'transacciones'])) {
        echo json_encode(['error' => 'Nombre de tabla no válido']);
        return;
    }

    if ($id !== null) {
        // Asumimos que cada tabla tiene una columna 'id' que es la clave primaria
        $stmt = $conn->prepare("SELECT * FROM {$table} WHERE id = ?");
        $stmt->execute([$id]);
    } else {
        // Si no se proporciona ID, devolvemos todos los registros (como estaba antes)
        $stmt = $conn->prepare("SELECT * FROM {$table}");
        $stmt->execute();
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($results)) {
        echo json_encode(['error' => 'No se encontró el registro']);
        return;
    }
    echo json_encode($results);
}


function handlePost($conn) {
    $data = json_decode(file_get_contents('php://input'), true);
    $table = $data['table'] ?? null; // Uso de operador de fusión de null para evitar errores undefined index

    if (!in_array($table, ['personas', 'cuentas_bancarias', 'transacciones'])) {
        echo json_encode(['error' => 'Nombre de tabla no válido']);
        return;
    }

    switch ($table) {
        case 'personas':
            // Verificar que todos los campos necesarios estén presentes
            if (!isset($data['nombre'], $data['apellido'], $data['fecha_nacimiento'], $data['documento_identidad'], $data['direccion'], $data['telefono'], $data['email'])) {
                echo json_encode(['error' => 'Datos incompletos para la tabla personas']);
                return;
            }

            // Añade aquí validaciones adicionales si es necesario, por ejemplo, verificar que el email tiene formato correcto
            // ...

            // Preparar y ejecutar la inserción
            $stmt = $conn->prepare("INSERT INTO personas (nombre, apellido, fecha_nacimiento, documento_identidad, direccion, telefono, email) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['nombre'], 
                $data['apellido'], 
                $data['fecha_nacimiento'], 
                $data['documento_identidad'], 
                $data['direccion'], 
                $data['telefono'], 
                $data['email']
            ]);
            break;

        case 'cuentas_bancarias':
            // Verificar que todos los campos necesarios estén presentes
            if (!isset($data['persona_id'], $data['tipo_cuenta'], $data['saldo'], $data['moneda'])) {
                echo json_encode(['error' => 'Datos incompletos para la tabla cuentas bancarias']);
                return;
            }

            // Preparar y ejecutar la inserción
            $stmt = $conn->prepare("INSERT INTO cuentas_bancarias (persona_id, tipo_cuenta, saldo, moneda) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $data['persona_id'], 
                $data['tipo_cuenta'], 
                $data['saldo'], 
                $data['moneda']
            ]);
            break;

        case 'transacciones':
            // Verificar que todos los campos necesarios estén presentes
            if (!isset($data['cuenta_bancaria_id'], $data['tipo_transaccion'], $data['monto'], $data['fecha_transaccion'])) {
                echo json_encode(['error' => 'Datos incompletos para la tabla transacciones']);
                return;
            }

            // Preparar y ejecutar la inserción
            $stmt = $conn->prepare("INSERT INTO transacciones (cuenta_bancaria_id, tipo_transaccion, monto, fecha_transaccion) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $data['cuenta_bancaria_id'], 
                $data['tipo_transaccion'], 
                $data['monto'], 
                $data['fecha_transaccion']
            ]);
            break;

        default:
            echo json_encode(['error' => 'Operación no soportada para la tabla especificada']);
            return;
    }

    // Si todo fue exitoso, envía un mensaje de éxito con los datos insertados
    echo json_encode(['status' => 'success', 'data' => $data]);
}

?>
