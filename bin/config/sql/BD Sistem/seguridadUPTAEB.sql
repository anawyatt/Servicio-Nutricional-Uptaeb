
            SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
            START TRANSACTION;
            SET time_zone = "+00:00";
            CREATE DATABASE seguridadUPTAEB;
            USE seguridadUPTAEB;

        CREATE TABLE rol(
            idRol INT AUTO_INCREMENT PRIMARY KEY,
            nombreRol VARCHAR(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            status tinyint(1) NOT NULL
        )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 

        INSERT INTO `rol` (`idRol`, `nombreRol`, `status`) VALUES
        (1, 'Super Usuario', 1);

        CREATE TABLE modulo(
            idModulo INT AUTO_INCREMENT PRIMARY KEY,
            nombreModulo VARCHAR(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            status tinyint(1) NOT NULL
        )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


        INSERT INTO `modulo` (`idModulo`, `nombreModulo`, `status`) VALUES
        (1, 'Home', 1),
        (2, 'Usuarios', 1),
        (3, 'Roles', 1),
        (4, 'Modulos', 1),
        (5, 'Permisos', 1),
        (6, 'Bitacora', 1),
        (7, 'Estudiantes', 1),
        (8, 'Asistencias', 1),
        (9, 'Menú', 1),
        (10, 'Eventos', 1),
        (11, 'Tipos de Alimentos', 1),
        (12, 'Alimentos', 1),
        (13, 'Inventario de Alimentos', 1),
        (14, 'Tipos de Utensilios', 1),
        (15, 'Utensilios', 1),
        (16, 'Inventario de Utensilios', 1),
        (17, 'Tipos de Salidas', 1),
        (18, 'Reporte Estadistico', 1),
        (19, 'Mantenimiento', 1);

        CREATE TABLE permiso(
            idPermiso INT AUTO_INCREMENT PRIMARY KEY,
            nombrePermiso VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            idRol INT NOT NULL,
            idModulo INT NOT NULL,
            status tinyint(1) NOT NULL,
            FOREIGN KEY(idRol) REFERENCES rol(idRol),
            FOREIGN KEY(idModulo) REFERENCES modulo(idModulo)
        )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        INSERT INTO `permiso` (`idPermiso`, `nombrePermiso`, `idRol`, `idModulo`, `status`) VALUES
        (1, 'consultar', 1, 1, 1),
        (3, 'consultar', 1, 2, 1),
        (4, 'registrar', 1, 2, 1),
        (5, 'modificar', 1, 2, 1),
        (6, 'eliminar', 1, 2, 1),
        (7, 'consultar', 1, 3, 1),
        (8, 'registrar', 1, 3, 1),
        (9, 'modificar', 1, 3, 1),
        (10, 'eliminar', 1, 3, 1),
        (11, 'consultar', 1, 4, 1),
        (12, 'modificar', 1, 4, 1),
        (13, 'consultar', 1, 5, 1),
        (14, 'modificar', 1, 5, 1),
        (15, 'consultar', 1, 6, 1),
        (16, 'consultar', 1, 7, 1),
        (17, 'registrar', 1, 7, 1),
        (18, 'consultar', 1, 8, 1),
        (19, 'registrar', 1, 8, 1),
        (20, 'modificar', 1, 8, 1),
        (21, 'eliminar', 1, 8, 1),
        (22, 'consultar', 1, 9, 1),
        (23, 'registrar', 1, 9, 1),
        (24, 'modificar', 1, 9, 1),
        (25, 'eliminar', 1, 9, 1),
        (26, 'consultar', 1, 10, 1),
        (27, 'registrar', 1, 10, 1),
        (28, 'modificar', 1, 10, 1),
        (29, 'modificar', 1, 10, 1),
        (30, 'eliminar', 1, 10, 1),
        (31, 'consultar', 1, 11, 1),
        (32, 'registrar', 1, 11, 1),
        (33, 'modificar', 1, 11, 1),
        (34, 'eliminar', 1, 11, 1),
        (35, 'consultar', 1, 12, 1),
        (36, 'registrar', 1, 12, 1),
        (37, 'modificar', 1, 12, 1),
        (38, 'eliminar', 1, 12, 1),
        (39, 'consultar', 1, 13, 1),
        (40, 'registrar', 1, 13, 1),
        (41, 'eliminar', 1, 13, 1),
        (42, 'consultar', 1, 14, 1),
        (43, 'registrar', 1, 14, 1),
        (44, 'modificar', 1, 14, 1),
        (45, 'eliminar', 1, 14, 1),
        (46, 'consultar', 1, 15, 1),
        (47, 'registrar', 1, 15, 1),
        (48, 'modificar', 1, 15, 1),
        (49, 'eliminar', 1, 15, 1),
        (50, 'consultar', 1, 16, 1),
        (51, 'registrar', 1, 16, 1),
        (52, 'eliminar', 1, 16, 1),
        (53, 'consultar', 1, 17, 1),
        (54, 'registrar', 1, 17, 1),
        (55, 'modificar', 1, 17, 1),
        (56, 'eliminar', 1, 17, 1),
        (57, 'consultar', 1, 18, 1),
        (58, 'Exportar', 1, 19, 1),
        (59, 'Importar', 1,19, 1);


        CREATE TABLE usuario(
            cedula INT PRIMARY KEY,
            img VARCHAR(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            nombre VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            segNombre VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            apellido VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            segApellido VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            correo VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            telefono VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            clave VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            idRol INT NOT NULL,
            status tinyint(1) NOT NULL, 
            FOREIGN KEY(idRol) REFERENCES rol(idRol)
        )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        INSERT INTO `usuario` (`cedula`, `img`, `nombre`, `segNombre`, `apellido`, `segApellido`, `correo`, `telefono`, `clave`, `idRol`, `status`) VALUES
        (12345678, 'assets/images/perfil/user.png', 'Servicio', 'Andres', 'Nutricional ', 'Eloy', 'ydjYy701fmCFBES2ecJ1SZm0WBfzpLfIVL0IAnlf52VBbvcNHQ/Ey1csGeE6ASwN', '0424 - 0000099', '$2y$10$M.vMxIOMqGZGDDW6RLoOOOkmDC5AIDzAkM0J2WeNtlGeV6OwcHYL.', 1, 1);

        CREATE TABLE bitacora(
            idBitacora INT AUTO_INCREMENT PRIMARY KEY,
            modulo VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            acciones VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            fecha date NOT NULL DEFAULT current_timestamp(),
            hora time NOT NULL DEFAULT current_timestamp(),
            cedula INT NOT NULL,
            status tinyint(1) NOT NULL,
            FOREIGN KEY(cedula) REFERENCES usuario(cedula)
        )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        CREATE TABLE notificaciones (
          idNotificaciones INT(11) NOT NULL AUTO_INCREMENT,
          titulo VARCHAR(255) NOT NULL,
          mensaje TEXT NOT NULL,
          tipo VARCHAR(255) NOT NULL,
          fechaNoti DATE NOT NULL,
          PRIMARY KEY (idNotificaciones)
        );

        CREATE TABLE notificaciones_usuarios(
          cedula int (11),
          idNotificaciones int (11),
          leida int (11),
          PRIMARY KEY (cedula,idNotificaciones),
          FOREIGN KEY (cedula) REFERENCES usuario(cedula),
          FOREIGN KEY (idNotificaciones) REFERENCES notificaciones(idNotificaciones)
        );
     
        COMMIT;

        
        START TRANSACTION;
        DELIMITER //

        CREATE PROCEDURE sp_registrar_bitacora(
            IN p_modulo VARCHAR(100),
            IN p_acciones TEXT,
            IN p_cedula VARCHAR(20)
        )
        BEGIN
            INSERT INTO bitacora (modulo, acciones, fecha, hora, cedula, status)
            VALUES (p_modulo, p_acciones, DEFAULT, DEFAULT, p_cedula, 1);
        END //

        DELIMITER ;
        
        CREATE INDEX idx_usuario_idRol ON usuario(idRol);
        CREATE INDEX idx_usuario_cedula ON usuario(cedula);
        CREATE INDEX idx_bitacora_cedula ON bitacora(cedula);
        CREATE INDEX idx_bitacora_fecha ON bitacora(fecha);

        CREATE INDEX idx_bitacora_hora ON bitacora(hora);
            -- Vista actualizada con idBitacora
CREATE OR REPLACE VIEW vista_bitacora_usuario AS
SELECT 
    b.idBitacora,
    b.modulo,
    b.fecha,
    b.hora,
    b.cedula,
    u.nombre,
    u.apellido,
    u.img,
    u.idRol
FROM 
    bitacora b
INNER JOIN 
    usuario u ON u.cedula = b.cedula
WHERE 
    b.status = 1;

        
-- Procedure actualizado con paginación
DELIMITER //

DROP PROCEDURE IF EXISTS proc_mostrar_bitacora1//

CREATE PROCEDURE proc_mostrar_bitacora1(
    IN p_cedula VARCHAR(20),
    IN p_idRol INT,
    IN p_fechaInicio DATE,
    IN p_fechaFin DATE,
    IN p_start INT,
    IN p_length INT,
    IN p_search VARCHAR(255),
    IN p_orderBy VARCHAR(50),
    IN p_orderDir VARCHAR(4)
)
BEGIN
    DECLARE v_sql TEXT;
    DECLARE v_where_clause TEXT DEFAULT '';
    DECLARE v_search_clause TEXT DEFAULT '';
    DECLARE v_order_clause TEXT DEFAULT '';
    
    -- Construir WHERE clause base según el rol
    IF p_idRol = 1 THEN
        -- Superusuario: puede ver todo
        SET v_where_clause = 'WHERE 1=1';
    ELSE
        -- Usuario normal: ve todo menos lo propio y sin los de rol=1
        SET v_where_clause = CONCAT('WHERE idRol != 1 AND cedula != "', p_cedula, '"');
    END IF;
    
    -- Agregar filtro de fechas si se proporcionan
    IF p_fechaInicio IS NOT NULL AND p_fechaFin IS NOT NULL THEN
        SET v_where_clause = CONCAT(v_where_clause, ' AND fecha BETWEEN "', p_fechaInicio, '" AND "', p_fechaFin, '"');
    END IF;
    
    -- Agregar búsqueda si se proporciona
    IF p_search IS NOT NULL AND p_search != '' THEN
        SET v_search_clause = CONCAT(' AND (nombre LIKE "%', p_search, '%" OR apellido LIKE "%', p_search, '%" OR modulo LIKE "%', p_search, '%")');
    END IF;
    
    -- Construir ORDER BY clause
    SET v_order_clause = CONCAT(' ORDER BY ', p_orderBy, ' ', p_orderDir);
    
    -- 1. Consulta principal con paginación
    SET @sql = CONCAT(
        'SELECT idBitacora, modulo, fecha, hora, cedula, nombre, apellido, img FROM vista_bitacora_usuario ',
        v_where_clause,
        v_search_clause,
        v_order_clause,
        ' LIMIT ', p_start, ', ', p_length
    );
    
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    
    -- 2. Contar total de registros (sin filtros de búsqueda ni paginación)
    SET @sql_total = CONCAT(
        'SELECT COUNT(*) as total FROM vista_bitacora_usuario ',
        v_where_clause
    );
    
    PREPARE stmt_total FROM @sql_total;
    EXECUTE stmt_total;
    DEALLOCATE PREPARE stmt_total;
    
    -- 3. Contar registros filtrados (con búsqueda pero sin paginación)
    SET @sql_filtered = CONCAT(
        'SELECT COUNT(*) as filtered FROM vista_bitacora_usuario ',
        v_where_clause,
        v_search_clause
    );
    
    PREPARE stmt_filtered FROM @sql_filtered;
    EXECUTE stmt_filtered;
    DEALLOCATE PREPARE stmt_filtered;

END //

DELIMITER ;
       
        DELIMITER $$

        CREATE PROCEDURE proc_ver_acciones_bitacora(
            IN p_cedula VARCHAR(30),
            IN p_idBitacora INT
        )
        BEGIN
            SELECT 
                acciones, 
                modulo, 
                fecha, 
                hora 
            FROM 
                bitacora
            WHERE 
                cedula = p_cedula 
                AND idBitacora = p_idBitacora 
                AND status = 1
            ORDER BY fecha DESC, hora DESC;
        END$$

        DELIMITER ;


          -- Índices en la tabla usuario
        CREATE INDEX idx_usuario_correo ON usuario(correo);
        CREATE INDEX idx_usuario_telefono ON usuario(telefono);
        CREATE INDEX idx_usuario_status ON usuario(status);


        -- Índice en la tabla rol
        CREATE INDEX idx_rol_idRol ON rol(idRol);

          DELIMITER //

        CREATE PROCEDURE proceRegistrarUsuario (
            IN p_cedula INT,
            IN p_img VARCHAR(255),
            IN p_nombre VARCHAR(100),
            IN p_segNombre VARCHAR(100),
            IN p_apellido VARCHAR(100),
            IN p_segApellido VARCHAR(100),
            IN p_correo VARCHAR(500),
            IN p_telefono VARCHAR(200),
            IN p_clave VARCHAR(255),
            IN p_idRol INT
        )
        BEGIN
            DECLARE existe INT;

            SELECT COUNT(*) INTO existe FROM usuario WHERE cedula = p_cedula AND status = 0;

            IF existe > 0 THEN
                UPDATE usuario 
                SET img = p_img, 
                    nombre = p_nombre, 
                    segNombre = p_segNombre, 
                    apellido = p_apellido,
                    segApellido = p_segApellido, 
                    correo = p_correo, 
                    telefono = p_telefono, 
                    clave = p_clave, 
                    idRol = p_idRol,
                    status = 1 
                WHERE cedula = p_cedula AND status = 0;
            ELSE
                INSERT INTO usuario (
                    cedula, img, nombre, segNombre, apellido, segApellido,
                    correo, telefono, clave, idRol, status
                )
                VALUES (
                    p_cedula, p_img, p_nombre, p_segNombre, p_apellido,
                    p_segApellido, p_correo, p_telefono, p_clave, p_idRol, 1
                );
            END IF;
        END //

        DELIMITER ;

         CREATE OR REPLACE VIEW vista_usuarios_info AS 
            SELECT  
                u.cedula, 
                u.img, 
                u.nombre, 
                u.segNombre, 
                u.apellido, 
                u.segApellido, 
                u.correo, 
                u.telefono, 
                u.status, 
                r.idRol, 
                r.nombreRol
            FROM usuario u 
            INNER JOIN rol r ON u.idRol = r.idRol 
            WHERE r.idRol != 1 AND u.status != 0;

        DELIMITER //

CREATE PROCEDURE sp_registrar_bitacora(
    IN p_modulo VARCHAR(100),
    IN p_acciones TEXT,
    IN p_cedula VARCHAR(20)
)
BEGIN
    INSERT INTO bitacora (modulo, acciones, fecha, hora, cedula, status)
    VALUES (p_modulo, p_acciones, DEFAULT, DEFAULT, p_cedula, 1);
END;
//

-- Agregar protección contra UPDATE y DELETE
CREATE TRIGGER before_update_bitacora
BEFORE UPDATE ON bitacora
FOR EACH ROW
BEGIN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No se permiten actualizaciones en bitacora.';
END;
//

CREATE TRIGGER before_delete_bitacora
BEFORE DELETE ON bitacora
FOR EACH ROW
BEGIN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No se permiten eliminaciones en bitacora.';
END;
//

