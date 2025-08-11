<?php
namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;

class RolesModelo extends connectDB
{
    private $id;
    private $payload;

    public function __construct()
    {
        parent::__construct();
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    }

    private function validarDato($dato, $tipo)
    {
        $expresiones = ['soloLetras' => "/^[a-zA-ZÀ-ÿ\s]{3,}$/"];
        if (!isset($expresiones[$tipo])) {
            return false;
        }
        return !empty($dato) && preg_match($expresiones[$tipo], $dato);
    }



    public function validarRol($rol)
    {
        if (!$this->validarDato($rol, 'soloLetras')) {
            return ['error' => 'El nombre debe contener solo letras y no puede estar vacío.'];
        }

        $this->rol = $rol;
        $resultado = $this->validarR();

        return $resultado === true ? ['resultado' => 'error2'] : ['resultado' => 'no esta duplicado'];

    }

    private function validarR()
    {
        try {
            $this->conectarDBSeguridad();
            $new = $this->conex2->prepare("SELECT nombreRol FROM `rol` WHERE  nombreRol = ? and status !=0");
            $new->bindValue(1, $this->rol);
            $new->execute();
            $data = $new->fetch();
            $this->desconectarDB();
            return !empty($data);

        } catch (\Exception $e) {
            throw new \RuntimeException('Error al verificar el rol: ' . $e->getMessage());
        }
    }

    public function registrarRol($rol)
    {
        try {
            $this->conectarDBSeguridad();
            if (!$this->validarDato($rol, 'soloLetras')) {
                return ['error' => 'El nombre debe contener solo letras y no puede estar vacío.'];
            }
            if ($this->validarR()) {
                return ['resultado' => 'error2'];
            }
            $this->rol = $rol;
            $idRol = $this->insertarRol();
            $this->crearPermisos($idRol);
            return ['resultado' => 'exitoso'];
             

        } catch (\Exception $e) {
            throw new \RuntimeException('Error al registrar el rol y sus permisos: ' . $e->getMessage());
        }
    }


    private function crearPermisos($idRol)
    {
        try {
            $this->conectarDBSeguridad();

            $query = $this->conex2->prepare(" INSERT INTO `permiso`(`nombrePermiso`, `idRol`, `idModulo`, `status`)VALUES (?, ?, ?, ?) ");
            $permisosPorModulo = $this->obtenerPermisosPersonalizados();
            $permisosDefault = ['consultar', 'registrar', 'modificar', 'eliminar'];
            $statusDefault = 0;

            foreach ($this->obtenerModulos() as $modulo) {
                $nombreModulo = $modulo->nombreModulo;
                $idModulo = $modulo->idModulo;

                if (isset($permisosPorModulo[$nombreModulo])) {
                    $permisoInfo = $permisosPorModulo[$nombreModulo];
                    $this->insertarPermisos($query, $permisoInfo['permisos'], $idRol, $idModulo, $permisoInfo['status']);
                } else {
                    $this->insertarPermisos($query, $permisosDefault, $idRol, $idModulo, $statusDefault);
                }
            }

            $this->desconectarDB();
        } catch (\Exception $e) {
            throw new \RuntimeException('Error al crear los permisos: ' . $e->getMessage());
        }
    }

    private function insertarPermisos($query, array $permisos, $idRol, $idModulo, $status)
    {
        foreach ($permisos as $permiso) {
            $query->execute([$permiso, $idRol, $idModulo, $status]);
        }
    }

    private function obtenerPermisosPersonalizados()
    {
        return [
            'Asistencias' => ['permisos' => ['consultar', 'registrar'], 'status' => 0],
            'Estudiantes' => ['permisos' => ['consultar', 'registrar'], 'status' => 0],
            'Home' => ['permisos' => ['consultar'], 'status' => 1],
            'Reporte Estadistico' => ['permisos' => ['consultar'], 'status' => 0],
            'Bitacora' => ['permisos' => ['consultar'], 'status' => 0],
            'Permisos' => ['permisos' => ['consultar', 'modificar'], 'status' => 0],
            'Modulos' => ['permisos' => ['consultar', 'modificar'], 'status' => 0],
            'Inventario de Alimentos' => ['permisos' => ['consultar', 'registrar', 'eliminar'], 'status' => 0],
            'Inventario de Utensilios' => ['permisos' => ['consultar', 'registrar', 'eliminar'], 'status' => 0],
            'Mantenimiento' => ['permisos' => ['Exportar', 'Importar'], 'status' => 0],
        ];
    }

    private function obtenerModulos()
    {
        try {
            $this->conectarDBSeguridad();
            $query = $this->conex2->prepare("SELECT * FROM `modulo` WHERE status !=0;");
            $query->execute();
            $data = $query->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            return $data;
        } catch (\Exception $e) {
            throw new \RuntimeException('Error al obtener los modulos: ' . $e->getMessage());
        }
    }

    private function insertarRol()
    {
        try {
            $this->conectarDBSeguridad();
            $query = $this->conex2->prepare("INSERT INTO `rol`(`nombreRol`, `status`) VALUES (?,1)");
            $query->bindValue(1, $this->rol);
            $query->execute();
            $id = $this->conex2->lastInsertId();
            $bitacora = new bitacoraModelo;
            $bitacora->registrarBitacora('Roles', 'Registró un rol llamado: ' . $this->rol, $this->payload->cedula);
            $this->desconectarDB();
            return $id;

        } catch (\Exception $e) {
            throw new \RuntimeException('Error al registrar el rol: ' . $e->getMessage());
        }

    }


    public function mostrarRolesTabla()
    {
        try {
            $this->conectarDBSeguridad();
            $new = $this->conex2->prepare("SELECT * FROM `rol` WHERE status !=0;");
            $new->execute();
            $data = $new->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            return $data;
        } catch (\PDOException $e) {
            return $e;
        }
    }

    public function muestraRol($id)
    {
        if (!preg_match("/^[0-9]{1,}$/", $id)) {
            $resultado = ['resultado' => 'Ingresar el id del rol'];
            return $resultado;
        } else {
            $this->id = $id;
            return $this->selectRol();
        }
    }

    private function selectRol()
    {
        try {
            $this->conectarDBSeguridad();
            $query = $this->conex2->prepare("SELECT idRol, nombreRol, status FROM rol WHERE idRol =?");
            $query->bindValue(1, $this->id);
            $query->execute();
            $data = $query->fetchAll(\PDO::FETCH_ASSOC);
            $this->desconectarDB();
            return $data;

        } catch (\PDOException $e) {
            return $e;
        }
    }

    public function verificarExistencia($id)
    {
        if (!preg_match("/^[0-9]{1,}$/", $id)) {
            return ['resultado' => 'Ingresar el id del rol'];
        }
        $this->id = $id;
        $resultado = $this->verificarE();
        return $resultado === true ? ['resultado' => 'si existe'] : ['resultado' => 'ya no existe'];
    }

    private function verificarE()
    {

        try {
            $this->conectarDBSeguridad();
            $mostrar = $this->conex2->prepare(" SELECT * FROM rol WHERE idRol = ? and status !=0");
            $mostrar->bindValue(1, $this->id);
            $mostrar->execute();
            $data = $mostrar->fetch();
            $this->desconectarDB();
            return !empty($data);
        } catch (\Exception $e) {
            throw new \RuntimeException('Error al verificar existencia del rol: ' . $e->getMessage());
        }
    }

    public function validarRol2($rol, $id)
    {
        $errores = [];

        if (!preg_match("/^[0-9]{1,}$/", $id)) {
            $errores[] = 'Ingresar el id del rol';
        }
        if (!preg_match("/^[a-zA-ZÀ-ÿ\s]{3,}$/", $rol)) {
            $errores[] = 'Ingresar el nombre del rol';
        }

        if (!empty($errores)) {
            return ['resultado' => implode(", ", $errores)];
        }

        $this->rol = $rol;
        $this->id = $id;
        $resultado = $this->valRol2();
        return $resultado === true ? ['resultado' => 'errorRol'] : ['resultado' => 'no esta duplicado'];
    }

    private function valRol2()
    {
        try {
            $this->conectarDBSeguridad();
            $new = $this->conex2->prepare("SELECT idRol FROM `rol` WHERE   nombreRol = ? and idRol !=? and status !=0");
            $new->bindValue(1, $this->rol);
            $new->bindValue(2, $this->id);
            $new->execute();
            $data = $new->fetchAll();
            $this->desconectarDB();
            return !empty($data);

        } catch (\Exception $e) {
            throw new \RuntimeException('Error al verificar duplicacion del rol: ' . $e->getMessage());
        }

    }

    public function editarRol($rol, $id)
    {
        $rolActual = $this->payload->rol;

        if ($id == 1 && $rolActual != 1) {
            return ['resultado' => 'No tienes permiso para editar el rol de Super Usuario.'];
        }
        if (!$this->validarDato($rol, 'soloLetras')) {
            return ['error' => 'El nombre debe contener solo letras y no puede estar vacío.'];
        }
        if (!preg_match("/^[0-9]{1,}$/", $id)) {
            return ['resultado' => 'Ingresar el id del rol'];
        }
        if($this->validarR()) {
            return ['resultado' => 'errorRol'];
        }
        if($this->verificarE() === false) {
            return ['resultado' => 'ya no existe'];
        }
        $this->rol = $rol;
        $this->id = $id;
        return $this->actualizarRol();
    }


    private function actualizarRol()
    {
        try {
            $this->conectarDBSeguridad();
            $this->conex2->beginTransaction();
            $query = $this->conex2->prepare("UPDATE rol SET `nombreRol` = ? WHERE idRol = ?");
            $query->bindValue(1, $this->rol);
            $query->bindValue(2, $this->id);
            $query->execute();

            if ($query->rowCount() > 0) {
                $bitacora = new bitacoraModelo;
                $bitacora->registrarBitacora('Roles', 'Se Modificó un rol llamado: ' . $this->rol, $this->payload->cedula);
                $this->conex2->commit();

                $resultado = ['resultado' => 'Rol actualizado exitosamente'];
            } else {
                $this->conex2->rollBack();
                $resultado = ['resultado' => 'no hubo cambios'];
            }
            return $resultado;

        } catch (\PDOException $e) {
            $this->conex2->rollBack();
            throw new \RuntimeException('Error al actualizar el rol: ' . $e->getMessage());
        } finally {
            $this->desconectarDB();
        }
    }


    public function eliminarRol($id)
    {
        $rolActual = $this->payload->rol;

        if (!preg_match("/^[0-9]{1,}$/", $id)) {
            return ['resultado' => 'Ingresar el id del rol'];
        }

        if ($rolActual == $id) {
            return ['resultado' => 'No puedes eliminar el rol con el que iniciaste sesión.'];
        }
        if($this->verificarE() === false) {
            return ['resultado' => 'ya no existe'];
        }

        if ($this->esSuperUsuario($id)) {
            return ['resultado' => 'No puedes eliminar el rol de super usuario.'];
        }

        if($this->usuariosRegistradosConRol($id)['resultado'] === 'usuarios_asociados') {
            return ['resultado' => 'No puedes eliminar este rol porque hay usuarios asociados a él.'];
        }

        $this->id = $id;
        return $this->borrarRol();
    }

    private function borrarRol()
    {
        try {
            $this->conectarDBSeguridad();
            $this->conex2->beginTransaction();
            $querySelect = $this->conex2->prepare("SELECT `nombreRol` FROM `rol` WHERE idRol = ? AND status = 1");
            $querySelect->bindValue(1, $this->id);
            $querySelect->execute();
            $resultado = $querySelect->fetch(\PDO::FETCH_ASSOC);

            if ($resultado) {
                $nombreR = $resultado['nombreRol'];
                $query = $this->conex2->prepare("UPDATE `rol` SET `status`='0' WHERE idRol = ?");
                $query->bindValue(1, $this->id);
                $query->execute();

                if ($query->rowCount() > 0) {
                    $bitacora = new bitacoraModelo;
                    $bitacora->registrarBitacora('Roles', 'Se anuló un rol llamado: ' . $nombreR, $this->payload->cedula);
                    $this->conex2->commit();
                    return ['resultado' => 'anulado correctamente.'];
                } else {
                    $this->conex2->rollBack();
                    return ['mensaje' => 'No se encontró el rol o no se pudo anular'];
                }
            } else {
                $this->conex2->rollBack();
                return ['mensaje' => 'No se encontró el rol'];
            }
        } catch (\PDOException $e) {
            $this->conex2->rollBack();
            throw new \RuntimeException('Error al borrar el rol: ' . $e->getMessage());
        } finally {
            $this->desconectarDB();
        }
    }



    public function usuariosRegistradosConRol($idRol)
    {
        if (!preg_match("/^[0-9]{1,}$/", $idRol)) {
            return ['resultado' => 'Ingresar el id del rol'];
        }
        $this->idRol = $idRol;
        return $this->usuariosRegistrados();
    }

    private function usuariosRegistrados()
    {
        try {
            $this->conectarDBSeguridad();
            $query = $this->conex2->prepare("SELECT COUNT(*) as total FROM usuario WHERE idRol = ? AND status = 1");
            $query->bindValue(1, $this->idRol);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $this->desconectarDB();
            if ($result['total'] > 0) {
                return ['resultado' => 'usuarios_asociados'];
            } else {
                return ['resultado' => 'se puede'];
            }
        } catch (\Exception $e) {
            throw new \RuntimeException('Error al obtener el rol: ' . $e->getMessage());
        }
    }

    private function esSuperUsuario($id)
    {
        try {
            $this->conectarDBSeguridad();
            $query = $this->conex2->prepare("SELECT nombreRol FROM rol WHERE idRol = ?");
            $query->bindValue(1, $id);
            $query->execute();
            $resultado = $query->fetch(\PDO::FETCH_ASSOC);
            $this->desconectarDB();

            return ($resultado['nombreRol'] == 'super usuario');

        } catch (\Exception $e) {
            throw new \RuntimeException('Error al obtener el rol: ' . $e->getMessage());
        }
    }

    private function informacion($id)
    {
        $this->id = $id;

        try {
            $this->conectarDBSeguridad();
            $mostrar = $this->conex2->prepare(" SELECT * FROM `rol` WHERE idRol=? ");
            $mostrar->bindValue(1, $this->id);
            $mostrar->execute();
            $data = $mostrar->fetchAll();
            $this->desconectarDB();
            return $data;

        } catch (\Exception $e) {
            throw new \RuntimeException('Error al obtener la info del rol: ' . $e->getMessage());
        }
    }

}


