-- Biblioteca "HOWARTS"
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
-- usuarios
CREATE TABLE usuarios (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(15) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- categorías
CREATE TABLE categorias (
    categoria_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(100) NOT NULL UNIQUE
);
-- autores
CREATE TABLE autores (
    autor_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_autor VARCHAR(100) NOT NULL
);
-- libros
CREATE TABLE libros (
    libro_id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    autor_id INT NOT NULL,
    categoria_id INT NOT NULL,
    copias_disponibles INT NOT NULL CHECK (copias_disponibles > 0),
    FOREIGN KEY (autor_id) REFERENCES autores(autor_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (categoria_id) REFERENCES categorias(categoria_id) ON DELETE CASCADE ON UPDATE CASCADE
);
-- préstamos
CREATE TABLE prestamos (
    prestamo_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    libro_id INT NOT NULL,
    fecha_prestamo TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_devolucion DATE NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (libro_id) REFERENCES libros(libro_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CHECK (fecha_devolucion > fecha_prestamo)
);
-- Administradores
CREATE TABLE administradores (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);


-- Creación de índices para mejorar el rendimiento
CREATE INDEX idx_usuario_id ON prestamos(usuario_id);
CREATE INDEX idx_libro_id ON prestamos(libro_id);
CREATE INDEX idx_categoria_id ON libros(categoria_id);

-- Inserción de datos iniciales
INSERT INTO categorias (nombre_categoria) VALUES 
('Fantasía'), ('Ciencia Ficción'), ('Misterio'), ('Historia'), ('Aventura'), ('Drama'), ('Romance'), ('Horror');

INSERT INTO autores (nombre_autor) VALUES 
('J.K. Rowling'), ('George R.R. Martin'), ('Isaac Asimov'), ('Agatha Christie'), 
('J.R.R. Tolkien'), ('Stephen King'), ('Jane Austen'), ('Mary Shelley');

INSERT INTO libros (titulo, autor_id, categoria_id, copias_disponibles) VALUES 
('Harry Potter y la Piedra Filosofal', 1, 1, 10),
('Juego de Tronos', 2, 1, 5),
('Fundación', 3, 2, 8),
('Asesinato en el Orient Express', 4, 3, 4),
('El Hobbit', 5, 5, 7),
('It', 6, 8, 6),
('Orgullo y Prejuicio', 7, 7, 10),
('Frankenstein', 8, 8, 5),
('Las Dos Torres', 5, 5, 4),
('Cementerio de Animales', 6, 8, 3),
('Emma', 7, 7, 6),
('Los Robots del Amanecer', 3, 2, 9),
('El Silmarillion', 5, 5, 2),
('Un Viaje al Centro de la Tierra', 5, 5, 3),
('La Larga Marcha', 6, 8, 4),
('Mujercitas', 7, 7, 6),
('El Hombre Invisible', 8, 8, 8),
('Drácula', 8, 8, 5),
('El Castillo Ambulante', 1, 1, 7),
('Cazadores de Sombras', 1, 1, 9);

INSERT INTO usuarios (nombre, correo, telefono) VALUES 
('Alice Smith', 'alice.smith@example.com', '5551234567'),
('Bob Johnson', 'bob.johnson@example.com', '5552345678'),
('Charlie Brown', 'charlie.brown@example.com', '5553456789'),
('Diana Prince', 'diana.prince@example.com', '5554567890'),
('Ethan Hunt', 'ethan.hunt@example.com', '5555678901'),
('Fiona Gallagher', 'fiona.gallagher@example.com', '5556789012'),
('George Martin', 'george.martin@example.com', '5557890123'),
('Holly Golightly', 'holly.golightly@example.com', '5558901234'),
('Ivy Winters', 'ivy.winters@example.com', '5559012345'),
('Jack Frost', 'jack.frost@example.com', '5550123456'),
('Kara Danvers', 'kara.danvers@example.com', '5551234578'),
('Liam Neeson', 'liam.neeson@example.com', '5552345689'),
('Mia Wallace', 'mia.wallace@example.com', '5553456790'),
('Nate Drake', 'nate.drake@example.com', '5554567801'),
('Olivia Benson', 'olivia.benson@example.com', '5555678912'),
('Peter Parker', 'peter.parker@example.com', '5556789023'),
('Quinn Fabray', 'quinn.fabray@example.com', '5557890134'),
('Rachel Green', 'rachel.green@example.com', '5558901245'),
('Sam Winchester', 'sam.winchester@example.com', '5559012356'),
('Tina Goldstein', 'tina.goldstein@example.com', '5550123467'),
('Ursula Buffay', 'ursula.buffay@example.com', '5551234589'),
('Victor Frankenstein', 'victor.frankenstein@example.com', '5552345690'),
('Wanda Maximoff', 'wanda.maximoff@example.com', '5553456701'),
('Xander Harris', 'xander.harris@example.com', '5554567812'),
('Yara Greyjoy', 'yara.greyjoy@example.com', '5555678923'),
('Zara Larsson', 'zara.larsson@example.com', '5556789034'),
('Arthur Pendragon', 'arthur.pendragon@example.com', '5557890145'),
('Bella Swan', 'bella.swan@example.com', '5558901256'),
('Cedric Diggory', 'cedric.diggory@example.com', '5559012367'),
('Dolores Umbridge', 'dolores.umbridge@example.com', '5550123478'),
('Eragon Shadeslayer', 'eragon.shadeslayer@example.com', '5551234590'),
('Frodo Baggins', 'frodo.baggins@example.com', '5552345601'),
('Gandalf the Grey', 'gandalf.the.grey@example.com', '5553456712'),
('Hermione Granger', 'hermione.granger@example.com', '5554567823'),
('Indiana Jones', 'indiana.jones@example.com', '5555678934'),
('James Bond', 'james.bond@example.com', '5556789045'),
('Katniss Everdeen', 'katniss.everdeen@example.com', '5557890156'),
('Luna Lovegood', 'luna.lovegood@example.com', '5558901267'),
('Morpheus', 'morpheus@example.com', '5559012378'),
('Neo Anderson', 'neo.anderson@example.com', '5550123489'),
('Ophelia', 'ophelia@example.com', '5551234501'),
('Percy Jackson', 'percy.jackson@example.com', '5552345612'),
('Quentin Coldwater', 'quentin.coldwater@example.com', '5553456723'),
('Ron Weasley', 'ron.weasley@example.com', '5554567834'),
('Sabrina Spellman', 'sabrina.spellman@example.com', '5555678945'),
('Tyrion Lannister', 'tyrion.lannister@example.com', '5556789056'),
('Ulrich Nielsen','ulrich.nielsen@example.com', '5557890167'),
('Violet Baudelaire', 'violet.baudelaire@example.com', '5558901278'),
('Will Turner', 'will.turner@example.com', '5559012389'),
('Xena Warrior', 'xena.warrior@example.com', '5550123490'),
('Yennefer Vengerberg', 'yennefer.vengerberg@example.com', '5551234512'),
('Zack Fair', 'zack.fair@example.com', '5552345623'),
('Aragorn Elessar', 'aragorn.elessar@example.com', '5553456734'),
('Bilbo Baggins', 'bilbo.baggins@example.com', '5554567845'),
('Ciri Fiona', 'ciri.fiona@example.com', '5555678956'),
('Dobby Elf', 'dobby.elf@example.com', '5556789067'),
('Eowyn Rohan', 'eowyn.rohan@example.com', '5557890178'),
('Faramir Steward', 'faramir.steward@example.com', '5558901289'),
('Gimli Dwarf', 'gimli.dwarf@example.com', '5559012390'),
('Hodor', 'hodor@example.com', '5550123501'),
('Isildur Numenor', 'isildur.numenor@example.com', '5551234523'),
('Jon Snow', 'jon.snow@example.com', '5552345634'),
('Kili Oakenshield', 'kili.oakenshield@example.com', '5553456745'),
('Legolas Greenleaf', 'legolas.greenleaf@example.com', '5554567856'),
('Merry Brandybuck', 'merry.brandybuck@example.com', '5555678967'),
('Nymeria Sand', 'nymeria.sand@example.com', '5556789078'),
('Oberyn Martell', 'oberyn.martell@example.com', '5557890189'),
('Pippin Took', 'pippin.took@example.com', '5558901290'),
('Ragnar Lothbrok', 'ragnar.lothbrok@example.com', '5559012401'),
('Sauron', 'sauron@example.com', '5550123512'),
('Thranduil Mirkwood', 'thranduil.mirkwood@example.com', '5551234534'),
('Ursula von der Leyen', 'ursula.vdl@example.com', '5552345645'),
('Varys Spider', 'varys.spider@example.com', '5553456756'),
('Witch King', 'witch.king@example.com', '5554567867'),
('Xanatos', 'xanatos@example.com', '5555678978'),
('Ygritte Wildling', 'ygritte.wildling@example.com', '5556789089'),
('Zelda Hyrule', 'zelda.hyrule@example.com', '5557890190');
