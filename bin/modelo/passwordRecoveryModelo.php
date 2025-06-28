<?php

namespace modelo;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use config\connect\connectDB as connectDB;
use helpers\encryption as encryption;
use helpers\JwtHelpers;
use config\componentes\configSistema;
use helpers\ConteoRecuperarHelpers;


class passwordRecoveryModelo extends connectDB
{
    private $correo;
    private $encryption;  
    private $baseUrl;  
    private $sistem;


    public function __construct()
    {
        parent::__construct();
        $this->encryption = new encryption();
        $config = new configSistema();
        $this->baseUrl = rtrim($config->_URL_());
        $this->sistem = new encryption();  
    }

        public function recuperContraseñas($correo) {
            $this->correo = trim($correo);
            $this->correo = ucfirst(strtolower($this->correo));

            if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $this->correo)) {
                return ['resultado' => 'error', 'mensaje' => 'Correo inválido'];
            }

            $verificacion = conteoRecuperarHelpers::verificarBloqueo($this->correo);
            if ($verificacion['bloqueado']) {
                return ['resultado' => 'error', 'mensaje' => $verificacion['mensaje']];
            }

            $resultadoEnvio = $this->enviarCorreoRecuperacion();

            if ($resultadoEnvio['resultado'] === 'no existe' || $resultadoEnvio['resultado'] === 'error') {
                $intento = conteoRecuperarHelpers::registrarIntento($this->correo);
                $mensajeExtra = isset($intento['mensaje']) ? ' ' . $intento['mensaje'] : '';
                return ['resultado' => 'error', 'mensaje' => $resultadoEnvio['mensaje'] . $mensajeExtra];
            }

            conteoRecuperarHelpers::resetearIntentos($this->correo);
            return $resultadoEnvio;
        }



        protected function enviarCorreoRecuperacion() {
            $this->conectarDBSeguridad();
            $correoCifrado = $this->encryption->encryptData($this->correo);
            $stmt = $this->conex2->prepare("SELECT cedula, nombre, segNombre, apellido, segApellido FROM usuario WHERE status = 1 AND correo = ?");
            $stmt->bindValue(1, $correoCifrado);
            $stmt->execute();
            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$usuario) {
                return ['resultado' => 'no existe', 'mensaje' => 'Ingresar correctamente el correo.'];
            }

            return $this->procesarEnvioCorreo($usuario);
        }
        
        protected function procesarEnvioCorreo($usuario) {
            $nombreCompleto = trim($usuario['nombre'] . ' ' . $usuario['segNombre'] . ' ' . $usuario['apellido'] . ' ' . $usuario['segApellido']);
            $codigo = rand(100000, 999999);

            $payload = [
                'correo' => $this->correo,
                'codigo' => $codigo,
                'tipo' => 'recuperacion',
                'exp' => time() + 600 
            ];

            $token = JwtHelpers::generarToken($payload);

            $rutaCifrada = urlencode($this->sistem->encryptURL("cambiarClave"));
            $enlace = $this->baseUrl . "?url=" . $rutaCifrada . "&token=" . urlencode($token);

            return $this->enviarCorreo($nombreCompleto, $codigo, $enlace);
        }
        
        protected function enviarCorreo($nombreCompleto, $codigo, $enlace){
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->SMTPDebug = 0; 
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'servicionutricional2024@gmail.com'; 
                $mail->Password = 'zekydvfmnesbfacj'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->CharSet = 'UTF-8';

                $mail->setFrom('servicionutricional2024@gmail.com', 'Sistema Servicio Nutricional UPTAEB');
                $mail->addAddress($this->correo, $nombreCompleto);

                $mail->isHTML(true);
                $mail->Subject = 'Recuperación de contraseña';

            $body = '
                        <!DOCTYPE html>
                <html lang="es">
                <head>
                    <meta charset="UTF-8" />
                    <title>Restablecer Contraseña</title>
                </head>
                <body style="margin:0; padding:0; background-color:#ffffff; font-family:Arial, sans-serif; color: #000000;">
                    <div class="container" style="width:100%; max-width:600px; margin:30px auto; background-color:#ffffff; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.08); overflow:hidden; border:1px solid #e0e0e0;">

                        <div class="header" style="text-align:center; background-color:#003aa5; padding:25px 15px; color:#ffffff;">
                            <img src="https://i.ibb.co/zr1Tkj8/logo2.png" alt="Logo Servicio Nutricional UPTAEB" style="max-width:100px; margin-bottom:10px;">
                            <h1 style="margin:0; font-size:22px; font-weight:bold;">Restablecer Contraseña</h1>
                        </div>

                        <div class="content" style="padding:25px 20px; text-align:justify; font-size:16px; line-height:1.6; color:#000000;">
                            <p><strong>Hola, ' . htmlspecialchars($nombreCompleto) . '.</strong></p>
                            <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta. Para continuar, por favor haz clic en el botón de abajo.</p>

                            <h2 style="text-align:center; color:#003aa5; font-size:24px; margin:25px 0 10px 0; letter-spacing:2px;">Código Generado:</h2>
                            <h2 style="text-align:center; color:#003aa5; font-size:28px; margin:5px 0;">' . htmlspecialchars($codigo) . '</h2>

                            <p>Recuerda que el código es válido por <strong>10 minutos</strong>. Si el tiempo expira, tendrás que solicitar un nuevo código.</p>

                            <p style="text-align:center; margin:30px 0;">
                                <a href="' . htmlspecialchars($enlace) . '" style="background:#003aa5; color:#fff; padding:12px 25px; text-decoration:none; border-radius:6px; font-weight:bold; display:inline-block;">Restablecer Contraseña</a>
                            </p>
                        </div>

                        <p style="font-size:14px; color:#000000; text-align:center; margin-top:20px;">
                            Si no solicitaste este cambio, por favor ignora este mensaje. Tu cuenta está segura.
                        </p>

                        <div class="footer" style="background-color:#f4f4f4; padding:15px; text-align:center; font-size:12px; color:#000000; border-top:1px solid #dddddd;">
                            Sistema de Gestión Operativa del Servicio Nutricional UPTAEB.
                        </div>

                    </div>
                </body>
                </html>

                    ';

                $mail->Subject = 'Recuperación de contraseña';
                $mail->Body = $body;

                $mail->send();

                return ['resultado' => 'ok', 'mensaje' => 'Correo de recuperación enviado'];
                } catch (Exception $e) {
                return ['resultado' => 'error', 'mensaje' => 'Error al enviar el correo: ' . $mail->ErrorInfo];
                }
         
        }





}

    