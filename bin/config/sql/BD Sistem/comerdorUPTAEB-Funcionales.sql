
            SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
            START TRANSACTION;
            SET time_zone = "+00:00";
            DROP DATABASE IF EXISTS comerdorUPTAEB;
            CREATE DATABASE comerdorUPTAEB;
            USE comerdorUPTAEB;
        
        -- Tabla Sección
        CREATE TABLE seccion (
            idSeccion INT AUTO_INCREMENT PRIMARY KEY,
            seccion VARCHAR(50) NOT NULL,
            status TINYINT(1) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Tabla Estudiante
        CREATE TABLE estudiante (
            cedEstudiante INT PRIMARY KEY,
            nombre VARCHAR(50) NOT NULL,
            segNombre VARCHAR(50),
            apellido VARCHAR(50) NOT NULL,
            segApellido VARCHAR(50),
            sexo VARCHAR(1) NOT NULL,
            telefono VARCHAR(20),
            nucleo VARCHAR(100) NOT NULL,
            carrera VARCHAR(100) NOT NULL,
            status TINYINT(1) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Tabla Estudiante_Seccion (relación muchos a muchos)
        CREATE TABLE estudiante_seccion (
            idEstudianteSeccion INT AUTO_INCREMENT PRIMARY KEY,
            cedEstudiante INT NOT NULL,
            idSeccion INT NOT NULL,
            FOREIGN KEY (cedEstudiante) REFERENCES estudiante(cedEstudiante),
            FOREIGN KEY (idSeccion) REFERENCES seccion(idSeccion)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Tabla Horario
        CREATE TABLE horario(
            idHorario INT AUTO_INCREMENT PRIMARY KEY,
            dia VARCHAR(50) NOT NULL,
            idSeccion INT NOT NULL,
            status TINYINT(1) NOT NULL,
            FOREIGN KEY (idSeccion) REFERENCES seccion(idSeccion)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        CREATE TABLE excepcion(
            idExc INT AUTO_INCREMENT PRIMARY KEY,
            descripcion VARCHAR(300) NOT NULL,
            cedEstudiante INT NOT NULL,
            fecha DATE NOT NULL DEFAULT CURRENT_DATE,
            status TINYINT(1) NOT NULL,
            FOREIGN KEY (cedEstudiante) REFERENCES estudiante(cedEstudiante)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Tabla tipoAlimento
        CREATE TABLE  tipoAlimento (
            idTipoA INT AUTO_INCREMENT PRIMARY KEY,
            tipo VARCHAR(50) NOT NULL,
            status TINYINT(1) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        

        -- Tabla alimento
        CREATE TABLE  alimento (
            idAlimento INT AUTO_INCREMENT PRIMARY KEY,
            codigo VARCHAR(20) NOT NULL,
            imgAlimento VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            nombre VARCHAR(50) NOT NULL,
            unidadMedida VARCHAR(50) NOT NULL,
            marca VARCHAR(50) NOT NULL,
            stock INT NOT NULL,
            reservado INT NOT NULL,
            idTipoA INT NOT NULL,
            status TINYINT(1) NOT NULL,
            FOREIGN KEY (idTipoA) REFERENCES tipoAlimento(idTipoA)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Tabla inventarioAlimento
        CREATE TABLE  entradaAlimento (
            idEntradaA INT AUTO_INCREMENT PRIMARY KEY,
            fecha DATE NOT NULL,
            hora TIME NOT NULL DEFAULT CURRENT_TIME,
            descripcion VARCHAR(300) NOT NULL,
            status TINYINT(1) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Tabla detalleInventarioA
        CREATE TABLE  detalleEntradaA (
            idDetalleA INT AUTO_INCREMENT PRIMARY KEY,
            cantidad INT NOT NULL,
            idAlimento INT NOT NULL,
            idEntradaA INT NOT NULL,
            status TINYINT(1) NOT NULL,
            FOREIGN KEY (idAlimento) REFERENCES alimento(idAlimento),
            FOREIGN KEY (idEntradaA) REFERENCES entradaAlimento(idEntradaA)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Tabla tipoSalidas
        CREATE TABLE  tipoSalidas (
            idTipoSalidas INT AUTO_INCREMENT PRIMARY KEY,
            tipoSalida VARCHAR(50) NOT NULL,
            status TINYINT(1) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        
        INSERT INTO `tipoSalidas` (`tipoSalida`, `status`) VALUES
        ('Menú', 1);


        -- Tabla salidaAlimentos
        CREATE TABLE  salidaAlimentos (
            idSalidaA INT AUTO_INCREMENT PRIMARY KEY,
            fecha DATE NOT NULL,
            hora TIME NOT NULL DEFAULT CURRENT_TIME,
            descripcion VARCHAR(300) NOT NULL,
            idTipoSalidaA INT NOT NULL,
            status TINYINT(1) NOT NULL,
            FOREIGN KEY (idTipoSalidaA) REFERENCES tipoSalidas(idTipoSalidas)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Tabla menú
        CREATE TABLE  menu (
            idMenu INT AUTO_INCREMENT PRIMARY KEY,
            feMenu date NOT NULL,
            horarioComida VARCHAR(50) NOT NULL,
            cantPlatos INT NOT NULL,
            status TINYINT(1) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


        -- Tabla detalleSalidaMenu
        CREATE TABLE  detalleSalidaMenu (
            idDetalleSalidaMenu INT AUTO_INCREMENT PRIMARY KEY,
            cantidad INT NOT NULL,
            idMenu INT NOT NULL,
            idAlimento INT NOT NULL,
            idSalidaA INT NOT NULL,
            status TINYINT(1) NOT NULL,
            FOREIGN KEY (idMenu) REFERENCES menu(idMenu),
            FOREIGN KEY (idAlimento) REFERENCES alimento(idAlimento),
            FOREIGN KEY (idSalidaA) REFERENCES salidaAlimentos(idSalidaA)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


        -- Tabla detalleSalidaA
        CREATE TABLE  detalleSalidaA (
            idDetalleSalidaA INT AUTO_INCREMENT PRIMARY KEY,
            cantidad INT NOT NULL,
            idAlimento INT NOT NULL,
            idSalidaA INT NOT NULL,
            status TINYINT(1) NOT NULL,
            FOREIGN KEY (idAlimento) REFERENCES alimento(idAlimento),
            FOREIGN KEY (idSalidaA) REFERENCES salidaAlimentos(idSalidaA)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


        -- Tabla tipoUtensilios
        CREATE TABLE  tipoUtensilios (
            idTipoU INT AUTO_INCREMENT PRIMARY KEY,
            tipo VARCHAR(50) NOT NULL,
            status TINYINT(1) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Tabla utensilios
        CREATE TABLE  utensilios (
            idUtensilios INT AUTO_INCREMENT PRIMARY KEY,
            imgUtensilios VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            nombre VARCHAR(50) NOT NULL,
            material VARCHAR(100) NOT NULL,
            stock INT NOT NULL,
            idTipoU INT NOT NULL,
            status TINYINT(1) NOT NULL,
            FOREIGN KEY (idTipoU) REFERENCES tipoUtensilios(idTipoU)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Tabla inventarioU
        CREATE TABLE  entradaU (
            idEntradaU INT AUTO_INCREMENT PRIMARY KEY,
            fecha DATE NOT NULL,
            hora TIME NOT NULL DEFAULT CURRENT_TIME,
            descripcion VARCHAR(300) NOT NULL,
            status TINYINT(1) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Tabla detalleInventarioU
        CREATE TABLE  detalleEntradaU (
            idDetalleU INT AUTO_INCREMENT PRIMARY KEY,
            cantidad INT NOT NULL,
            idUtensilios INT NOT NULL,
            idEntradaU INT NOT NULL,
            status TINYINT(1) NOT NULL,
            FOREIGN KEY (idUtensilios) REFERENCES utensilios(idUtensilios),
            FOREIGN KEY ( idEntradaU) REFERENCES entradaU( idEntradaU)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Tabla salidaUtensilios
        CREATE TABLE  salidaUtensilios (
            idSalidaU INT AUTO_INCREMENT PRIMARY KEY,
            fecha DATE NOT NULL,
            hora TIME NOT NULL DEFAULT CURRENT_TIME,
            descripcion VARCHAR(300) NOT NULL,
            idTipoSalidas INT NOT NULL,
            status TINYINT(1) NOT NULL,
            FOREIGN KEY (idTipoSalidas) REFERENCES tipoSalidas(idTipoSalidas)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Tabla detalleSalidaU
        CREATE TABLE  detalleSalidaU (
            idDetalleSalidaU INT AUTO_INCREMENT PRIMARY KEY,
            cantidad INT NOT NULL,
            idUtensilios INT NOT NULL,
            idSalidaU INT NOT NULL,
            status TINYINT(1) NOT NULL,
            FOREIGN KEY (idUtensilios) REFERENCES utensilios(idUtensilios),
            FOREIGN KEY (idSalidaU) REFERENCES salidaUtensilios(idSalidaU)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


        -- Tabla Asistencia
        CREATE TABLE  asistencia (
            idAsistencia INT AUTO_INCREMENT PRIMARY KEY,
            cedEstudiante INT NOT NULL,
            fecha DATE NOT NULL DEFAULT CURRENT_DATE,
            hora TIME NOT NULL DEFAULT CURRENT_TIME,
            idMenu INT NOT NULL,
            status TINYINT(1) NOT NULL,
            FOREIGN KEY (cedEstudiante) REFERENCES estudiante(cedEstudiante),
            FOREIGN KEY (idMenu) REFERENCES menu(idMenu)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Tabla evento
        CREATE TABLE  evento (
            idEvento INT AUTO_INCREMENT PRIMARY KEY,
            nomEvent VARCHAR(100) NOT NULL,
            descripEvent VARCHAR(300) NOT NULL,
            idMenu INT NOT NULL,
            status TINYINT(1) NOT NULL,
            FOREIGN KEY (idMenu) REFERENCES menu(idMenu)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


        COMMIT;

                START TRANSACTION;

                CREATE INDEX idx_estudiante_cedula ON estudiante(cedEstudiante);
                CREATE INDEX idx_estudiante_status ON estudiante(status);

                CREATE INDEX idx_estudianteSeccion_cedula ON estudiante_seccion(cedEstudiante);
                CREATE INDEX idx_estudianteSeccion_idSeccion ON estudiante_seccion(idSeccion);
                
                CREATE INDEX idx_seccion_idSeccion ON seccion(idSeccion);
                CREATE INDEX idx_seccion_status ON seccion(status);

                CREATE INDEX idx_horario_idSeccion ON horario(idSeccion);
                CREATE INDEX idx_horario_status ON horario(status);

                CREATE INDEX idx_menu_fecha_horario ON menu(feMenu, horarioComida);
                CREATE INDEX idx_menu_status ON menu(status);

                CREATE INDEX idx_asistencia_idmenu_fecha ON asistencia(idMenu, fecha);
                CREATE INDEX idx_asistencia_fecha ON asistencia(fecha);
                CREATE INDEX idx_asistencia_cedula_fecha ON asistencia(cedEstudiante, fecha);

                CREATE INDEX idx_menu_fecha_horario_status ON menu(feMenu, horarioComida, status);
                
                CREATE INDEX idx_asistencia_fecha_cedula ON asistencia(fecha, cedEstudiante);
                CREATE INDEX idx_menu_horario ON menu(horarioComida);
                
                CREATE INDEX idx_asistencia_fecha_idmenu ON asistencia(fecha, idMenu);

                CREATE INDEX idx_alimento_idAlimento ON alimento(idAlimento);
                CREATE INDEX idx_alimento_idTipoAlimento ON alimento(idTipoA);
                CREATE INDEX idx_alimento_busqueda ON alimento (idTipoA, nombre, marca);
                CREATE INDEX idx_alimento_idTipoA_stock_status ON alimento (idTipoA, stock, status);
                CREATE INDEX idx_alimento_status_stock ON alimento (status, stock);
                CREATE INDEX idx_entradaalimento_status_fecha ON entradaalimento (status, fecha);
                CREATE INDEX idx_detalleentradaa_idEntradaA ON detalleentradaa (idEntradaA);
                CREATE INDEX idx_detalleentradaa_idAlimento ON detalleentradaa (idAlimento);
                CREATE INDEX idx_detallesalidaa_idAlimento_status ON detallesalidaa (idAlimento, status);
                CREATE INDEX idx_salidaalimentos_idSalidaA_status ON salidaalimentos (idSalidaA, status);
                CREATE INDEX idx_detallesalidaa_idDetalleSalidaA ON detallesalidaa (idDetalleSalidaA);
                CREATE INDEX idx_detallesalidaa_idSalidaA_idAlimento ON detallesalidaa (idSalidaA, idAlimento);
                CREATE INDEX idx_salidaalimentos_fecha_status ON salidaalimentos(fecha, status);
                CREATE INDEX idx_salidaalimentos_tiposalida ON salidaalimentos(idTipoSalidaA);
                

                CREATE INDEX idx_tipoStatus ON tipoutensilios (status, idTipoU);


               COMMIT;

                START TRANSACTION;
            
                -- Vistas

               CREATE OR REPLACE VIEW vista_resumen_general AS SELECT (SELECT COUNT(a.idAsistencia) FROM asistencia a INNER JOIN menu m ON a.idMenu = m.idMenu WHERE a.status = 1 AND a.fecha = CURDATE() ) AS asistencias_hoy, ( SELECT COUNT(m.idMenu) AS cantidad FROM menu m LEFT JOIN evento e ON m.idMenu = e.idMenu WHERE m.status = 1 AND e.idMenu IS NULL) AS menus_activos,(SELECT COUNT(e.idEvento) FROM evento e INNER JOIN menu m ON e.idMenu = m.idMenu WHERE e.status = 1 ) AS eventos_activos, (SELECT COUNT(*) FROM alimento WHERE status = 1 AND (stock > 0 OR reservado > 0) ) AS alimentos_disponibles, (SELECT COUNT(*) FROM utensilios WHERE status = 1 AND stock > 0 ) AS utensilios_disponibles;

                CREATE OR REPLACE VIEW vista_estudiantes_con_secciones AS
                SELECT 
                    e.cedEstudiante,
                    e.nombre,
                    e.apellido,
                    e.carrera,
                    e.status,
                    GROUP_CONCAT(s.seccion ORDER BY s.seccion SEPARATOR ', ') AS seccion 
                FROM estudiante e
                JOIN estudiante_seccion es ON e.cedEstudiante = es.cedEstudiante
                JOIN seccion s ON es.idSeccion = s.idSeccion 
                WHERE e.status = 1 AND s.status = 1 
                GROUP BY e.cedEstudiante;

                CREATE OR REPLACE VIEW vista_info_estudiante AS
                SELECT 
                    e.cedEstudiante, 
                    e.nombre, 
                    e.segNombre, 
                    e.apellido, 
                    e.segApellido, 
                    e.sexo, 
                    e.telefono, 
                    e.nucleo, 
                    e.carrera, 
                    e.status, 
                    GROUP_CONCAT(DISTINCT s.seccion ORDER BY s.seccion SEPARATOR ', ') AS seccion,
                    GROUP_CONCAT(DISTINCT h.dia ORDER BY 
                        FIELD(h.dia, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo') 
                        SEPARATOR ', ') AS horario
                FROM estudiante e
                JOIN estudiante_seccion es ON e.cedEstudiante = es.cedEstudiante
                JOIN seccion s ON es.idSeccion = s.idSeccion
                JOIN horario h ON s.idSeccion = h.idSeccion
                WHERE e.status = 1 AND s.status = 1 AND h.status = 1
                GROUP BY 
                    e.cedEstudiante, 
                    e.nombre, 
                    e.segNombre, 
                    e.apellido, 
                    e.segApellido, 
                    e.sexo, 
                    e.telefono,     
                    e.nucleo, 
                    e.carrera, 
                    e.status;


                    CREATE OR REPLACE VIEW vista_alimentos AS SELECT a.*, ta.tipo FROM alimento a INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE a.status = 1;
                    CREATE OR REPLACE VIEW vista_alimentos_entrada AS SELECT ea.idEntradaA, ea.fecha, ea.hora, ea.descripcion, ea.status, a.idAlimento, a.imgAlimento, a.codigo, a.nombre, a.marca, a.unidadMedida, ta.idTipoA, ta.tipo, dea.cantidad FROM entradaalimento ea INNER JOIN detalleentradaa dea ON dea.idEntradaA = ea.idEntradaA INNER JOIN alimento a ON a.idAlimento = dea.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA;
                    CREATE OR REPLACE VIEW vista_salida_alimentos AS SELECT sa.idSalidaA, sa.fecha, sa.hora, sa.descripcion, sa.status, sa.idTipoSalidaA, ts.tipoSalida FROM salidaalimentos sa INNER JOIN tiposalidas ts ON ts.idTipoSalidas = sa.idTipoSalidaA WHERE ts.tipoSalida != 'Menú' AND sa.status = 1;
                    CREATE OR REPLACE VIEW vista_detalle_salida_alimentos AS SELECT sa.idSalidaA, sa.fecha, sa.hora, sa.descripcion, ts.tipoSalida, a.idAlimento, a.nombre, a.codigo, a.marca, a.unidadMedida, a.stock, a.imgAlimento, ta.idTipoA, ta.tipo, dsa.cantidad, dsa.status AS statusDetalle FROM salidaalimentos sa INNER JOIN tiposalidas ts ON ts.idTipoSalidas = sa.idTipoSalidaA INNER JOIN detallesalidaa dsa ON dsa.idSalidaA = sa.idSalidaA INNER JOIN alimento a ON a.idAlimento = dsa.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA;

                    CREATE OR REPLACE VIEW vista_tipos_utensilios_activos AS SELECT * FROM tipoutensilios WHERE status != 0;

                    
                    DELIMITER $$

                        CREATE PROCEDURE sp_mostrar_asistencia (
                            IN p_fecha DATE,
                            IN p_horario VARCHAR(20)
                        )
                        BEGIN
                            DECLARE v_fecha DATE;
                            SET v_fecha = IFNULL(p_fecha, CURDATE());

                            SELECT DISTINCT 
                                e.cedEstudiante AS Cedula, 
                                e.nombre AS Nombre, 
                                e.apellido AS Apellido, 
                                e.carrera AS Carrera, 
                                v_fecha AS Fecha,
                                m.horarioComida AS HorarioDeComida
                            FROM asistencia a 
                            JOIN estudiante e ON a.cedEstudiante = e.cedEstudiante 
                            JOIN menu m ON a.idMenu = m.idMenu 
                            WHERE a.status = 1
                                AND a.fecha = v_fecha
                                AND (p_horario IS NULL OR m.horarioComida = p_horario);
                        END $$
                        DELIMITER ;
                            DELIMITER $$

                            CREATE PROCEDURE sp_mostrar_ultima_asistencia (
                                IN p_horario VARCHAR(20)
                            )
                            BEGIN
                                DECLARE v_max_fecha DATE;

                                -- Buscar la fecha máxima antes de hoy según el horario
                                IF p_horario IS NOT NULL AND p_horario != '' THEN
                                    SELECT MAX(a.fecha)
                                    INTO v_max_fecha
                                    FROM asistencia a
                                    JOIN menu m ON a.idMenu = m.idMenu
                                    WHERE m.horarioComida = p_horario
                                    AND a.fecha < CURDATE();
                                ELSE
                                    SELECT MAX(fecha)
                                    INTO v_max_fecha
                                    FROM asistencia
                                    WHERE fecha < CURDATE();
                                END IF;

                                -- Consulta principal con fecha incluida
                                SELECT DISTINCT 
                                    e.cedEstudiante AS Cedula, 
                                    e.nombre AS Nombre, 
                                    e.apellido AS Apellido, 
                                    e.carrera AS Carrera, 
                                    m.horarioComida AS HorarioDeComida,
                                    a.fecha AS FechaAsistencia
                                FROM asistencia a
                                JOIN estudiante e ON a.cedEstudiante = e.cedEstudiante
                                JOIN menu m ON a.idMenu = m.idMenu
                                WHERE a.status = 1
                                AND a.fecha = v_max_fecha
                                ORDER BY a.fecha DESC, a.hora DESC;

                            END $$
                            DELIMITER ;

                                 --Menu
                         DELIMITER $$

                        -- Verificar si un tipo de alimento existe y tiene stock
                        CREATE PROCEDURE verificar_existencia_tipo_alimento (
                            IN tipoA INT
                        )
                        BEGIN
                            SELECT idTipoA
                            FROM tipoalimento
                            WHERE idTipoA = tipoA
                            AND idTipoA IN (
                                SELECT idTipoA
                                FROM alimento
                                WHERE status = 1 AND stock > 0
                            );
                        END $$

                        -- Verificar si un alimento está disponible
                        CREATE PROCEDURE proceVerificarAlimentoDisponible (
                            IN p_idAlimento INT
                        )
                        BEGIN
                            SELECT idAlimento
                            FROM alimento
                            WHERE status = 1
                            AND idAlimento = p_idAlimento
                            AND stock > 0;
                        END $$

                        -- Mostrar alimentos por tipo que estén disponibles en stock
                        CREATE PROCEDURE proceMostrarAlimentosPorTipo (
                            IN tipoA INT
                        )
                        BEGIN
                            SELECT DISTINCT 
                                a.idAlimento, 
                                a.codigo, 
                                a.imgAlimento,
                                a.nombre, 
                                a.unidadMedida, 
                                a.marca, 
                                a.stock 
                            FROM tipoalimento ta 
                            INNER JOIN alimento a ON ta.idTipoA = a.idTipoA 
                            WHERE a.idTipoA = tipoA 
                            AND a.stock > 0 
                            AND a.idAlimento IN (
                                SELECT idAlimento FROM detalleentradaa WHERE status = 1
                            );
                        END $$

                        DELIMITER ;

                                                -- Tipos de alimentos con stock positivo
                        CREATE OR REPLACE VIEW vistaTiposAlimentosConStock AS 
                        SELECT DISTINCT ta.idTipoA, ta.tipo
                        FROM tipoalimento ta 
                        INNER JOIN alimento a ON ta.idTipoA = a.idTipoA 
                        WHERE a.idAlimento IN (
                            SELECT idAlimento 
                            FROM detalleentradaa 
                            WHERE status = 1 AND stock > 0
                        );

                        -- Tipos de alimentos usados en menús
                        CREATE OR REPLACE VIEW vista_tipo_alimentos_por_menu AS
                        SELECT 
                            ta.idTipoA, 
                            ta.tipo, 
                            m.idMenu, 
                            m.feMenu, 
                            m.horarioComida,
                            a.marca
                        FROM detallesalidamenu dsm
                        INNER JOIN alimento a ON a.idAlimento = dsm.idAlimento
                        INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA
                        INNER JOIN menu m ON m.idMenu = dsm.idMenu
                        GROUP BY ta.idTipoA, ta.tipo, m.idMenu, m.feMenu, m.horarioComida;

                        -- Detalle de alimentos por menú
                       CREATE OR REPLACE VIEW vista_detalle_alimentos_por_menu AS
                        SELECT 
                            a.idAlimento, 
                            a.imgAlimento, 
                            a.nombre, 
                            a.marca, 
                            a.unidadMedida, 
                            dsm.cantidad, 
                            ta.idTipoA, 
                            ta.tipo, 
                            m.idMenu, 
                            m.feMenu, 
                            m.horarioComida, 
                            m.cantPlatos, 
                            sa.descripcion, 
                            sa.idSalidaA
                        FROM salidaalimentos sa
                        INNER JOIN detallesalidamenu dsm ON dsm.idSalidaA = sa.idSalidaA
                        INNER JOIN alimento a ON a.idAlimento = dsm.idAlimento
                        INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA
                        INNER JOIN menu m ON m.idMenu = dsm.idMenu
                        WHERE m.status = 1 AND sa.status = 1;


                        -- Tipos de alimentos por evento
                     CREATE OR REPLACE VIEW vista_tipo_alimento_evento AS 
                            SELECT DISTINCT 
                                ta.idTipoA, 
                                ta.tipo, 
                                e.nomEvent, 
                                e.idEvento,
                                e.idMenu, 
                                m.feMenu, 
                                m.horarioComida,
                                a.marca
                        FROM evento e 
                        INNER JOIN menu m ON m.idMenu = e.idMenu AND m.status = 1
                        LEFT JOIN detallesalidamenu dsm ON dsm.idMenu = m.idMenu AND dsm.status = 1
                        LEFT JOIN salidaalimentos sa ON sa.idSalidaA = dsm.idSalidaA AND sa.status = 1
                        LEFT JOIN alimento a ON a.idAlimento = dsm.idAlimento AND a.status = 1
                        LEFT JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA AND ta.status = 1
                        WHERE e.status = 1;


                        -- Detalle de alimentos por evento
                       CREATE OR REPLACE VIEW vista_detalle_alimentos_evento AS
                        SELECT
                            a.idAlimento,
                            a.imgAlimento,
                            a.nombre,
                            a.marca,
                            a.unidadMedida,
                            dsm.cantidad,
                            ta.idTipoA,
                            ta.tipo,
                            m.idMenu,
                            m.feMenu,
                            m.horarioComida,
                            m.cantPlatos,
                            sa.descripcion, 
                            sa.idSalidaA,
                            e.idEvento,
                            e.nomEvent,
                            e.descripEvent,
                            e.idMenu AS idMenuEvento
                        FROM evento e
                        INNER JOIN menu m ON e.idMenu = m.idMenu AND m.status = 1
                        INNER JOIN detallesalidamenu dsm ON dsm.idMenu = m.idMenu AND dsm.status = 1
                        INNER JOIN salidaalimentos sa ON sa.idSalidaA = dsm.idSalidaA AND sa.status = 1
                        INNER JOIN alimento a ON a.idAlimento = dsm.idAlimento AND a.status = 1
                        INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA AND ta.status = 1
                        WHERE e.status = 1;


                       CREATE INDEX idx_menufecha_horario ON menu (feMenu, horarioComida, status);
                       CREATE INDEX idx_evento_idMenu ON evento (idMenu);
                       CREATE INDEX idx_detalleentradaa_idAli ON detalleentradaa (idAlimento);
                       CREATE INDEX idx_alimento_idTipoA ON alimento (idTipoA);

                        DELIMITER //

                        CREATE PROCEDURE registrar_tipo_utensilio(
                            IN p_tipo VARCHAR(50),
                            OUT p_resultado VARCHAR(100)
                        )
                        BEGIN
                            DECLARE EXIT HANDLER FOR SQLEXCEPTION
                            BEGIN
                                ROLLBACK;
                                SET p_resultado = 'Error en la inserción';
                            END;

                            START TRANSACTION;

                            INSERT INTO tipoutensilios (tipo, status) VALUES (p_tipo, 1);

                            COMMIT;
                            SET p_resultado = 'exitoso';
                        END //

                        DELIMITER ;

                        DELIMITER //

                        CREATE PROCEDURE actualizar_tipo_utensilio (
                            IN p_id INT,
                            IN p_nuevo_tipo VARCHAR(50),
                            OUT p_resultado VARCHAR(100)
                        )
                        BEGIN
                            DECLARE v_filas_afectadas INT DEFAULT 0;

                            DECLARE EXIT HANDLER FOR SQLEXCEPTION
                            BEGIN
                                ROLLBACK;
                                SET p_resultado = 'Error al actualizar el tipo';
                            END;

                            START TRANSACTION;

                            UPDATE tipoutensilios 
                            SET tipo = p_nuevo_tipo 
                            WHERE idTipoU = p_id;

                            SET v_filas_afectadas = ROW_COUNT();

                            IF v_filas_afectadas > 0 THEN
                                COMMIT;
                                SET p_resultado = 'actualizado';
                            ELSE
                                ROLLBACK;
                                SET p_resultado = 'no encontrado o sin cambios';
                            END IF;
                        END //

                        DELIMITER ;

                        DELIMITER //

                        CREATE PROCEDURE anular_tipo_utensilio (
                            IN p_id INT,
                            OUT p_resultado VARCHAR(100),
                            OUT p_tipo_nombre VARCHAR(50)
                        )
                        BEGIN
                            DECLARE v_tipo_nombre VARCHAR(50);
                            DECLARE v_filas_afectadas INT DEFAULT 0;

                            DECLARE EXIT HANDLER FOR SQLEXCEPTION
                            BEGIN
                                ROLLBACK;
                                SET p_resultado = 'Error al anular el tipo';
                            END;

                            START TRANSACTION;

                            SELECT tipo INTO v_tipo_nombre
                            FROM tipoutensilios
                            WHERE idTipoU = p_id AND status = 1
                            LIMIT 1;

                            IF v_tipo_nombre IS NOT NULL THEN
                                UPDATE tipoutensilios SET status = 0 WHERE idTipoU = p_id;
                                SET v_filas_afectadas = ROW_COUNT();

                                IF v_filas_afectadas > 0 THEN
                                    COMMIT;
                                    SET p_resultado = 'anulado';
                                    SET p_tipo_nombre = v_tipo_nombre;
                                ELSE
                                    ROLLBACK;
                                    SET p_resultado = 'no encontrado o sin cambios';
                                END IF;
                            ELSE
                                ROLLBACK;
                                SET p_resultado = 'no encontrado o ya anulado';
                            END IF;
                        END //
                        DELIMITER ;

                       DELIMITER //

                        CREATE PROCEDURE sp_registrar_utensilio (
                            IN p_img VARCHAR(255),
                            IN p_nombre VARCHAR(50),
                            IN p_material VARCHAR(30),
                            IN p_tipoU INT
                        )
                        BEGIN
                            -- Verificar que el tipo de utensilio exista
                            IF EXISTS (
                                SELECT 1 FROM tipoutensilios WHERE idTipoU = p_tipoU
                            ) THEN

                                -- Insertar utensilio
                                INSERT INTO utensilios (imgUtensilios, nombre, material, stock, idTipoU, status)
                                VALUES (p_img, p_nombre, p_material, 0, p_tipoU, 1);
                            ELSE
                                -- Si el tipo no existe, lanzar error
                                SIGNAL SQLSTATE '45000'
                                SET MESSAGE_TEXT = 'El tipo de utensilio no existe';
                            END IF;
                        END //

                        DELIMITER ;

                        DELIMITER //
                        
                        CREATE PROCEDURE sp_modificar_utensilio (
                            IN p_id INT,
                            IN p_nombre VARCHAR(50),
                            IN p_material VARCHAR(30),
                            IN p_tipoU INT
                        )
                        BEGIN
                            DECLARE utensilioExiste INT DEFAULT 0;

                            -- Bloquear fila para evitar modificaciones concurrentes
                            SELECT COUNT(*) INTO utensilioExiste 
                            FROM utensilios 
                            WHERE idUtensilios = p_id 
                            FOR UPDATE;

                            IF utensilioExiste = 0 THEN
                                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Utensilio no encontrado';
                            ELSE
                                UPDATE utensilios 
                                SET nombre = p_nombre, material = p_material, idTipoU = p_tipoU
                                WHERE idUtensilios = p_id;
                            END IF;
                        END //

                        DELIMITER ;

                        DELIMITER //

                        CREATE PROCEDURE sp_registrar_detalle_salida (
                            IN p_idUtensilio INT,
                            IN p_cantidad INT,
                            IN p_idSalidaU INT
                        )
                        BEGIN
                            DECLARE stockActual INT DEFAULT 0;

                            START TRANSACTION;

                            -- Obtener stock actual con bloqueo
                            SELECT stock INTO stockActual FROM utensilios WHERE idUtensilios = p_idUtensilio AND status = 1 FOR UPDATE;

                            IF stockActual < p_cantidad THEN
                                ROLLBACK;
                                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stock insuficiente para la salida';
                            ELSE
                                -- Insertar detalle
                                INSERT INTO detallesalidau (cantidad, idUtensilios, idSalidaU, status)
                                VALUES (p_cantidad, p_idUtensilio, p_idSalidaU, 1);

                                -- Actualizar stock
                                UPDATE utensilios
                                SET stock = stockActual - p_cantidad
                                WHERE idUtensilios = p_idUtensilio;

                                COMMIT;
                            END IF;
                        END //

                        DELIMITER ;

                        DELIMITER //

                        CREATE PROCEDURE sp_registrarDetalleEntrada(
                            IN p_cantidad INT,
                            IN p_idUtensilio INT,
                            IN p_idEntrada INT
                        )
                        BEGIN
                            DECLARE currentStock INT;

                            START TRANSACTION;

                            INSERT INTO detalleentradau (cantidad, idUtensilios, idEntradaU, status) VALUES (p_cantidad, p_idUtensilio, p_idEntrada, 1);

                            SELECT stock INTO currentStock FROM utensilios WHERE idUtensilios = p_idUtensilio AND status = 1 FOR UPDATE;

                            IF currentStock IS NULL THEN
                                ROLLBACK;
                                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Utensilio no encontrado o inactivo';
                            ELSE
                                UPDATE utensilios SET stock = currentStock + p_cantidad WHERE idUtensilios = p_idUtensilio;
                                COMMIT;
                            END IF;
                        END //

                        DELIMITER ;






                COMMIT;
