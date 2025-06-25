<?php

namespace modelo;

use config\connect\connectDB as connectDB;
use helpers\encryption as encryption;
use helpers\JwtHelpers;

 
class cambiarClaveModelo extends connectDB
{
    private $correo;
    private $encryption;    
    private $codigo;
    private $nuevaClave;    
    private $confirmarClave;


    public function __construct()
    {
        parent::__construct();
        $this->encryption = new encryption();
    }

        public function actualizarClaveRecuperacion($token, $codigo, $nuevaClave, $confirmarClave){
            $this->codigo = trim($codigo);
            $this->nuevaClave = trim($nuevaClave);
            $this->confirmarClave = trim($confirmarClave);

            $datos = JwtHelpers::verificarTokenPersonalizado($token);

            if (!$datos) {
                return ['resultado' => 'error', 'mensaje' => 'Token inválido o expirado'];
            }

            if (!$datos || $datos['tipo'] !== 'recuperacion') {
                return ['resultado' => 'error', 'mensaje' => 'Token de token inválido'];
            }

            if ($datos['codigo'] != $this->codigo) {
                return ['resultado' => 'error', 'mensaje' => 'Código incorrecto'];
            }

            if ($this->nuevaClave !== $this->confirmarClave) {
                return ['resultado' => 'error', 'mensaje' => 'Las contraseñas no coinciden'];
            }

            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\*\-_\.\;\,\(\)\"@#\$=])[A-Za-z\d\*\-_\.\;\,\(\)\"@#\$=]{8,}$/', $this->nuevaClave)) {
                return ['resultado' => 'error', 'mensaje' => 'La contraseña no cumple con los requisitos mínimos de seguridad'];
            }

            return $this->validarYActualizarClave($datos['correo']);
        }

        private function validarYActualizarClave($correo){
            try {
                $claveHash = password_hash($this->nuevaClave, PASSWORD_BCRYPT);
                $correoCifrado = $this->encryption->encryptData($correo);

                $this->conectarDBSeguridad();
                $sql = $this->conex2->prepare("UPDATE usuario SET clave = ? WHERE correo = ?");
                $sql->bindValue(1, $claveHash);
                $sql->bindValue(2, $correoCifrado);
                $sql->execute();

                return [
                    'resultado' => 'ok',
                    'mensaje' => 'Contraseña actualizada correctamente',
                    'url' => '?url=' . urlencode($this->encryption->encryptURL('login'))
                ];
            } catch (\Exception $e) {
                return ['resultado' => 'error', 'mensaje' => 'Error interno: ' . $e->getMessage()];
            }
        }











}

    