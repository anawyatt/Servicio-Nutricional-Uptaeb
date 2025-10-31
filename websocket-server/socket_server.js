const express = require('express');
const http = require('http');
const { Server } = require('socket.io');

const app = express();
const httpServer = http.createServer(app);
const io = new Server(httpServer, {
    cors: {
        origin: "*", 
        methods: ["GET", "POST"]
    }
});

const PORT = 3000;

app.use(express.json());


const userSocketMap = {}; 

io.on('connection', (socket) => {
    console.log(`[Socket.IO] Nuevo cliente conectado: ${socket.id}`);

    socket.on('register_cedula', (cedula) => {
        userSocketMap[cedula] = socket.id;
        console.log(`[Socket.IO] Cédula ${cedula} registrada al socket ${socket.id}`);
    });

    socket.on('disconnect', () => {
        for (const cedula in userSocketMap) {
            if (userSocketMap[cedula] === socket.id) {
                delete userSocketMap[cedula];
                console.log(`[Socket.IO] Cédula ${cedula} desconectada.`);
                break;
            }
        }
    });
});


app.post('/send-notif', (req, res) => {
    const { cedulas, data } = req.body;
    
    if (!cedulas || !Array.isArray(cedulas) || !data) {
        return res.status(400).json({ success: false, message: 'Parámetros inválidos.' });
    }

    let sentCount = 0;
 
    cedulas.forEach(cedula => {
        const socketId = userSocketMap[cedula];
        if (socketId) {
            io.to(socketId).emit('nueva_notificacion_push', data);
            sentCount++;
        }
    });

    res.json({ 
        success: true, 
        message: `Notificaciones intentadas enviar: ${cedulas.length}. Notificaciones enviadas (clientes conectados): ${sentCount}` 
    });
});

httpServer.listen(PORT, () => {
    console.log(`Servidor de notificaciones corriendo en puerto ${PORT}`);
});