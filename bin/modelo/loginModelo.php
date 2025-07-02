<?php

namespace modelo;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use config\connect\connectDB as connectDB;
use helpers\encryption as encryption;
use helpers\JwtHelpers;
use helpers\ConteoLoginHelpers; // Importar la clase para manejar intentos

class loginModelo extends connectDB
{
    private $cedula;
    private $clave;
    private $correo;
    private $nombre2;
    private $segNombre;
    private $apellido;
    private $segApellido;
    private $sistem;
    private $encryption;


    public function __construct()
    {
        parent::__construct();
         $this->encryption = new encryption(); 
    }

    public function loginSistema($cedula, $clave)
    {
        $this->cedula = trim($cedula);
        $this->clave = $clave;
        $this->sistem = new encryption();


        // Validar inputs antes de llamar login privada
        if (empty($this->cedula) || empty($this->clave)) {
            return ['resultado' => 'error', 'mensaje' => 'Cédula y contraseña son obligatorios.'];
        }

        // Solo verificar si está bloqueado, NO registrar intento aquí
        $verificacion = ConteoLoginHelpers::verificarBloqueo($this->cedula);
        if ($verificacion['bloqueado']) {
            return ['resultado' => 'error', 'mensaje' => $verificacion['mensaje']];
        }

        $resultado = $this->login();

        // Si el login es exitoso, resetear intentos
        if ($resultado['resultado'] === 'success') {
            ConteoLoginHelpers::resetearIntentos($this->cedula);
            return $resultado;
        } else if ($resultado['resultado'] === 'error') {
            // Solo aquí registrar el intento fallido
            $intento = ConteoLoginHelpers::registrarIntento($this->cedula);
            $resultado['mensaje'] .= isset($intento['mensaje']) ? ' ' . $intento['mensaje'] : '';
        }

        return $resultado;
    }

    private function login()
    {
        try {
            $this->conectarDBSeguridad();
            $data = $this->conex2->prepare("SELECT u.cedula, u.nombre, u.apellido, u.correo, u.img, u.clave, u.idRol, u.status, r.nombreRol 
            FROM usuario u 
            LEFT JOIN rol r ON u.idRol = r.idRol 
            WHERE u.cedula = ? AND u.status = 1");
            $data->bindValue(1, $this->cedula);
            $data->execute();
            $user = $data->fetch(\PDO::FETCH_ASSOC);
            $this->desconectarDB();

            if (!$user) {
                return ['resultado' => 'error', 'mensaje' => 'Usuario o contraseña incorrectos'];
            }

            if (!password_verify($this->clave, $user['clave'])) {
                return ['resultado' => 'error', 'mensaje' => 'Usuario o contraseña incorrectos'];
            }
            
            $user['correo'] = $this->encryption->decryptData($user['correo']);

            // Login correcto, crear payload JWT
            $payload = [
                'cedula' => $user['cedula'],
                'nombre' => $user['nombre'],
                'apellido' => $user['apellido'],
                'correo' => $user['correo'],
                'img' => $user['img'],
                'rol' => $user['idRol'],
                'nombreRol' => $user['nombreRol']
            ];

            // Registrar en bitácora


            $token = JwtHelpers::generarToken($payload);
            setcookie('jwt', $token, time() + 3600 * 6, "/", "", false, true);

            $bitacora = new bitacoraModelo;
            $bitacora->registrarBitacora('Login', 'El Usuario ' . $payload['nombre'] . ' ' . $payload['apellido'] . ': Inició sesión', $payload['cedula']);

            $url = $user['idRol'] != 1 ? 'horarioComida' : 'home';
            $encryptedURL = urlencode($this->sistem->encryptURL($url));

            return [ 
                'resultado' => 'success', 
                'url' => '?url=' . $encryptedURL,
                'token' => $token  ];

                
        } catch (\PDOException $e) {
            error_log("Error PDO en loginSistema: " . $e->getMessage());
            return ['resultado' => 'error', 'mensaje' => 'Error interno del sistema. Intente más tarde.'];
        } catch (\Exception $e) {
            error_log("Error general en loginSistema: " . $e->getMessage());
            return ['resultado' => 'error', 'mensaje' => 'Error interno del sistema. Intente más tarde.'];
        }
    }
}
